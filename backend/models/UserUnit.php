<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_user_unit".
 *
 * @property integer $uu_id
 * @property integer $user_id
 * @property integer $unit_id
 *
 * @property TUnit $unit
 * @property User $user
 */
class UserUnit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_user_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'p_master_unit_id'], 'required'],
            [['user_id', 'p_master_unit_id'], 'integer'],
            [['p_master_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['p_master_unit_id' => 'p_master_unit_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            't_user_unit_id' => 'ID',
            'user_id' => 'User ID',
            'p_master_unit_id' => 'Unit ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['p_master_unit_id' => 'p_master_unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
