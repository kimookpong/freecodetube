<?php
/**@var $model \common\models\Video */

use \yii\helpers\StringHelper;
use \yii\helpers\Url;
?>

<div class="media">
<a href="<?php echo Url::to(['/video/update','id'=>$model->video_id])?>">
<div class="embed-responsive embed-responsive-16by9 mr-2" style="width:140px;">
                <video class="embed-responsive-item" poster="<?php echo $model->getThumbnailLink() ?>" src="<?php echo $model->getVideoLink() ?>" ></video>
            </div>
</a>

  <div class="media-body">
    <h5 class="mt-0"><?php echo $model->title?></h5>
    
    <?php echo StringHelper::truncateWords($model->descriptipn,10)?>    
</div>
</div>