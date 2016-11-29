<?

global $db_host;
$db_host = 'localhost';     // Сервер
global $db_user;
$db_user = 'root';  // Имя пользователя
global $db_password;
$db_password = '';  // Пароль пользователя
global $db_name;
$db_name = 'ineudb';          // Имя базы данных

// Подключаемся к серверу
    $conn = mysqli_connect($db_host, $db_user, $db_password) or die(
                    "<p>Невозможно подключиться к СУБД: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");

    $db = mysqli_select_db($conn, $db_name) or die(
                    "<p>Невозможно подключиться к базе данных: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");


//Запросы на каждый день недели (пока только понедельник - четверг)
$mondayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=1 ORDER BY `number`';
$tuesdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=2 ORDER BY `number`';
$wednesdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=3 ORDER BY `number`';
$thursdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=4 ORDER BY `number`';