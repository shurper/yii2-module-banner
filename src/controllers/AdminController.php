<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 13:13
 */

namespace floor12\banner\controllers;

use floor12\banner\models\AdsBanner;
use floor12\banner\models\AdsPlace;
use yii\web\Controller;
use \Yii;
use floor12\banner\models\AdsBannerFilter;
use floor12\banner\models\AdsPlaceFilter;
use floor12\editmodal\EditModalAction;
use floor12\editmodal\DeleteAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/** Контроллер для управления баннерами
 * Class AdminController
 * @package floor12\banner\controllers
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
                        'roles' => [Yii::$app->getModule('banner')->editRole],
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
        $this->layout = Yii::$app->getModule('banner')->layout;
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

    /** Подключаем необходимые экшены для редактирования и удаления площадок и баннеров
     *  Для обеспечения этого функционала используем пакет floor12\editmodal для редактирования в модальном окне
     * @return array
     */
    public function actions(): array
    {
        return [
            'place-form' => [
                'class' => EditModalAction::class,
                'model' => AdsPlace::class,
                'view' => '_form_place',
                'message' => 'Площадка сохранена',
            ],
            'place-delete' => [
                'class' => DeleteAction::class,
                'model' => AdsPlace::class,
                'message' => 'Площадка удалена',
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
            'banner-delete' => [
                'class' => DeleteAction::class,
                'model' => AdsBanner::class,
                'message' => 'Баннер удален',
            ]
        ];
    }
}