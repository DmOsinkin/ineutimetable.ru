<?

global $db_host;
global $db_user;
global $db_password;
global $db_name;

$db_host = 'localhost';     // Сервер
$db_user = 'root';  // Имя пользователя
$db_password = '';  // Пароль пользователя
$db_name = 'ineudb';          // Имя базы данных

// Подключаемся к серверу
global $conn;
$conn = mysqli_connect($db_host, $db_user, $db_password) or die(
                "<p>Невозможно подключиться к СУБД: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");

$db = mysqli_select_db($conn, $db_name) or die(
                "<p>Невозможно подключиться к базе данных: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");

