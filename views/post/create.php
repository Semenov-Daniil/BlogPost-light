<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var app\models\Themes $themes */

$this->title = 'Содание поста';
$this->params['breadcrumbs'][] = ['label' => 'Посты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'themes' => $themes
    ]) ?>

</div>
