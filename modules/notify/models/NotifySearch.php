<?php

namespace app\modules\notify\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\notify\models\Notify;

/**
 * NotifySearch represents the model behind the search form of `app\modules\notify\models\Notify`.
 */
class NotifySearch extends Notify
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'to_user_id', 'created_at', 'updated_at', 'status', 'readed_time'], 'integer'],
            [['title', 'description'], 'safe'],
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
        $query = Notify::find();

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
            'to_user_id' => $this->to_user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'readed_time' => $this->readed_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
