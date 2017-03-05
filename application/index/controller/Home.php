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

/**
 * 调试填写模板文件并下载
 */
 public function downloadfile()
 {
 	include_once '/PHPWord.php';
	$PHPWord = new \PHPWord();
	$document = $PHPWord->loadTemplate("D:/wamp/www/public/uploads/PHP.docx");
	
	$document->setValue('Value1', 'Sun');
	$document->setValue('Value2', 'Mercury');
	$document->setValue('Value3', 'Venus');
	$document->setValue('Value4', 'Earth');
	$document->setValue('Value5', 'Mars');
	$document->setValue('Value6', 'Jupiter');
	$document->setValue('Value7', 'Saturn');
	$document->setValue('Value8', 'Uranus');
	$document->setValue('Value9', 'Neptun');
	$document->setValue('Value10', 'Pluto');
	
	$document->setValue('weekday', date('l'));
	$document->setValue('time', date('H:i'));
	
	$document->save('D:/wamp/www/public/uploads/test.docx');
 	$filename=realpath("D:/wamp/www/public/uploads/test.docx"); //文件名
	$date=date("Ymd-H:i:m");
	Header( "Content-type:  application/octet-stream "); 
	Header( "Accept-Ranges:  bytes "); 
	Header( "Accept-Length: " .filesize($filename));
	header( "Content-Disposition:  attachment;  filename= {$date}.docx"); 
	echo file_get_contents($filename);
	readfile($filename); 
	$this->success("下载成功", "index");// 跳转首页页面
 }

/**
 * 输出对标擂台赛缴费平台通报表
 */
 public function down_dbtb1()
 {
 	$dir=dirname(__FILE__);//查找当前脚本所在路径	
 	include_once '/PHPExcel.php';//引入PHPExcel类库
	$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
	$objSheet=$objPHPExcel->getActiveSheet();//获取活动工作表
	//设置表缺省格式为水平、垂直居中
	$objSheet->getDefaultStyle()->getAlignment()
		->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
		->SetHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle("A1:Z1")->getFont()->setName("微软雅黑")->setSize(20)->setBold(True);
	$objSheet->getStyle("A3:Z5")->getFont()->setName("微软雅黑")->setSize(11)->setBold(True);
	
	$row = Db::name('bgsc')->where('dbzb < 20' )->select();//获取数据
	
	//Merge cells 合并分离单元格  
	$objSheet->mergeCells('A1:N1');
	$objSheet->setCellValue("A1","对标擂台赛缴费平台通报表2017");
	$objSheet->setCellValue("A2","说明：******************");
	//设置表头合并单元格
	$objSheet->mergeCells('A3:A5')
			->mergeCells('B3:B5')
			->mergeCells('C3:C5')
			->mergeCells('D3:D5')
			->mergeCells('E3:H3')
			->mergeCells('E4:E5')
			->mergeCells('F4:F5')
			->mergeCells('G4:G5')
			->mergeCells('H4:H5')
			->mergeCells('I3:N3')
			->mergeCells('I4:I5')
			->mergeCells('J4:J5')
			->mergeCells('K4:K5')
			->mergeCells('L4:L5')
			->mergeCells('M4:M5')
			->mergeCells('N4:N5');
	//填充表头背景颜色
	$objSheet->getStyle('A3:N5')
		->getFill()
		->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()->setRGB('d9ead3');
	$gradeBorder=$this->getBorderStyle("090909");//获取年级边框样式代码
	$objSheet->getStyle("A3:N42")
		->applyFromArray($gradeBorder);//设置每个年级的边框
	$objSheet->getStyle(3)->getAlignment()->setWrapText(true);//设置文字自动换行
	$objSheet->setCellValue("A3","组别")
		->setCellValue("B3","机构名称")
		->setCellValue("C3","缴费平台\n活跃户")
		->setCellValue("D3","缴费平台\n缴费笔数")
		->setCellValue("E3","缴费平台户数")
		->setCellValue("E4","合计")
		->setCellValue("F4","已上线")
		->setCellValue("G4","待省行审批")
		->setCellValue("H4","已组织材料\n待上报")
		->setCellValue("I3","行业应用缴费")
		->setCellValue("I4","电费")
		->setCellValue("J4","交通罚没")
		->setCellValue("K4","通讯费")
		->setCellValue("L4","彩票站点充值")
		->setCellValue("M4","水费")
		->setCellValue("N4","有线电视");
	
	$j=6;
	foreach($row as $key=>$val){
		$objSheet->setCellValue("A".$j,$val['dbzb'])
			->setCellValue("B".$j,$val['jgname'])
			->setCellValue("C".$j,$val['活跃户数'])
			->setCellValue("D".$j,$val['缴费平台缴费笔数'])
			->setCellValue("E".$j,$val['合计'])
			->setCellValue("F".$j,$val['已上线'])
			->setCellValue("G".$j,$val['正在审批'])
			->setCellValue("H".$j,$val['储备'])
			->setCellValue("I".$j,$val['电费'])
			->setCellValue("J".$j,$val['交通罚没'])
			->setCellValue("K".$j,$val['通讯费'])
			->setCellValue("L".$j,$val['彩票站点缴费'])
			->setCellValue("M".$j,$val['水费'])
			->setCellValue("N".$j,$val['有线费']);
			$j++;
	}
	$objWrite=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');//生成Excel文件
	//$objWrite->save("D:/wamp/www/public/uploads/export_2.xls");//保存文件
	$this->browser_export('Excel5','browser_excel.xls');//输出到浏览器
	$objWrite->save("php://output");
 }

	/**
	 * 输出对标擂台赛缴费平台通报表
	 */
	public function down_dbtb(){
		$dir=dirname(__FILE__);//查找当前脚本所在路径	
	 	include_once '/PHPExcel.php';//引入PHPExcel类库
		$objPHPExcel = \PHPExcel_IOFactory::load('D:/wamp/www/public/uploads/tb_template.xls');//打开Excel模板
		$objSheet=$objPHPExcel->getActiveSheet('40机构');//获取活动工作表
		$row = Db::name('bgsc')->where('dbzb < 40' )->select();//获取数据
		$j=7;
		foreach($row as $key=>$val){
			$objSheet->setCellValue("F".$j,$val['活跃户数'])
				->setCellValue("G".$j,$val['缴费平台缴费笔数'])
				->setCellValue("H".$j,$val['合计'])
				->setCellValue("I".$j,$val['已上线'])
				->setCellValue("J".$j,$val['正在审批'])
				->setCellValue("K".$j,$val['储备'])
				->setCellValue("N".$j,$val['电费'])
				->setCellValue("P".$j,$val['交通罚没'])
				->setCellValue("R".$j,$val['通讯费'])
				->setCellValue("T".$j,$val['彩票站点缴费'])
				->setCellValue("V".$j,$val['水费'])
				->setCellValue("X".$j,$val['有线费']);
				$j++;
		}
		$objWrite=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');//生成Excel文件
			//$objWrite->save("D:/wamp/www/public/uploads/export_2.xls");//保存文件
		$this->browser_export('Excel5','browser_excel.xls');//输出到浏览器
		$objWrite->save("php://output");
	}
	/**
	 * 生成Excel文件输出到浏览器
	 */
	function browser_export($type,$filename){
		
		if($type=="Excel5"){
			header('Content-Type:application/vnd.ms-excel');//告诉浏览器将要输出excel03文件
		}else{
			header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//告诉浏览器将要输出Excel07文件
		}
		header('Content-Disposition:attachment;filename="'.$filename.'"');//告诉浏览器将输出文件的名称
		header('Cache-Control:max-age=0');//禁止缓存
	}
	/**
	**获取边框样式代码
	**/
		function getBorderStyle($color){
				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => \PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => $color),
						),
						
						
					),
				);
				return $styleArray;
		}


}
