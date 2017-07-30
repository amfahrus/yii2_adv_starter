<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_unit".
 *
 * @property integer $unit_id
 * @property string $unit_name
 * @property string $unit_code
 * @property integer $unit_status
 * @property integer $unit_parent
 */
class Unit extends \yii\db\ActiveRecord
{
    public $parent_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_master_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_name', 'unit_code'], 'string'],
            [['unit_status', 'unit_parent'], 'integer'],
            [['parent_name'], 'in',
                'range' => static::find()->select(['unit_name'])->column(),
                'message' => 'Unit "{value}" not found.'],
        ];
    }


    /**
     * Use to loop detected.
     */
    public function filterParent()
    {
        $parent = $this->parent;
        $db = static::getDb();
        $query = (new Query)->select(['unit_parent'])
            ->from(static::tableName())
            ->where('[[id]]=:id');
        while ($parent) {
            if ($this->id == $parent) {
                $this->addError('parent_name', 'Loop detected.');
                return;
            }
            $parent = $query->params([':id' => $parent])->scalar($db);
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'p_master_unit_id' => 'Unit ID',
            'unit_name' => 'Unit Name',
            'unit_code' => 'Unit Code',
            'unit_status' => 'Unit Status',
            'unit_parent' => 'Unit Parent',
            'parent_name' => 'Parent Name',
        ];
    }

    /**
     * Get menu parent
     * @return \yii\db\ActiveQuery
     */
    public function getUnitParent()
    {
        return $this->hasOne(Unit::className(), ['p_master_unit_id' => 'unit_parent']);
    }

    public static function getUnitSource()
    {
        $tableName = static::tableName();
        return (new \yii\db\Query())
                ->select(['u.p_master_unit_id', 'u.unit_name', 'u.unit_code', 'u.unit_status', 'parent_name' => 'p.unit_name'])
                ->from(['u' => $tableName])
                ->leftJoin(['p' => $tableName], '[[u.unit_parent]]=[[p.p_master_unit_id]]')
                ->all(static::getDb());
    }
}
