<?php

namespace app\library\eav\base;

use Yii;

/**
 * This is the model class for table "entity_attribute".
 *
 * @property integer $id
 * @property string $entity
 * @property integer $entity_id
 * @property string $attribute
 * @property string $value
 */
class EntityAttribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entity_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity', 'entity_id', 'attribute'], 'required'],
            [['entity_id'], 'integer'],
            [['entity', 'attribute', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity' => 'Entity',
            'entity_id' => 'Entity ID',
            'attribute' => 'Attribute',
            'value' => 'Value',
        ];
    }
}
