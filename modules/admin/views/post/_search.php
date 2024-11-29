<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PostSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="posts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'd-flex gap-3 flex-wrap',
            'data' => ['pjax' => true]
        ]
    ]); ?>

    <?= $form->field($model, 'statuses_id')->dropDownList($statuses, ['prompt' => 'Выбрать статус']) ?>

    <div class="form-group d-flex gap-3 align-items-end">
        <?= Html::a('Сброс', ['/panel-admin'], ['class' => 'btn btn-outline-secondary', 'data' => ['pjax' => true]]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>