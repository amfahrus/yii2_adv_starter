<?php

namespace backend\models\form;

use Yii;
use yii\rbac\Item;
use yii\helpers\Json;
use yii\base\Model;
use backend\models\Unit;
use backend\models\UserUnit;
use mdm\admin\components\Helper;

/**
 * This is the model class for table "tbl_auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $ruleName
 * @property string $data
 *
 */
class Assignunit extends Model
{
    public $unit_name;
    public $p_master_unit_id;
    public $user_id;
    /**
     * @var Item
     */

    /**
     * Get items
     * @return array
     */
    public function getItems($id)
    {
		$manager = Yii::$app->getAuthManager();
		$unit = Unit::find()
			->indexBy('unit_name')
			->all();
        $avaliable = [];
		foreach ($unit as $row) {
                //$avaliable[$row['unit_id']] = $row['unit_name'];
                //$avaliable[$row['unit_name']] = 'unit';
                $avaliable['unit'][$row['p_master_unit_id']] = $row['unit_name'];
            }
		foreach (array_keys($manager->getRoles()) as $name) {
            //$avaliable[$name] = 'role';
            $avaliable['role'][$name] = $name;
        }

        foreach (array_keys($manager->getPermissions()) as $name) {
            if ($name[0] != '/') {
                //$avaliable[$name] = 'permission';
                $avaliable['permission'][$name] = $name;
            }
        }
		//die(print_r($avaliable));
        $assigned = [];
        $userunits = Unit::find()
			->select('p_master_unit.p_master_unit_id,p_master_unit.unit_name')
			->leftJoin('t_user_unit', 'p_master_unit.p_master_unit_id = t_user_unit.p_master_unit_id')
			->where(['t_user_unit.user_id' => $id])
			//->with('orders')
			->all();
		//die(print_r($userunits));
		foreach ($userunits as $rows) {
                //$assigned[$rows['unit_id']] = $rows['unit_name'];
                $assigned['unit'][$rows['p_master_unit_id']] = $rows['unit_name'];
				//unset($avaliable[$rows['unit_id']]);
				unset($avaliable['unit'][$rows['p_master_unit_id']]);
                //$avaliable[$row['unit_name']] = 'unit';
                //$avaliable['unit'][$row['unit_id']] = $row['unit_name'];
            }

        foreach ($manager->getAssignments($id) as $item) {
			if(isset($avaliable['role'][$item->roleName])){
				$assigned['role'][$item->roleName] = $avaliable['role'][$item->roleName];
				unset($avaliable['role'][$item->roleName]);
			} else {
				$assigned['permission'][$item->roleName] = $avaliable['permission'][$item->roleName];
				unset($avaliable['permission'][$item->roleName]);
			}
        }
		//die(print_r($assigned));
        //unset($avaliable[$this->unit_id]);
        return[
            'avaliable' => $avaliable,
            'assigned' => $assigned
        ];
    }

    /**
     * Adds an item as a child of another item.
     * @param array $items
     * @return int
     */
    public function addChildren($id,$items)
    {
		//die(print_r($items));
        $i = 0;
        // assign unit
		/*foreach($items as $row){
			$userunit = new UserUnit();
			$userunit->user_id = $id;
			$userunit->unit_id = $row[$i];
			$userunit->save();
            $i++;
		}*/

		$manager = Yii::$app->getAuthManager();
        foreach ($items as $name) {
            try {
				$item = $manager->getRole($name);
				$item = $item ? : $manager->getPermission($name);
				if($item){
					$manager->assign($item, $id);
				} else {
					$userunit = new UserUnit();
					$userunit->user_id = $id;
					$userunit->p_master_unit_id = $name[$i];
					$userunit->save();
				}
				$i++;
            } catch (\Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }
        }
        Helper::invalidate();
        return $i;
    }

    public function removeChildren($id,$items)
    {
		//die(print_r($items));
        $i = 0;
        //remove assigned unit
		/*foreach($items as $row){
			UserUnit::deleteAll('user_id = '.$id.' AND unit_id = '.$row[$i]);
            $i++;
		}*/

		$manager = Yii::$app->getAuthManager();
        foreach ($items as $name) {
            try {
				$item = $manager->getRole($name);
				$item = $item ? : $manager->getPermission($name);
				if($item){
					$manager->revoke($item, $id);
				} else {
					UserUnit::deleteAll('user_id = '.$id.' AND p_master_unit_id = '.$name[$i]);
				}
                $i++;
            } catch (\Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }
        }
        Helper::invalidate();
        return $i;
    }
}
