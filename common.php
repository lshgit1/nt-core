<?php
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );

header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');

$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',
                  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',
                  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
$ext_cnt = count($ext_arr);
for ($i=0; $i<$ext_cnt; $i++) {
    // POST, GET 으로 선언된 전역변수가 있다면 unset() 시킴
    if (isset($_GET[$ext_arr[$i]]))  unset($_GET[$ext_arr[$i]]);
    if (isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);
    if (isset($_REQUEST[$ext_arr[$i]])) unset($_REQUEST[$ext_arr[$i]]);
}

unset($ext_arr);
unset($ext_cnt);
unset($i);

// multi-dimensional array에 사용자지정 함수적용
function array_map_deep($fn, $array)
{
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = array_map_deep($fn, $value);
            } else {
                $array[$key] = call_user_func($fn, $value);
            }
        }
    } else {
        $array = call_user_func($fn, $array);
    }

    return $array;
}

// sql escape 적용
$_POST    = array_map_deep('addslashes',  $_POST);
$_GET     = array_map_deep('addslashes',  $_GET);
$_COOKIE  = array_map_deep('addslashes',  $_COOKIE);
$_REQUEST = array_map_deep('addslashes',  $_REQUEST);

// autoload
require __DIR__.'/vendor/autoload.php';

// 경로 설정
new PATH();

// 공통변수
$html   = array();
$nt     = array();
$config = array();
$member = array();

require NT_CONFIG_PATH.DIRECTORY_SEPARATOR.'config.php';
require NT_LIB_PATH.DIRECTORY_SEPARATOR.'functions.php';

// User functions
if (is_file(NT_LIB_PATH.DIRECTORY_SEPARATOR.'functions.php'))
    require NT_LIB_PATH.DIRECTORY_SEPARATOR.'functions.user.php';

// SESSION 설정
new SESSION();

header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

// 시간상수
define('NT_TIME_SERVER', time());
define('NT_TIME_YMDHIS', date('Y-m-d H:i:s', NT_TIME_SERVER));
define('NT_TIME_YMD',    date('Y-m-d',       NT_TIME_SERVER));
define('NT_TIME_HIS',    date('H:i:s',       NT_TIME_SERVER));

// DB 연결
$DB = new DB();

// Init 파일 로드
if (defined('NT_INIT_PATH') && NT_INIT_PATH) {
    foreach (glob(NT_INIT_PATH.DIRECTORY_SEPARATOR.'[0-9][0-9].init.php') as $f) {
        require_once $f;
    }

    unset($f);
}