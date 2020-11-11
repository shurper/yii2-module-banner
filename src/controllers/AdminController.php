<?php
/**
 * Created by PhpStorm.
 * User: shurper
 * Date: 19.06.2018
 * Time: 13:13
 */

namespace shurper\banner\controllers;

use shurper\banner\models\AdsBanner;
use shurper\banner\models\AdsBannerFilter;
use shurper\banner\models\AdsPlace;
use shurper\banner\models\AdsPlaceFilter;
use shurper\banner\models\AdsPopPlaceFilter;
use shurper\banner\models\AdsPopup;
use shurper\banner\models\AdsPopupFilter;
use shurper\banner\models\AdsPopupPlace;
use shurper\editmodal\DeleteAction;
use shurper\editmodal\EditModalAction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/** Контроллер для управления баннерами
 * Class AdminController
 * @package shurper\banner\controllers
 */
class AdminController extends Controller
{
    public $defaultAction = 'banner';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Yii::$app->getModule('banner')->administratorRole],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'place-delete' => ['delete'],
                    'banner-delete' => ['delete'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = Yii::$app->getModule('banner')->adminLayout;
    }

    public function beforeAction($action)
    {
        if(!Yii::$app->user->identity->isAdmin()){
            return $this->goHome();
        }
    }
    /** Страница управления баннерами
     * @return string
     */
    public function actionBanner(): string
    {
        $model = new AdsBannerFilter();
        $model->load(Yii::$app->request->get());
        $model->validate();
        return $this->render('banner', ['model' => $model]);
    }

    /** Страница управления площадками
     * @return string
     */
    public function actionPlace(): string
    {
        $model = new AdsPlaceFilter();
        $model->load(Yii::$app->request->get());
        $model->validate();
        return $this->render('places', ['model' => $model]);
    }

    /** Страница управления pop-up баннерами
     * @return string
     */
    public function actionPopup(): string
    {
        $model = new AdsPopupFilter();
        $model->load(Yii::$app->request->get());
        $model->validate();
        return $this->render('popup', ['model' => $model]);
    }

    /** Страница управления pop-up площадками
     * @return string
     */
    public function actionPopPlace(): string
    {
        $model = new AdsPopPlaceFilter();
        $model->load(Yii::$app->request->get());
        $model->validate();
        return $this->render('popup_places', ['model' => $model]);
    }

    /** Подключаем необходимые экшены для редактирования и удаления площадок и баннеров
     *  Для обеспечения этого функционала используем пакет shurper\editmodal для редактирования в модальном окне
     * @return array
     */
    public function actions(): array
    {
        return [
            // Формы
            'place-form' => [
                'class' => EditModalAction::class,
                'model' => AdsPlace::class,
                'view' => '_form_place',
                'message' => 'Площадка сохранена',
            ],
            'popup-place-form' => [
                'class' => EditModalAction::class,
                'model' => AdsPopupPlace::class,
                'view' => '_form_popup_place',
                'message' => 'Площадка сохранена',
            ],
            'popup-form' => [
                'class' => EditModalAction::class,
                'model' => AdsPopup::class,
                'view' => '_form_popup',
                'message' => 'Баннер сохранен',
                'viewParams' => [
                    'places' => AdsPopupPlace::find()
                        ->select('title')
                        ->orderBy('title')
                        ->indexBy('id')
                        ->column()
                ]
            ],
            'banner-form' => [
                'class' => EditModalAction::class,
                'model' => AdsBanner::class,
                'view' => '_form_banner',
                'message' => 'Баннер сохранен',
                'viewParams' => [
                    'places' => AdsPlace::find()
                        ->select('title')
                        ->orderBy('title')
                        ->indexBy('id')
                        ->column()
                ]
            ],
            // Удаления
            'place-delete' => [
                'class' => DeleteAction::class,
                'model' => AdsPlace::class,
                'message' => 'Площадка удалена',
            ],
            'popup-delete' => [
                'class' => DeleteAction::class,
                'model' => AdsPopup::class,
                'message' => 'Баннер удален',
            ],
            'banner-delete' => [
                'class' => DeleteAction::class,
                'model' => AdsBanner::class,
                'message' => 'Баннер удален',
            ],
            'popup-place-delete' => [
                'class' => DeleteAction::class,
                'model' => AdsPopupPlace::class,
                'message' => 'Площадка удалена',
            ]
        ];
    }
}
