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
abstract class LookupTable extends \yii\db\ActiveRecord
{

    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_SEARCH = 'search';

    public $createPermission = TRUE;
    public $readPermission = TRUE;
    public $updatePermission = TRUE;
    public $deletePermission = TRUE;

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
        $query = $class::find()->indexBy('id');

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

    public static function synchronise($values, $purge)
    {
        $class = get_called_class();
        foreach ($values as $value) {
            $model = new $class(['name' => $value]);
            $model->save();
        }

        if ($purge) {
            $class::deleteAll(['NOT IN', 'name', $values]);
        }
    }

}
