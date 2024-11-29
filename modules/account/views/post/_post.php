<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

/** @var app\models\Posts $model */
/** @var array $statusesStyle */

?>
<div class="post">
    <div class="card">
        <?php if ($model->image): ?>
            <img src="/<?= $model->image ?>" class="card-img-top object-fit-cover" alt="Изображение поста" style="height: 30rem;">
        <?php endif; ?>
        <div class="card-body">
            <h5 class="card-title"><?= $model->title ?> <span class="badge <?= $statusesStyle[$model->statuses->title] ?>"><?= $model->statuses->title ?></span></h5>
            <h6 class="card-subtitle mb-2 text-body-secondary"><?= $model->themes->title ?> | <?= $model->users->login ?> | <?= Yii::$app->formatter->asDatetime($model->created_at) ?></h6>
            <p class="card-text"><?= $model->preview ?></p>
            <div>
                <?= Html::a('Читать', ['/post/view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <? if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id == $model->users_id && $model->statuses->title == 'Одобрен'): ?>
                    <?= Html::a('Редактировать', ['/post/update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
                <? endif; ?>
                <? if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id == $model->users_id && $model->statuses->title == 'Редактирование'): ?>
                    <?= Html::a('Отправить на модерацию', ['modern', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                <? endif; ?>
                <? if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id == $model->users_id && count($model->comments) == 0): ?>
                    <?= Html::a('Удалить', ['/post/delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data' => ['method' => 'post']]) ?>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>
