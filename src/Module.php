<?php

namespace floor12\banner;

/**
 * Banner module definition class
 * @property  string $layout
 * @property  string $controllerNamespace
 * @property  string $editRole
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'floor12\banner\controllers';

    /** Путь к макету, который используется в контроллерах управления рассылками
     * @var string
     */
    public $layout;

    /**
     * Те роли в системе, которым разрешено редактирование новостей
     * @var array
     */
    public $editRole = '@';

}
