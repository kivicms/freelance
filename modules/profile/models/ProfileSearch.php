<?php

namespace app\modules\profile\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\profile\models\Profile;
use yii\helpers\VarDumper;

/**
 * ProfileSearch represents the model behind the search form of `app\models\Profile`.
 */
class ProfileSearch extends Profile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'sex', 'type_of_legal', 'is_verified', 'executed_orders', 'created_at', 'updated_at', 'follower_counter', 'following_counter', 'order_placed_counter', 'order_actual_counter'], 'integer'],
            [['lastname', 'firstname', 'middlename', 'phone', 'www', 'title', 'description', 'address_fact', 'address_legal'], 'safe'],
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
    
    public function searchIFollowing($params)
    {
        $query = Profile::find();
        $query->leftJoin('follower as f', 'f.user_id = profile.user_id');
        
        $query->andWhere('f.follower_id=:follower_id',[
            ':follower_id' => \Yii::$app->user->id
        ]);
        
        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);
        
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'title', $this->title]);
        //VarDumper::dump($params,10,true);die;
        return $dataProvider;
    }
    
    public function searchMyFollowers($params)
    {
        
        $query = Profile::find();
        $query->leftJoin('follower as f', 'f.follower_id = profile.user_id');
        
        $query->andWhere('f.user_id=:user_id',[
            ':user_id' => \Yii::$app->user->id
        ]);
        
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
        $query->andFilterWhere(['like', 'title', $this->title]);
        
        return $dataProvider;
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
        
        $query = Profile::find();
        $query->leftJoin('auth_assignment','auth_assignment.user_id=profile.user_id');
        
        $query->andWhere('auth_assignment.item_name="company"');
        $query->andWhere('profile.is_verified=1');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);        
        
        $this->load($params);

        if (isset($_POST['CompanySearchForm'])) {
            $this->title = $_POST['CompanySearchForm']['title'];    
        }
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'sex' => $this->sex,
            'type_of_legal' => $this->type_of_legal,
            'is_verified' => $this->is_verified,
            'executed_orders' => $this->executed_orders,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'follower_counter' => $this->follower_counter,
            'following_counter' => $this->following_counter,
            'order_placed_counter' => $this->order_placed_counter,
            'order_actual_counter' => $this->order_actual_counter,
        ]);

        $query->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'www', $this->www])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address_fact', $this->address_fact])
            ->andFilterWhere(['like', 'address_legal', $this->address_legal]);

        return $dataProvider;
    }
}
