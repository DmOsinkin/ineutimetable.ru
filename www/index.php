<?

$db_host = 'localhost';     // Сервер
$db_user = 'root';  // Имя пользователя
$db_password = '';  // Пароль пользователя
$db_name = 'ineudb';          // Имя базы данных

// Подключаемся к серверу
$conn = mysql_connect($db_host, $db_user, $db_password) or die(
    "<p>Невозможно подключиться к СУБД: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");

// Эта часть кода выполнится только в случае успешного подключения к серверу
// Выбираем базу данных
$db = mysql_select_db($db_name, $conn) or die(
    "<p>Невозможно подключиться к базе данных: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");

// Эта часть кода выполняется только в случае успешного подключения к БД
// Указываем серверу, что данные, которые мы от него получаем, нам нужны в кодировке UTF-8
$query = mysql_query("set names utf8", $conn) or die(
    "<p>Невозможно выполнить запрос к базе данных: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");


$query = "SELECT * FROM lessons";

$mondayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=1';
$tuesdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=2';
$wednesdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=3';
$thursdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=4';

$mondayResult = mysql_query($mondayQuery) or die('mondayQuery failed: ' . mysql_error());
$tuesdaResult = mysql_query($tuesdayQuery) or die('tuesdayQuery failed: ' . mysql_error());
$wednesdayResult = mysql_query($wednesdayQuery) or die('wednesdayQuery failed: ' . mysql_error());
$thursdayResult = mysql_query($thursdayQuery) or die('thursdayQuery failed: ' . mysql_error());

echo '<html>
    <head>
        <title>Расписание 13-САИ</title>
        <meta name="http-equiv" content="Content-type: text/html; charset=UTF-8">
        <div align="center">
            <h1>
                <font face="helvetica">Расписание</font>
            </h1>
        </div>
        <hr>
    </head>
    <body>
<table style="height:110px" width="600px"  border=\'2\'>';

while ($row = mysql_fetch_object($mondayResult)) {
    echo 
    "<tr>
        <td>$row->name</td>
        <td>$row->day</td>
        <td>$row->number</td>
        <td>$row->first_week</td>
        <td>$row->second_week</td>
        <td>$row->teacher</td>
        <td>$row->classroom</td>
        <td>$row->type</td>
    </tr>";
}
