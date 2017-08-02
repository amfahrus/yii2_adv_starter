<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $order_id
 * @property integer $customer_id
 * @property integer $p_master_unit_id
 * @property string $order_name
 * @property string $order_address
 * @property string $order_lat
 * @property string $order_lng
 * @property double $order_price
 * @property string $order_start
 * @property string $order_finish
 *
 * @property Customer $customer
 * @property PMasterUnit $pMasterUnit
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $customer_name;
    public $customer_phone;
    public $unit_name;
    public $cost_pickup;
    public $cost_delivery;
    public $cost_overtime;
    public $total_cost;
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'p_master_unit_id', 'order_name', 'order_address', 'order_date', 'order_price','order_hours'], 'required'],
            [['customer_id', 'p_master_unit_id', 'order_pickup', 'order_delivery'], 'integer'],
            [['order_address'], 'string'],
            [['order_price','order_hours','order_cost_pickup','order_cost_delivery','order_cost_overtime','order_total_cost'], 'number'],
            [['order_start', 'order_finish', 'order_date'], 'safe'],
            [['order_name'], 'string', 'max' => 200],
            [['order_lat', 'order_lng'], 'string', 'max' => 45],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['p_master_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['p_master_unit_id' => 'p_master_unit_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'customer_id' => 'Customer',
            'p_master_unit_id' => 'Unit',
            'order_pickup' => 'Dijemput',
            'order_delivery' => 'Diantar',
            'customer_name' => 'Nama Pelanggan',
            'customer_phone' => 'Nomor HP',
            'unit_name' => 'Nama Unit',
            'order_name' => 'Nama Peserta',
            'order_address' => 'Alamat',
            'order_lat' => 'Latitude',
            'order_lng' => 'Longitude',
            'order_price' => 'Harga',
            'order_hours' => 'Lama Waktu',
            'order_date' => 'Tanggal Pesan',
            'order_start' => 'Waktu Mulai',
            'order_finish' => 'Waktu Selesai',
            'order_cost_pickup' => 'Biaya Jemput',
            'order_cost_delivery' => 'Biaya Antar',
            'order_cost_overtime' => 'Biaya Overtime',
            'order_total_cost' => 'Total Biaya',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['p_master_unit_id' => 'p_master_unit_id']);
    }
}
