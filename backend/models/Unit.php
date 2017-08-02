<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "p_master_unit".
 *
 * @property integer $p_master_unit_id
 * @property string $unit_name
 * @property string $unit_code
 * @property integer $unit_status
 * @property integer $unit_parent
 * @property integer $unit_capacity
 * @property double $unit_latlng
 * @property integer $unit_radius
 * @property double $unit_price
 * @property double $unit_price_overtime
 * @property double $unit_price_pickup
 * @property double $unit_price_delivery
 * @property integer $monday
 * @property integer $tuesday
 * @property integer $wednesday
 * @property integer $thursday
 * @property integer $friday
 * @property integer $saturday
 * @property integer $sunday
 *
 * @property TUserUnit[] $tUserUnits
 */
class Unit extends \yii\db\ActiveRecord
{
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
    public $hours;
    public $label;
    public $price;
    public function rules()
    {
        return [
            [['unit_name', 'unit_code', 'unit_status'], 'required'],
            [['unit_status', 'unit_parent', 'unit_member_discount', 'unit_capacity', 'unit_radius', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'], 'integer'],
            [['hours','price', 'unit_price_6', 'unit_price_12'], 'number'],
            [['unit_lat', 'unit_lng', 'unit_price_overtime', 'unit_price_pickup', 'unit_price_delivery'], 'string', 'max' => 55],
            [['label','unit_name', 'unit_code'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'p_master_unit_id' => 'P Master Unit ID',
            'unit_name' => 'Unit Name',
            'unit_code' => 'Unit Code',
            'unit_status' => 'Unit Status',
            'unit_parent' => 'Unit Parent',
            'unit_capacity' => 'Unit Capacity',
            'unit_lat' => 'Unit Latitude',
            'unit_lng' => 'Unit Longitude',
            'unit_radius' => 'Unit Radius Meter',
            'unit_price_6' => 'Unit Price 6 Hour',
            'unit_price_12' => 'Unit Price 12 Hour',
            'unit_member_discount' => 'Unit Member Discount',
            'unit_price_overtime' => 'Unit Price Overtime',
            'unit_price_pickup' => 'Unit Price Pickup',
            'unit_price_delivery' => 'Unit Price Delivery',
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTUserUnits()
    {
        return $this->hasMany(TUserUnit::className(), ['p_master_unit_id' => 'p_master_unit_id']);
    }
}
