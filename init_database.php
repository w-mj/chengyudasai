<?php
/**
 * Created by PhpStorm.
 * User: MingjianW
 * Date: 2018/6/6
 * Time: 14:58
 */
require 'vendor/autoload.php';

$group=12;
$db = new Workerman\MySQL\Connection('localhost', '3306', 'chengyu', 'chengyu', 'chengyu');//本机为3306端口
for ($i = 1; $i <= $group; $i++) {
    $db->query("insert into `sum` (`name`) values ('group$i')");
}
