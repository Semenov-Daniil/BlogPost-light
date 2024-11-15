<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\YiiAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var app\models\Themes $themes */
/** @var yii\widgets\ActiveForm $form */

$this->registerJsFile('js/post.js', ['depends' => YiiAsset::class]);

?>

<div class="posts-form">

    <?php Pjax::begin([
        'id' => 'pjax-post-form',
        'enablePushState' => false,
        'timeout' => 10000,
    ]); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'post-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
            'options' => [
                'data' => ['pjax' => true],
                'enctype' => 'multipart/form-data',
            ]
        ]); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'preview')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'themes_id')->dropDownList($themes, ['prompt' => 'Выбрите тему', 'disabled' => $model->check]) ?>

        <?= $form->field($model, 'check')->checkbox() ?>

        <?= $form->field($model, 'theme')->textInput(['maxlength' => true, 'disabled' => !$model->check]) ?>

        <?= $form->field($model, 'uploadFile')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>
