<?php
/**
 * Created by IntelliJ IDEA.
 * User: lights
 * Date: 2016/11/16
 * Time: 上午10:37
 */

class UserStore
{
    private $users = array();

    function addUser($name, $email, $pass)
    {
        if (isset($this->users[$email])) {
            throw new Exception("User {$email} already in the sys!\n");
        }

        if (strlen($pass) < 2) {
            throw new Exception("pass too short\n");
        }

        $this->users[$email] = array(
            'pass' => $pass,
            'email' => $email,
            'name' => $name
        );

        return true;
    }

    function notifyPasswordFailure($email)
    {
        if (isset($this->users[$email])) {
            $this->users[$email]['failed'] = time(); // what is this ???
        }
    }

    function getUser($email)
    {
        return ($this->users[$email]); // 为什么要加一个括号？？？
    }
}

// 手工执行的测试
//
// $store = new UserStore();
// $store->addUser("jack", "jack@qq.com", "123");
// $user = $store->getUser("jack@qq.com");
// print_r($user);

use PHPUnit_Framework_TestCase;

class UserStoreTest extends PHPUnit_Framework_TestCase
{
    /** @var UserStore */
    private $store;

    public function setUp()
    {
        $this->store = new UserStore();
    }

    public function tearDown()
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    public function testGetUser()
    {
        $this->store->addUser("jack", "jack@qq.com", "123");
        $user = $this->store->getUser("jack@qq.com");
        $this->assertEquals($user["email"], "jack@qq.com");
        $this->assertEquals($user["name"], "jack");
        $this->assertEquals($user["pass"], "123");
    }
}