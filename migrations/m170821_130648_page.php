<?php

use yii\db\Migration;

class m170821_130648_page extends Migration
{
    public function up()
    {
        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'alias' => $this->string(255)->notNull(),
            'template' => $this->string(11)->notNull(),
            'lang' => $this->string(3)->notNull()->defaultValue('ru'),
            'title' => $this->string(255)->notNull(),
            'h1' => $this->string(255)->notNull()->defaultValue(''),
            'description' => $this->string(255)->notNull(),
            'keywords' => $this->string(255)->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->integer(1)->unsigned()->notNull()->defaultValue(1),
            'created' => $this->datetime()->notNull(),
            'updated' => $this->datetime()->notNull(),
        ]);
        $this->createIndex('page_status', 'page', ['status']);
        $this->createIndex('page_created', 'page', ['created']);
        $this->createIndex('page_alias', 'page', ['alias']);
    }

    public function down()
    {
        $this->dropTable('page');
    }
}
