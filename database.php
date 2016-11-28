<?

include_once ("config.php");

// Подключаемся к серверу
$conn = mysqli_connect($db_host, $db_user, $db_password) or die(
                "<p>Невозможно подключиться к СУБД: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");
