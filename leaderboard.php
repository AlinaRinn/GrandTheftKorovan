<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/GTK_db.php');

$db_connect = new GTKdb();

$table = '<table><tr id="tablehead"><td>Место</td><td>Грабитель</td><td>Золото</td><td>Дата набигания</td></tr>';
$counter = 0;
foreach ($db_connect->selectAll("leaderboard") as $mi) {
    $counter++;
    $table .= '<tr><td>' . $counter . '</td>';
    foreach($mi as $my)
    {
        $table .= '<td>' . $my .'</td>';
    }
    $table .= '</tr>';
}
$table .= '</table>';
echo $table;


require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php');