<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\behaviors\BlameableBehavior;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

/**
 * This is the model class for table "{{%videos}}".
 *
 * @property string $video_id
 * @property string $title
 * @property string|null $descriptipn
 * @property string|null $tags
 * @property int|null $status
 * @property int|null $has_thumnail
 * @property string|null $video_name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 */
class Video extends \yii\db\ActiveRecord
{
    const STATUS_UNLISTED = 0;
    const STATUS_PUBLISHED = 1;
     /**
     * @var \yii\web\uploadedFile
     */
    public $video;

    public $thumnail;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%videos}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'title'], 'required'],
            [['descriptipn'], 'string'],
            [['status', 'has_thumnail', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['video_id'], 'string', 'max' => 16],
            [['title', 'tags', 'video_name'], 'string', 'max' => 512],
            [['video_id'], 'unique'],
            ['has_thumnail','default','value' => 0],
            ['status','default','value' => self::STATUS_UNLISTED],
            ['thumnail','image','minWidth'=>300],
            ['video','file','extensions' => ['mp4']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'title' => 'Title',
            'descriptipn' => 'Descriptipn',
            'tags' => 'Tags',
            'status' => 'Status',
            'has_thumnail' => 'Has Thumnail',
            'video_name' => 'Video Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'thumnail' => 'Thumbnail'
        ];
    }

    public function getStatusLabels()
    {
        return [
            self::STATUS_UNLISTED => 'Unlisted',
            self::STATUS_PUBLISHED => 'Published',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\VideoQuery(get_called_class());
    }

    public function save($runValidation = true,$attributeNames = null)
    {
        $isInsert = $this->isNewRecord;

  
        if ($isInsert){
            $this->video_id = Yii::$app->security->generateRandomString(8);
            $this->title = $this->video->name;
            $this->video_name = $this->video->name;
        }

        if($this->thumnail){
            $this->has_thumnail = 1;
        }

        $saved = parent::save($runValidation,$attributeNames);


        if(!$saved){
            return false;
        }
        if($isInsert){
            $videoPath = Yii::getAlias('@frontend/web/storage/videos/'.$this->video_id.'.mp4');

            if(!is_dir(dirname($videoPath))){
               FileHelper::createDirectory(dirname($videoPath));
            }
            $this->video->saveAs($videoPath);
        }
        if($this->thumnail){
            $thumnailPath = Yii::getAlias('@frontend/web/storage/thumbs/'.$this->video_id.'.jpg');

            if(!is_dir(dirname($thumnailPath))){
               FileHelper::createDirectory(dirname($thumnailPath));
            }
            $this->thumnail->saveAs($thumnailPath);
            Image::getImagine()
                    ->open($thumnailPath)
                    ->thumbnail(new Box(1280,1280))
                    ->save();
        }
        return true;
    }

    public function getVideoLink()
    {
        return Yii::$app->params['frontendUrl'].'/storage/videos/'.$this->video_id.'.mp4';
    }

    public function getThumbnailLink()
    {
        return $this->has_thumnail ? 
        Yii::$app->params['frontendUrl'].'/storage/thumbs/'.$this->video_id.'.jpg'
        : '' ;
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $videoPath = Yii::getAlias('@frontend/web/storage/videos/'.$this->video_id.'.mp4');
        unlink($videoPath);

        $thumnailPath = Yii::getAlias('@frontend/web/storage/thumbs/'.$this->video_id.'.jpg');

        if(file_exists($thumnailPath)) {
            unlink($thumnailPath);
        }
        
    }

}

