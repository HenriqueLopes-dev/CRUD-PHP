<?php
$errors = [];
$edit_btn = null;

if (isset($_POST['edit_btn'])) {
    $edit_btn = $_GET['id'];
}

if (isset($_POST['edit_confirm_btn'])) {

    $name = $_POST['user_name'] ?? '';
    $email = $_POST['user_email'] ?? '';

    if (empty($errors)) {
        $edit_user = [
            'id' => $_POST['user_id'],
            'name' => $_POST['user_name'],
            'email' => $_POST['user_email']
        ];
    }

}

$delete_user = null;
if (isset($_POST['delete_btn'])) {
    $delete_user = $_GET['id'];
}

require_once 'user_controller.php';

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

if (isset($errors['id'])) {
    $edit_btn = isset($errors['id']) ? (int) $errors['id'] : null;

}

?>
<?php require_once "components/header.php"; ?>

<body>
    <?php require_once "components/navbar.php"; ?>

    <div class="container-sm mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Gerenciador de Usuários</h4>
            </div>

            <div class="mt-4 card shadow-sm">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">

                        <?php foreach ($users as $user) { ?>

                            <tr>
                                <?php if ($edit_btn == $user->id && $user->id == $logged_id) { ?>
                                    <form action="index.php" method="POST">
                                        <input type="hidden" name="user_id" value="<?php echo $user->id ?>">
                                        <td> <?php echo $user->id ?> </td>
                                        <td>
                                            <input type="text" class="form-control" name="user_name"
                                                value="<?php echo $user->name ?>">

                                            <?php if (isset($errors["name"])) { ?>
                                                <?php foreach ($errors["name"] as $error) { ?>

                                                    <small class="text-danger">
                                                        <?php echo $error ?>
                                                    </small><br>

                                                <?php }
                                            } ?>

                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="user_email"
                                                value="<?php echo $user->email ?>">

                                            <?php if (isset($errors["email"])) { ?>
                                                <?php foreach ($errors["email"] as $error) { ?>

                                                    <small class="text-danger">
                                                        <?php echo $error ?>
                                                    </small><br>

                                                <?php }
                                            } ?>

                                        </td>
                                        <td class="text-center d-flex justify-content-center gap-2">
                                            <button type="submit" class="btn btn-sm btn-success"
                                                name="edit_confirm_btn">Salvar</button>
                                            <a href="index.php" class="btn btn-sm btn-secondary">Cancelar</a>
                                        </td>
                                    </form>

                                <?php } else { ?>

                                    <td> <?php echo $user->id ?> </td>
                                    <td> <?php echo $user->name ?> </td>
                                    <td> <?php echo $user->email ?> </td>

                                    <?php if ($user->id == $logged_id) { ?>
                                        <td class="text-center d-flex justify-content-center gap-2">
                                            <form action="index.php?id=<?php echo $user->id ?>" method="POST">
                                                <button class="btn btn-sm btn-warning text-white" name="edit_btn">Editar</button>
                                            </form>

                                            <form action="index.php?id=<?php echo $user->id ?>" method="POST">
                                                <button class="btn btn-sm btn-danger" name="delete_btn">Excluir</button>
                                            </form>
                                        </td>

                                    <?php } else
                                        echo '<td></td>';
                                } ?>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>