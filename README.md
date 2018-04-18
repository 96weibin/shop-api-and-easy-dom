# php&MySQL写后台，结合前端简单的样式

## php小白的学习之路

![icon](http://img.heibaimanhua.com/wp-content/uploads/2016/07/17/2992e4e5a3b231abc7e5_size17_w480_h480.jpg)

## 技术栈 mySQL， PHP ，Ajax ，RegExp

  代码上有注释  ， 在 reademe 上就不详细描述了  ，毕竟这种小项目对于大神们  都太easy了  嘻嘻 简述一下

### 开启器服务器

  php运行在服务器端,可以使用xampp等集合工具开启服务器，
  也可以使用npm

```js
 npm install --global http-server
 http-server
```

这次开发明显感觉到，前后端是应该分开开发的，因为如果后端的没写好，要通过echo  判断信息， 前端如果有问题，要console 信息，调试的时候反正我是报错了。

### 实用工具 postman

![icon](http://www.xp510.com/uploadfile/2017/0122/20170122034008468.png);

在这里调试后端 感觉很不错

### insert汉字

  在建表的时候我使用的是 图形化工具 相对简单   ，就是设置 排序规则 为  utf-8-general-ci

  在php  文件中 链接 mySQL 选择数据库 然后  要在插入之前设置   即可实现向mySQL 数据库 读写 中文

```php
  mysql_query("set character set 'utf8'");//读库
  mysql_query("set names 'utf8'");//写库
```

### 类型选择

文字————————> varchar
数字————————> int
文件————————> blob  作为二进制

### php中用到的 mySQL语句

```php
 $con = mysql_connect('localhost','root');
  //链接mySQL 传3参数  域名 用户名 密码

  mysql_select_db('api',$con);
  //选择数据库
  $users = mysql_query("SELECT * FROM user WHERE username = '$_POST[username]'");
  //查询数据库 user表 里面 username是 post请求 的username 匹配的结果集


  //这个结果集不能直接使用
  while($row = mysql_fetch_array($users)){
    /*****
     * mysql_fetch_array()  返回结果集的每一条
     * while  直接遍历  每一条 符合条件的
     * 然后你想干啥就干啥吧
     * **********/
  }


  //向mySQL 插入信息

  mysql_query("INSERT INTO user (id, username, password, mail)
      VALUES (NULL, '$_POST[username]',' $_POST[password]', '$_POST[mail]')",$con);
    //注意这里   插入的时候 还要传   $con 而 查询的时候不需要
```

### php 和 前端 传输数据类型 以及变换的方法

  较为好的方法，php用数组存储，由于echo只能传输字符串，所以要将数组转化成字符串，

  我猜是因为 可能还会有跨域请求的可能  会用到jsonp

  所以在 编码成json字符串

```php
  echo json_encode($res);//返回json字符串
```

再在前端将json字符串 解析成json

```js
  JSON.parse(res);
```

### php 返回的结构

```php
  $res = [
    'code'=>0,    //code0 代表ok  1 代表 有问题  这些都是你自己说的算的
    'massage' => '你真帅',
    'data'=[]
    /*等等等等  按需求加就行*/
  ]

```

#### 这次遇到的一丢丢问题

```html
  在登录的时候 根据post的username去表里查password 进行比较 当时echo 出来是同样的字符串 ，但是判断相等  就是 不相等

  开始我以为  难道 不能 用 ==  或 === 对字符串进行相等判断？

  去网上查了php字符串的方法 strcmp(str1,str2)  ， 但是网上的确是有 用 == === 判断的   我就蒙蔽了  ，

  当时   两个password
  分别是  $_POST['password']  和
  $row['password']  这个$row  是while遍历 SELECT 结果集得到匹配的数组

  我以为  可能这两个值的  值类型不一样？？


  去查了  php 数据类型  获取值类型的3种方法

  值类型：  null、boolean、整数型、 浮点型、字符串、数组、 对象

  gettype(value)  可以得到值类型

  (string)value   在value前用括号 写值类型 可以进行 类型转化


  value.isArray() 根据返回判断是不是相应类型

  结果都是string

  那就是这俩值 是真的不相等 。。毕竟电脑不会骗我的。

  仔细看了看输出的值的确可能有  恍然大悟  可能是查了一个空格。
  因为当时数据库里的数据  是用 postman 提交的  ，没有做正则匹配



  解决方法就是在  trim 一下这两个字符串在比较  就好了
  原来如此简单的问题。。。。。。。。。。。。。。
```

![icon](http://easyread.ph.126.net/iFRovnxtoPqvxiz3bCL3xA==/7916754199850941552.jpg)