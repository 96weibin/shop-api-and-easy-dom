var oBtn = document.getElementsByClassName('sub')[0];
var oUser = document.getElementById('user');
var oPass = document.getElementById('pass');
var oMail = document.getElementsByName('mail')[0];
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
        // var json = JSON.parse(res);
        // console.log(json);
        // if(json.code === 0) {
        //   alert('注册成功');
        //   // setTimeout(function(){
        //   //   location.href = 'http://127.0.0.1/shop-api-and-easy-dom/login.html';
        //   // }, 1000);
        // }
      }


    });
  }
};