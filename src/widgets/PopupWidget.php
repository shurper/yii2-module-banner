<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 12:13
 */

namespace floor12\banner\widgets;

use floor12\banner\models\AdsPopup;
use \Yii;
use floor12\banner\models\AdsPlace;
use yii\base\Widget;
use yii\web\Cookie;

class PopupWidget extends Widget
{

    const COOKIE_NAME = 'popup-banner-showed';

    private $_banner;

    /**
     * @return bool
     */
    public function init(): bool
    {
        // Некоторые браузеры любят посылать HEAD запросы, что ошибочно увеличивает счетчик просмотров
        if (Yii::$app->request->method == 'HEAD')
            return false;

        $cookie = Yii::$app->request->cookies->get(self::COOKIE_NAME);

        if (!$cookie)
            $this->_banner = AdsPopup::find()->active()->orderBy('RAND()')->one();

        return true;
    }

    /** Рендерим вьюху
     * @return string
     */
    public function run(): string
    {
        if (!$this->_banner)
            return "";
        else {
            $this->_banner->increaseViews();
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'popup-banner-showed',
                'value' => 'true',
                'expire' => time() + $this->_banner->repeat_period
            ]));
            return $this->render('popupWidget', ['model' => $this->_banner]);
        }

    }

}