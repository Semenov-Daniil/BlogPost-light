<?php

namespace app\modules\admin\models;

use app\models\Users;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * BlockForm is the model behind the block form.
 *
 */
class BlockForm extends Model
{
    public string $date = '';
    public string $time = '';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['date', 'time'], 'required'],
            ['date', 'date', 'format' => 'php:Y-m-d'],
            ['time', 'time', 'format' => 'HH:mm'],
            ['date', 'validateDate'],
            ['time', 'validateTime'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Дата блокировки',
            'time' => 'Время блокировки',
        ];
    }

    public function validateDate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (strtotime($this->date) < strtotime(date('Y-m-d'))) {
                $this->addError($attribute, 'Увеличьте дату.');
            }
        }
    }

    public function validateTime($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (strtotime("$this->date $this->time") <= time()) {
                $this->addError($attribute, 'Увеличьте время.');
            }
        }
    }

    public function block($id)
    {
        if ($this->validate()) {
            if ($user = Users::findOne(['id' => $id])) {
                $user->is_block = 1;
                $user->block_time = "$this->date $this->time";
                return $user->save();
            }
        }
        return false;
    }

    public function permach($id)
    {
        if ($user = Users::findOne(['id' => $id])) {
            $user->is_block = 1;
            return $user->save();
        }
        return false;
    }
}
