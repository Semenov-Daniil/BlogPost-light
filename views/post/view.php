<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var app\models\Comments $comment */
/** @var yii\data\ActiveDataProvider $commentsList */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Посты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerJsFile('js/reaction.js', ['depends' => YiiAsset::class])

?>
<div class="posts-view">

    <div class="post mb-5">
        <div class="card">
            <?php if ($model->image): ?>
                <img src="/<?= $model->image ?>" class="card-img-top object-fit-cover" alt="Изображение поста" style="height: 30rem;">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= $model->title ?></h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?= $model->themes->title ?> | <?= $model->users->login ?> | <?= Yii::$app->formatter->asDatetime($model->created_at) ?></h6>
                <p class="card-text"><?= $model->text ?></p>
                <div>
                    <? if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id == $model->users_id): ?>
                        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                    <? endif; ?>
                    <? if (!Yii::$app->user->isGuest && (Yii::$app->user->identity->isAdmin || (Yii::$app->user->identity->id == $model->users_id && $commentsList->getCount() == 0))): ?>
                        <?= Html::button('Удалить', ['class' => 'btn btn-danger', 'data-bs-toggle' => "modal", 'data-bs-target' => "#deleteModal"]) ?>
                    <? endif; ?>
                </div>
                <div class="reaction mt-4">
                    <?= Html::a("👍 <span class='count-reaction'>$model->like</span>", ['reaction', 'postId' => $model->id, 'reaction' => 1], ['class' => 'text-decoration-none btn-reaction']) ?>
                    <?= Html::a("👎 <span class='count-reaction'>$model->dislike</span>", ['reaction', 'postId' => $model->id, 'reaction' => 0], ['class' => 'text-decoration-none btn-reaction']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->identity->isAdmin || Yii::$app->user->identity->id == $model->users_id)): ?>
        <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Удаление поста: <?= $model->title  ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Вы точно хотите удалить пост: <?= $model->title ?>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <?= Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data' => ['method' => 'post']]) ?>
                    </div>
                </div>
            </div>
        </div>
    <? endif; ?>

    <h3 class="mb-3">Комментарии</h3>

    <?php Pjax::begin([
        'id' => 'pjax-comment-form',
        'enablePushState' => false,
        'timeout' => 10000,
    ]); ?>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAuthor && Yii::$app->user->identity->id !== $model->users_id): ?>
            <div class="mb-4">
                <?php $form = ActiveForm::begin([
                    'id' => 'comment-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'col-lg-3 form-control'],
                        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                    ],
                    'options' => [
                        'data' => ['pjax' => true],
                    ],
                    'action' => "/comment/create?postId=$model->id"
                ]); ?>
        
                <?= $form->field($comment, 'text')->textarea(['rows' => 6])->label('Написать комментарий') ?>
        
                <div class="form-group">
                    <div>
                        <?= Html::submitButton('Отправить комментарий', ['class' => 'btn btn-primary', 'name' => 'comment-button']) ?>
                    </div>
                </div>
        
                <?php ActiveForm::end(); ?>
            </div>
        <?php endif; ?>

        <?= ListView::widget([
            'dataProvider' => $commentsList,
            'itemOptions' => ['class' => 'mb-3'],
            'itemView' => '_comment',
            'viewParams' => [
                'authorPostId' => $model->users_id,
                'comment' => $comment,
            ],
            'layout' => "{items}"
        ]) ?>
    <?php Pjax::end(); ?>

</div>
