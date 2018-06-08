<?php
/**
 * Created by PhpStorm.
 * User: MingjianW
 * Date: 2018/6/8
 * Time: 22:19
 */

$db=new PDO("mysql:host=localhost;dbname=chengyu","chengyu","chengyu");
$db->query('update `sum` set part1=0, part2=0, extrapart=0, part3=0, part4=0, sum=0');