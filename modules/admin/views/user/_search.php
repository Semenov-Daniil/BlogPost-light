<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\UserSearch $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'd-flex gap-3 flex-wrap',
            'data' => ['pjax' => true]
        ],
        'fieldConfig' => ['template' => '{label}{input}'],
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
        'enableClientScript' => false,
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'login') ?>

    <?= $form->field($model, 'is_block')->dropDownList($blocks, ['prompt' => 'Все пользователи']) ?>


    <div class="form-group d-flex gap-3 align-items-end">
        <?= Html::a('Сброс', ['/panel-admin/user'], ['class' => 'btn btn-outline-secondary', 'data' => ['pjax' => true]]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
