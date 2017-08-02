<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use backend\models\Customer;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $customer_name;
    public $customer_address;
    public $customer_phone;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            [['customer_address'], 'string'],
            [['customer_name'], 'string', 'max' => 200],
            [['customer_phone'], 'string', 'max' => 45],

            [['customer_name','customer_phone','customer_address'], 'required'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        //return $user->save() ? $user : null;
        $model = new Customer();
        if($user->save()){
           $model->user_id = $user->id;
           $model->username = $user->username;
           $model->email = $user->email;
           $model->password = $this->password;
           $model->customer_name = $this->customer_name;
           $model->customer_phone = $this->customer_phone;
           $model->customer_address = $this->customer_address;
           $model->customer_code = $this->getCode();
           $model->save();
           return $user;
        } else {
          return null;
        }
    }

    protected function getCode()
    {
        if (($model = Customer::find()->orderBy('customer_id DESC')->one()) !== null) {
            return str_pad($model->customer_id, 4, '0', STR_PAD_LEFT).'/'.date("m").date("y");
        } else {
            return str_pad(1, 4, '0', STR_PAD_LEFT).'/'.date("m").date("y");
        }
    }
}
