<?
/**
  * registration.php
  * Страница регистрации пользователей. Предполагается, что в вашей
  * базе данных присутствует таблица пользователей users, в которой
  * есть поля id, login, password, reg_date
  */
  
// Подключаем файл с пользовательскими функциями
require_once('functions.php');

// Инициализируем переменные для введенных значений и возможных ошибок
$errors = array();
$fields = array();

// Заранее инициализируем переменную регистрации, присваивая ей ложное значение
$reg = false;

// Если была нажата кнопка регистрации
if(isset($_POST['submit'])) {
	// Делаем массив сообщений об ошибках пустым
	$errors['login'] = $errors['password'] = $errors['password_again'] = '';
	
	// С помощью стандартной функции trim() удалим лишние пробелы
	// из введенных пользователем данных
	$fields['login'] = trim($_POST['login']);
	$password = trim($_POST['password']);
	$password_again = trim($_POST['password_again']);
	
	// Если логин не пройдет проверку, будет сообщение об ошибке
	$errors['login'] = checkLogin($fields['login']) === true ? '' : checkLogin($fields['login']);
	
	// Если пароль не пройдет проверку, будет сообщение об ошибке
	$errors['password'] = checkPassword($password) === true ? '' : checkPassword($password);
	
	// Если пароль введен верно, но пароли не идентичны, будет сообщение об ошибке
	$errors['password_again'] = (checkPassword($password) === true && $password === $password_again) ? '' : 'Введенные пароли не совпадают';
	
	// Если ошибок нет, нам нужно добавить информацию о пользователе в БД
	if($errors['login'] == '' && $errors['password'] == '' && $errors['password_again'] == '') {
		// Вызываем функцию регистрации, её результат записываем в переменную
		$reg = registration($fields['login'], $password);
		
		// Если регистрация прошла успешно, сообщаем об этом пользователю
		// И создаем заголовок страницы, который выполнит переадресацию к форме авторизации
		if($reg === true) {
			$message = '<p>Вы успешно зарегистрировались в системе. Сейчас вы будете переадресованы к странице авторизации. Если это не произошло, перейдите на неё по <a href="login.php">прямой ссылке</a>.</p>';
			header('Refresh: 5; URL = login.php');
		}
		// Иначе сообщаем пользователю об ошибке
		else {
			$errors['full_error'] = $reg;
		}
	}
}

?>
<html>
<head>
	<title>Регистрация пользователей</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<form action="" method="post">
		<div class="row">
			<label for="login">Укажите ваш логин:</label>
			<input type="text" class="text" name="login" id="login" value="<?=$fields['login'];?>" />
			<div class="error" id="login-error"><?=$errors['login'];?></div>
			<div class="instruction" id="login-instruction">В имени пользователя могут быть только символы латинского алфавита, цифры, символы '_', '-', '.'. Длина имени пользователя должна быть не короче 4 символов и не длиннее 16 символов</div>
		</div>
		<div class="row">
			<label for="password">Напишите ваш пароль:</label>
			<input type="password" class="text" name="password" id="password" value="" />
			<div class="error" id="password-error"><?=$errors['password'];?></div>
			<div class="instruction" id="password-instruction">В пароле вы можете использовать только символы латинского алфавита, цифры, символы '_', '!', '(', ')'. Пароль должен быть не короче 6 символов и не длиннее 16 символов</div>
		</div>
		<div class="row">
			<label for="password_again">Повторите введенный пароль:</label>
			<input type="password" class="text" name="password_again" id="password_again" value="" />
			<div class="error" id="password_again-error"><?=$errors['password_again'];?></div>
			<div class="instruction" id="password_again-instruction">Повторите введенный ранее пароль</div>
		</div>
		<div class="row">
			<!-- Кнопка отправки данных формы -->
			<input type="submit" name="submit" id="btn-submit" value="Зарегистрироваться" />
			
			<!-- Кнопка сброса полей формы к исходному состоянию -->
			<input type="reset" name="reset" id="btn-reset" value="Очистить" />
		</div>
	</form>
</body>
</html>