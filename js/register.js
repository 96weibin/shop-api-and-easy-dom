var oBtn = document.getElementsByClassName('sub')[0];
var oUser = document.getElementById('user');
var oPass = document.getElementById('pass');
var oMail = document.getElementsByName('mail')[0];
var reg = document.querySelector('.reg');
var dMail = document.getElementsByClassName('mail')[0];
var title = document.getElementsByTagName('h1')[0];
sessionStorage.status = 'login';
/**此页面完成注册和登录
 * 默认登录
 * 点击 注册   更改样式，
 * 一级dom事件 同一事件异能绑定一个处理函数， 后来居上
 * 
 */

login();

//点击更改为注册
reg.onclick = function(){
  register();  
};


//登录


function login(){
  oBtn.onclick = function(){
    var [user,pass] = [oUser.value, oPass.value];
    if(!user && !pass) {
      alert('请填写完整信息');
    }else if(!/^(?![a-zA-Z]+$)(?![0-9]+$)(?![-_.]+$)[a-zA-Z0-9-._]{5,15}$/g.test(pass)){
      alert('密码格式不匹配');
    }else{
      myajax.post('http://127.0.0.1/shop-api-and-easy-dom/php/login.php',{'status':'login','username':user,'password':pass},function(err,res){
        console.log(res);
      });
    }
  };
}

//注册

function register (){
  //简单更改一下页面样式
  dMail.style.display = 'block';
  oBtn.value = '注册';
  reg.style.display = 'none';
  sessionStorage = 'register';
  title.innerHTML = '注册页面';

  //注册函数
  oBtn.onclick = function(){
    // console.log(oUser.value);
    var [user, pass, mail] = [oUser.value, oPass.value, oMail.value];
    if(!user && !pass && !mail){
      alert('请填写完整信息');
    }else if(!/^(?![a-zA-Z]+$)(?![0-9]+$)(?![-_.]+$)[a-zA-Z0-9-._]{5,15}$/g.test(pass)){
      alert('密码格式不匹配');
    }else if(!/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/g.test(mail)){
      alert('邮箱格式不匹配');
    }else{
      myajax.post('http://127.0.0.1/shop-api-and-easy-dom/php/login.php',{'status' : 'register', 'username' : user, 'password' : pass, 'mail' : mail },function(err,res){
        if(err){
          throw new Error(err);
        }else{
          console.log(res);
          var json = JSON.parse(res);
          console.log(json);
          if(json.code === 0) {

            dMail.style.display = 'none';
            oBtn.value = '登录';
            // reg.style.display = 'none';
            sessionStorage = 'login';
            title.innerHTML = '注册完了 登录吧';
            login();
          }else{
            alert(json.massage);
          }

        }
      });
    }
  };


}
