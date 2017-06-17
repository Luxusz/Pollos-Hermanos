<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admixtures */

$this->title = 'Create Admixtures';
$this->params['breadcrumbs'][] = ['label' => 'Admixtures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admixtures-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'nombrer' => $nombrer,
        'productosLst' => $productosLst,
        
    ]) ?>

</div>
