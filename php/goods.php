<?php

  $con = mysql_connect('127.0.0.1','root','');
  if(!$con){
    $res = [
      'code'=>1,
      'massage' => 'db connect filed'
    ];
    echo json_encode($res);
  }
  mysql_select_db('api',$con);

  //读写库的时候 可以传入 汉字了
  mysql_query("set character set 'utf8'");//读库 
  mysql_query("set names 'utf8'");//写库 


  if($_POST['status'] === 'uploadGoods'){
    //上传商品
    $insert = mysql_query("INSERT INTO goods (id, name, number, message, img, price)
    VALUES('','$_POST[name]','$_POST[number]','$_POST[message]','$_POST[img]','$_POST[price]')",$con);

    if($insert){
      $res = [
        'code'=>0,
        'massage' => 'goods had been created!'
      ];
      echo json_encode($res);
    }else{
      echo mysql_error();
    }
    echo $_POST['name'].$_POST['number'].$_POST['message'].$_POST['img'].$_POST['price'];
  }else{
    $res = [
      'code' => 1,
      'massage' => 'status error'
    ];
    echo $res;
  }


?>