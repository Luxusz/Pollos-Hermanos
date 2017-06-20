<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    
      
     
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionRegister()
    {
        $model = new Users();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            //si la vista se carga mediante post (el usuario presiono el boton submit)
            //se creara una variable hash en la que se generara una clave encriptada
            $hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            //luego, se le dice a la clave del modelo que sea igual a la clave encriptada
            $model->password = $hash;
            //finalmente, se guarda en la bd y se redirige a la vista de detalles
            if($model->validate()){
                    $model->save();                    
                    $auth = Yii::$app->authManager;
                    $rolNuevoYii = $auth->getRole($model->role);
                    $auth->assign($rolNuevoYii, $model->id);
                }
                else{
                    print_r($model->errors);
                    echo "<meta http-equiv='refresh' content='8; ".Url::toRoute("users/register")."'>";
                }
                
            
            return $this->redirect(['site/login']);
        } else {
            //si no, la llamada es mediante get, por lo que debe renderizar la vista
            //con todos los elementos correspondientes al modelo, y adicionalmente
            //el arreglo de items que creamos previamente
            return $this->render('register', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionLobby()
    {
        return $this->render('lobby');
    }
    
    public function actionLobbyu()
    {
        return $this->render('lobbyu');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        
        if (!\Yii::$app->user->isGuest) {
            
            return $this->goHome();
        }

        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            return $this->render('lobby');        
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('http://localhost/polloshermanos/web/index.php?r=site%2Flogin');   
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    /*public function actionRoles(){
    
        /*$auth = Yii::$app->authManager;
        
        $rol1 = "admin";
        $rol2 = "usuario";
        
        try{
            $rolAuth1 = $auth->createRole($rol1);
            $rolAuth2 = $auth->createRole($rol2);
            $auth->add($rolAuth1);
            $auth->add($rolAuth2);
        } catch (Exception $ex) {

        }
        
        
    }*/
}
