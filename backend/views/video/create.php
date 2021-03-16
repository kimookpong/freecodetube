<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex flex-column justify-content-center align-items-center">

        <div class="upload-icon">
            <i class="fas fa-upload"></i>
        </div>
        <p class="m-0">ลากและวางไฟล์วิดีโอเพื่ออัปโหลด</p>
        <p class="text-muted">วิดีโอจะเป็นแบบส่วนตัวจนกว่าคุณจะเผยแพร่</p>
        <?php $form = \yii\bootstrap4\ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]) ?>

        <?php echo $form->errorSummary($model);?>
        <button class="btn btn-primary btn-file">
            Selected File
            <input type="file" id="videoFile" name="video">
        </button>
        <?php  \yii\bootstrap4\ActiveForm::end() ?>
    </div>


</div>
