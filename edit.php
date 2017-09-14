<?php
include 'settings.php';

$result = $tasks->query('SELECT * FROM tasks WHERE id = '.$_GET['id'].'');
 foreach ($result->fetchAll(PDO::FETCH_ASSOC)as $value) {
 	$row = $value;
 }
print_r($row);
if (isset($_POST['save'])){
	$description = $_POST['new_description'];
	$update = $tasks->prepare ('UPDATE tasks SET description = :description WHERE id = :id');
	$update->execute([':description' => $_POST['new_description'], ':id' => $_GET['id']]);
	unset($_POST);
	header('Location: index.php');
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

<h1>Редактирование задания:</h1>
<div style="float: left">
    <form method="POST">
    <label for="save">Изменить задачу:</label>
        <input type="text" name="new_description" placeholder="Описание задачи" value="<?=$row['description'];?>" />
        <input type="submit" name="save" value="изменить" />
    </form>
</div>

<div style="clear: both"></div>



</table>
</body>
</html>