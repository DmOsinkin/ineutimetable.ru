<?php
include_once './functions.php';
include_once './config.php';
include_once './database.php';

$group = $_GET['group'];
//Запросы на каждый день недели (пока только понедельник - четверг)
$mondayQuery = 'SELECT * FROM lessons WHERE `group`="' . $group . '" AND `day`=1 ORDER BY `number`';
$tuesdayQuery = 'SELECT * FROM lessons WHERE `group`="' . $group . '" AND `day`=2 ORDER BY `number`';
$wednesdayQuery = 'SELECT * FROM lessons WHERE `group`="' . $group . '" AND `day`=3 ORDER BY `number`';
$thursdayQuery = 'SELECT * FROM lessons WHERE `group`="' . $group . '" AND `day`=4 ORDER BY `number`';
$fridayQuery = 'SELECT * FROM lessons WHERE `group`="' . $group . '" AND `day`=5 ORDER BY `number`';
$saturdayQuery = 'SELECT * FROM lessons WHERE `group`="' . $group . '" AND `day`=6 ORDER BY `number`';
$sundayQuery = 'SELECT * FROM lessons WHERE `group`="' . $group . '" AND `day`=7 ORDER BY `number`';

constructDayByQuery($mondayQuery, $conn);
constructDayByQuery($tuesdayQuery, $conn);
constructDayByQuery($wednesdayQuery, $conn);
constructDayByQuery($thursdayQuery, $conn);
constructDayByQuery($fridayQuery, $conn);
constructDayByQuery($saturdayQuery, $conn);
constructDayByQuery($sundayQuery, $conn);
