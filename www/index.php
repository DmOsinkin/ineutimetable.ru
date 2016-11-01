<?

$db_host = 'localhost';     // Сервер
$db_user = 'root';  // Имя пользователя
$db_password = '';  // Пароль пользователя
$db_name = 'ineudb';          // Имя базы данных

function getHours($i){
    switch ($i) {
        case 1:
            echo "<tr><td><div align='center'>7.30-9.05</div></td>";
            break;
        case 2:
            echo "<tr><td><div align='center'>9.20-10.55</div></td>";
            break;
        case 3:
            echo "<tr><td><div align='center'>11.10-12.45</div></td>";
            break;
        case 4:
            echo "<tr><td><div align='center'>13.15-14.50</div></td>";
            break;
        case 5:
            echo "<tr><td><div align='center'>15.00-16.35</div></td>";
            break;
        case 6:
            echo "<tr><td><div align='center'>16.45-18.20</div></td>";
            break;
        default:
            break;
    }
}

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

//Запросы на каждый день недели (пока только понедельник - четверг)
$mondayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=1 ORDER BY `number`';
$tuesdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=2 ORDER BY `number`';
$wednesdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=3 ORDER BY `number`';
$thursdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=4 ORDER BY `number`';

$mondayResult = mysqli_query($mondayQuery) or die('mondayQuery failed: ' . mysqli_error());
$tuesdaResult = mysqli_query($tuesdayQuery) or die('tuesdayQuery failed: ' . mysqli_error());
$wednesdayResult = mysqli_query($wednesdayQuery) or die('wednesdayQuery failed: ' . mysqli_error());
$thursdayResult = mysqli_query($thursdayQuery) or die('thursdayQuery failed: ' . mysqli_error());

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

$mondayLessonArray = Array();
$i = 0;
while ($row = mysql_fetch_object($mondayResult)) {

    $mondayLessonArray[$i] = array(
        "number" => $row->number,
        "first_week" => $row->first_week,
        "second_week" => $row->second_week,
        "name" => $row->name,
        "classroom" => $row->classroom,
        "type" => $row->type,
        "teacher" => $row->teacher,
    );
    $i++;
}

for ($i = 0; $i < count($mondayLessonArray); $i++) {
    if ($mondayLessonArray[$i]["first_week"] == $mondayLessonArray[$i]["second_week"]) {
        getHours($mondayLessonArray[$i]["number"]);
        echo
        '<td>
            <div align=\'center\' valign=\'top\'>', $mondayLessonArray[$i]["name"], '<br></div>
            <div align=\'left\'>', $mondayLessonArray[$i]["type"], '<br></div>
            <div align=\'left\'>', $mondayLessonArray[$i]["teacher"], '<br></div>
            <div align=\'left\'>', $mondayLessonArray[$i]["classroom"], '</div>
        </td>
    </tr>';
    } else {
        for ($j = $i; $j < count($mondayLessonArray); $j++) {
            if ($mondayLessonArray[$i]['number'] == $mondayLessonArray[$j]['number']){
                getHours($mondayLessonArray[$i]["number"]);
                if ($mondayLessonArray[$i]['first_week'] == 1){

                    echo
                    '<td>
                        <table border=\'1\'> 
                            <td style=\"width:250px\">
                                <div align=\'center\' valign=\'top\'>'+$mondayLessonArray[$i]['name']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$i]['type']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$i]['teacher']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$i]['classroom']+'</div>
                            </td>
                            <td style=\"width:250px\">
                                <div align=\'center\' valign=\'top\'>'+$mondayLessonArray[$j]['name']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$j]['type']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$j]['teacher']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$j]['classroom']+'</div>
                            </td>
                        </table>
                    </td>';
                } else {

                    echo
                        '<td>
                        <table border=\'1\'>
                            <td style=\"width:250px\">
                                <div align=\'center\' valign=\'top\'>'+$mondayLessonArray[$j]['name']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$j]['type']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$j]['teacher']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$j]['classroom']+'</div>
                            </td>
                            <td style=\"width:250px\">
                                <div align=\'center\' valign=\'top\'>'+$mondayLessonArray[$i]['name']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$i]['type']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$i]['teacher']+'<br></div>
                                <div align=\'left\'>'+$mondayLessonArray[$i]['classroom']+'</div>
                            </td>

                        </table>
                    </td>';
                }
            }
        }
    }
}

echo '</table>
</body>
</html>';
