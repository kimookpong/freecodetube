<?php

namespace frontend\controllers;

use Yii;
use common\models\Video;
use common\models\VideoView;
use yii\helpers\FileHelper;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\base\Behavior;
use yii\filters\AccessControl;


class VideoController extends Controller
{   
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->published()->lastest()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionView($id)
    {
        $this->layout = 'auth';
        $video = Video::findOne($id);
        if(!$video){
            throw new NotFoundHttpException('Video does not exit');
        }

        $videoView = new VideoView();
        $videoView->video_id = $id;
        $videoView->user_id = Yii::$app->user->id;
        $videoView->created_at = time();
        $videoView->save();

        return $this->render('view',[
            'model' => $video
        ]);
    }

}