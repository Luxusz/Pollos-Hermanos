<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Score */

$this->title = 'Puntuar';
$this->params['breadcrumbs'][] = ['label' => 'Puntuaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="score-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
