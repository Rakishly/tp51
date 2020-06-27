<?php
namespace app\index\controller;
use Swoole\Client;
use think\App;
use think\Controller;
use think\Request;
use think\response\Redirect;

class Index extends Controller
{

    protected $img = [];
    public function index()
    {
        //halt(request()->server());
        //return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';



        $this->img = [
            '/uploads/2020/06/27/5ef753f5c001c.png',
            '/uploads/2020/06/27/5ef753f7d9088.png'
        ];

        $this->assign('img', $this->img);
        return view('index/index');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    /*
    public function test()
    {

        $client = new Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC);
        $ret = $client->connect("106.13.188.80", 9508);

        if(empty($ret)){
            echo 'error!connect to swoole_server failed';
        } else {
            $client->send('test');
        }
    }*/

    public function test()
    {
        return view('index');
    }

    public function upload(Request $request)
    {

        //接收上传的文件
        $file = $request->file('file');

        if(!empty($file)){
            //图片存的路径
            $imgUrl=  $request->server('DOCUMENT_ROOT') . '/uploads/' .  date("Y/m/d");

            // 移动到框架应用根目录/public/uploads/ 目录下

            $info = $file->validate(['size'=>10485760,'ext'=>'jpg,png,gif'])->rule('uniqid')->move($imgUrl);
            $error = $file->getError();
            //验证文件后缀后大小
            if(!empty($error)){
                dump($error);exit;
            }
            if($info){
                // 成功上传后 获取上传信息
                //获取图片的名字
                $imgName = $info->getFilename();
                //halt($imgName);
                //获取图片的路径
                $photo = '/uploads/' .  date("Y/m/d") . "/" . $imgName;

            }else{
                // 上传失败获取错误信息
                $file->getError();
            }
        }else{
            $photo = '';
        }
        if($photo !== ''){
            return ['code'=>1,'msg'=>'成功','photo'=>$photo];
        }else{
            return ['code'=>404,'msg'=>'失败'];
        }

    }


    public function edit(Request $request)
    {
        if ($request->isPost()) {

            $data = $request->post('img');
            halt($data);

        }

    }

    public function del(Request $request)
    {
        $imgName = $request->post('imgName');
        if (file_exists($request->server('DOCUMENT_ROOT').$imgName)) {
            $res = unlink($request->server('DOCUMENT_ROOT').$imgName);
            if ($res) {
                return ['code'=>1,'msg'=>'成功'];
            } else {
                return ['code'=>404,'msg'=>'失败'];
            }
        };
    }

}
