<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string $text
 * @property int $users_id
 * @property int $posts_id
 * @property int|null $answer_id
 * @property string $created_at
 *
 * @property Comments $answer
 * @property Comments[] $comments
 * @property Posts $posts
 * @property Users $users
 */
class Comments extends \yii\db\ActiveRecord
{
    public string $login = '';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
            [['users_id', 'posts_id', 'answer_id'], 'integer'],
            [['created_at'], 'safe'],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::class, 'targetAttribute' => ['answer_id' => 'id']],
            [['posts_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::class, 'targetAttribute' => ['posts_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['users_id' => 'id']],
            ['text', 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Комментарий',
            'users_id' => 'Users ID',
            'posts_id' => 'Posts ID',
            'answer_id' => 'Answer ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Answer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Comments::class, ['answer_id' => 'id'])
            ->select(['comments.id', 'text', 'created_at', 'users.login', 'answer_id', 'users_id'])
            ->joinWith('users', false);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['answer_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasOne(Posts::class, ['id' => 'posts_id']);
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

    public function create(int $postId, int|null $answerId): bool
    {
        if ($this->validate()) {
            $this->posts_id = $postId;
            $this->answer_id = $answerId;
            $this->users_id = Yii::$app->user->identity->id;

            return $this->save();
        }

        return false;
    }

    public static function getCommentsList($postId)
    {
        return new ActiveDataProvider([
            'query' => self::find()
                ->select([
                    'comments.id', 'text', 'created_at', 'users.login', 'users_id', 'posts_id',
                ])
                ->joinWith('users', false)
                ->with('answers')
                ->where(['posts_id' => $postId, 'answer_id' => null])
                ->orderBy(['created_at' => SORT_DESC])
                ,
        ]);
    }
}
