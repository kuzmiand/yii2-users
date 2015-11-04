<?php

namespace kuzmiand\users\components;

use Yii;
use yii\web\Controller;
use kuzmiand\users\components\AccessControl;
use kuzmiand\behaviors\multilanguage\MultiLanguageHelper;

class BaseController extends Controller
{

    public function init()
    {
        MultiLanguageHelper::catchLanguage();
        parent::init();
    }

    /**
     * @return array
     */
    /*public function behaviors()
    {
        return [
            'access-control'=> [
                'class' => AccessControl::className(),
            ],
        ];
    }*/

    /**
     * Render ajax or usual depends on request
     *
     * @param string $view
     * @param array $params
     *
     * @return string|\yii\web\Response
     */
    protected function renderIsAjax($view, $params = [])
    {
        if ( Yii::$app->request->isAjax )
        {
            return $this->renderAjax($view, $params);
        }
        else
        {
            return $this->render($view, $params);
        }
    }
}