<?php
namespace app\http;

use think\swoole\Server;

class Swoole extends Server
{
    protected $host = '106.13.188.80';
    protected $port = 9502;
    protected $serverType = 'socket';
    protected $mode = SWOOLE_PROCESS;
    protected $sockType = SWOOLE_SOCK_TCP;
    protected $option = [
        'worker_num'=> 4,
        'daemonize'	=> true,
        'backlog'	=> 128
    ];

    public function __construct()
    {
        // 把上面的属性在此处通过config配置化
    }

    // 注意命名规范，要符合在Server里面定义的event
    public function onReceive($server, $fd, $from_id, $data)
    {
        $server->send($fd, 'Swoole: '.$data);
    }
}