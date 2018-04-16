<?php
  $con = mysql_connect('localhost','root');

  if(!$con){
    die('can` tconnect '.mysql_error);
  }else{
    // echo "连接成功";
  };
  mysql_select_db('api',$con);
  

  if($_POST['status'] === 'login'){
    // echo '登录借口';


  }elseif($_POST['status'] === 'register'){
    //注册接口
    $insertUser = "INSERT INTO user (id, username, password, mail) 
    VALUES (NULL, '$_POST[username]',' $_POST[password]', '$_POST[mail]')";

    //想在这里做一个查询，检测是否已经注册，如果已经注册  返回已经注册
    // $sname = mysql_query("SELECT * FROM user 
    // WHERE username = ads");

    // print_r($sname);

    // while($row = mysql_fetch_array($sname))
    // {
    //   echo $row['username'].$row['password'];
    //   echo "<br/>";
    // };

    if (!mysql_query($insertUser,$con)) {
      die(mysql_error());
    }else{
      $res = [
        'code'=>0,
        'massage'=>'registed'
      ];


      echo json_encode($res);
    };
    mysql_close($con);
    
  }else{
    echo 'status not true';
  }
?>