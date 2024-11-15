<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property string $email
 * @property string $login
 * @property string $password
 * @property string $phone
 * @property string $auth_key
 * @property int $roles_id
 * @property int $is_block
 * @property string|null $block_time
 * @property string|null $avatar
 * @property string $registered_at
 *
 * @property Posts[] $posts
 * @property Roles $roles
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->auth_key = Yii::$app->security->generateRandomString();
            $this->roles_id = Roles::getRole('author');
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'login', 'password', 'phone'], 'required'],
            [['roles_id', 'is_block'], 'integer'],
            [['block_time', 'registered_at'], 'safe'],
            [['name', 'surname', 'patronymic', 'email', 'login', 'password', 'auth_key', 'avatar'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'unique'],
            [['login'], 'unique'],
            [['roles_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['roles_id' => 'id']],
            [['patronymic', 'avatar'], 'default', 'value' => null],
            [['is_block'], 'default', 'value' => 0],
            [['name', 'surname', 'email', 'login', 'password', 'auth_key'], 'trim'],
            [['patronymic', 'avatar'], 'filter', 'filter' => function($value) {
                return is_null($value) ? $value : trim($value);
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'email' => 'Электронная почта',
            'login' => 'Логин',
            'password' => 'Пароль',
            'phone' => 'Телефон',
            'auth_key' => 'Auth Key',
            'roles_id' => 'Роль',
            'is_block' => 'Заблокирован',
            'block_time' => 'Время блокировки',
            'avatar' => 'Аватар',
            'registered_at' => 'Зарегистирован с',
        ];
    }

    /**
     * Gets query for [[Roles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasOne(Roles::class, ['id' => 'roles_id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['users_id' => 'id']);
    }

    public function getIsAuthor(): bool
    {
        return $this->roles_id == Roles::getRole('author');
    }

    public function getIsAdmin(): bool
    {
        return $this->roles_id == Roles::getRole('admin');
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds user by login
     *
     * @param string $login
     * @return static|null
     */
    public static function findByLogin(string $login): static|null
    {
        return self::findOne(['login' => $login]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}
