<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "themes".
 *
 * @property int $id
 * @property string $title
 *
 * @property Posts[] $posts
 */
class Themes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'themes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['themes_id' => 'id']);
    }

    public static function getThemes()
    {
        return self::find()
            ->select('title')
            ->indexBy('id')
            ->column()
            ;
    }
}
