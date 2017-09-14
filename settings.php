<?php
//http://university.netology.ru/u/belous/me/lesson13/lesson4_2.php
$tasks = new PDO("mysql:host = localhost; dbname=mybase", "root", "");

$sql   = 'SELECT * FROM tasks';

if (isset($_POST['save']) && !empty($_POST['description'])) {
    $insert = 'INSERT INTO `tasks` (`description`, `is_done`, `date_added`)
VALUES (:description, 0, now())';
$insert_st = $tasks->prepare($insert);
    $insert_st->execute([':description' => $_POST['description']]);
}

if (isset($_POST['sort']) && !empty($_POST['sort_by'])) {
    $sql .= ' ORDER BY ' . $_POST['sort_by'] . ' ';
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $del    = 'DELETE FROM `tasks` WHERE id = :id';
$del_st = $tasks->prepare($del);
    $del_st->execute([':id' => $_GET['id']]);
}

function showData($tasks, $sql)
{
    if (!empty($tasks)) {
        foreach ($tasks->query($sql) as $row) {
            echo
            '<tr>
                <td>' . $row['description'] . '</td>
                <td>' . $row['date_added'] . '</td>
                <td>' . $row['is_done'] . '</td>
                <td>
                    <a href=edit.php?id=' . $row['id'] . '&action=edit>Изменить</a>
                    <a href=?id=' . $row['id'] . '&action=done>Выполнить</a>
                    <a href=?id=' . $row['id'] . '&action=delete>Удалить</a>
                </td>
            </tr>';
        }
    }
}
?>

