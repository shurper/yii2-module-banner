<?php
/**
 * Created by PhpStorm.
 * User: shurper
 * Date: 19.06.2018
 * Time: 20:22
 *
 * @var $model AdsPlace
 * @var $this View
 *
 */

use shurper\banner\models\AdsPlace;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'options' => ['class' => 'modaledit-form'],
    'enableClientValidation' => true
]);

$this->registerJs("updateAdsPlaceForm()");

?>
<div class="modal-header">
    <h2><?= $model->isNewRecord ? "Добавление плащадки" : "Редактирование плащадки"; ?></h2>
</div>

<div class="modal-body">

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-9">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->checkbox() ?>
            <?= $form->field($model, 'slider')->checkbox() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'desktop_width') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'desktop_height') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mobile_width') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mobile_height') ?>
        </div>
    </div>

    <div id="adsplace-form-slider-block">
        <br>
        <h2>Настройки слайдера</h2>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'slider_direction')->dropDownList($model->directions) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'slider_time')->textInput(['placeholder' => 3000]) ?>
            </div>
            <div class="col-md-3" style="padding-top: 25px">
                <?= $form->field($model, 'slider_arrows')->checkbox() ?>
            </div>
        </div>
    </div>

</div>

<div class="modal-footer">
    <?= Html::a('Отмена', '', ['class' => 'btn btn-default modaledit-disable']) ?>
    <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
