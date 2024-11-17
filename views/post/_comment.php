<?php

/** @var yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var app\models\Comments $model */
/** @var int $authorPostId */
/** @var app\models\Comments $comment */

?>
<div class="comment mb-3">
    <div class="card mb-3">
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-body-secondary"><?= $model->login ?> | <?= Yii::$app->formatter->asDatetime($model->created_at) ?></h6>
            <p class="card-text"><?= $model->text ?></p>
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAuthor && Yii::$app->user->identity->id == $authorPostId && Yii::$app->user->identity->id !== $model->users_id): ?>
                <?= Html::button('Ответить', ['class' => 'btn btn-primary mb-3', 'data-bs-toggle'=>"collapse", 'data-bs-target'=>"#answerComment$model->id", "aria-expanded"=>"false", "aria-controls"=>"answerComment$model->id"]); ?>
                <div class="collapse" id="answerComment<?= $model->id ?>">
                    <div class="card card-body">
                        <?php $form = ActiveForm::begin([
                            'id' => 'answer-comment-form',
                            'fieldConfig' => [
                                'template' => "{label}\n{input}\n{error}",
                                'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
                                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                            ],
                            'options' => [
                                'data' => ['pjax' => true],
                            ],
                            'action' => "/comment/create?postId=$model->posts_id&answerId=$model->id"
                        ]); ?>
                
                        <?= $form->field($comment, 'text')->textarea(['rows' => 6])->label('Написать ответ на комментарий') ?>
                
                        <div class="form-group">
                            <div>
                                <?= Html::submitButton('Отправить ответ на комментарий', ['class' => 'btn btn-primary', 'name' => 'comment-button']) ?>
                            </div>
                        </div>
                
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            <?php endif;?>
        </div>
    </div>
    <?php if ($model->answers): ?>
        <div class="ms-4">
            <?php foreach($model->answers as $answer): ?>
                <?= $this->render('_comment', [
                    'model' => $answer,
                    'authorPostId' => $authorPostId
                ]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif;?>
</div>
