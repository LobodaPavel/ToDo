<?php 

		require "db.php";

		$data = $_POST;
		if (isset($data['do_signup'])) {
			$errors = array();
			if (trim($data['reg_login'] == "")) {
				$errors[] = "Введите свой логин!";
			}
			if ($data['reg_password'] == "") {
				$errors[] = "Введите пароль"; 
			}
			if ($data['reg_password-conf'] == "") {
				$errors[] = "Повторите ввод пароля";
			}
			if ($data['reg_password'] != $data['reg_password-conf']) {
				$errors[] = "Введенные пароли не совпадают!";
			}
			if (R::count('users', "login = ?", array($data['reg_login'])) > 0) {
				$errors[] = "Пользователь с таким логином уже существует!";
			}
			if (empty($errors)) {
				$user = R::dispense('users');
				$user->login = $data['reg_login'];
				$user->password = $data['reg_password'];
				$user->adminstanus = 0;
				R::store($user);
				setcookie("logged_user", $data['reg_login'], time()+3600);
				$_COOKIE["logged_user"];
				header('location:/home.php');
			}else{
				echo "<div><p>".array_shift($errors)."</p></div>";
			}
			
		}
		if (isset($data['do_login'])) {
			$errors = array();
			if ($data['log_login'] == "") {
				$errors[] ="Введите логин";
			}
			if ($data['log_password'] == "") {
				$errors[] = "Введите пароль";
			}
			$user = R::find('users', "login = ?", array($data['log_login']));
					if ( $user ) {
					
					}else{
						$errors[] = "Пользователь с таким логинoм не зарегистрирован!";
					}

					$user = R::find('users', "password = ?", array($data['log_password']));

					if ( $user ) {
						setcookie("logged_user", $data['log_login'], time()+36000);
						$_COOKIE["logged_user"];
						header('location:/home.php');
				}else{
					$errors[] = "Пользователь с таким паролем не зарегистрирован!";
				}
			if (empty($errors)) {
					
			}else{
				echo "<div><p>".array_shift($errors)."</p></div>";
			}
		}
	 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ToDo | Вход</title>
	<link rel="stylesheet" href="css/regpage.css">
	<link rel="stylesheet" href="libs/bootstrap/bootstrap-grid-3.3.1.min.css">
	<meta charset="UTF-8">

</head>
<body>
	<wrapper class="wrapper cont">

		<div class="wrapper text-box">
			<h1 class="title" style="width: auto; background-color: #333333;">Упс ! Кажется вы не вошли в свой аккаунт ToDo...</h1>
			<h2 class="title" style="width: auto; background-color: #333333;">Пора бы это исправить</h2>
			<h1 class="title" style="width: auto; background-color: #333333;">Для продолжения войдите или зарегистрируйте аккаунт!</h1>
		</div>

			<div class="forms">
			<div class="form-div reg-form col-md-6 wrapper">
				<h2 class="title">Создайте ToDo аккаунт менее чем за минуту:</h2>
			<form action="/regpage.php" method="post">
				<input class="form-input" type="text" name="reg_login" placeholder="Будующий логин *" value="<?php echo @$data['reg_login']; ?>"><br>
				<input class="form-input" type="password" name="reg_password" placeholder="Будующий пароль" value="<?php echo @$data['reg_password']; ?>"><br>
				<input class="form-input" type="password" name="reg_password-conf" placeholder="Повторите пароль" value="<?php echo @$data['reg_password-conf']; ?>"><br>
				<button class="form-button reg-butt" type="submit" name="do_signup">Создать аккаунт!</button>
			</form>
			</div>
			<div class="form-div log-form col-md-6 wrapper">
				<h2 class="title">Войдите в свой ToDo аккаунт:</h2><br>
			<form action="/regpage.php" method="post">
				<input type="text" class="form-input user_login" placeholder="Ваш логин *" name="log_login" value="<?php echo @$data['log_login']; ?>"><br>
				<input type="password" class="form-input" placeholder="Пароль *" name="log_password" value="<?php echo @$data['log_password']; ?>"><br>
				<button class="form-button log-butt" type="submit" name="do_login">Войти</button>
			</form>
			</div>
	</div>
	</wrapper>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</body>
</html>