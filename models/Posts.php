<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $title
 * @property string $preview
 * @property string $text
 * @property int $users_id
 * @property int $themes_id
 * @property int $statuses_id
 * @property string|null $image
 * @property string $created_at
 * @property int $like
 * @property int $dislike
 *
 * @property Statuses $statuses
 * @property Themes $themes
 * @property Users $users
 */
class Posts extends \yii\db\ActiveRecord
{
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->users_id = Yii::$app->user->identity->id;
            $this->statuses_id = Statuses::getStatus('Редактирование');
        }

        return true;
    }

    public $uploadFile;
    public bool $check = false;
    public string $theme = '';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'preview', 'text'], 'required'],
            [['text'], 'string'],
            [['users_id', 'themes_id', 'statuses_id', 'like', 'dislike'], 'integer'],
            [['created_at'], 'safe'],
            [['check'], 'boolean'],
            [['uploadFile'], 'image'],
            ['image', 'default', 'value' => null],
            [['like', 'dislike'], 'default', 'value' => 0],
            [['title', 'preview', 'image', 'theme'], 'string', 'max' => 255],
            [['statuses_id'], 'exist', 'skipOnError' => true, 'targetClass' => Statuses::class, 'targetAttribute' => ['statuses_id' => 'id']],
            [['themes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Themes::class, 'targetAttribute' => ['themes_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['users_id' => 'id']],

            ['themes_id', 'required', 'when' => function($model) {
                return !$model->check;
            }, 'whenClient' => "function (attribute, value) {
                return !$('#posts-check').prop('checked');
            }"],

            ['theme', 'required', 'when' => function($model) {
                return $model->check;
            }, 'whenClient' => "function (attribute, value) {
                return $('#posts-check').prop('checked');
            }"]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'preview' => 'Превью',
            'text' => 'Текст',
            'users_id' => 'Автор',
            'themes_id' => 'Тема',
            'statuses_id' => 'Статус',
            'image' => 'Изображение',
            'created_at' => 'Создан',
            'like' => 'Нравиться',
            'dislike' => 'Не нравиться',
            'check' => 'Другая тема',
            'uploadFile' => 'Изображение',
            'theme' => 'Своя тема',
        ];
    }

    /**
     * Gets query for [[Statuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatuses()
    {
        return $this->hasOne(Statuses::class, ['id' => 'statuses_id']);
    }

    /**
     * Gets query for [[Themes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getThemes()
    {
        return $this->hasOne(Themes::class, ['id' => 'themes_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id']);
    }

    public function create()
    {
        if ($this->validate()) {
            if (is_null($this->uploadFile) || $this->upload()) {
                if ($this->check) {
                    $themes = new Themes();
                    $themes->title =  $this->theme;
                    $themes->save();
                    $this->themes_id = $themes->id;
                }

                return $this->save(false);
            }
        }
        
        return false;
    }

    public function upload()
    {
        $this->image = 'uploads/posts/'  . Yii::$app->security->generateRandomString() . '_' . time() . '.' . $this->uploadFile->extension;
        return $this->uploadFile->saveAs($this->image);
    }
}
