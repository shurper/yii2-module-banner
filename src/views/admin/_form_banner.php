<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 20:22
 *
 * @var $model \floor12\banner\models\AdsPlace
 * @var $this \yii\web\View
 * @var $places array
 *
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use floor12\files\components\FileInputWidget;
use kartik\select2\Select2;
use \kartik\date\DatePicker;

$datePickerOptions = [
    'language' => 'ru',
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd.mm.yyyy'
    ]
];

$form = ActiveForm::begin([
    'options' => ['class' => 'modaledit-form'],
    'enableClientValidation' => true
]);


?>
<div class="modal-header">
    <h2><?= $model->isNewRecord ? "Добавление баннера" : "Редактирование баннера"; ?></h2>
</div>
<div class="modal-body">

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'show_start')->widget(DatePicker::class, $datePickerOptions) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'show_end')->widget(DatePicker::class, $datePickerOptions) ?>
        </div>
        <div class="col-md-3" style="padding-top: 31px;">
            <?= $form->field($model, 'status')->checkbox() ?>
        </div>
    </div>

    <?= $form->field($model, 'href') ?>

    <?= $form->field($model, 'place_ids')->widget(Select2::class, [
        'data' => $places,
        'language' => 'ru',
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'file_desktop')->widget(FileInputWidget::class, []) ?>

    <?= $form->field($model, 'file_mobile')->widget(FileInputWidget::class, []) ?>

</div>

<div class="modal-footer">
    <?= Html::a('Отмена', '', ['class' => 'btn btn-default modaledit-disable']) ?>
    <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>