<?php 
	require "db.php";

	if (isset($_COOKIE['logged_user'])) {

		}else{
			header('location: /regpage.php');
		}


	$data = $_POST;
	
	if (isset($data['add'])) {
		$errors = array();
		if ($data['newToDo'] == "") {
			$errors[] = "Заполните поле 'Задание'";
		}
		if($data['category']==""){
			$data['category'] = "Не задано";
		}
		if (empty($errors)) {


				$todo = R::dispense('todos');
				$todo->id;
				$todo->login = $_COOKIE["logged_user"];
				$todo->text = $data['newToDo'];
				$todo->category = $data['category'];
				$todo->status = 1; // 1 - not complete 2 - complete 3 - срочно comlete
				R::store($todo);

		}else{
			echo'<h4 style="color:red; background-color: #fff; border: 1px red solid; padding-top: 10px; padding-bottom: 10px; text-align: center; margin-bottom: 0px;">'.array_shift($errors).'</h4>';
		}
	}
	

	// Вывод todo
	$results = R::find('todos', 'WHERE login = ?', [$_COOKIE['logged_user']]);

	if (isset($data['dell_butt'])) {
		$dell_err = array();
		if ($data['dell_id_value'] == "") {
			$dell_err[] = "Заполните поле с [id *] елемента";
		}
		if (empty($dell_err)) {
			//Удаление...
			$dell_id = $data['dell_id_value'];
			$dell_object = R::load("todos", $dell_id);
			R::trash($dell_object);
			// Перезагрузка, чтоб обьэкт удалился
			header('location: /home.php');
		}else{
			echo '<h4 style="color:red; background-color: #fff; border: 1px red solid; padding-top: 10px; padding-bottom: 10px; text-align: center; margin-bottom: 0px;">'.array_shift($dell_err).'</h4>';
		}
	}

 ?>
<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>ToDo | Ваш список!</title>
	<meta name="description" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="libs/bootstrap/bootstrap-grid-3.3.1.min.css" />
	<link rel="stylesheet" href="libs/font-awesome-4.2.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="libs/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="libs/owl-carousel/owl.carousel.css" />
	<link rel="stylesheet" href="libs/countdown/jquery.countdown.css" />
	<link rel="stylesheet" href="css/fonts.css" />
	<link rel="stylesheet" href="css/home-styles.css" />
	<link rel="stylesheet" href="css/media.css" />
	<link rel="stylesheet" href="css/animate.css">

</head>
<body>
	<section class="header">
		<div class="navbar">
			<div class="touch" id="touch-menu">
				<i class="fa fa-bars" id="touch-menu" aria-hidden="true" title="Открыть меню"></i>
			</div>
			
			<div class="add-input">
				<form action="/home.php" method="post">
					<button name="add" class="add-butt">Добавить!</button>
					<input type="text" name="category" placeholder="Категория *" title="Не обязательное поле">
					<input type="text" name="newToDo" placeholder="Задание *">
				</form>
			</div>
			<div class="user" style="margin-left: 275px; margin-top: -25px;">
				<span style="color: #fff; margin-right: 5px;"><?php echo $_COOKIE["logged_user"]; ?></span><i style="color: green;" class="fa fa-circle" aria-hidden="true"></i>
			</div>
			<div class="ucp-list">
				<ul>
					<li class="active" style="background-color: #fff;"><a style="color: red;" href="/home.php">Главная</a></li>
					<li><a href="/logout.php" class="logout" title="Выйти из ToDo аккаунта">Выйти</a></li>
				</ul>
			</div>
		</div>
		<div class="nav">
			<ul>
				<span>Настройки фильтра:</span>
				<li><i class="fa fa-nav fa-check" aria-hidden="true"></i><a href="#">Только выполненные</a></li>
				<li><i class="fa fa-nav fa-times" aria-hidden="true"></i><a href="#">Только не завершенные</a></li>
				<li><i class="fa fa-nav fa-clock-o" aria-hidden="true"></i></i><a href="#">Только важные</a></li>
			</ul>
			<a href="#" class="profile-sett">Настройки профиля</a>
		</div>
	</section>
	<section class="content">
		<div class="todo-list">
			<?php  
				foreach( $results as $user){
					echo '
					<div class="todo-item">
						<span> id = ['.$user->id.']<span>
						<span class="category">[ '.$user->category.' ]</span><span>'.$user->text.'</span>
					</div>';
				} 
				
			?>
		</div>
	</section>
	<section class="footer">
		<span class="copy">Клали мы на ваши права Copyrighting(2017)</span>
		<div class="del-inp">
			<form action="/home.php" method="post">
				<span>Удалите запись: </span>
				<input type="text" name="dell_id_value" placeholder="id *">
				<button type="submit" name="dell_butt">Удалить</button>
			</form>
		</div>
	</section>
	<div class="hidden">

	</div>
	<!--[if lt IE 9]>
	<script src="libs/html5shiv/es5-shim.min.js"></script>
	<script src="libs/html5shiv/html5shiv.min.js"></script>
	<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
	<script src="libs/respond/respond.min.js"></script>
	<![endif]-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="libs/jquery-mousewheel/jquery.mousewheel.min.js"></script>
	<script src="libs/fancybox/jquery.fancybox.pack.js"></script>
	<script src="libs/waypoints/waypoints-1.6.2.min.js"></script>
	<script src="libs/scrollto/jquery.scrollTo.min.js"></script>
	<script src="libs/owl-carousel/owl.carousel.min.js"></script>
	<script src="libs/countdown/jquery.plugin.js"></script>
	<script src="libs/countdown/jquery.countdown.min.js"></script>
	<script src="libs/countdown/jquery.countdown-ru.js"></script>
	<script src="libs/landing-nav/navigation.js"></script>
	<script src="js/home.js"></script>
	<!-- Yandex.Metrika counter --><!-- /Yandex.Metrika counter -->
	<!-- Google Analytics counter --><!-- /Google Analytics counter -->
	<!-- HelloPreload http://hello-site.ru/preloader/ -->

</body>
</html>