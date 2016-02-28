# jsonp实例
* jsonp.html
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>jsonp</title>
</head>
<body>
    <input type="button" id='btn' value="点击">
    <script>
        function addScript (url){
            var script = document.createElement('script');
                script.src = url;
                document.head.appendChild(script);
        }
        function callback (data){//取得json对象
            console.log(data.zhangsan)
        }
        window.onload = function(){
            var btn = document.getElementById('btn')
            btn.onclick= function(){
                addScript('jsonp.php?cb=callback')
            }
        }
    </script>
</body>
</html>
```
* jsonp.php
```php
<?php 
    $callback = $_GET["cb"];
    $arr = array('zhangsan'=>'123','lisi'=>'345');
    $str = json_encode($arr);//将数组转化成json字符串
    echo "alert($callback);";
    echo "{$callback}({$str})";
    //输出的是一个js 执行方法  callback("{'zhangsan':'123','lisi':'345'}") 实参是json数据
?>
```

ajax实例
===

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form id="form">
        <input type="text" name="name" id="name"><br>
        <label for="sex">男</label>
        <input type="radio" value="man" name="sex" id=""><br>
        <label for="sex">女</label>
        <input type="radio" value="woman" name="sex" id=""><br>
        <select multiple="true" name="select" id="select">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <input type="button" value="提交按钮" id='submit'>
    </form>
</body>
<script>
    window.onload=function(){
        var form = document.getElementById("form");
        var btn = document.getElementById('submit');

        btn.onclick=function(){
            // console.log(1)
            submitData(form)
        }
    }
// ajax提交表单
function submitData (form){
    var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4){
                if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
                    // alert(xhr.responseText)
                    var div = document.createElement('div');
                    div.innerHTML=xhr.responseText;
                    document.body.appendChild(div);
                }else{
                    alert('request is unsuccessful'+xhr.status)
                }
            }
        }
        // 进度事件
        xhr.onprogress = function(e){
            console.log('progress')
            var div = document.createElement('div');
                div.style.width = 100+'px';
                div.style.height = 100+'px';
                div.style.border = '1px solid red';
            if(e.lengthComputable){//进度信息是否可用
                div.innerHTML='下载了'+e.loaded+'一共有'+e.total;
            }
            document.body.appendChild(div);
        }
        xhr.open('post','test.php',true)
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(serialize(form))
}

// 序列化表单字段和值组合成一段 'url' 
function serialize (form){
//  用于保存序列化的字段和值
    var parts = [];
    var filed = null,
        i,
        j,
        option,
        optvalue
    for (var i = 0; i < form.elements.length; i++) {
        filed = form.elements[i];
        switch (filed.type) {
            // 单选按钮
            case "select-one":
            // 多选按钮
            case "select-multiple":
                if (filed.name) {
                    for(var j = 0, optionLen = filed.options.length; j < optionLen; j++){
                        option = filed.options[j];
                        if(option.selected){
                            optvalue = '';
                            if(option.hasAttribute){
                                optvalue = option.hasAttribute("value") ? option.value : option.text;
                            }else{// 兼容ie的
                                optvalue = option.hasAttribute("value").specified ? option.value : option.text;
                            }
                            parts.push(encodeURIComponent(filed.name) + "=" + encodeURIComponent(optvalue))
                        }
                    }
                }
                break;
            case undefined:
            case 'file': //文件输入
            case 'reset': //重置表单
            case 'submit': //提交按钮
            case 'button': //自定义按钮
            break;
            case "radio":
            case "checkbox":
                if(!filed.checked){
                    break;
                }
            default:
                //不包含没有名字的字段
                if(filed.name.length){
                    parts.push(encodeURIComponent(filed.name) + "=" + encodeURIComponent(filed.value))
                }
                break;
        }
    };
    return parts.join('&')
}


my_switch(2)
my_switch(3)
my_switch(4)
function my_switch (value){
    switch (value) {
        case 1:
            break;
        case 2://没有break,将会执行default
        case 3:
        case 4:
        case 5:
        default:
            console.log('默认执行')
            break;
    }
}
</script>
</html>
```