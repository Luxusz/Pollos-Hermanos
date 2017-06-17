<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recipes".
 *
 * @property integer $id
 * @property integer $users_id
 * @property string $name
 * @property string $comment
 *
 * @property ProductsPerRecipes[] $productsPerRecipes
 * @property Users $users
 * @property Score[] $scores
 */
class Recipes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recipes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users_id', 'name'], 'required'],
            [['users_id'], 'integer'],
            [['name'], 'string', 'max' => 40],
            [['comment'], 'string', 'max' => 100],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'users_id' => 'Nombre Creador',
            'name' => 'Nombre de la Receta',
            'comment' => 'Comentario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsPerRecipes()
    {
        return $this->hasMany(ProductsPerRecipes::className(), ['recipes_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScores()
    {
        return $this->hasMany(Score::className(), ['recipes_id' => 'id']);
    }
}
