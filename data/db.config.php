<?php
/**
*数据库相关信息设置
*/

/**
*数据库 主机名 或 IP 地址
*/
    $db_host = 'localhost';
    $db_port = '3306';

/**
*数据库用户名和密码，连接和访问 MySQL 数据库时所需的用户名和密码，不推荐使用空的数据库密码
*/
    $db_user = 'root';
    $db_pwd = '111111';//需修改后才能使用

/**
*数据库名，论坛程序所使用的数据库名。
*/
    $db_name = 'testoj_211';

/**
*数据库类型，有效选项有 mysql 和 mysqli
*若服务器的配置是 PHP5.1.0或更高版本 和 MySQL4.1.3或更高版本，可以尝试使用 mysqli
*/
    $database = 'mysqli';

/**
*Mysql编码设置(常用编码：gbk、big5、utf8、latin1)
*请不要随意更改此项，否则将可能导致论坛出现乱码现象
*/
    $db_charset = 'gbk';
?>