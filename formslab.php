<?php
$users = [
    'Ivanov' => '111111',
    'Petrov' => '222222',
    'Sidorov' => '333333'];
?>
<html>
<body>
<div>
    <?php if($_SERVER['REQUEST_METHOD'] =='POST'){
        $imputLogin  = $_POST['user_email'];
        $imputPassword = $_POST['user_password'];
        if (array_key_exists($imputLogin, $users) && $users[$imputLogin] === $imputPassword){
            echo "Пользователь залогинен";
        }else {
            echo 'Пользователь не идентифицирован';
        }
     }
      ?>
</div>
       <form method="post" action="">
    <label>email</label>
        <br>
        <input name="user_email">
            <br>
            <label>password</label>
           <br>
            <input type="password" name="user_password">
           <br>
              <input type="submit">
          </form>
                  <body>
                  <?php




