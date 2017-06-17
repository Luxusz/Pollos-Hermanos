<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admixtures */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admixtures-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'products_id')->dropDownList($productosLst,['prompt'=>'SELECCIONE UN PRODUCTO']);
    ?>

    <?= $form->field($model, 'recipes_name')->textInput(['value'=>$nombrer]) ?>

    <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Agregar' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        
        
        <?= Html::a('No Agregar Más', ['/recipes/index'], ['class'=>'btn btn-primary']) ?>
    </div>
    
    <div class="form-group">
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
