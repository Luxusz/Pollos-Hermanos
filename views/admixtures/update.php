<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admixtures */

$this->title = 'Update Admixtures: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admixtures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'products_id' => $model->products_id, 'recipes_id' => $model->recipes_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admixtures-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
