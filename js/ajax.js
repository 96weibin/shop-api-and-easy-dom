(function(){
  var myajax = window.myajax = {};

  myajax.queryJsonToQueryString = function(json){
    // console.log(json);
    var arr = [];
    for(var k in json){
      arr.push(k + '=' + encodeURIComponent(json[k]));
      // console.log(json);
      // console.log('k:'+ k + '          value:'+ encodeURIComponent(json[k]));
    }
    return arr.join('&');
  };


  myajax.get = function(url, queryJSON, callback) {
    // console.log('get qingqiu')
    if(window.XMLHttpRequest) {
      var xhr = new XMLHttpRequest();
    }else{
      var xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }
    // console.log(xhr.readyState);
    xhr.onreadystatechange = function(){
      // console.log('readychange')
      console.log(xhr.DONE);
      if(xhr.readyState  === xhr.DONE) {
        if(xhr.status >= 200 && xhr.status < 300 || xhr.status === 304) {
          callback && callback(null,xhr.responseText);
        }else{
          callback && callback(new Error('没有找到文件'),undefined);
        }

      }
      
    };
    var queryString = myajax.queryJsonToQueryString(queryJSON);
    console.log(url + '?' + queryString);
    xhr.open('GET', url + '?' + queryString,true);
    xhr.send(null);
  };
  myajax.post = function(url, queryJSON, callback){
    if(window.XMLHttpRequest) {
      var xhr = new XMLHttpRequest();
    }else{
      var xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xhr.onreadystatechange = function(){
      if(xhr.readyState === xhr.DONE) {
        if(xhr.status >=200 && xhr.status < 300 || xhr.status ===304) {
          callback && callback(null, xhr.responseText);
        }else{
          callback && callback('File is not here');
        }
      }
    };
    xhr.open('POST', url, true);
    var queryString = myajax.queryJsonToQueryString(queryJSON);
    xhr.setRequestHeader('Content-Type',"application/x-www-form-urlencoded");
    xhr.send(queryString);
  };

  
})();