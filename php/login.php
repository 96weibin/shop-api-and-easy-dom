<?php
/**此页实根据 post请求时 status 判断用户是要注册还是登录
 * 如果status 错误 报错
 * 
 * status 是 login 时登录
 * 
 * 根据账号 在user表中 找密码匹配的 匹配 就返回 code 0 message land successful 以及返回用户id   后续添加 返回用户头像
 * 
 * 
 * status 是 register 时为注册   
 * 正则匹配格式  交给前端完成  select查询mail 用mysql_num_rows()判断结果集的行数 判断是否注册过  注册过die 'code:1'
 * 没注册过 
 * 
 * 经过试验发现  不光要  看 mail  在数据库中已经存在，  开始是想的用户名会比较开放， 允许 重名的情况，
 * 但是 如果登录的时候用  用用户名进行登录 就不能 有重名的现象了   
 * 
 * 现在大多数网站还登录的时候还是比较开放的，  可以使用  用户名 + 密码    邮箱 + 密码来进行登录  
 * 这下想来   其实还是挺简单的  只要在后台  正则匹配一下 ，知道他是用啥登录的     在去对应的行 WHERE 数据  拿密码进行比较即可
 * 这种的前提  就是   用户的  邮箱， 用户名 必须都是唯一的    用什么登录  就需要什么是唯一的
 * 
 * 
 * 
 * 就 insert 数据  返回  code 0 msg registed
 *  
 */

  //链接mysql
  $con = mysql_connect('localhost','root');
  if(!$con){
    die('can` tconnect '.mysql_error());
  }else{
    // echo "连接成功";
  };



  //选择数据库
  mysql_select_db('api',$con);
  

  if($_POST['status'] === 'login')
  {
    // echo '登录接口';
    $users = mysql_query("SELECT * FROM user WHERE username = '$_POST[username]'");
    $num = 0;    
    while($row = mysql_fetch_array($users)){
      // echo ($row['password'].'______________'.$_POST['password']);
      // echo gettype($row['password']).'_____________'.gettype($_POST['password']) ;
      // echo ($row['password'] == $_POST['password']) ;
      // echo "<br>";
      // echo (1==0);

      //判断 php的数据类型   gettype()    isArray()   var_dump

      

      //  可以使用字符串的比较的方法    strcasecmp 不区分大小写比较 strcmp  -1 小于  0 等于 1 大于
      //也可以通过  == === 判断相等 ，但是要注意的是  最好 将连个字符串  trim 一下  去掉多余的空格 
      //使用  postman  测试post 请求  ， 就没有正则验证  ，  应该是我不小心   多打了个空格   ，   哎  将近一个小时都在找  为啥 打出来一样的字符串 就是不相等


      // echo(strcmp($row['password'],$_POST['password']));
      // echo(strcmp('he','he'));

      //
      if(trim($row['password']) === trim($_POST['password'])){
        // echo $row['password'].'____________'.$_POST['password'];
        $num ++;
        
      }
    }
    if($num === 0){
      $res = [
        'code'=>1,
        'massage' => 'password is not true!'
      ];
      echo json_encode($res);
    }elseif($num === 1) {
      $res = [
        'code' => 0,
        'massage' => 'land succeeful!'
      ];
      echo json_encode($res);
    }else{
      $res = [
        'code' => 1,
        'massage' => 'db data error!'
      ];
      echo json_encode($res);
    }


  }
  elseif($_POST['status'] === 'register')
  {
    // echo('注册接口');


    //查询user表  里面mail是 post请求的mail的数据
    //这里要注意   WHERE 子句 最后一个    无论是固定值还是变量  都要用 '' 引起来
    $a = mysql_query("SELECT * FROM user WHERE username = '$_POST[username]'");

    /**这里我更改了  查询的对象   ，  之前查的是  mail */


    //mysql_num_rows()  返回的是结果集 的行数 
    // echo(mysql_num_rows($a));
    if(mysql_num_rows($a))
    {
      $res = [
        'code' => 1,
        'massage' => 'the username had been existed!'
      ];

      die(json_encode($res));
    }
    else
    {
      // echo ($_POST['mail']);
      $insertUser = "INSERT INTO user (id, username, password, mail) 
      VALUES (NULL, '$_POST[username]',' $_POST[password]', '$_POST[mail]')";
      //向mysql插入数据
      if (!mysql_query($insertUser,$con)) 
      {
        die(mysql_error());
      }
      else
      {
        $res = [
          'code' => 0,
          'massage' => 'registed'
        ];
        echo json_encode($res);
      };
      mysql_close($con);
    }   
  }
  else
  {
    $res = [
      'code' => 1,
      'massage' => 'status is not true!'
    ];
    echo json_encode($res);
  }
?>