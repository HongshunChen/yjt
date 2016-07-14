<?php

require_once dirname(__FILE__) . '/cls/PHPExcel.php';
require_once dirname(__FILE__) . '/cls/DbHelper.php';


class app {

	public function index () {

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('Europe/London');

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
				->setCellValue('A'.($key + 2), $user['username'])
				->setCellValue('B'.($key + 2), $user['nickname'])
				->setCellValue('C'.($key + 2), $user['reg_time']);
		}

		$objPHPExcel->getActiveSheet()->setTitle('用户列表');

		$objPHPExcel->setActiveSheetIndex(0);


		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="用户列表.xls"');
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

