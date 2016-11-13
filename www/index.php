<?php

$db_host = 'localhost';     // Сервер
$db_user = 'root';  // Имя пользователя
$db_password = '';  // Пароль пользователя
$db_name = 'ineudb';          // Имя базы данных

function getHours($hour) {

    switch ($hour) {
        case 1:
            echo "<tr><td style=\"width:90px\"><div align=\'center\'>7.30-9.05</div></td>";
            break;
        case 2:
            echo "<tr><td style=\"width:90px\"><div align=\'center\'>9.20-10.55</div></td>";
            break;
        case 3:
            echo "<tr><td style=\"width:90px\"><div align=\'center\'>11.10-12.45</div></td>";
            break;
        case 4:
            echo "<tr><td style=\"width:90px\"><div align=\'center\'>13.15-14.50</div></td>";
            break;
        case 5:
            echo "<tr><td style=\"width:90px\"><div align=\'center\'>15.00-16.35</div></td>";
            break;
        case 6:
            echo "<tr><td style=\"width:90px\"><div align=\'center\'>16.45-18.20</div></td>";
            break;
        default:
            break;
    }
}

function constructDayByQuery($_query, $_conn) {

    $result = mysqli_query($_conn, $_query) or die('mondayQuery failed: ' . mysqli_error());
    $dayLessonArray = Array();
    $i = 0;

    echo '<table style="height:110px" width="600px"  border=\'2\'>';

    while ($row = mysqli_fetch_object($result)) {
        $dayLessonArray[$i] = array(
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

    for ($i = 0; $i < count($dayLessonArray); $i++) {
        if ($dayLessonArray[$i]["first_week"] == $dayLessonArray[$i]["second_week"]) {
            //обычная еженедельная пара
            getHours($dayLessonArray[$i]["number"]);
            echo
            '<td>
            <div align=\'center\' valign=\'top\'>', $dayLessonArray[$i]["name"], '<br></div>
            <div align=\'left\'>', $dayLessonArray[$i]["type"], '<br></div>
            <div align=\'left\'>', $dayLessonArray[$i]["teacher"], '<br></div>
            <div align=\'left\'>', $dayLessonArray[$i]["classroom"], '</div>
        </td>
    </tr>';
        } else {
            $isPair = false;
            for ($j = $i + 1; $j < count($dayLessonArray); $j++) {
                if ($dayLessonArray[$i]['number'] == $dayLessonArray[$j]['number']) {
                    //Если найдена пара
                    $isPair = true;
                    getHours($dayLessonArray[$i]["number"]);
                    if ($dayLessonArray[$i]['first_week'] == 1) {
                        echo
                        '<td>
                        <table border=\'1\'> 
                            <td style="width:240px">
                                <div align=\'center\' valign=\'top\'>', $dayLessonArray[$i]['name'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['type'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['teacher'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['classroom'], '</div>
                            </td>
                            <td style="width:240px">
                                <div align=\'center\' valign=\'top\'>', $dayLessonArray[$j]['name'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$j]['type'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$j]['teacher'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$j]['classroom'], '</div>
                            </td>
                        </table>
                        </td>
                        </tr>';
                        unset($dayLessonArray[$j]);
                        $dayLessonArray = array_values($dayLessonArray);
                    } else {
                        echo
                        '<td>
                        <table border=\'1\'>
                            <td style="width:240px">
                                <div align=\'center\' valign=\'top\'>', $dayLessonArray[$j]['name'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$j]['type'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$j]['teacher'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$j]['classroom'], '</div>
                            </td>
                            <td style="width:240px">
                                <div align=\'center\' valign=\'top\'>', $dayLessonArray[$i]['name'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['type'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['teacher'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['classroom'], '</div>
                            </td> 
                        </table>
                    </td>
                    </tr>';
                        // TODO: функция удаления пары из массива, которая была найдена для четности
                        unset($dayLessonArray[$j]);
                        $dayLessonArray = array_values($dayLessonArray);
                    }
                }
            }
            if (!$isPair) {
                //Если пара не найдена
                getHours($dayLessonArray[$i]["number"]);
                if ($dayLessonArray[$i]['first_week'] == 1) {
                    echo
                    '<td>
                        <table border=\'1\'> 
                            <td style="width:240px">
                                <div align=\'center\' valign=\'top\'>', $dayLessonArray[$i]['name'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['type'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['teacher'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['classroom'], '</div>
                            </td>
                            <td style="width:240px"></td>
                        </table>
                    </td>
                    </tr>';
                } else {
                    echo
                    '<td>
                        <table border=\'1\'>
                            <td style="width:240px"></td>
                            <td style="width:240px">
                                <div align=\'center\' valign=\'top\'>', $dayLessonArray[$i]['name'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['type'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['teacher'], '<br></div>
                                <div align=\'left\'>', $dayLessonArray[$i]['classroom'], '</div>
                            </td>
                        </table>
                    </td>
                    </tr>';
                }
            }
        }
    }
    echo '</table>';
}

// Подключаемся к серверу
$conn = mysqli_connect($db_host, $db_user, $db_password) or die(
                "<p>Невозможно подключиться к СУБД: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");

// Эта часть кода выполнится только в случае успешного подключения к серверу
// Выбираем базу данных
$db = mysqli_select_db($conn, $db_name) or die(
                "<p>Невозможно подключиться к базе данных: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");

// Эта часть кода выполняется только в случае успешного подключения к БД
// Указываем серверу, что данные, которые мы от него получаем, нам нужны в кодировке UTF-8
$query = mysqli_query($conn, "set names utf8") or die(
                "<p>Невозможно выполнить запрос к базе данных: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");



//Запросы на каждый день недели (пока только понедельник - четверг)
$mondayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=1 ORDER BY `number`';
$tuesdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=2 ORDER BY `number`';
$wednesdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=3 ORDER BY `number`';
$thursdayQuery = 'SELECT * FROM lessons WHERE `group`="13-САИ" AND `day`=4 ORDER BY `number`';

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
    <body>';
echo '<h3>Monday</h3>';
constructDayByQuery($mondayQuery, $conn);

echo '<h3>Tuesday</h3>';
constructDayByQuery($tuesdayQuery, $conn);

echo '<h3>Wednesday</h3>';
constructDayByQuery($wednesdayQuery, $conn);

echo '<h3>Thursday</h3>';
constructDayByQuery($thursdayQuery, $conn);

echo '</body>
</html>';
