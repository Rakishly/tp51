<?php
namespace app\index\controller;
use Swoole\Client;

class Test
{
    public function index()
    {
        echo 1;exit;
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function test()
    {

        $client = new Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC);
        $ret = $client->connect("106.13.188.80", 9508);

        if(empty($ret)){
            echo 'error!connect to swoole_server failed';
        } else {
            $client->send('test');
        }
    }
}
