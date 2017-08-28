<?php
//http://university.netology.ru/u/belous/me/lesson13/lesson4_2.php
$tasks = new PDO("mysql:host = http://university.netology.ru/u/belous/me/lesson13; dbname=mybase", "root", "", array(PDO::ATTR_PERSISTENT => true));
$sql   = 'SELECT *FROM tasks';

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

?>
<html>
<title>Lesson4_2</title>
<body>
<style>
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }

    table td, table th {
        border: 1px solid #ccc;
        padding: 5px;
    }

    table th {
        background: #eee;
    }
</style>

<h1>Список дел на сегодня</h1>
<div style="float: left">
    <form method="POST">
    <label for="save">Новая задача:</label>
        <input type="text" name="description" placeholder="Описание задачи" value="" />
        <input type="submit" name="save" value="Добавить" />
    </form>
</div>
<div style="float: left; margin-left: 20px;">
    <form method="POST">
        <label for="sort">Сортировать по:</label>
        <select name="sort_by">
            <option value="date_added">Дате добавления</option>
            <option value="is_done">Статусу</option>
            <option value="description">Описанию</option>
        </select>
        <input type="submit" name="sort" value="Отсортировать" />
    </form>
</div>
<div style="clear: both"></div>

<table>
    <tr>
        <th>Описание задачи</th>
        <th>Дата добавления</th>
        <th>Статус</th>
        <th></th>
    </tr>

<?php
foreach ($tasks->query($sql) as $row) {
    echo
        '<tr>
    <td>' . $row['description'] . '</td>
    <td>' . $row['date_added'] . '</td>
    <td>' . $row['is_done'] . '</td>
    <td>
        <a href=?id=' . $row['id'] . '&action=edit>Изменить</a>
        <a href=?id=' . $row['id'] . '&action=done>Выполнить</a>
        <a href=?id=' . $row['id'] . '&action=delete>Удалить</a>
    </td>
</tr>';
}
?>

</table>
</body>
</html>