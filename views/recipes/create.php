<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Recipes */

$this->title = 'Crear Receta';
$this->params['breadcrumbs'][] = ['label' => 'Lista de Recetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'usuariosLst' => $usuariosLst,
    ]) ?>

</div>
