<?php 
$db_host = 'localhost';     // Сервер
$db_user = 'root';  // Имя пользователя
$db_password = 'LVBNHBQ';  // Пароль пользователя
$db_name = 'ineudb';          // Имя базы данных

// Подключаемся к серверу
$conn = mysqli_connect($db_host, $db_user, $db_password) or die(
                "<p>Невозможно подключиться к СУБД: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");
$db = mysqli_select_db($conn, $db_name) or die(
                "<p>Невозможно подключиться к базе данных: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");
$query = mysqli_query($conn, "set names utf8") or die(
                "<p>Невозможно выполнить запрос к базе данных: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");

$query = "SELECT DISTINCT `group` FROM lessons;";
$result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error());

$groups = Array();
$i = 0;
while ($row = mysqli_fetch_object($result)) {
    $groups[$i] = $row->group;
    $i++;
}
mysqli_close($conn);
?>

<br>
<h4>Доступно расписание для групп:</h4>
<?php
for ($i = 0; $i < count($groups); $i++) {
    echo "<a href=timetable.php?group=" . $groups[$i] . ">" . $groups[$i] . "</a><br>";
}
?>