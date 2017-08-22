<?php

namespace app\library\eav;

use Yii;
use yii\base\Component;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class EntityAttributes
 * @package app\library\model
 *
 * Декоратор для работы с массивом дополнительных атрибутов
 */
class EntityAttributes extends Component
{
    /**
     * @var ActiveRecord
     */
    public $entity;

    /**
     * Класс для хранения дополнительных атрибутов сущности
     * @var string
     */
    public $attributesClass = '\\app\\library\\eav\\EntityAttribute';

    /**
     * @var EntityAttribute[]
     */
    private $_attributes;

    /**
     * @param string $name
     * @return null|string
     */
    public function getAttribute($name)
    {
        $attributes = $this->getAttributes();
        if (isset($attributes[$name]))
        {
            /** @var EntityAttribute $attribute */
            $attribute = $attributes[$name];
            return $attribute->value;
        }
        return null;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setAttribute($name, $value)
    {
        $attributes = $this->getAttributes();
        if (isset($attributes[$name]))
        {
            /** @var EntityAttribute $attribute */
            $attribute = $attributes[$name];
            $attribute->value = $value;
        } else
        {
            $class = $this->attributesClass;
            $attribute = new $class([
                'entity' => get_class($this->entity),
                'entity_id' => $this->entity->getPrimaryKey(),
                'attribute' => $name,
                'value' => $value,
            ]);
            $this->_attributes[$name] = $attribute;
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasAttribute($name)
    {
        $attributes = $this->getAttributes();
        return isset($attributes[$name]);
    }

    /**
     * @return EntityAttribute[]|array|\yii\db\ActiveRecord[]
     */
    public function getAttributes()
    {
        if (is_null($this->_attributes))
        {
            $class = $this->attributesClass;
            $query = $class::find(); /** @var ActiveQuery $query */
            $query->where([
                'entity' => get_class($this->entity),
                'entity_id' => $this->entity->getPrimaryKey(),
            ]);
            $query->indexBy('attribute');
            $this->_attributes = $query->all();
        }
        return $this->_attributes;
    }
}