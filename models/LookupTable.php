<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actor_artifact_role".
 *
 * @property integer $id
 * @property string $name
 *
 */
class LookupTable extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
            [['name'], 'unique'],
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

}
