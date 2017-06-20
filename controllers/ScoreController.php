<?php

namespace app\controllers;

use Yii;
use app\models\Recipes;
use app\models\Score;
use app\models\ScoreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * ScoreController implements the CRUD actions for Score model.
 */
class ScoreController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [                
                [
                    'allow' => true,
                    'actions' => ['index','create','view','update','createtolst'],
                    'roles' => ['admin'],
                ],
                [
                    'allow' => true,
                    'actions' => ['index','create','view','createtolst'],
                    'roles' => ['usuario'],
                ],
            ],
        ],
    ];
    }

    /**
     * Lists all Score models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScoreSearch();
        $dataProvider = $searchModel->searchX(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Score model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Score model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Score();
        $recetas = Recipes::findX()->all();
        $recetasLst = ArrayHelper::map($recetas, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'recetasLst' => $recetasLst,
            ]);
        }
    }
    
    public function actionCreatetolst($idr)
    {
        $model = new Score();
        $rrecetav = Recipes::findOne($idr);
        $recetav = $rrecetav -> id ;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('createtolst', [
                'model' => $model,
                'recetav' => $recetav,
            ]);
        }
    }

    /**
     * Updates an existing Score model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Score model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Score model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Score the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Score::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
