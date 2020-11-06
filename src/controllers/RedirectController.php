<?php
/**
 * Created by PhpStorm.
 * User: shurper
 * Date: 20.06.2018
 * Time: 10:10
 */

namespace shurper\banner\controllers;

use shurper\banner\models\AdsBanner;
use shurper\banner\models\AdsPopup;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RedirectController extends Controller
{
    public $defaultAction = 'redirect';

    /** Обрабатываем клик по баннеру.
     *  Проверяем, есть ли такой, активен ли, имеет ли он ссылку.
     *  Если да, то увеличиваем счетчик кликов и запускаем редирект.
     *
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionRedirect($id)
    {
        $model = AdsBanner::find()
            ->byId((int)$id)
            ->hasLink()
            ->active()
            ->one();

        if (!$model)
            throw new NotFoundHttpException("Requested banner not found, disabled or has no valid link.");

        $model->increaseClicks();

        return $this->redirect($model->href, 302);
    }

    /** Обрабатываем клик по поп-апу.
     *  Проверяем, есть ли такой, активен ли, имеет ли он ссылку.
     *  Если да, то увеличиваем счетчик кликов и запускаем редирект.
     *
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionPopup($id)
    {
        $model = AdsPopup::find()
            ->byId((int)$id)
            ->hasLink()
            ->active()
            ->one();

        if (!$model)
            throw new NotFoundHttpException("Requested banner not found, disabled or has no valid link.");

        $model->increaseClicks();

        return $this->redirect($model->href, 302);
    }

}
