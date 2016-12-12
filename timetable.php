<?php

require 'index.php';

$db_host = 'localhost';     // Сервер
$db_user = 'root';  // Имя пользователя
$db_password = 'LVBNHBQ';  // Пароль пользователя
$db_name = 'ineudb';          // Имя базы данных

function getDay($_day) {
    if ($_day != null) {
        $days = array(
            1 => "Понедельник",
            2 => "Вторник",
            3 => "Среда",
            4 => "Четверг",
            5 => "Пятница",
            6 => "Суббота",
            7 => "Воскресение",
        );
        return $days[$_day];
    }
}

function getHours($_hour) {
    if ($_hour['housing'] < 5) {
        $hours = array(
            1 => "7.30-9.05",
            2 => "9.20-10.55",
            3 => "11.10-12.45",
            4 => "13.15-14.50",
            5 => "15.00-16.35",
            6 => "16.45-18.20"
        );
    } else {
        $hours = array(
            1 => "8.00-9.35",
            2 => "9.50-11.25",
            3 => "11.40-13.15",
            4 => "13.45-15.20",
            5 => "15.30-17.05",
            6 => "17.15-18.50"
        );
    }
    return $hours[$_hour['number']];
}

function constructDayByQuery($_query, $_conn) {

    $result = mysqli_query($_conn, $_query);

    if (mysqli_num_rows($result) == 0) {
        return;
    }
    $dayLessonArray = Array();
    $i = 0;
    while ($row = mysqli_fetch_object($result)) {
        $dayLessonArray[$i] = array(
            "number" => $row->number,
            "first_week" => $row->first_week,
            "second_week" => $row->second_week,
            "name" => $row->name,
            "classroom" => $row->classroom,
            "type" => $row->type,
            "teacher" => $row->teacher,
            "housing" => $row->housing,
            "day" => $row->day
        );
        $i++;
    }
    echo '<h3>' . getDay($dayLessonArray[0]["day"]) . '</h3>';
    echo '<table width="600px" border=\'3\'>';

    for ($i = 0; $i < count($dayLessonArray); $i++) {
        if ($dayLessonArray[$i]["first_week"] == $dayLessonArray[$i]["second_week"]) {
            //обычная еженедельная пара
            echo '<tr><td style="width:110px" height="100px"><div align=\'center\'>'
            . getHours($dayLessonArray[$i]) . '</div></td>';
            echo
            '<td height="90px">
            <div align=\'center\' valign=\'top\' height="25px">', $dayLessonArray[$i]["name"], '<br></div>
            <div align=\'left\' height="25px">', $dayLessonArray[$i]["type"], '<br></div>
            <div align=\'left\' height="25px">', $dayLessonArray[$i]["teacher"], '<br></div>
            <div align=\'left\' height="25px">', $dayLessonArray[$i]["classroom"], '</div>
        </td>
    </tr>';
        } else {
            $isPair = false;
            for ($j = $i + 1; $j < count($dayLessonArray); $j++) {
                if ($dayLessonArray[$i]['number'] == $dayLessonArray[$j]['number']) {
                    //Если найдена пара
                    $isPair = true;
                    echo '<tr><td style="width:110px" height="90px"><div align=\'center\'>'
                    . getHours($dayLessonArray[$i]) . '</div></td>';
                    if ($dayLessonArray[$i]['first_week'] == 1) {
                        echo
                        '<td>
                        <table border=\'1\' height="100px"> 
                            <td style="width:245px">
                                <div align=\'center\' valign=\'top\' height="25px">', $dayLessonArray[$i]['name'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['type'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['teacher'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['classroom'], '</div>
                            </td>
                            <td style="width:245px">
                                <div align=\'center\' valign=\'top\' height="25px">', $dayLessonArray[$j]['name'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$j]['type'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$j]['teacher'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$j]['classroom'], '</div>
                            </td>
                        </table>
                        </td>
                        </tr>';
                        unset($dayLessonArray[$j]);
                        $dayLessonArray = array_values($dayLessonArray);
                    } else {
                        echo
                        '<td>
                        <table border=\'1\' height="100px">
                            <td style="width:245px">
                                <div align=\'center\' valign=\'top\' height="25px">', $dayLessonArray[$j]['name'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$j]['type'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$j]['teacher'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$j]['classroom'], '</div>
                            </td>
                            <td style="width:245px">
                                <div align=\'center\' valign=\'top\' height="25px">', $dayLessonArray[$i]['name'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['type'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['teacher'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['classroom'], '</div>
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
                echo '<tr><td style="width:110px" height="90px"><div align=\'center\'>'
                . getHours($dayLessonArray[$i]) . '</div></td>';
                if ($dayLessonArray[$i]['first_week'] == 1) {
                    echo
                    '<td>
                        <table border=\'1\' height="100px"> 
                            <td style="width:245px">
                                <div align=\'center\' valign=\'top\' height="25px">', $dayLessonArray[$i]['name'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['type'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['teacher'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['classroom'], '</div>
                            </td>
                            <td style="width:245px" height="100px"></td>
                        </table>
                    </td>
                    </tr>';
                } else {
                    echo
                    '<td>
                        <table border=\'1\' height="100px">
                            <td style="width:245px"></td>
                            <td style="width:245px" height="100px">
                                <div align=\'center\' valign=\'top\' height="25px">', $dayLessonArray[$i]['name'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['type'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['teacher'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['classroom'], '</div>
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
$mondayQuery = 'SELECT * FROM lessons WHERE `group`="' . $_GET['group'] . '" AND `day`=1 ORDER BY `number`';
$tuesdayQuery = 'SELECT * FROM lessons WHERE `group`="' . $_GET['group'] . '" AND `day`=2 ORDER BY `number`';
$wednesdayQuery = 'SELECT * FROM lessons WHERE `group`="' . $_GET['group'] . '" AND `day`=3 ORDER BY `number`';
$thursdayQuery = 'SELECT * FROM lessons WHERE `group`="' . $_GET['group'] . '" AND `day`=4 ORDER BY `number`';
$fridayQuery = 'SELECT * FROM lessons WHERE `group`="' . $_GET['group'] . '" AND `day`=5 ORDER BY `number`';
$saturdayQuery = 'SELECT * FROM lessons WHERE `group`="' . $_GET['group'] . '" AND `day`=6 ORDER BY `number`';
$sundayQuery = 'SELECT * FROM lessons WHERE `group`="' . $_GET['group'] . '" AND `day`=7 ORDER BY `number`';



constructDayByQuery($mondayQuery, $conn);
constructDayByQuery($tuesdayQuery, $conn);
constructDayByQuery($wednesdayQuery, $conn);
constructDayByQuery($thursdayQuery, $conn);
constructDayByQuery($fridayQuery, $conn);
constructDayByQuery($saturdayQuery, $conn);
constructDayByQuery($sundayQuery, $conn);

mysqli_close($conn);

echo '</body>
</html>';
