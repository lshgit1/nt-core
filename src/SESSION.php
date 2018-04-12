<?php
/**
 * Session class
 */

class SESSION
{
    public function __construct()
    {
        @ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
        @ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 따라다니는것을 무력화함

        if (isset($SESSION_CACHE_LIMITER))
            @session_cache_limiter($SESSION_CACHE_LIMITER);
        else
            @session_cache_limiter("no-cache, must-revalidate");

        ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
        ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
        ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
        ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.

        require_once(NT_CONFIG_PATH.DIRECTORY_SEPARATOR.'session.php');

        ini_set('session.cookie_domain',  NT_COOKIE_DOMAIN);
        session_set_cookie_params(0, '/', NT_COOKIE_DOMAIN);

        ini_set('session.save_handler', NT_SESSION_HANDLER);
        ini_set('session.save_path',    NT_SESSION_PATH);

        session_start();
    }
}