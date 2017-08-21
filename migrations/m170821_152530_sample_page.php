<?php

use yii\db\Migration;

class m170821_152530_sample_page extends Migration
{
    public function safeUp()
    {
        $this->insert('page', [
            'id' => 1,
            'alias' => 'test-page',
            'template' => 'basic',
            'lang' => 'ru',
            'title' => 'Sample Page',
            'h1' => '',
            'description' => 'Sample Page For Tests',
            'keywords' => 'sample,page,test',
            'text' => 'Sample Page For Tests. That\'s it.',
            'status' => 1,
            'created' => date('c'),
            'updated' => date('c'),
        ]);
    }

    public function safeDown()
    {
        $this->delete('page', 'id=1');
    }
}
