<?
// DB 정보
/*
define('DB_HOST',       "10.1.1.10:13306");
define('DB_USER',       "root");
define('DB_PASSWORD',   "a32956!");
define('DB_DATABASE',   "divas_gapyeong");
*/
/*
define('DB_HOST',       "localhost:3309");
define('DB_USER',       "root");
define('DB_PASSWORD',   "123456");
define('DB_DATABASE',   "divas_ech");
*/
/*
define('DB_HOST',		"27.101.121.81:13306");
define('DB_USER',		"root");  
define('DB_PASSWORD',	"divas32956");
define('DB_DATABASE',	"divas"); 
*/


define('DB_HOST',		"192.168.1.8");
define('DB_USER',		"root");  
define('DB_PASSWORD',	"123456");
define('DB_DATABASE',	"vws"); 

/* define('DB_HOST',		"192.168.1.63");
define('DB_USER',		"root");  
define('DB_PASSWORD',	"2412");
define('DB_DATABASE',	"divas_new");  */

// 시간 정보
if(TEST == "0"){
	define('O_NOW_START',	"CAST('".strftime("%Y-%m-%d %H",strtotime('now')).':00:00'."' AS DATETIME)");				//현재시간 시작
	define('O_NOW_END',		"CAST('".strftime("%Y-%m-%d %H",strtotime('now')).':59:59'."' AS DATETIME)");				//현재시간 끝
	define('O_BEF_START',	"CAST('".strftime("%Y-%m-%d %H",strtotime('-1 hour')).':00:00'."' AS DATETIME)");			//전시간 시작
	define('O_BEF_END',		"CAST('".strftime("%Y-%m-%d %H",strtotime('-1 hour')).':59:59'."' AS DATETIME)");			//전시간 끝
	define('R_NOW_START',	"CAST('".strftime("%Y-%m-%d %H",strtotime('now '.DIFF)).':00:00'."' AS DATETIME)");			//현재시간 시작
	define('R_NOW_END',		"CAST('".strftime("%Y-%m-%d %H",strtotime('now '.DIFF)).':59:59'."' AS DATETIME)");			//현재시간 끝
	define('R_BBBEF_START',	"CAST('".strftime("%Y-%m-%d %H",strtotime('-3 hour '.DIFF)).':00:00'."' AS DATETIME)");		//전전전시간 시작
	define('R_BBBEF_END',	"CAST('".strftime("%Y-%m-%d %H",strtotime('-3 hour '.DIFF)).':59:59'."' AS DATETIME)");		//전전전시간 끝
	define('R_BBEF_START',	"CAST('".strftime("%Y-%m-%d %H",strtotime('-2 hour '.DIFF)).':00:00'."' AS DATETIME)");		//전전시간 시작
	define('R_BBEF_END',	"CAST('".strftime("%Y-%m-%d %H",strtotime('-2 hour '.DIFF)).':59:59'."' AS DATETIME)");		//전전시간 끝
	define('R_BEF_START',	"CAST('".strftime("%Y-%m-%d %H",strtotime('-1 hour '.DIFF)).':00:00'."' AS DATETIME)");		//전시간 시작
	define('R_BEF_END',		"CAST('".strftime("%Y-%m-%d %H",strtotime('-1 hour '.DIFF)).':59:59'."' AS DATETIME)");		//전시간 끝
	define('R_DAY_START',	"CAST('".strftime("%Y-%m-%d",strtotime('now')).' 00:00:00'."' AS DATETIME)");				//금일 시작
	define('R_DAY_END',		"CAST('".strftime("%Y-%m-%d",strtotime('now')).' 23:59:59'."' AS DATETIME)");				//금일 끝
	define('R_BDAY_START',	"CAST('".strftime("%Y-%m-%d",strtotime('-1 day')).' 00:00:00'."' AS DATETIME)");			//전일 시작
	define('R_BDAY_END',	"CAST('".strftime("%Y-%m-%d",strtotime('-1 day')).' 23:59:59'."' AS DATETIME)");			//전일 끝
	define('R_BBDAY_START',	"CAST('".strftime("%Y-%m-%d",strtotime('-2 day')).' 00:00:00'."' AS DATETIME)");			//전전일 시작
	define('R_BBDAY_END',	"CAST('".strftime("%Y-%m-%d",strtotime('-2 day')).' 23:59:59'."' AS DATETIME)");			//전전일 끝
	define('R_MONTH_START',	"CAST('".strftime("%Y-%m",strtotime('now')).'-01 00:00:00'."' AS DATETIME)");				//월간 시작
	define('R_MONTH_END',	"CAST('".strftime("%Y-%m",strtotime('now')).'-31 23:59:59'."' AS DATETIME)");				//월간 끝
	define('R_YEAR_START',	"CAST('".strftime("%Y",strtotime('now')).'-01-01 00:00:00'."' AS DATETIME)");				//연간 시작
	define('R_YEAR_END',	"CAST('".strftime("%Y",strtotime('now')).'-12-31 23:59:59'."' AS DATETIME)");				//연간 끝
}else{
	define('O_NOW_START',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." ".TEST_h.":00:00"))."' AS DATETIME)");
	define('O_NOW_END',		"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." ".TEST_h.":59:59"))."' AS DATETIME)");
	define('O_BEF_START',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." ".TEST_h.":00:00 -1 hour"))."' AS DATETIME)");
	define('O_BEF_END',		"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." ".TEST_h.":59:59 -1 hour"))."' AS DATETIME)");
	define('R_NOW_START',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." ".TEST_h.":00:00"))."' AS DATETIME)");
	define('R_NOW_END',		"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." ".TEST_h.":59:59"))."' AS DATETIME)");
	define('R_BBEF_START',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." ".TEST_h.":00:00 -2 hour"))."' AS DATETIME)");
	define('R_BBEF_END',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." ".TEST_h.":59:59 -2 hour"))."' AS DATETIME)");
	define('R_BEF_START',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." ".TEST_h.":00:00 -1 hour"))."' AS DATETIME)");
	define('R_BEF_END',		"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." ".TEST_h.":59:59 -1 hour"))."' AS DATETIME)");
	define('R_DAY_START',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." 00:00:00"))."' AS DATETIME)");
	define('R_DAY_END',		"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." 23:59:59"))."' AS DATETIME)");
	define('R_BDAY_START',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." 00:00:00 -1 day"))."' AS DATETIME)");
	define('R_BDAY_END',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." 23:59:59 -1 day"))."' AS DATETIME)");
	define('R_BBDAY_START',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." 00:00:00 -2 day"))."' AS DATETIME)");
	define('R_BBDAY_END',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-".TEST_d." 23:59:59 -2 day"))."' AS DATETIME)");
	define('R_MONTH_START',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-01 00:00:00"))."' AS DATETIME)");
	define('R_MONTH_END',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-".TEST_m."-31 23:59:59"))."' AS DATETIME)");
	define('R_YEAR_START',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-01-01 00:00:00"))."' AS DATETIME)");
	define('R_YEAR_END',	"CAST('".date("Y-m-d H:i:s", strtotime(TEST_y."-12-31 23:59:59"))."' AS DATETIME)");
}
?>