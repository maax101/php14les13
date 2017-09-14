<?php
//http://university.netology.ru/u/belous/me/lesson13/lesson4_2.php
$tasks = new PDO("mysql:host = localhost; dbname=mybase", "root", "");
print_r($_POST);

$sql   = ('SELECT * FROM tasks');
var_dump($sql);
if (isset($_POST['save']) && !empty($_POST['description'])) {
    $insert = 'INSERT INTO `tasks` (`description`, `is_done`, `date_added`)
VALUES (:description, 0, now())';
$insert_st = $tasks->prepare($insert);
    $insert_st->execute([':description' => $_POST['description']]);
}

if (isset($_POST['sort']) && !empty($_POST['sort_by'])) {
    $tasks->quote ($sql .= ' ORDER BY ' . ($_POST['sort_by']). ' ');
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $del    = 'DELETE FROM `tasks` WHERE id = :id';
$del_st = $tasks->prepare($del);
    $del_st->execute([':id' => $_GET['id']]);
}
var_dump($sql);
function showData($tasks, $sql)
{
    if (!empty($tasks)) {
        return $tasks->query($sql);
          
    }    
}
if (isset($_GET['action']) && $_GET['action'] = 'done'){
   
    $done = $tasks->prepare ('UPDATE tasks SET is_done = 1 WHERE id = :id');
    $done->execute([':id' => $_GET['id']]);
    unset($_GET['action']);
 }   
?>

