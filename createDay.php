<?php

$sortedData = array();

for ($i = 0; $i < count($dayLessonArray); $i++) {
    if ($dayLessonArray[$i]["first_week"] == $dayLessonArray[$i]["second_week"]) {
        //обычная еженедельная пара
        $sortedData[$i] = array(
            'key' => 0,
            'day' => $dayLessonArray[$i],
        );
        
          echo '<tr><td style="width:110px" height="100px"><div align=\'center\'>'
          . getHours($dayLessonArray[$i]["number"]) . '</div></td>';
          echo
          '<td height="90px">
          <div align=\'center\' valign=\'top\' height="25px">', $dayLessonArray[$i]["name"], '<br></div>
          <div align=\'left\' height="25px">', $dayLessonArray[$i]["type"], '<br></div>
          <div align=\'left\' height="25px">', $dayLessonArray[$i]["teacher"], '<br></div>
          <div align=\'left\' height="25px">', $dayLessonArray[$i]["classroom"], '</div>
          </td>
          </tr>';
         return $dayLessonArray;
    } else {
        $isPair = false;
        for ($j = $i + 1; $j < count($dayLessonArray); $j++) {
            if ($dayLessonArray[$i]['number'] == $dayLessonArray[$j]['number']) {
                //Если найдена пара
                $isPair = true;
                
                
                
                echo '<tr><td style="width:110px" height="90px"><div align=\'center\'>'
                . getHours($dayLessonArray[$i]["number"]) . '</div></td>';
                if ($dayLessonArray[$i]['first_week'] == 1) {
                    echo
                    '<td>
                        <table border=\'1\' height="100px"> 
                            <td style="width:240px">
                                <div align=\'center\' valign=\'top\' height="25px">', $dayLessonArray[$i]['name'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['type'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['teacher'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['classroom'], '</div>
                            </td>
                            <td style="width:240px">
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
                            <td style="width:240px">
                                <div align=\'center\' valign=\'top\' height="25px">', $dayLessonArray[$j]['name'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$j]['type'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$j]['teacher'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$j]['classroom'], '</div>
                            </td>
                            <td style="width:240px">
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
            echo '<tr><td style="width:90px" height="90px"><div align=\'center\'>'
            . getHours($dayLessonArray[$i]["number"]) . '</div></td>';
            if ($dayLessonArray[$i]['first_week'] == 1) {
                echo
                '<td>
                        <table border=\'1\' height="100px"> 
                            <td style="width:240px">
                                <div align=\'center\' valign=\'top\' height="25px">', $dayLessonArray[$i]['name'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['type'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['teacher'], '<br></div>
                                <div align=\'left\' height="25px">', $dayLessonArray[$i]['classroom'], '</div>
                            </td>
                            <td style="width:240px" height="100px"></td>
                        </table>
                    </td>
                    </tr>';
            } else {
                echo
                '<td>
                        <table border=\'1\' height="100px">
                            <td style="width:240px"></td>
                            <td style="width:240px" height="100px">
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