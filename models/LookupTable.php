<?php

namespace humanized\lookup\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/**
 * This an abstract class for implementing lookup tables, i.e. tables with just two attributes: an auto-incremented id and a unique name
 *
 * @property integer $id
 * @property string $name
 *
 */
abstract class LookupTable extends \yii\db\ActiveRecord {

    const SCENARIO_SEARCH = 'search';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //For use in admin scenario
            [['name'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['name'], 'string', 'max' => 45, 'on' => self::SCENARIO_DEFAULT],
            [['name'], 'unique', 'on' => self::SCENARIO_DEFAULT],
            [['id'], 'integer', 'on' => self::SCENARIO_SEARCH],
            [['name'], 'safe', 'on' => self::SCENARIO_SEARCH],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    public function search($params)
    {
        $class = get_called_class();
        $query = $class::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }

    public static function getDropdownData()
    {
        $caller = get_called_class();
        return ArrayHelper::map($caller::find()->asArray()->all());
    }

    public static function getIdByName($name)
    {
        $model = self::getModelByName($name);
        return isset($model) ? $model->id : NULL;
    }

    public static function getModelByName($name)
    {
        $caller = get_called_class();
        return $caller::findOne(['name' => $name]);
    }

    public static function getModelById($id)
    {
        $caller = get_called_class();
        return $caller::findOne($id);
    }

}
