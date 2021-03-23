<?php

/* @var $model \common\models\Video */
?>

<div class="row">
    <div class="col-sm-8">
        <div class="embed-responsive embed-responsive-16by9 mb-3">
            <video class="embed-responsive-item" poster="<?php echo $model->getThumbnailLink() ?>" src="<?php echo $model->getVideoLink() ?>" controls autoplay></video>
        </div>
        <h6 class="m-2"><?php echo $model->title ?></h6>
        <div class="d-flex justify-content-between align-item-center">
            <div>
                <?php echo $model->getViews() ?> views . <?php echo Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
            <div>
                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-thumbs-up"></i> 9</button>
                <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-thumbs-down"></i> 3</button>
            </div>
        </div>
    </div>
    <div class="col-sm-4">

    </div>
</div>