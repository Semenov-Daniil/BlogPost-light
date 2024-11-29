<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

/** @var app\models\Users $model */
/** @var array $blocksStyle */
/** @var array $blocks */

?>
<div class="post">
    <div class="card">
        <div class="">
            <div class="row g-0">
                <h5 class="card-title col-md-auto m-0 p-3 text-center align-content-center border-end border-bottom">#<?= $model->id ?></h5>
                <div class="col p-3">
                    <h5 class="card-title"><?= Html::encode($model->surname) ?> <?= Html::encode($model->name) ?> <?= Html::encode($model->patronymic) ?> <span class="badge <?= $blocksStyle[$model->is_block] ?>"><?= $blocks[$model->is_block] ?></span></h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary"><?= Html::encode($model->login) ?> | <?= Yii::$app->formatter->asDatetime($model->registered_at) ?></h6>
                </div>
                <div class="border-start border-top d-flex flex-lg-row flex-column flex-wrap col-md-auto p-3 gap-3 align-items-center">
                    <? if (!Yii::$app->user->isGuest && !$model->is_block): ?>
                        <?= Html::a('Заблокировать на время', ['block-time', 'id' => $model->id], ['class' => 'btn btn-primary col-mb-auto']) ?>
                        <?= Html::a('Заблокировать на всегда', ['block-permach', 'id' => $model->id], ['class' => 'btn btn-primary col-mb-auto']) ?>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
