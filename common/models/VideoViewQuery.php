<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[VideoView]].
 *
 * @see VideoView
 */
class VideoViewQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VideoView[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VideoView|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
