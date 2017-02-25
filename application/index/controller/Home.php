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
	 * 缴费平台数据导入上传
	 */
	 public function upjfsj()
	 {
	 	$this->assign('ygid',1);
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

			$ac = count($data);
			for ($i=5;$i<$ac;$i++){
				$cell[$i][0]=$data[$i][1];
				$cell[$i][1]=$data[$i][4];
			}
			
					
			$this->assign("var",$cell);			
			return $this->fetch("test");
			
//			$objPHPExcel->setActiveSheetIndex(0);
//			$sheet0=$objPHPExcel->getSheet(0);	
//			$i=0;
//			//获取行数，并把数据读取出来$data数组
//			foreach($sheet0->getRowIterator() as $row){//逐行处理
//				if($row->getRowIndex()<5){
//					continue;
//				}
//				$data[$i]=$row->getCellIterator($i)->getValue();
//				$i=$i+1;
//				$data[$i]=$row->getCell(4)->getValue();
//				$i=$i+1;
//			}
			
	        
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
