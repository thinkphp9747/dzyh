<?php
namespace app\index\model;
use think\Model;    // 调用模型类
/**
 * 员工模型类
 */
class Yg extends Model
{
    /**
     * 用户登录
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return bool   成功返回true，失败返回false。
     */
    static public function login($username, $password)
    {
        // 验证用户是否存在
        $map = array('username' => $username);
        $yg = self::get($map);
    
        if (!is_null($yg)) {
            // 验证密码是否正确
            if ($yg->checkPassword($password)) {
                // 登录
                session('ygid', $yg->getData('id'));
                session('name',$yg->getData('username'));
				session('jgbh',$yg->getData('jgbh'));
                
                return true;
            }
        }
    
        return false;
    }
    
    /**
     * 验证密码是否正确
     * @param  string $password 密码
     * @return bool
     */
    public function checkPassword($password)
    {
        if ($this->getData('password') === $this::encryptPassword($password))
        {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 密码加密算法
     * @param    string                   $password 加密前密码
     * @return   string                             		加密后密码
     * @author panjie@yunzhiclub.com http://www.mengyunzhi.com
     * @DateTime 2016-10-21T09:26:18+0800
     */
    static public function encryptPassword($password)
    {
        // ʵ实际的过程中，我还还可以借助其它字符串算法，来实现不同的加密。
        return sha1(md5($password) . 'mengyunzhi');
    }
    
    /**
     * 注销
     * @return bool 成功true，失败false。
     * @author panjie
     */
    static public function logOut()
    {
        // 销毁session中数据
        session('ygId', null);
        return true;
    }
    
    /**
     * 判断用户是否已登录
     * @return boolean 已登录true
     * @author  panjie <panjie@yunzhiclub.com>
     */
    static public function isLogin()
    {
        $ygid = session('ygid');
    
        // isset()和is_null()是一对反义词
        if (isset($ygid)) {
            return true;
        } else {
            return false;
        }
    }
}