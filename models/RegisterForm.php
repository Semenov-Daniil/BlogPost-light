<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegisterForm is the model behind the register form.
 */
class RegisterForm extends Model
{
    public string $name = 'Иван';
    public string $surname = 'Иванов';
    public string $patronymic = '';
    public string $login = 'user';
    public string $email = 'user@user.ru';
    public string $phone = '+7(999)-999-99-99';
    public string $password = 'pa55WORD';
    public string $password_repeat = 'pa55WORD';
    public bool $rules = false;
    public $uploadFile;
    public string $avatar = '';


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'login', 'password', 'password_repeat', 'phone'], 'required'],
            [['rules'], 'required', 'requiredValue' => true, 'message' => 'Необходимо согласие с правилами регистрации.'],
            [['name', 'surname', 'patronymic', 'email', 'login', 'password_repeat'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 255, 'min' => 6],
            [['phone'], 'string', 'max' => 20],
            [['uploadFile'], 'image'],
            [['email'], 'unique', 'targetClass' => Users::class],
            [['login'], 'unique', 'targetClass' => Users::class],
            [['email'], 'email'],
            [['name', 'surname', 'patronymic'], 'match', 'pattern' => '/^[а-яё\s\-]+$/ui', 'message' => 'Только кириллица, пробел, тире.'],
            [['login'], 'match', 'pattern' => '/^[a-z\-]+$/i', 'message' => 'Только латиница, тире.'],
            [['password'], 'match', 'pattern' => '/^[a-z\d]+$/i', 'message' => 'Только латиница, цифры.'],
            [['phone'], 'match', 'pattern' => '/^\+7\([\d]{3}\)\-[\d]{3}(\-[\d]{2}){2}$/', 'message' => 'Только в формате +7(XXX)-XXX-XX-XX.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'email' => 'Электронная почта',
            'login' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'phone' => 'Телефон',
            'uploadFile' => 'Аватар',
            'rules' => 'Согласие с правилами регистрации',
        ];
    }

    /**
     * Register new user.
     * @return bool the user is registered and logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {

            if (is_null($this->uploadFile) || $this->upload()) {
                $user = new Users();

                $user->attributes = $this->attributes;

                if ($user->save()) {
                    return Yii::$app->user->login($user);
                }

                $this->addErrors($user->errors);
            }

        }
        return false;
    }

    public function upload()
    {
        $this->avatar = 'uploads/avatars/'  . Yii::$app->security->generateRandomString() . '_' . time() . '.' . $this->uploadFile->extension;
        return $this->uploadFile->saveAs($this->avatar);
    }
}
