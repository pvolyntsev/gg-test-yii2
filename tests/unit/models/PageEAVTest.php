<?php
namespace tests\models;
use app\models\PageEAV;

class PageEAVTest extends \Codeception\Test\Unit
{
    // проверка поиска по ID
    public function testPageById()
    {
        expect_that($page = PageEAV::findOne(1));
        expect($page->alias)->equals('test-page');

        expect_not(PageEAV::findOne(999));
    }
//
//    public function testFindUserByAccessToken()
//    {
//        expect_that($user = User::findIdentityByAccessToken('100-token'));
//        expect($user->username)->equals('admin');
//
//        expect_not(User::findIdentityByAccessToken('non-existing'));
//    }
//
//    public function testFindUserByUsername()
//    {
//        expect_that($user = User::findByUsername('admin'));
//        expect_not(User::findByUsername('not-admin'));
//    }
//
//    /**
//     * @depends testFindUserByUsername
//     */
//    public function testValidateUser($user)
//    {
//        $user = User::findByUsername('admin');
//        expect_that($user->validateAuthKey('test100key'));
//        expect_not($user->validateAuthKey('test102key'));
//
//        expect_that($user->validatePassword('admin'));
//        expect_not($user->validatePassword('123456'));
//    }
}
