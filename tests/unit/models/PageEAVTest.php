<?php
namespace tests\models;
use app\models\PageEAV;

class PageEAVTes extends \Codeception\Test\Unit
{
    // проверка поиска по ID
    public function testPageById()
    {
        expect_that($page = PageEAV::findOne(1));
        expect($page->alias)->equals('test-page');

        expect_not(PageEAV::findOne(999));
    }

    public function testReadExtraAttribute()
    {
        expect_that($page = PageEAV::findOne(1));
        expect($page->extra_attribute)->equals('some_value');
        expect($page->other_attribute)->internalType('null');
    }

    public function testWriteExtraAttribute()
    {
        expect_that($page = PageEAV::findOne(1));
        expect($page->new_attribute)->internalType('null');
        $page->new_attribute = $testValue = date('c');
        expect($page->new_attribute)->equals($testValue);
    }

    public function testRemoveExtraAttribute()
    {
        expect_that($page = PageEAV::findOne(1));
        expect($page->new_attribute)->internalType('null');
        $page->new_attribute = $testValue = date('c');
        expect($page->new_attribute)->equals($testValue);
        unset($page->new_attribute);
        expect($page->new_attribute)->internalType('null');
    }

    public function testSaveExtraAttributes()
    {
        expect_that($page = PageEAV::findOne(1));
        $randomAttribute = 'x'.sha1(time());

        expect($page->{$randomAttribute})->internalType('null');
        $page->{$randomAttribute} = $testValue = date('c');

        expect_that($page->save());

        expect_that($page = PageEAV::findOne(1));
        expect($page->{$randomAttribute})->equals($testValue);
    }
}
