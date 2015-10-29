<?php

namespace kuzmiand\users;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'kuzmiand\users\controllers';

    public $userPhotoUrl = '';

    public $userPhotoPath = '';

    public $customViews = [];

    public $customMailViews = [];

    public $customLayout = [];

    public $commonPermissionName = 'commonPermission';

    /**
     * Table aliases
     *
     * @var string
     */
    public $user_table = '{{%user}}';
    public $user_visit_log_table = '{{%user_visit_log}}';
    public $auth_item_table = '{{%auth_item}}';
    public $auth_item_child_table = '{{%auth_item_child}}';
    public $auth_item_group_table = '{{%auth_item_group}}';
    public $auth_assignment_table = '{{%auth_assignment}}';
    public $auth_rule_table = '{{%auth_rule}}';


    public function init()
    {
        parent::init();

        self::registerTranslations();
    }

    public static function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['users']) && !isset(Yii::$app->i18n->translations['users/*'])) {
            Yii::$app->i18n->translations['users'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@kuzmiand/users/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'users' => 'users.php'
                ]
            ];
        }
    }

    public function getCustomLayout($default)
    {
        if (isset($this->customLayout[$default])) {
            return $this->customLayout[$default];
        } else {
            return '@app/views/layouts/main';
        }
    }

    public function getCustomView($default)
    {
        if (isset($this->customViews[$default])) {
            return $this->customViews[$default];
        } else {
            return '@app/views/layouts/main';
        }
    }

    public function getCustomMailView($default)
    {
        if (isset($this->customMailViews[$default])) {
            return $this->customMailViews[$default];
        } else {
            return '@kuzmiand/users/mail/' . $default;
        }
    }
}
