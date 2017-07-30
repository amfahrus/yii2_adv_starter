<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserdataInternal;

/**
 * UserdataInternalSearch represents the model behind the search form about `backend\models\UserdataInternal`.
 */
class UserdataInternalSearch extends UserdataInternal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['t_userdata_internal_id', 'user_id'], 'integer'],
            [['fullname', 'nik', 'username', 'email'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    /*public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
        ];
    }*/

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
		//die(var_dump($params));
        $query = UserdataInternal::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['username'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['email'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['user.email' => SORT_ASC],
            'desc' => ['user.email' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Select All
		$query->select('*');

        // Join other table
		$query->leftJoin('user', 'id = user_id');

        // grid filtering conditions
        $query->andFilterWhere([
            't_userdata_internal_id' => $this->t_userdata_internal_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'nik', $this->nik]);
		//die(var_dump($query));
        return $dataProvider;
    }
}
