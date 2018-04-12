### 필요사항

- PHP 7.0 이상
- MariaDB 또는 Mysql DB Server
- composer
- PDO
- php-redis
- redis-server




### 사용법

```
git clone https://github.com/chicpro/nt-core.git
composer update
```



### 기본설정

##### SALT 설정

- config/config.php

```
define('NT_ENCRYPT_SALT', '');
```

##### DB 설정

- config/db.php

```
define('DB_HOST', 'localhost');
define('DB_NAME', 'dbname');
define('DB_USER', 'dbuser');
define('DB_PASS', 'dbpass');
```



#### 사용 패키지

- Klein.php : https://github.com/klein/klein.php
- PHPMailer : https://github.com/PHPMailer/PHPMailer