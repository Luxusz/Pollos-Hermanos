<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admixtures".
 *
 * @property integer $id
 * @property integer $products_id
 * @property integer $recipes_id
 * @property string $quantity
 * @property string $unity
 * @property string $comment
 */
class Admixtures extends \yii\db\ActiveRecord
{
    public $recipes_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admixtures';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['products_id', 'recipes_id', 'quantity', 'unity'], 'required'],
            [['products_id', 'recipes_id'], 'integer'],
            [['quantity'], 'string', 'max' => 5],
            [['unity', 'comment'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'products_id' => 'Ingrediente',
            'recipes_id' => 'Receta',
            'quantity' => 'Cantidad',
            'unity' => 'Unidad',
            'comment' => 'Comentario',
            'recipes_name' => 'Receta',
        ];
    }
}
