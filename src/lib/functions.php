<?php
// javascript src link 처리
function getjQuery(array $js)
{
    if(!$js) {
        $js = array();
        $js[] = NT_DEFAULT_JQUERY;
    }

    $link = array();

    if(is_array($js)) {
        foreach($js as $src) {
            if(!trim($src))
                continue;

            $link[] = '<script src="'.$src.'"></script>';
        }
    }

    echo implode(PHP_EOL, $link).PHP_EOL;
}

// javascript src link 처리
function getJavascript(array $js, bool $header = true)
{
    if(!$js)
        $js = array();

    if($header)
        array_unshift($js, NT_JS_URL.DIRECTORY_SEPARATOR.'common.js');

    $link = array();

    if(is_array($js)) {
        foreach($js as $src) {
            if(!trim($src))
                continue;

            if(defined('JS_VERSION') && JS_VERSION)
                $src = preg_replace('#\.js([\'\"]?)$#i', '.js?ver='.JS_VERSION.'$1', $src);

            $link[] = '<script src="'.$src.'"></script>';
        }
    }

    echo implode(PHP_EOL, $link).PHP_EOL;
}

// stylesheet src link 처리
function getStylesheet(array $css)
{
    if(!$css)
        $css = array();

    $link = array();

    if(is_array($css)) {
        foreach($css as $src) {
            if(!trim($src))
                continue;

            if(defined('CSS_VERSION') && CSS_VERSION)
                $src = preg_replace('#\.css([\'\"]?)$#i', '.css?ver='.CSS_VERSION.'$1', $src);

            $link[] = '<link rel="stylesheet" href="'.$src.'">';
        }
    }

    echo implode(PHP_EOL, $link).PHP_EOL;
}

// html char
function getHtmlChar($str)
{
    return htmlentities($str, ENT_QUOTES);
}

function gotoUrl(string $url)
{
    $url = str_replace("&amp;", "&", $url);

    if (!headers_sent())
        header('Location: '.$url);
    else {
        echo '<script>';
        echo 'location.replace("'.$url.'");';
        echo '</script>';
    }
    exit;
}

function alert(string $msg = '', string $url = '')
{
    $url = preg_replace("/[\<\>\'\"\\\'\\\"\(\)]/", "", $url);

    echo '<script>'.PHP_EOL;
    echo 'alert("'.strip_tags($msg).'");'.PHP_EOL;
    if ($url)
        echo 'document.location.replace("'.str_replace('&amp;', '&', $url).'");'.PHP_EOL;
    else
        echo 'history.back();'.PHP_EOL;
    echo '</script>';
    exit;
}

function alertClose(string $msg='')
{
    echo '<script>'.PHP_EOL;
    echo 'alert("'.strip_tags($msg).'");'.PHP_EOL;
    echo 'window.close();'.PHP_EOL;
    echo '</script>';
    exit;
}

function dieJson(string $str, string $key = 'error')
{
    die(json_encode(array($key=>$str)));
}

function dieJsonp(string $str, string $key = 'error', string $callback = 'callback')
{
    die($callback.'('.json_encode(array($key=>$str)).')');
}

function randomChar(string $length)
{
    $str = 'abcdefghijklmnopqrstuvwxyz0123456789!@#$%&*ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $max = strlen($str) - 1;
    $chr = '';
    $len = abs($length);

    for ($i=0; $i<$len; $i++) {
        $chr .= $str[random_int(0, $max)];
    }

    return $chr;
}

function isNullTime(string $time)
{
    return preg_replace('#[0:\-\s]#', '', $time) == '';
}

function getSelected(string $val1, string $val2)
{
    return ($val1 == $val2 ? ' selected="selected"': '');
}

function getChecked(string $val1, string $val2)
{
    return ($val1 == $val2 ? ' checked="checked"': '');
}

function getRichTime(string $time)
{
    if (substr($time, 0, 10) == NT_TIME_YMD)
        return substr($time, 11, 5);
    else
        return substr($time, 5, 5);
}

function getSubstr(string $str, string $len, string $suffix = '…')
{
    $arr_str = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    $str_len = count($arr_str);

    if ($str_len >= $len) {
        $slice_str = array_slice($arr_str, 0, $len);
        $str = join('', $slice_str);

        return $str . ($str_len > $len ? $suffix : '');
    } else {
        $str = join('', $arr_str);
        return $str;
    }
}

function getCharCount(string $str)
{
    if (!$str)
        return 0;

    $arr_str = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);

    return count($arr_str);


}

function getMemberUID()
{
    $nt = $GLOBALS['nt'];
    $DB = $GLOBALS['DB'];

    while (1) {
        $uid = date('YmdHis', time()) . str_pad((int)(microtime()*100), 2, "0", STR_PAD_LEFT);

        $sql = " select count(mb_uid) as cnt from `{$nt['member_table']}` where mb_uid = :mb_uid ";

        $DB->prepare($sql);
        $DB->bindValue(':mb_uid', $uid);
        $DB->execute();

        $row = $DB->fetch();

        if (!$row['cnt'])
            break;

        // insert 하지 못했으면 일정시간 쉰다음 다시 유일키를 만든다.
        usleep(10000); // 100분의 1초를 쉰다
    }

    return $uid;
}

function getMember(string $uid, string $field = '*')
{
    $nt = $GLOBALS['nt'];
    $DB = $GLOBALS['DB'];

    if (!$DB->pdo)
        return null;

    $sql = " select $field from `{$nt['member_table']}` where mb_uid = :mb_uid ";

    $DB->prepare($sql);
    $DB->bindValue(':mb_uid', $uid);
    $DB->execute();

    return $DB->fetch();
}

function baseConvert( $num, $base = null, $index = null ) {
    if ($num <= 0)
        return '0';

    if (!$index)
        $index = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    if (!$base)
        $base = strlen($index);
    else
        $index = substr($index, 0, $base);

    $res = '';

    while ( $num > 0 ) {
        $char = bcmod( $num, $base );
        $res .= substr( $index, $char, 1 );
        $num = bcsub( $num, $char );
        $num = bcdiv( $num, $base );
    }

    return $res;
}

function getConfig()
{
    $nt = $GLOBALS['nt'];
    $DB = $GLOBALS['DB'];

    if (!$DB->pdo)
        return null;

    $sql = " select * from `{$nt['config_table']}` ";

    $DB->prepare($sql);
    $DB->execute();

    return $DB->fetch();
}

function getHeader(string $name = null)
{
    if($name)
        $file = "header-{$name}.php";
    else
        $file = 'header.php';

    loadPage($file);
}

function getFooter(string $name = null)
{
    if($name)
        $file = "footer-{$name}.php";
    else
        $file = 'footer.php';

    loadPage($file);
}

function loadPage(string $file, bool $once = true)
{
    global $html, $config, $member, $is_member, $is_admin, $is_super, $DB;

    $page = NT_PAGES_PATH.DIRECTORY_SEPARATOR.$file;

    if (is_file($page)) {
        if ($once)
            require_once($page);
        else
            require($page);
    }

}