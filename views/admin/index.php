<?php

use kuzmiand\users\components\GhostHtml;
use kuzmiand\users\models\rbacDB\Role;
use kuzmiand\users\models\User;

use kuzmiand\users\grid_bulk_actions\GridBulkActions;
use kuzmiand\users\grid_page_size\GridPageSize;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;


$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

	<h2 class="lte-hide-title"><?= $this->title ?></h2>

	<div class="panel panel-default">
		<div class="panel-body">

			<div class="row">
				<div class="col-sm-6">
					<p>
						<?= GhostHtml::a(
							'<span class="glyphicon glyphicon-plus-sign"></span> ' . 'Create',
							['/user-management/user/create'],
							['class' => 'btn btn-success']
						) ?>
					</p>
				</div>

				<div class="col-sm-6 text-right">
					<?= GridPageSize::widget(['pjaxId'=>'user-grid-pjax']) ?>
				</div>
			</div>


			<?php Pjax::begin([
				'id'=>'user-grid-pjax',
			]) ?>

			<?= GridView::widget([
				'id'=>'user-grid',
				'dataProvider' => $dataProvider,
				'pager'=>[
					'options'=>['class'=>'pagination pagination-sm'],
					'hideOnSinglePage'=>true,
					'lastPageLabel'=>'>>',
					'firstPageLabel'=>'<<',
				],
				'filterModel' => $searchModel,
				'layout'=>'{items}<div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">{summary}'.GridBulkActions::widget([
						'gridId'=>'user-grid',
						'actions'=>[
							Url::to(['bulk-activate', 'attribute'=>'status'])=>GridBulkActions::t('app', 'Activate'),
							Url::to(['bulk-deactivate', 'attribute'=>'status'])=>GridBulkActions::t('app', 'Deactivate'),
							'----'=>[
								Url::to(['bulk-delete'])=>GridBulkActions::t('app', 'Delete'),
							],
						],
					]).'</div></div>',
				'columns' => [
					['class' => 'yii\grid\SerialColumn', 'options'=>['style'=>'width:30px'] ],

					[
						'class'=>'kuzmiand\users\components\StatusColumn',
						'attribute'=>'superadmin',
						'visible'=>Yii::$app->user->identity->isSuperadmin,
						'options'=>['style'=>'width:100px']
					],

					[
						'attribute'=>'username',
						'value'=>function(User $model){
								return Html::a($model->username,['view', 'id'=>$model->id],['data-pjax'=>0]);
							},
						'format'=>'raw',
						'options'=>['style'=>'width:auto']
					],
					[
						'attribute'=>'email',
						'format'=>'raw',
						'visible'=>User::hasPermission('viewUserEmail'),
						'options'=>['style'=>'width:auto']
					],
					/*[
						'class'=>'kuzmiand\users\components\StatusColumn',
						'attribute'=>'email_confirmed',
						'visible'=>User::hasPermission('viewUserEmail'),
					],*/
					[
						'attribute'=>'gridRoleSearch',
						'filter'=>ArrayHelper::map(Role::getAvailableRoles(Yii::$app->user->identity->isSuperAdmin),'name', 'description'),
						'value'=>function(User $model){
								return implode(', ', ArrayHelper::map($model->roles, 'name', 'description'));
							},
						'format'=>'raw',
						'visible'=>User::hasPermission('viewUserRoles'),
					],
					[
						'attribute'=>'registration_ip',
						'value'=>function(User $model){
								return Html::a($model->registration_ip, "http://ipinfo.io/" . $model->registration_ip, ["target"=>"_blank"]);
							},
						'format'=>'raw',
						'visible'=>User::hasPermission('viewRegistrationIp'),
						'options'=>['style'=>'width:100px']
					],
					[
						'value'=>function(User $model){
								return GhostHtml::a(
									'Roles and permissions',
									['/user/user-permission/set', 'id'=>$model->id],
									['class'=>'btn btn-sm btn-primary', 'data-pjax'=>0]);
							},
						'format'=>'raw',
						'visible'=>User::canRoute('/user/user-permission/set'),
						'options'=>[
							'width'=>'165px',
						],
					],
					/*[
						'value'=>function(User $model){
								return GhostHtml::a(
									'Change password',
									['change-password', 'id'=>$model->id],
									['class'=>'btn btn-sm btn-default', 'data-pjax'=>0]);
							},
						'format'=>'raw',
						'options'=>[
							'width'=>'10px',
						],
					],*/
					[
						'class'=>'kuzmiand\users\components\StatusColumn',
						'attribute'=>'status',
						'optionsArray'=>[
							[User::STATUS_ACTIVE,  'Active', 'success'],
							[User::STATUS_NEW, 'Inactive', 'warning'],
							[User::STATUS_BLOCKED, 'Blocked', 'danger'],
						],
					],
					['class' => 'yii\grid\CheckboxColumn', 'options'=>['style'=>'width:30px'] ],
					[
						'class' => 'yii\grid\ActionColumn',
						'contentOptions'=>['style'=>'width:70px; text-align:center;'],
					],
				],
			]); ?>

			<?php Pjax::end() ?>

		</div>
	</div>
</div>
