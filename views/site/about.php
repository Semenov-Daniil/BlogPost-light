<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>

    <?php Pjax::begin(['id' => 'pjax-outer', 'linkSelector' => '#pjax-outer a', 'timeout' => 10000, 'formSelector' => '#pjax-outer form:not(#pjax-inner form)']); ?>

        <!-- Контент внешнего Pjax -->

        <?php Pjax::begin(['id' => 'pjax-inner', 'linkSelector' => '#pjax-inner a', 'timeout' => 10000, 'formSelector' => '#pjax-inner form',]); ?>

            <!-- Контент внутреннего Pjax -->
            <?= Html::a('Ссылка внутреннего Pjax', ['controller/inner-action'], ['data-pjax' => 0]) ?>
            <?= Html::beginForm(['controller/inner-form-action'], 'post', ['data-pjax' => '#pjax-inner']); ?>
                <!-- Поля формы -->
                <button type="submit">Отправить (внутренний)</button>
            <?= Html::endForm(); ?>

        <?php Pjax::end(); ?>

        <?= Html::a('Ссылка внешнего Pjax', ['controller/outer-action'], ['data-pjax' => 0]) ?>
        <?= Html::beginForm(['controller/outer-form-action'], 'post', ['data-pjax' => '#pjax-outer']); ?>
            <!-- Поля формы -->
            <button type="submit">Отправить (внешний)</button>
        <?= Html::endForm(); ?>

    <?php Pjax::end(); ?>
</div>
