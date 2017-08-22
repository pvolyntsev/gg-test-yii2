<?php

use yii\db\Migration;

/**
 * Class m170821_160329_entity_attribute
 * Модель для хранения дополнительных атрибутов
 */
class m170821_160329_entity_attribute extends Migration
{
    public function up()
    {
        $this->createTable('entity_attribute', [
            'id' => $this->primaryKey(),
            'entity' => $this->string(255)->notNull(),
            'entity_id' => $this->integer(11)->notNull(),
            'attribute' => $this->string(255)->notNull(),
            'value' => $this->string(255)->defaultValue(null),
        ]);
        $this->createIndex('eav_entity', 'entity_attribute', ['entity', 'entity_id']);
        $this->createIndex('eav_attribute', 'entity_attribute', ['entity', 'entity_id', 'attribute']);
        $this->createIndex('eav_value', 'entity_attribute', ['attribute', 'value']);

        // Sample Data
        $this->insert('entity_attribute', [
            'entity' => 'app\\models\\PageEAV',
            'entity_id' => 1,
            'attribute' => 'extra_attribute',
            'value' => 'some_value',
        ]);
    }

    public function down()
    {
        $this->dropTable('entity_attribute');
    }
}
