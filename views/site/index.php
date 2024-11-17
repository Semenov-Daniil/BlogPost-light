<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="text-center my-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="fw-bolder fst-italic font-monospace">Вдохновляйся, твори, выкладывай!</p>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'mb-3'],
        'itemView' => '../post/_post.php',
        'layout' => "<div>{items}</div>",
    ]); ?>

</div>
