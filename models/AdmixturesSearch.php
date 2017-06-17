<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admixtures;

/**
 * AdmixturesSearch represents the model behind the search form about `app\models\Admixtures`.
 */
class AdmixturesSearch extends Admixtures
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'products_id', 'recipes_id'], 'integer'],
            [['quantity', 'unity', 'comment'], 'safe'],
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
        $query = Admixtures::find();

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
            'products_id' => $this->products_id,
            'recipes_id' => $this->recipes_id,
        ]);

        $query->andFilterWhere(['like', 'quantity', $this->quantity])
            ->andFilterWhere(['like', 'unity', $this->unity])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
