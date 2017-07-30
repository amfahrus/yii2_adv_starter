<?php
namespace backend\models\form;

use Yii;
use backend\models\User;
use backend\models\UserdataInternal;
use yii\base\Model;

/**
 * Signup form
 */
class Signup extends UserdataInternal
{
    public $username;
    public $email;
    public $password;
    public $fullname;
    public $nik;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'mdm\admin\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            
            ['fullname', 'required'],
            ['fullname', 'string'],
            
            ['nik', 'required'],
            ['nik', 'string'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
		//return $this->save();
		if (!$this->validate()) {
            return null;
        }
		$user = new User();
		$userdata = new UserdataInternal();
		$user->username = $this->username;
		$user->auth_key = Yii::$app->security->generateRandomString();
		$user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
		$user->email = $this->email;
		$user->created_at = strtotime('now');
		$user->updated_at = strtotime('now');
		if ($user->save()) {
			$userdata->user_id = $user->id;
			$userdata->fullname = $this->fullname;
			$userdata->nik = $this->nik;
			return $userdata->save() ? $userdata : null;
		}
    }
}
