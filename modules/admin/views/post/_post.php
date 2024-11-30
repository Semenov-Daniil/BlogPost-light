<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\web\YiiAsset;

/** @var app\models\Posts $model */
/** @var array $statusesStyle */

$this->registerJsFile('js/cancelModal.js', ['depends' => YiiAsset::class]);

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
                <? if (!Yii::$app->user->isGuest && $model->statuses->title == 'Модерация'): ?>
                    <?= Html::a('Одобрить', ['change-status', 'postId' => $model->id, 'status' => 'Одобрен'], ['class' => 'btn btn-success']) ?>
                <? endif; ?>
                <? if (!Yii::$app->user->isGuest && $model->statuses->title == 'Модерация'): ?>
                    <?= Html::a('Запретить', ['change-status', 'postId' => $model->id, 'status' => 'Запрещен'], ['class' => 'btn btn-danger']) ?>
                <? endif; ?>
                <? if (!Yii::$app->user->isGuest): ?>
                    <?= Html::a('Удалить', ['/post/delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data' => ['method' => 'post']]) ?>
                <? endif; ?>
                <? if (!Yii::$app->user->isGuest): ?>
                    <?= Html::a('Удалить (modal)', ['cancel-modal', 'id' => $model->id], ['class' => 'btn btn-danger btn-cancel-modal', 'data' => ['pjax' => true]]) ?>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>

<?php

Modal::begin([
    'id' => 'cancel-modal',
    'title' => 'Hello world',
]);

echo 'Say hello...';

Modal::end();