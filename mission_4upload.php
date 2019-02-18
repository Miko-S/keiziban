<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WEB掲示板</title>
</head>
<body>
    <h1>WEB掲示板</h1>
    <?php
    //データベースへの接続
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo=new PDO($dsn,$user,$password);
    //テーブルの作成
    $sql="CREATE TABLE tbmission43"
    ."("
    ."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
    ."name char(32),"
    ."comment TEXT,"
    ."created char(32),"
    ."pass char(32)"
    .");";
    //SQLステートメントを実行し、結果を変数に格納
    $stmt = $pdo->query($sql);
    $name=$_POST['name'];
    $comment=$_POST['comment'];
    $pass=$_POST['pass'];
    $dnumber=$_POST['dnumber'];
    $dpass=$_POST['dpass'];
    $hennumber=$_POST['hennumber'];
    $henpass=$_POST['henpass'];
    $enumber=$_POST['enumber'];
    
    if(!empty($name) && !empty($comment) && !empty($pass)){
        if(empty($enumber)){
            //データの入力 insert
            $sql = $pdo -> prepare("INSERT INTO tbmission43 (id,name,comment,created,pass) VALUES (:id,:name,:comment,now(),:pass)");
            $sql -> bindParam(':id',$id,PDO::PARAM_STR);
            $sql -> bindParam(':name',$name,PDO::PARAM_STR);
            $sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
            $sql -> bindParam(':pass',$pass,PDO::PARAM_STR);

            $sql -> execute();
            echo '投稿が送信されました<br>';
        }else{
            echo 'コメントが編集されました<br>';
            $id = $enumber;
            $na = $name;
            $co = $comment;
            $pa = $pass;
            $sql = "update tbmission43 set name='$na',comment='$co' where id=$id";
            $result = $pdo->query($sql);
        }
    }
    //データの削除
    if(!empty($dnumber)){
            echo'削除対象の番号が入力されました<br>';
            $sql = 'SELECT*FROM tbmission43';
            $results = $pdo -> query($sql);
            foreach($results as $row){
                if($dnumber == $row['id']){
                    if($dpass == $row['pass']){
                        $sql = "delete from tbmission43 where id=$dnumber";
                        //ALTER TABLE tbmission43 auto_increment=$dnumber;
                        $result =$pdo->query($sql);
                    }else{
                        echo '削除フォームのパスワードが正しくありません<br>';
                    }
                }
            }
    }
    //データの編集
    if(!empty($hennumber)){
        echo'編集対象の番号が入力されました<br>';
            $sql = 'SELECT*FROM tbmission43';
            $results = $pdo -> query($sql);
            foreach($results as $row){
                if($hennumber == $row['id']){
                    if($henpass == $row['pass']){
                        $ename=$row['name'];
                        $ecomment=$row['comment'];
                        $epass=$row['pass'];
                        $result =$pdo->query($sql);
                    }elseif($henpass != $row['pass']){
                        echo '編集フォームのパスワードが一致しません<br>';
                        unset($hennumber);
                    }
                    
                }
            }
    }
    ?>
    <form action="mission_4.php" method="post">
        <h3>投稿フォーム</h3>
        <p>名前：<input type="text" name="name" placeholder="名前" value="<?php if(!empty($hennumber)){echo $ename;} ?>"></p>
        <p>コメント：<input type="text" name="comment" placeholder="コメント" value="<?php if(!empty($hennumber)){echo $ecomment;} ?>"></p>
        <p>パスワード<input type="text" name="pass" placeholder="パスワード" value="<?php if(!empty($hennumber)){echo $epass;} ?>">　<input type="submit" value="投稿"></p>
        <p><input type="number" name="enumber" placeholder="hideen" value="<?php if(!empty($hennumber)){echo $hennumber;} ?>"></p>
    </form>
    <br>
    <form action="mission_4.php" method="post">
        <h3>投稿削除用フォーム</h3>
        <p><input type="number" name="dnumber" placeholder="削除対象番号"></p>
        <p><input type="text" name="dpass" placeholder="パスワード">　<input type="submit" value="削除"></p>
    </form>
    <form action="mission_4.php" method="post">
        <h3>投稿編集用フォーム</h3>
        <p><input type="number" name="hennumber" placeholder="削除対象番号"></p>
        <p><input type="text" name="henpass" placeholder="パスワード">　<input type="submit" value="編集"></p>
    </form>
    <br>
    <h2>掲示板</h2>
    <?php
    //データの表示
    $sql = 'SELECT*FROM tbmission43';
    $results = $pdo -> query($sql);
    foreach($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].' '.$row['name'].' '.$row['comment'].' '.$row['created'].'<br>';
    }
    ?>
</body>
</html>