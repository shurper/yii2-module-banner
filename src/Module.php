<?php

namespace floor12\banner;

use Yii;
use yii\base\InvalidConfigException;

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

    /** Относительный путь к папке, доступной из веба, для публикации там баннеров
     * @var string
     */
    public $bannersWebPath = '@web/banners';

    /** Полный путь к папке, доступной из веба, для публикации там баннеров
     * @var string
     */
    public $bannersWebrootPath = '@webroot/banners';
    /**
     * Width to switch between mobile and desktop banner version
     * @var int
     */
    public $transitionWidth = 700;

    /** @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        $webPath = Yii::getAlias($this->bannersWebrootPath);
        if (!file_exists($webPath))
            throw new InvalidConfigException("Папка '{$webPath}' не найдена.");

        if (!is_writable($webPath))
            throw new InvalidConfigException("Папка '{$webPath}' не доступна для записи.");
    }

}
