<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $lastname
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $authKey
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'lastname', 'username', 'email', 'password', 'role'], 'required'],
            [['name', 'lastname', 'role'], 'string', 'max' => 15],
            [['username', 'authKey'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 80],
            [['password'], 'string', 'max' => 70],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'lastname' => 'Apellido',
            'username' => 'Nombre de Usuario',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Rol',
            'authKey' => 'Auth Key',
        ];
    }
    
    public static function findIdentity($id){
            return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null){
            throw new NotSupportedException();//I don't implement this method because I don't have any access token column in my database
    }

    public function getId(){
            return $this->id;
    }

    public function getAuthKey(){
            return $this->authKey;//Here I return a value of my authKey column
    }

    public function validateAuthKey($authKey){
            return $this->authKey === $authKey;
    }
    public static function findByUsername($username){
            return self::findOne(['username'=>$username]);
    }

    public function validatePassword($password){
        
        //se cambia la validacion por defecto a validacion de clave encriptada
        $user = Users::findOne(['username'=>$this->username]);
        if ($user!=null) {
            //busca al usuario en la bd, y si no es null, obtiene el hash y lo compara
            $hash = $user->password;
            if(Yii::$app->getSecurity()->validatePassword($password, $hash)) {
                //de ser iguales, puede iniciar sesion
                return true;
            }
        }
        //caso contrario, retorna falso y se mantiene en la vista de login
        return false;
    }
}

