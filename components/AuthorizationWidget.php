<?php

namespace kuzmiand\users\components;

use kuzmiand\users\models\forms\LoginForm;
use kuzmiand\users\Module;
use yii\base\Widget;

class AuthorizationWidget extends Widget
{
    public function run()
    {
        $model = new LoginForm;
        Module::registerTranslations();
        return $this->render('authorizationWidget', ['model' => $model]);
    }
}