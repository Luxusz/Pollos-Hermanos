<?php

namespace app\controllers;
/**
 * Prueba awdawda
 */
use Yii;
use app\models\Admixtures;
use app\models\AdmixturesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * AdmixturesController implements the CRUD actions for Admixtures model.
 */
class AdmixturesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Admixtures models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdmixturesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admixtures model.
     * @param integer $id
     * @param integer $products_id
     * @param integer $recipes_id
     * @return mixed
     */
    public function actionView($id, $products_id, $recipes_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $products_id, $recipes_id),
        ]);
    }

    /**
     * Creates a new Admixtures model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Admixtures();
        $receta = \app\models\Recipes::findOne($id);
        $nombrer = $receta->name;
        
        $productos = \app\models\Products::find()->all();
        $productosLst = ArrayHelper::map($productos, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'nombrer' => $nombrer,
                'productosLst' => $productosLst,
                
            ]);
        }
    }

    /**
     * Updates an existing Admixtures model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $products_id
     * @param integer $recipes_id
     * @return mixed
     */
    public function actionUpdate($id, $products_id, $recipes_id)
    {
        $model = $this->findModel($id, $products_id, $recipes_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'products_id' => $model->products_id, 'recipes_id' => $model->recipes_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admixtures model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $products_id
     * @param integer $recipes_id
     * @return mixed
     */
    public function actionDelete($id, $products_id, $recipes_id)
    {
        $this->findModel($id, $products_id, $recipes_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admixtures model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $products_id
     * @param integer $recipes_id
     * @return Admixtures the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $products_id, $recipes_id)
    {
        if (($model = Admixtures::findOne(['id' => $id, 'products_id' => $products_id, 'recipes_id' => $recipes_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
