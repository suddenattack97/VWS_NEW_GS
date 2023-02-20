<?
define('ORA_DSN',	"DivasDB");
define('ORA_TNS',	"DIVASDB");  
define('ORA_ID',	"DivasDB");
define('ORA_PW',	"htni1600"); 

#오라클 쿼리 실행중 월간의 마지막날 가져오기
$year	= date("Y");
$month	= date("m");
$day	= date("t",mktime(0,0,0,$month,1, $year));

define('month_end_day',			$year."-".$month."-".$day);

//mysql 시간
define('R_NOW_START',	"TO_DATE('".strftime("%Y-%m-%d %H",strtotime('now')).':00:00'."','YYYY-MM-DD HH24:mi:SS')");		//현재시간 시작
define('R_NOW_END',		"TO_DATE('".strftime("%Y-%m-%d %H",strtotime('now')).':59:59'."','YYYY-MM-DD HH24:mi:SS')");		//현재시간 끝
define('R_BEF_START',	"TO_DATE('".strftime("%Y-%m-%d %H",strtotime('-1 hour')).':00:00'."','YYYY-MM-DD HH24:mi:SS')");	//전시간 시작
define('R_BEF_END',		"TO_DATE('".strftime("%Y-%m-%d %H",strtotime('-1 hour')).':59:59'."','YYYY-MM-DD HH24:mi:SS')");	//전시간 끝
define('R_DAY_START',	"TO_DATE('".strftime("%Y-%m-%d",strtotime('now')).' 00:00:00'."','YYYY-MM-DD HH24:mi:SS')");		//금일 시작
define('R_DAY_END',		"TO_DATE('".strftime("%Y-%m-%d",strtotime('now')).' 23:59:59'."','YYYY-MM-DD HH24:mi:SS')");		//금일 끝
define('R_BDAY_START',	"TO_DATE('".strftime("%Y-%m-%d",strtotime('-1 day')).' 00:00:00'."','YYYY-MM-DD HH24:mi:SS')");		//전일 시작
define('R_BDAY_END',	"TO_DATE('".strftime("%Y-%m-%d",strtotime('-1 day')).' 23:59:59'."','YYYY-MM-DD HH24:mi:SS')");		//전일 끝
define('R_MONTH_START',	"TO_DATE('".strftime("%Y-%m",strtotime('now')).'-01 00:00:00'."','YYYY-MM-DD HH24:mi:SS')");		//월간 시작
define('R_MONTH_END',	"TO_DATE('".month_end_day.' 23:59:59'."','YYYY-MM-DD HH24:mi:SS')");								//월간 끝
define('R_YEAR_START',	"TO_DATE('".strftime("%Y",strtotime('now')).'-01-01 00:00:00'."','YYYY-MM-DD HH24:mi:SS')");		//연간 시작
define('R_YEAR_END',	"TO_DATE('".strftime("%Y",strtotime('now')).'-12-31 23:59:59'."','YYYY-MM-DD HH24:mi:SS')");		//연간 끝
?>