<?

$db_host = 'localhost';     // Сервер
$db_user = 'root';  // Имя пользователя
$db_password = '';  // Пароль пользователя
$db_name = 'ineudb';          // Имя базы данных

//Запросы на каждый день недели (пока только понедельник - четверг)
$mondayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=1 ORDER BY `number`';
$tuesdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=2 ORDER BY `number`';
$wednesdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=3 ORDER BY `number`';
$thursdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=4 ORDER BY `number`';