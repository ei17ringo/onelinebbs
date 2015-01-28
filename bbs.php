<?php

//データベースに接続
$link = mysql_connect('localhost', 'root', 'mangoshake');

//文字コードのセット
mysql_query('SET NAMES utf8',$link);

//データベースに接続出来ません
if(!$link){
	die('データベースに接続出来ません:'.mysql_eror());
}


mysql_select_db('oneline_bbs', $link);

$errors = array();

// POSTなら保存処理実行
var_dump($_SERVER['REQUEST_METHOD']);
if($_SERVER['REQUEST_METHOD'] === 'POST'){
		//名前が正しくセットされているかチェック
		$name = null;
		if(!isset($_POST['name']) || !strlen($_POST['name'])){
		$errors['name'] = '名前を入力してください';	
		}elseif(strlen($_POST['name']) > 20){
			$errors['name'] ='名前は２０文字以内で入力してください';
		}else{
			$name = $_POST['name'];
		}

		//ひとことが正しく入力されているかチェック
		$comment = null;
		if(!isset($_POST['comment']) || !strlen($_POST['comment'])){
		$errors['comment'] = 'ひとことを入力してください';	
		}elseif(strlen($_POST['comment']) > 500){
			$errors['comment'] ='ひとことは５００文字以内で入力してください';
		}else{
			$comment = $_POST['comment'];
		}

		//エラーがなければ保存
		if(count($errors) === 0){
			//保存する為のSQL文を作成
			$sql = "INSERT INTO `post` (`name`, `comment`, `created_at`)VALUES('"
				. mysql_real_escape_string($name) . "','"
				. mysql_real_escape_string($comment) . "','"
			//				. date_time_set('Y-m-d H:i:s', $hour, $minute, $second) . "')";
				. date('Y-m-d H:i:s') . "')";
			echo $sql;

			//保存する
			mysql_query($sql, $link);

		}

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>ひとこと掲示板</title>
</head>
<body>
 <h1>一言掲示板</h1>

	<form action="bbs.php" method="post">
		名前: <input type="text" name="name"/><br/>
		ひとこと: <input type="text" name="comment" size="60" /><br/>
		<input type="submit" name="submit" value="送信" />
	</form>

</body>
</html>