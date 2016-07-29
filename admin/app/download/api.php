<?php

require_once dirname(__FILE__) . '/cls/PHPExcel.php';
require_once dirname(__FILE__) . '/cls/DbHelper.php';


class app {

	public function index () {

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('Asia/Shanghai');

		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');

		/** Include PHPExcel */


		$user_type = intval($_GET['user_type']);
		$title = ['用户列表', '管理员列表'];

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
			->setLastModifiedBy("Maarten Balliauw")
			->setTitle("Office 2007 XLSX Test Document")
			->setSubject("Office 2007 XLSX Test Document")
			->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
			->setKeywords("office 2007 openxml php")
			->setCategory("Test result file");


		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', '手机号')
			->setCellValue('B1', '用户名')
			->setCellValue('C1', '注册时间');

		$db_helper = new DbHelper();
		switch ($user_type) {
			case 1:
				$sql = "select username, nickname, from_unixtime(userregtime, '%Y-%m-%d %H:%i') as reg_time from x2_user where usergroupid=8";
				$users = $db_helper->get_list($sql);
				break;
			case 2:
				$sql = "select username, nickname, from_unixtime(userregtime, '%Y-%m-%d %H:%i') as reg_time from x2_user where usergroupid=1";
				$users = $db_helper->get_list($sql);
				break;
			default:
				break;
		}
               
		foreach ($users as $key=>$user) {
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit('A'.($key + 2),$user['username'],   PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValue('B'.($key + 2), $user['nickname'])
				->setCellValue('C'.($key + 2), $user['reg_time']);
		}

		$objPHPExcel->getActiveSheet()->setTitle($title[$user_type-1]);

		$objPHPExcel->setActiveSheetIndex(0);

                ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$title[$user_type-1].'.xls"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');

		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
        public function orders(){
           
                error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('Asia/Shanghai');

		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');

		/** Include PHPExcel */


		$user_type = intval($_GET['user_type']);
		$title = ['视频订单报表', '直播订单报表','主观题订单报表','订单报表'];

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
			->setLastModifiedBy("Maarten Balliauw")
			->setTitle("Office 2007 XLSX Test Document")
			->setSubject("Office 2007 XLSX Test Document")
			->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
			->setKeywords("office 2007 openxml php")
			->setCategory("Test result file");


		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', '订单编号')
			->setCellValue('B1', '订单标题')
			->setCellValue('C1', '订单客户')
                        ->setCellValue('D1', '代金券金额')
                        ->setCellValue('E1', '支付价格')
                        ->setCellValue('F1', '下单时间');
                      

		$db_helper = new DbHelper();
		switch ($user_type) {
			case 1:
				$sql = "select ordersn ,ordertitle,B.username,couponsn,orderprice,from_unixtime(ordercreatetime, '%Y-%m-%d %H:%i') as ordercreatetime 
                                        from x2_orders A inner join x2_user B ON A.orderuserid=B.userid 
                                        where orderstatus=0 and ordertype=1"; //视频
				$orders = $db_helper->get_list($sql);
				break;
			case 2:
				$sql = "select ordersn ,ordertitle,B.username,couponsn,orderprice,from_unixtime(ordercreatetime, '%Y-%m-%d %H:%i') as ordercreatetime 
                                        from x2_orders A inner join x2_user B ON A.orderuserid=B.userid 
                                        where orderstatus=1 and ordertype=2"; //直播
				$orders = $db_helper->get_list($sql);
				break;
                        case 3:
                            $sql = "select ordersn ,ordertitle,B.username,couponsn,orderprice,from_unixtime(ordercreatetime, '%Y-%m-%d %H:%i') as ordercreatetime 
                                        from x2_orders A inner join x2_user B ON A.orderuserid=B.userid 
                                        where orderstatus=0 and ordertype=1";  //主观题
				$orders = $db_helper->get_list($sql);
                                break;
			default:
                               $sql = "select ordersn ,ordertitle,B.username,couponsn,orderprice,from_unixtime(ordercreatetime, '%Y-%m-%d %H:%i') as ordercreatetime 
                                        from x2_orders A inner join x2_user B ON A.orderuserid=B.userid 
                                        where orderstatus=0 "; //所有
				$orders = $db_helper->get_list($sql);
				break;
		}
               
		foreach ($orders as $key=>$order) {
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit('A'.($key + 2),$order['ordersn'],PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValue('B'.($key + 2), $order['ordertitle'])
				->setCellValueExplicit('C'.($key + 2), $order['username'],PHPExcel_Cell_DataType::TYPE_STRING)
                                ->setCellValue('D'.($key + 2), $order['couponsn'])
                                ->setCellValue('E'.($key + 2), $order['orderprice'])
                                ->setCellValue('F'.($key + 2), $order['ordercreatetime']);
                              
		}

		$objPHPExcel->getActiveSheet()->setTitle($title[$user_type-1]);

		$objPHPExcel->setActiveSheetIndex(0);

                ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$title[$user_type-1].'.xls"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');

		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
        }
        
}

