<?php
/**
 * Created by PhpStorm.
 * User: troub
 * Date: 2017/5/10
 * Time: 17:39
 */


if (isset($_POST['part'])&&isset($_POST['group'])&&isset($_POST['score'])){
    $part=$_POST['part'];
    $group=$_POST['group'];
    $score=$_POST['score'];
    try{
        $db=new PDO("mysql:host=localhost;dbname=chengyu","chengyu","chengyu");
    }catch(PDOException $e){
        echo json_encode(array('error'=>"database: connection failure<br>"));
        exit(1);
    }
    if ($part == 'part4') {
        $already_q = "SELECT `part4` from `sum` WHERE `name`=?";
        $r = $db->prepare($already_q);
        $already = $r->execute(array($group));
        $already = $r->fetch(PDO::FETCH_NUM);
        $already = $already[0];
        $score = (int)$already + (int)$score;
    }
    $q="UPDATE `sum` SET `$part`=? WHERE `name`=?";
    $stmt=$db->prepare($q);
    $r=$stmt->execute(array($score,$group));
    if (!$r){
        echo json_encode(array('error'=>"$group: save failure<br>"));
        exit(1);
    }
    echo json_encode(array('msg'=>"$group: successfully saved<br>"));
}else{
    echo "未经授权";
}