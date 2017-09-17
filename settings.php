<?php
//http://university.netology.ru/u/belous/me/lesson13/lesson4_2.php
$db_con = new PDO("mysql:host = localhost; dbname=belous; charset=UTF8", "belous", "neto1253");

$sql = ('SELECT * FROM tasks');
if (isset($_POST['save']) && !empty($_POST['description'])) {
    $insert = 'INSERT INTO `tasks` (`description`, `is_done`, `date_added`)
    VALUES (:description, 0, now())';
    $insert_st = $db_con->prepare($insert);
    $insert_st->execute([':description' => $_POST['description']]);
}

if (isset($_POST['sort']) && !empty($_POST['sort_by'])) {
    $db_con->quote($sql .= ' ORDER BY ' . ($_POST['sort_by']) . ' ');
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $del    = 'DELETE FROM `tasks` WHERE id = :id';
    $del_st = $db_con->prepare($del);
    $del_st->execute([':id' => $_GET['id']]);
}

function showData($db_con, $sql)
{
    if (!empty($db_con)) {
        return $db_con->query($sql);
    }
}

if (isset($_GET['action']) && $_GET['action'] = 'done') {
    $done = $db_con->prepare('UPDATE tasks SET is_done = 1 WHERE id = :id');
    $done->execute([':id' => $_GET['id']]);
    unset($_GET['action']);
}
