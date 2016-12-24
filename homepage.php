
<?php
include 'config.php';
include 'database.php';

$query = "SELECT DISTINCT `group` FROM lessons;";
$result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error());

$groups = Array();
$i = 0;
while ($row = mysqli_fetch_object($result)) {
    $groups[$i] = $row->group;
    $i++;
}
?>

<br>
<h4>Доступно расписание для групп:</h4>
<?php
    for ($i = 0; $i < count($groups); $i++) {
        echo '<a href="index.php?&page=timetable&group='.$groups[$i].'">' . $groups[$i] . '</a><br>';
    }
?>
<hr>
