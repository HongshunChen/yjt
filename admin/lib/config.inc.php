<?php
define('DOMAINTYPE','off');
define('CH','exam_');
define('CDO','');
define('CP','/');
define('CRT',180);
define('CS','xn9dylsl012002');
define('HE','utf-8');
define('PN',10);
define('TIME',time());
define('WRITETOKEN','c7679704-ffbc-40ab-839d-72a8e4521a10');
define('USERID','e48926e810');
define('READTOKEN','c05bccf2-849b-4ce0-97ee-12ac810a35c3');
$hash = md5(TIME.WRITETOKEN);
define('HASH',$hash);

if(dirname($_SERVER['SCRIPT_NAME']))
define('WP','http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).'/');
else
define('WP','http://'.$_SERVER['SERVER_NAME']);

define('DB','yjt');//MYSQL数据库名
define('DH','120.27.47.182');//MYSQL主机名，不用改
define('DU','root');//MYSQL数据库用户名
define('DP','root');//MYSQL数据库用户密码
define('DTH','x2_');//系统表前缀，不用改


/*优惠券面值配置*/
define('TEN_COUPON',10);
define('TOW_COUPON',20);
define('FIFTY_COUPON',50);

// 优惠券生效时间 10天
define('TIME_COUPON',10);
// 每次生成条数
define('NUBER_COUPON',100);
//优惠券自动生成阀值
define('THRESHOLD',10);

?>
