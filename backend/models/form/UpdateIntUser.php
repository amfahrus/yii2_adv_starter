<?php

namespace backend\models\form;

use Yii;
use yii\rbac\Item;
use yii\helpers\Json;
use yii\base\Model;
use backend\models\User;
use backend\models\UserdataInternal;

/**
 * This is the model class for table "tbl_auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $ruleName
 * @property string $data
 */
class UpdateIntUser extends Model
{
    public $username;
    public $email;
    /**
     * @var Item
     */

    /**
     * Get User
     * @return array
     */
    public function getUserId($id)
    {
        $query = User::find()
			->select('username,email,t_userdata_internal.*')
			->leftJoin('t_userdata_internal', 'id = t_userdata_internal.user_id')
			->where(['t_userdata_internal.t_userdata_internal_id' => $id])
			//->asArray()
			->one();
		//die(var_dump($query));

		return $query;
    }

}
