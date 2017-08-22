<?php

namespace app\library\eav;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\base\UnknownPropertyException;

/**
 * Class BaseActiveRecord
 * @package app\library\eav
 *
 * Base class for entity-attribute-value storage scheme using ActiveRecord
 *
 * @property EntityAttributes $eavAttributes
 */
abstract class BaseActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @var EntityAttributes
     */
    private $_eavAttributes;

    /**
     * Returns the named additional attribute value.
     * @param string $name the additional attribute name
     * @return mixed the attribute value. `null` if the attribute is not set or does not exist.
     */
    public function getEavAttribute($name)
    {
        return $this->getEavAttributes()->getAttribute($name);
    }

    /**
     * Sets the named additional attribute value.
     * @param string $name the additional attribute name
     * @param mixed $value the additional attribute value.
     */
    public function setEavAttribute($name, $value)
    {
        $this->getEavAttributes()->setAttribute($name, $value);
    }

    public function getEavAttributes()
    {
        if (is_null($this->_eavAttributes))
        {
            $this->_eavAttributes = new EntityAttributes([
                'entity' => $this,
                // TODO 'attributesClass' => ?
            ]);
        }
        return $this->_eavAttributes;
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        // это очень ресурсоёмкий  и ненадёжный метод, потому что в Yii2 используется для нескольких целей
        // 1. обращение к атрибутам сущности $this->_attributes[]
        // 2. обращение к отношениям между сущностями $this->_related[]
        // 3. обращение к компонентам Yii2 Component::__get()
        // 100% заменить метод не получится
        // потому что $this->_attributes[] и $this->_related[] являются приватными

        try
        {
            if ($this->hasAttribute($name))
            {
                return $this->getAttribute($name);
            }
            elseif ($this->getEavAttributes()->hasAttribute($name))
            {
                return $this->getEavAttributes()->getAttribute($name);
            }
            else
            {
                return parent::__get($name);
            }
        } catch(InvalidParamException $e) // не сработал $this->setAttribute()
        {
            // приходится подавять ошибки, которые генерирует Yii2
        } catch(UnknownPropertyException $e) // не сработал parent::__get();
        {
            // приходится подавять ошибки, которые генерирует Yii2
        }
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        try
        {
            if ($this->hasAttribute($name))
            {
                $this->setAttribute($name, $value);
            }
            else
            {
                parent::__set($name, $value);
            }
        } catch(InvalidParamException $e) // не сработал $this->setAttribute()
        {
            $this->getEavAttributes()->setAttribute($name, $value);
        } catch(UnknownPropertyException $e) // не сработал parent::__set()
        {
            $this->getEavAttributes()->setAttribute($name, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function __unset($name)
    {
        if ($this->getEavAttributes()->hasAttribute($name))
            return $this->getEavAttributes()->deleteAttribute($name);
        else
            return parent::__unset($name);
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $isValid = parent::validate($attributeNames, $clearErrors);
        $eavIsValid = $this->getEavAttributes()->validate();
        return $isValid && $eavIsValid;
    }

    public function isTransactional($operation)
    {
        // все операции (вставка, изменение и удаление) должны выполняться в транзакциях из-за дополнительных атрибутов
        if ($operation & (self::OP_INSERT | self::OP_UPDATE | self::OP_DELETE))
            return true;
        else
            return parent::isTransactional($operation);
    }

    public function afterSave($insert, $changedAttributes)
    {
        // TODO перевести на события
        return $this->getEavAttributes()->saveAll() && parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        // TODO перевести на события
        return $this->getEavAttributes()->deleteAll() && parent::afterDelete();
    }
}
