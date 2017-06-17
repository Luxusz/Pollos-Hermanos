<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admixtures */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admixtures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admixtures-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'products_id' => $model->products_id, 'recipes_id' => $model->recipes_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'products_id' => $model->products_id, 'recipes_id' => $model->recipes_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'products_id',
            'recipes_id',
            'quantity',
            'unity',
            'comment',
        ],
    ]) ?>

</div>
