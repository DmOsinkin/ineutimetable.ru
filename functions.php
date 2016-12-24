<?php

/*
 * functions.php
 * Файл с пользовательскими функциями
 */

/**
 * Получить день недели по порядковому номеру.
 * 
 * @param type $_day
 * @return string
 */
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

/**
 * Получить время по номеру пары.
 * 
 * @param type $_numOfLesson
 * @return string
 */
function getHours($_numOfLesson) {
    if ($_numOfLesson['housing'] < 5) {
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
    return $hours[$_numOfLesson['number']];
}

/**
 * Построить день по sql-запросу
 * 
 * @param type $_query
 * @param type $_conn
 * @return type
 */
function constructDayByQuery($_query, $_conn) {

    $result = mysqli_query($_conn, $_query);
    
    //если не найдено пар (например, воскресенье - выходной)
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
    
    echo '<h3 align="center">' . getDay($dayLessonArray[0]["day"]) . '</h3>';
    echo '<table width="600px" border=\'3\' align="center">';

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

?>