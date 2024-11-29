<?php

use app\models\Users;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\YiiAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\admin\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/searchAdminUsers.js', ['depends' => YiiAsset::class]);
?>
<div class="users-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php Pjax::begin([
        'id' => 'pjax-users',
        // 'enablePushState' => false,
        'timeout' => 10000
    ])?>

        <div class="cnt-search d-flex gap-3 justify-content-between flex-wrap">
            <div>
                Сортировка
                <div class="">
                    <?= $dataProvider->sort->link('id', ['label' => 'ID', 'class' => 'btn btn-outline-secondary']) ?>
                </div>
            </div>
            <?= $this->render('_search', ['model' => $searchModel, 'blocks' => $blocks]); ?>
        </div>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'mb-3'],
            'itemView' => '_user',
            'layout' => "
                <div class=\"mb-3\">{pager}</div>\n
                <div>{items}</div>\n
                <div>{pager}</div>",
            'pager' => ['class' => LinkPager::class],
            'viewParams' => [
                'blocksStyle' => $blocksStyle,
                'blocks' => $blocks,
            ]
        ]); ?>

    <?php Pjax::end(); ?>

</div>
