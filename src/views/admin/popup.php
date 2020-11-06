<?php
/**
 * Created by PhpStorm.
 * User: shurper
 * Date: 19.06.2018
 * Time: 13:13
 *
 * @var $this View
 * @var $model AdsBannerFilter;
 */

use shurper\banner\assets\BannerAsset;
use shurper\banner\models\AdsBannerFilter;
use shurper\banner\models\AdsPopup;
use shurper\banner\widgets\TabWidget;
use shurper\editmodal\EditModalHelper;
use shurper\editmodal\IconHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\BootstrapAsset;
use shurper\editmodal\EditModalAsset;

BootstrapAsset::register($this);
BannerAsset::register($this);
EditModalAsset::register($this);


$this->title = 'Pop-up';

echo Html::tag('h1', 'Баннеры');

echo TabWidget::widget();

echo EditModalHelper::editBtn(
    'popup-form',
    0,
    'btn btn-sm btn-primary btn-banner-add',
    IconHelper::PLUS . " добавить баннер"
);


$form = ActiveForm::begin([
    'method' => 'GET',
    'options' => ['class' => 'autosubmit', 'data-container' => '#items'],
    'enableClientValidation' => false,
]); ?>
    <div class="filter-block">
        <div class="row">

            <div class="col-md-8">
                <?= $form->field($model, 'filter')
                    ->label(false)
                    ->textInput(['placeholder' => 'Поиск по pop-up баннерам', 'autofocus' => true]) ?>
            </div>

            <div class="col-md-2">
                <?= $form->field($model, "status")
                    ->label(false)
                    ->dropDownList(['Активные', 'Выключенные'], ['prompt' => 'Все статусы']) ?>
            </div>

            <div class="col-md-2">
                <?= $form->field($model, "archive")
                    ->label(false)
                    ->dropDownList(['Актуальные', 'Архивные']) ?>
            </div>

        </div>
    </div>

<?php
ActiveForm::end();

Pjax::begin(['id' => 'items']);

echo GridView::widget([
    'dataProvider' => $model->dataProvider(),
    'tableOptions' => ['class' => 'table table-striped table-banners'],
    'layout' => "{items}\n{pager}\n{summary}",
    'columns' => [
        'id',
        [
            'attribute' => 'title',
            'content' => function (AdsPopup $model): string {
                if ($model->status == AdsPopup::STATUS_DISABLED)
                    $html = Html::tag('span', $model, ['class' => 'striked']);
                else
                    $html = $model;
                return $html;
            }
        ],
        'views',
        'clicks',
        ['contentOptions' => ['style' => 'min-width:100px; text-align:right;'],
            'content' => function (AdsPopup $model) {
                return
                    EditModalHelper::editBtn('/banner/admin/popup-form', $model->id) .
                    EditModalHelper::deleteBtn('/banner/admin/popup-delete', $model->id);
            },
        ]
    ]
]);

Pjax::end();

