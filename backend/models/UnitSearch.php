<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Unit;

/**
 * UnitSearch represents the model behind the search form about `backend\models\Unit`.
 */
class UnitSearch extends Unit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_master_unit_id', 'unit_status', 'unit_parent', 'unit_capacity', 'unit_radius', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'], 'integer'],
            [['unit_name', 'unit_code'], 'safe'],
            [['unit_price_6', 'unit_price_12'], 'number'],
            [['unit_lat', 'unit_lng', 'unit_price_overtime', 'unit_price_pickup', 'unit_price_delivery'], 'string', 'max' => 55],
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
        $query = Unit::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['unitParent.unit_name'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['p_master_unit.unit_parent' => SORT_ASC],
            'desc' => ['p_master_unit.unit_parent' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'p_master_unit_id' => $this->p_master_unit_id,
            'unit_status' => $this->unit_status,
            'unit_parent' => $this->unit_parent,
            'unit_capacity' => $this->unit_capacity,
            'unit_lat' => $this->unit_lat,
            'unit_lng' => $this->unit_lng,
            'unit_radius' => $this->unit_radius,
            'unit_price_6' => $this->unit_price_6,
            'unit_price_12' => $this->unit_price_12,
            'unit_price_overtime' => $this->unit_price_overtime,
            'unit_price_pickup' => $this->unit_price_pickup,
            'unit_price_delivery' => $this->unit_price_delivery,
            'monday' => $this->monday,
            'tuesday' => $this->tuesday,
            'wednesday' => $this->wednesday,
            'thursday' => $this->thursday,
            'friday' => $this->friday,
            'saturday' => $this->saturday,
            'sunday' => $this->sunday,
        ]);

        $query->andFilterWhere(['like', 'unit_name', $this->unit_name])
            ->andFilterWhere(['like', 'unit_code', $this->unit_code]);

        return $dataProvider;
    }
}
