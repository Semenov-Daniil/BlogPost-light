<?php

/** @var yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\Pjax;

/** @var app\models\Users $model */
/** @var array $blocks */
/** @var array $blocksStyle */
/** @var app\modules\admin\models\BlockForm $blockModel */
/** @var int|null $userId */

?>
<div class="user">
    <div class="card">
        <div class="">
            <div class="row g-0">
                <h5 class="card-title user-id col-md-auto m-0 p-3 text-center align-content-center">#<?= $model->id ?></h5>
                <div class="col p-3">
                    <h5 class="card-title"><?= Html::encode($model->surname) ?> <?= Html::encode($model->name) ?> <?= Html::encode($model->patronymic) ?> <span class="badge <?= $blocksStyle[$model->is_block] ?>"><?= $model->is_block ? "Заблокирован" . ($model->block_time ? ' до ' . Yii::$app->formatter->asDatetime($model->block_time) : ' навсегда') : 'Активный' ?></span></h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary"><?= Html::encode($model->login) ?> | <?= Yii::$app->formatter->asDatetime($model->registered_at) ?></h6>
                </div>
                <div class="user-action d-flex flex-lg-row flex-column flex-wrap col-md-auto p-3 gap-3 align-items-center">
                    <? if (!Yii::$app->user->isGuest && !$model->is_block): ?>
                    <?= Html::button('Заблокировать на время', ['class' => 'btn btn-primary col-mb-auto', 'type' => 'button', 'data' => ['bs-toggle' => 'collapse', 'bs-target' => "#collapseBlock$model->id"], 'aria' => ['expanded' => ($userId == $model->id ? 'true' : 'false'), 'controls' => "collapseBlock$model->id"]]) ?>
                    <?= Html::a('Заблокировать навсегда', ['block-permach', 'id' => $model->id], ['class' => 'btn btn-primary col-mb-auto']) ?>
                    <? endif; ?>
                    <? if (!Yii::$app->user->isGuest && $model->is_block): ?>
                    <?= Html::a('Разблокировать', ['unblock', 'id' => $model->id], ['class' => 'btn btn-primary col-mb-auto']) ?>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="collapse <?= $userId == $model->id ? 'show' : '' ?>" id="collapseBlock<?= $model->id ?>">
        <div class="card card-body mt-3">
            <h5 class="card-title">Блокировка пользователя #<?= $model->id ?></h5>
            <?php $form = ActiveForm::begin([
                'id' => "block-user-$model->id",
                'action' => ['block-time', 'id' => $model->id, ...Yii::$app->request->get()],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-7 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
                'options' => [
                    'data' => ['pjax' => '#pjax-list-users'],
                ],
            ]); ?>

            <div class="row flex-wrap">
                <div class="col-md-3">
                    <?= $form->field($blockModel, 'date')->textInput(['type' => 'date', 'min' => date('Y-m-d'), 'value' => date('Y-m-d')]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($blockModel, 'time')->textInput(['type' => 'time']) ?>
                </div>
            </div>


            <div class="form-group">
                <?= Html::submitButton('Заблокировать', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
