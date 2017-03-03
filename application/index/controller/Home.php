<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
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
		 $request = Request::instance();
		 $this->assign('module',$request->module());
		 $this->assign('controller',$request->controller());
		 $this->assign('action',$request->action());
    	return view();    
	}
	/**
	 * 通报数据图表显示
	 */
	public function chart()
	{
		$this->assign('ygid',1);
		$request = Request::instance();
		 $this->assign('module',$request->module());
		 $this->assign('controller',$request->controller());
		 $this->assign('action',$request->action());
		return view();
	}
	
	/**
	 * 缴费平台数据导入上传
	 */
	 public function upjfsj()
	 {
	 	$this->assign('ygid',1);
		$request = Request::instance();
		 $this->assign('module',$request->module());
		 $this->assign('controller',$request->controller());
		 $this->assign('action',$request->action());
		return view();
	 }
	 
	 /**
	 * 悦生活数据导入上传 
	 */
	 public function upyshsj()
	 {
	 	$this->assign('ygid',1);
		$request = Request::instance();
		 $this->assign('module',$request->module());
		 $this->assign('controller',$request->controller());
		 $this->assign('action',$request->action());
		return view();
	 }
	 
	 /**
	  * 缴费平台数据导入
	  */
  
	public function putjfsj()
	{
		 $file = request()->file('import');
	    // 移动到框架应用根目录/public/uploads/ 目录下
	     $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads','jfsj.xlsx');
	    if($info){
	        // 成功上传后 获取上传信息
	       
	        $filepath = $info->getFilename();
			
			//引入PHPExcel类库
	
			include_once '/PHPExcel/IOFactory.php';
			
//			//获取excel文件
			
			$objPHPExcel = \PHPExcel_IOFactory::load("D:/wamp/www/public/uploads/".$filepath);//加载文件
			//sheetCount = $objPHPExcel->getSheetCount();//获取excel文件里有多少sheet
			$data=$objPHPExcel->getSheet(0)->toArray();
			$sj=date("Y-m-d");
			$ac = count($data);
			for ($i=3;$i<$ac;$i++){
				
				$cell[]=array(
					'sjdate'=>$sj,
					'shbh'=>$data[$i][0],
					'shlb'=>$data[$i][1],
					'wsjyl'=>$data[$i][10],
					'xjjyl'=>$data[$i][12],
					'wsjye'=>$data[$i][16],
					'xjjye'=>$data[$i][18]
				);
			}
					
			$result = Db::name('jfptsj')->insertAll($cell);	
			 if ($result) {                                               // 验证

                    $this->success("导入成功", "index");// 跳转首页页面

                } else {

                    $this->error("导入失败，原因可能是excel表中有些用户已被注册。或表格格式错误","5");// 提示错误

                }
					
			     
	    }else{
	        // 上传失败获取错误信息
	        echo $file->getError();
	    }
		
	}
	
	 /**
	  * 悦生活数据导入
	  */
  
	public function putyshsj()
	{
		 $file = request()->file('import');
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads','yshsj.xlsx');
	    if($info){
	        // 成功上传后 获取上传信息
	       
	        $filepath = $info->getFilename();
			
			//引入PHPExcel类库
	
			include_once '/PHPExcel/IOFactory.php';
			
//			//获取excel文件
			
			$objPHPExcel = \PHPExcel_IOFactory::load("D:/wamp/www/public/uploads/".$filepath);//加载文件
			//sheetCount = $objPHPExcel->getSheetCount();//获取excel文件里有多少sheet
			$data=$objPHPExcel->getSheet(0)->toArray();

			$ac = count($data);
			for ($i=7;$i<$ac;$i++){
				
				$cell[]=array(
					'jgbh'=>$data[$i][1],
					'cpjf'=>$data[$i][50],
					'sjjf'=>$data[$i][70],
					'yxjf'=>$data[$i][71],
					'jtfmjf'=>$data[$i][73],
					'dfjf'=>$data[$i][77],
					'sfjf'=>$data[$i][78],
					'sjdate'=>date("Y-m-d")
				);
			}
					
			$result = Db::name('yshsj')->insertAll($cell);	
			 if ($result) {                                               // 验证

                    $this->success("导入成功", "index");// 跳转首页页面

                } else {

                    $this->error("导入失败，原因可能是excel表中有些用户已被注册。或表格格式错误","5");// 提示错误

                }
					
			     
	    }else{
	        // 上传失败获取错误信息
	        echo $file->getError();
	    }
		
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
