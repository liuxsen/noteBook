<?php 
	$callback = $_GET["cb"];
	$arr = array('zhangsan'=>'123','lisi'=>'345');
	$str = json_encode($arr);
	echo "alert($callback);";
	echo "{$callback}({$str})";
 ?>