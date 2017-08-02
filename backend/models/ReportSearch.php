<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Customer;
use backend\models\Unit;
use backend\models\Order;

/**
 * CustomerSearch represents the model behind the search form about `backend\models\Customer`.
 */
class ReportSearch extends Order
{
    /**
     * @inheritdoc
     */
    public $start;
    public $end;
    public function rules()
    {
        return [
            //[['customer_id', 'user_id','customer_is_member'], 'integer'],
            //[['order_name', 'order_date', 'order_hours', 'order_start', 'order_finish', 'order_cost_pickup', 'order_cost_delivery', 'rder_cost_overtime', 'order_total_cost', 'order_discount', 'order_total_cost_discount'], 'safe'],
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
        //die(var_dump($params['ReportSearch']['customer_id']));
        if(!empty($params)){
            $query = Order::find()->where([
              'and',
              ['=','customer_id',$params['ReportSearch']['customer_id']],
              ['=','p_master_unit_id',$params['ReportSearch']['p_master_unit_id']],
              ['>=','order_date',$params['ReportSearch']['start']],
              ['<=','order_date',$params['ReportSearch']['end']],
              ['>','order_total_cost',0]
            ]);
        } else {
            $query = Order::find()->where(['=','customer_id',0]);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'customer_id' => $this->customer_id,
            'p_master_unit_id' => $this->p_master_unit_id,
        ]);

        $query->andFilterWhere(['>=', 'order_date', $this->start])
            ->andFilterWhere(['<=', 'order_dates', $this->end]);

        return $dataProvider;

    }

    public function generate($customer,$unit,$start,$end)
    {
        $query = Order::find()->where([
          'and',
          ['=','customer_id',$customer],
          ['=','p_master_unit_id',$unit],
          ['>=','order_date',$start],
          ['<=','order_date',$end]
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
