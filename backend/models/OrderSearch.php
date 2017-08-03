<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Order;

/**
 * OrderSearch represents the model behind the search form about `backend\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public $unit;
    public function rules()
    {
        return [
            [['order_id', 'customer_id', 'p_master_unit_id', 'order_pickup', 'order_delivery'], 'integer'],
            [['customer_name', 'customer_phone', 'unit_name','order_name', 'order_address', 'order_lat', 'order_lng', 'order_date', 'order_start', 'order_finish'], 'safe'],
            [['order_price','order_hours'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();
        $query->joinWith('unit');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['customer_name'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['customer.customer_name' => SORT_ASC],
            'desc' => ['customer.customer_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['customer_phone'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['customer.customer_phone' => SORT_ASC],
            'desc' => ['customer.customer_phone' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['unit_name'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['p_master_unit.unit_name' => SORT_ASC],
            'desc' => ['p_master_unit.unit_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'p_master_unit_id' => $this->p_master_unit_id,
            'order_pickup' => $this->order_pickup,
            'order_delivery' => $this->order_delivery,
            'order_price' => $this->order_price,
            'order_hours' => $this->order_hours,
            'order_date' => $this->order_date,
            'order_start' => $this->order_start,
            'order_finish' => $this->order_finish,
        ]);

        $query->andFilterWhere(['like', 'order_name', $this->order_name])
            ->andFilterWhere(['like', 'order_address', $this->order_address])
            ->andFilterWhere(['like', 'order_lat', $this->order_lat])
            ->andFilterWhere(['like', 'order_lng', $this->order_lng])
            ->andFilterWhere(['like', 'unit_name', $this->unit]);

        return $dataProvider;
    }

    public function search_customer($params,$customer)
    {
        $query = Order::find()->where(['=','customer_id',$customer]);
        $query->joinWith('unit');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['customer_name'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['customer.customer_name' => SORT_ASC],
            'desc' => ['customer.customer_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['customer_phone'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['customer.customer_phone' => SORT_ASC],
            'desc' => ['customer.customer_phone' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['unit_name'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['p_master_unit.unit_name' => SORT_ASC],
            'desc' => ['p_master_unit.unit_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'p_master_unit_id' => $this->p_master_unit_id,
            'order_pickup' => $this->order_pickup,
            'order_delivery' => $this->order_delivery,
            'order_price' => $this->order_price,
            'order_hours' => $this->order_hours,
            'order_date' => $this->order_date,
            'order_start' => $this->order_start,
            'order_finish' => $this->order_finish,
        ]);

        $query->andFilterWhere(['like', 'order_name', $this->order_name])
            ->andFilterWhere(['like', 'order_address', $this->order_address])
            ->andFilterWhere(['like', 'order_lat', $this->order_lat])
            ->andFilterWhere(['like', 'order_lng', $this->order_lng])
            ->andFilterWhere(['like', 'unit_name', $this->unit]);

        return $dataProvider;
    }
}
