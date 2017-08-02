<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $customer_id
 * @property integer $user_id
 * @property string $customer_name
 * @property string $customer_phone
 * @property string $customer_address
 * @property string $customer_lat
 * @property string $customer_lng
 * @property string $device_id
 * @property string $device_platform
 *
 * @property User $user
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $username;
    public $email;
    public $password;
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'username', 'email', 'password', 'customer_name', 'customer_phone', 'customer_address'], 'required'],
            [['user_id','customer_is_member'], 'integer'],
            [['customer_address', 'customer_code', 'device_id'], 'string'],
            [['customer_name'], 'string', 'max' => 200],
            [['customer_phone'], 'string', 'max' => 45],
            [['device_platform'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'user_id' => 'User ID',
            'customer_name' => 'Customer Name',
            'customer_phone' => 'Customer Phone',
            'customer_address' => 'Customer Address',
            'customer_code' => 'Customer Code',
            'customer_is_member' => 'Customer Is Member',
            'device_id' => 'Device ID',
            'device_platform' => 'Device Platform',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
