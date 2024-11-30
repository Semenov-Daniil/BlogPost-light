<?php

namespace app\modules\admin\controllers;

use app\models\Users;
use app\modules\admin\models\BlockForm;
use app\modules\admin\models\UserSearch;
use yii\debug\models\search\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * UserController implements the CRUD actions for Users model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Users models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new BlockForm();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'blocks' => Users::getBlocks(),
            'blocksStyle' => Users::getBlocksStyle(),
            'blockModel' => $model,
            'userId' => null,
        ]);
    }

    public function actionBlockTime($id)
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new BlockForm();
        $userId = $id;

        if ($this->request->isAjax) {
            if ($model->load($this->request->post()) && $model->block($id)) {
                $model->date = '';
                $model->time = '';
                $userId = null;
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'blocks' => Users::getBlocks(),
            'blocksStyle' => Users::getBlocksStyle(),
            'blockModel' => $model,
            'userId' => $userId,
        ]);
    }

    public function actionBlockPermach($id)
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new BlockForm();
        $userId = $id;

        if ($this->request->isAjax) {
            if ($model->permach($id)) {
                $userId = null;
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'blocks' => Users::getBlocks(),
            'blocksStyle' => Users::getBlocksStyle(),
            'blockModel' => $model,
            'userId' => $userId,
        ]);
    }

    public function actionUnblock($id)
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new BlockForm();
        $userId = null;

        $this->findModel($id)->unblock();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'blocks' => Users::getBlocks(),
            'blocksStyle' => Users::getBlocksStyle(),
            'blockModel' => $model,
            'userId' => $userId,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
