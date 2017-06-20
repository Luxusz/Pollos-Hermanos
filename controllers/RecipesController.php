<?php

namespace app\controllers;

use Yii;
use app\models\Recipes;
use app\models\RecipesSearch;
use app\models\Users;
use app\models\Admixtures;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\web\Response;
/**
 * RecipesController implements the CRUD actions for Recipes model.
 */
class RecipesController extends Controller
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
                    'actions' => ['index','create','view','viewnot','update','misrecetas','recetas','createdynamic'],
                    'roles' => ['admin'],
                ],
                [
                    'allow' => true,
                    'actions' => ['index','create','view','viewnot','misrecetas','recetas','createdynamic'],
                    'roles' => ['usuario'],
                ],
            ],
        ],
    ];
    }

    /**
     * Lists all Recipes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecipesSearch();
        //$searchModel->users_id = Yii::$app->user->identity->id;
        $dataProvider = $searchModel->searchXY(Yii::$app->request->queryParams);
        
       

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionMisrecetas()
    {
        $searchModel = new RecipesSearch();
        $searchModel->users_id = Yii::$app->user->identity->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
       

        return $this->render('misrecetas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionRecetas()
    {
        $searchModel = new RecipesSearch();
        $dataProvider = $searchModel->searchX(Yii::$app->request->queryParams);
        
       

        return $this->render('recetas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Recipes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    
    public function actionViewnot($id)
    {
        return $this->render('viewnot', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Recipes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Recipes();
        /*$usuarios = Users::find()->all();
        $usuariosLst = ArrayHelper::map($usuarios, 'id', 'username');*/
        $usuarios = Users::find()->all();
        $usuariosLst = ArrayHelper::map($usuarios, 'id', 'username');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/admixtures/create', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'usuariosLst' => $usuariosLst,
            ]);
        }
    }
    
    
    public function actionCreatedynamic()
    {
        $model = new Recipes();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        $model->users_id = Yii::$app->user->identity->id;                
        $request = Yii::$app->request;
        if ($model->load($request->post())) {
            $model->save();
            $ingredientes = $request->post('admixtures');
            $unidades = $request->post('unities');
            $cantidades = $request->post('quantities');
            foreach($ingredientes as $i=>$productoId){
                $modelVP = new Admixtures();
                $unidad = $unidades[$i];
                $cantidad = $cantidades[$i];
                $modelVP->products_id = $productoId;
                $modelVP->unity = $unidad;
                $modelVP->quantity = $cantidad;
                $modelVP->recipes_id = $model->id;
                if($modelVP->validate()){
                    $modelVP->save();
                }
                else{
                    print_r($model->errors);
                }
            }
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('createdynamic', [
                'model' => $model,
            ]);
        }
        
    }

    /**
     * Updates an existing Recipes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $respaldo = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $request = Yii::$app->request;
            $ingredientes = $request->post('admixtures');
            $unidades = $request->post('unities');
            $cantidades = $request->post('quantities');
            $vpAnteriores = Admixtures::deleteAll(['recipes_id'=>$id]);
            foreach($ingredientes as $i=>$productoId){
                $modelVP = new Admixtures();
                $unidad = $unidades[$i];
                $cantidad = $cantidades[$i];
                $modelVP->products_id = $productoId;
                $modelVP->unity = $unidad;
                $modelVP->quantity = $cantidad;
                $modelVP->recipes_id = $model->id;
                if($modelVP->validate()){
                    $modelVP->save();
                }
                else{
                    print_r($model->errors);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'respaldo' => $respaldo,
            ]);
        }
    }

    /**
     * Deletes an existing Recipes model.
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
     * Finds the Recipes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recipes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recipes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
