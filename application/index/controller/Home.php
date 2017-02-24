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
		 $file = request()->file('jfsj');
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
	    if($info){
	        // 成功上传后 获取上传信息
	        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
	        $filepath = "/public/uploads/".$info->getSaveName();
			
			//引入PHPExcel类库
			require_once '/public/PHPExcel/IOFactory.php';
			
			//获取excel文件
			$objPHPExcel = \PHPExcel_IOFactory::load("$filepath");
			$objPHPExcel->setActiveSheetIndex(0);
			$sheet0=$objPHPExcel->getSheet(0);	
			
			//获取行数，并把数据读取出来$data数组
			$rowCount=$sheet0->getHighestRow();//excel行数
	        $data=array();
	        for ($i = 2; $i <= $rowCount; $i++){
	            $item['name']=$this->getExcelValue($sheet0,'A'.$i);
	            $item['sex']=$this->getExcelValue($sheet0,'B'.$i);
	            $item['contact']=$this->getExcelValue($sheet0,'C'.$i);
	            $item['remark']=$this->getExcelValue($sheet0,'D'.$i);
	            $item['addtime']=$this->getExcelValue($sheet0,'E'.$i);
	
	            $data[]=$item;
	        }	
			
			//保存到数据
			$success=0;
			$error=0;
			$sum=count($data);
			foreach($data as $k=>$v){
			    if(M('temp_area3')->data($v)->add()){
			        $success++;
			    }else {
			        $error++;
			        }
			    }
			
			        echo "总{$sum}条，成功{$success}条，失败{$error}条。";
			
	        
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
