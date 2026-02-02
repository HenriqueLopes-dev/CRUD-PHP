<?php
require_once "../../crud_private/user.model.php";
require_once "../../crud_private/user.service.php";
require_once "../../crud_private/connection_db.php";

session_start();
$user_data = null;
$logged_id = null;

if (isset($_SESSION['logged'])) {
    $logged_id = $_SESSION['logged']['id'];
}

if (isset($_SESSION['user_data'])) {
    $user_data = $_SESSION['user_data'];
    unset($_SESSION['user_data']);
}

$connection = new Connection();
$user = new User();
$user_service = new UserService($connection, $user);

$action = $_POST['action'] ?? $user_data['action'] ?? null;

if ($user_data) {
    if ($action == 'create') {

        $user->name = $user_data['name'];
        $user->email = $user_data['email'];
        $user->password = $user_data['password'];

        $user_service->create();

        header("Location: index.php");
        exit;
    }

    if ($action == 'login') {

        $user->email = $user_data['email'];
        $user->password = $user_data['password'];

        $user_service->login();

        header("Location: index.php");
        exit;
    }
}

if (isset($delete_user) && isset($logged_id) && $delete_user == $logged_id) {

    $user_service->delete($delete_user);
    header('Location: logout.php');
    exit;
}

if (isset($edit_user) && isset($logged_id) && $edit_user['id'] == $logged_id) {
    $user_update = new User();
    $user_update->id = $edit_user['id'];
    $user_update->name = $edit_user['name'];
    $user_update->email = $edit_user['email'];

    $user_service->update($user_update);

    $users = $user_service->list();
}

if ($user_data == null) {
    $users = $user_service->list();
}

?>