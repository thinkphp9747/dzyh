<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
/**
 * 缴费平台控制器
 */
class Home extends Controller
{
	/**
	 * 缴费平台主页
	 */
    public function index()
    {
    	 $this->assign('ygid',10);
    	return view();    
	}
	/**
	 * 通报数据图表显示
	 */
	public function chart()
	{
		$this->assign('ygid',1);
		return view();
	}
	
	 /**
     * AJAX返回检索数据填充图表
     * @return  $responce       返回json数据
     */
    public function json()
    {
         
        // 检索数据库数据
        $row = Db::name('yg')->select();
        

        // 转化记录集为json数据格式
         
        for ($i = 0; $i < count($row); $i ++) {
            //$responce->rows[$i]['id'] = trim($row[$i]['id']);
            $responce[$i]= array(
                $row[$i]['id'],
                $row[$i]['username']                
            );
        }
               
        echo json_encode($responce); // 转化为json数据格式
        
    }
}
