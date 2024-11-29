<?php

use app\models\Posts;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\YiiAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $statusesStyle */

$this->title = 'Панель администратора';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/searchAdminPosts.js', ['depends' => YiiAsset::class]);

?>
<div class="posts-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= Html::a('Список пользователей', ['/panel-admin/user'], ['class' => 'btn btn-success'])?>
    
    <?php Pjax::begin([
        'id' => 'pjax-posts',
        'enablePushState' => false,
        'timeout' => 10000
    ])?>

        <div class="cnt-search d-flex gap-3 justify-content-between flex-wrap">
            <div>
                Сортировка
                <div class="">
                    <?= $dataProvider->sort->link('created_at', ['label' => 'Время создания', 'class' => 'btn btn-outline-secondary', 'id' => 'search-created_at']) ?>
                </div>
            </div>
            <?= $this->render('_search', ['model' => $searchModel, 'statuses' => $statuses]); ?>
        </div>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'mb-3'],
            'itemView' => '_post',
            'layout' => "
                <div class=\"mb-3\">{pager}</div>\n
                <div>{items}</div>\n
                <div>{pager}</div>",
            'pager' => ['class' => LinkPager::class],
            'viewParams' => [
                'statusesStyle' => $statusesStyle
            ] 
        ]); ?>

    <?php Pjax::end(); ?>

</div>
