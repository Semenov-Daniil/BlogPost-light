<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

/** @var app\models\Posts $model */

?>
<div class="post">
    <div class="card">
        <?php if ($model->image): ?>
            <img src="/<?= $model->image ?>" class="card-img-top object-fit-cover" alt="Изображение поста" style="height: 30rem;">
        <?php endif; ?>
        <div class="card-body">
            <h5 class="card-title"><?= $model->title ?></h5>
            <h6 class="card-subtitle mb-2 text-body-secondary"><?= $model->themes->title ?> | <?= $model->users->login ?> | <?= Yii::$app->formatter->asDatetime($model->created_at) ?></h6>
            <p class="card-text"><?= $model->preview ?></p>
            <div>
                <?= Html::a('Читать', ['post/view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <? if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id == $model->users_id): ?>
                    <?= Html::a('Редактировать', ['post/view', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                <? endif; ?>
                <? if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin): ?>
                    <?= Html::a('Удалить', ['post/delete', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>
