<?php

use kuzmiand\users\grid_page_size\GridPageSize;
use kuzmiand\users\components\GhostHtml;
use kuzmiand\users\models\rbacDB\AuthItemGroup;
use kuzmiand\users\models\rbacDB\Role;

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;


$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;

?>

<h2 class="lte-hide-title"><?= $this->title ?></h2>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
				<p>
					<?= GhostHtml::a(
						'<span class="glyphicon glyphicon-plus-sign"></span> ' . 'Create',
						['create'],
						['class' => 'btn btn-success']
					) ?>
				</p>
			</div>

			<div class="col-sm-6 text-right">
				<?= GridPageSize::widget(['pjaxId'=>'role-grid-pjax']) ?>
			</div>
		</div>

		<?php Pjax::begin([
			'id'=>'role-grid-pjax',
		]) ?>

		<?= GridView::widget([
			'id'=>'role-grid',
			'dataProvider' => $dataProvider,
			'pager'=>[
				'options'=>['class'=>'pagination pagination-sm'],
				'hideOnSinglePage'=>true,
				'lastPageLabel'=>'>>',
				'firstPageLabel'=>'<<',
			],
			'filterModel' => $searchModel,
			'layout'=>'{items}<div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">{summary}</div></div>',
			'columns' => [
				['class' => 'yii\grid\SerialColumn', 'options'=>['style'=>'width:30px'] ],

				[
					'attribute'=>'description',
					'value'=>function(Role $model){
							return Html::a($model->description, ['view', 'id'=>$model->name], ['data-pjax'=>0]);
						},
					'format'=>'raw',
				],
				'name',
				[
					'class' => 'yii\grid\ActionColumn',
					'contentOptions'=>['style'=>'width:70px; text-align:center;'],
				],
			],
		]); ?>

		<?php Pjax::end() ?>
	</div>
</div>