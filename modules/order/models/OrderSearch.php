<?php

namespace app\modules\order\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\order\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\modules\order\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'is_archive', 'executor_id'], 'integer'],
            [['title', 'description', 'deadline'], 'safe'],
            [['budget'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query->andWhere('is_archive=0');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'budget' => $this->budget,
            'deadline' => $this->deadline,
            'status' => $this->status,
            'is_archive' => $this->is_archive,
            'executor_id' => $this->executor_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
    
    public function my($params)
    {
        $query = Order::find();
        $query->andWhere(['user_id' => \Yii::$app->user->id]);
        
        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'budget' => $this->budget,
            'deadline' => $this->deadline,
            'status' => $this->status,
            'is_archive' => $this->is_archive,
            'executor_id' => $this->executor_id,
        ]);
        
        $query->andFilterWhere(['like', 'title', $this->title])
        ->andFilterWhere(['like', 'description', $this->description]);
        
        return $dataProvider;
    }
}
