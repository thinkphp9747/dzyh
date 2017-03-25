<?php
namespace app\index\controller;
use think\Controller;
use think\Request;              // 引用Request类库
use app\index\model\Yg;   // 引用yg模型类

/**
 * 系统登录控制器
 */

class Index extends Controller
{
     // 用户登录表单
    public function index()
    {
        // 显示登录表单
        $a = "123";
		trace('123');
        return view();
        
    }
    
    // 处理用户提交的登录数据
    public function login()
    {
        // 接收post信息
        $postData = Request::instance()->post();
		      
        // 直接调用M层方法，进行登录。
        if (Yg::login($postData['username'], $postData['password'])) {
            return $this->success('login success', url('home/index'));
        } else {
            return $this->error('username or password incorrent', url('index'));
        }
        
    }
    
    // 注销
    public function logOut()
    {
        if (yg::logOut()) {
            return $this->success('logout success', url('index'));
        } else {
            return $this->error('logout error', url('home/index'));
        }
    }
}
