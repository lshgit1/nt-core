<?php
// 일반설정
define('CSS_VERSION', '');
define('JS_VERSION',  '');

// Default jquery
define('NT_DEFAULT_JQUERY', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js');

// PHPMailer SMTP
define('NT_SMTP_HOST',   '127.0.0.1');
define('NT_SMTP_PORT',   '25');
define('NT_SMTP_AUTH',   false);
define('NT_SMTP_USER',   '');
define('NT_SMTP_PASS',   '');
define('NT_SMTP_SECURE', 'ssl');

// 일반상수
define('NT_ENCRYPT_SALT',  '');
define('NT_TOKEN_LENGTH',  16);
define('NT_EMAIL_PATTERN', '/^([0-9a-zA-Z_\-\.]+)@([0-9a-zA-Z_\-\.]+)\.([0-9a-zA-Z_\-]+)$/');

// reCAPTCHA
define('CAPTCHA_SITE_KEY',   '');
define('CAPTCHA_SECRET_KEY', '');

// DB 테이블
define('NT_TABLE_PREFIX', 'nt_');

$nt['config_table'] = NT_TABLE_PREFIX.'config';
$nt['member_table'] = NT_TABLE_PREFIX.'member';