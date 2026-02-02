<?php
session_start();
$errors = [];


if (isset($_POST['user_password']) && isset($_POST['user_email'])) {
    $_SESSION['user_data'] = [
        'action' => 'login',
        'email' => $_POST['user_email'],
        'password' => $_POST['user_password']
    ];
    header("Location: user_controller.php");
    exit;
}

$errors = $_SESSION['errors'] ?? null;
unset($_SESSION['errors']);

?>
<?php require_once "components/header.php"; ?>

<body>
    <?php require_once "components/navbar.php"; ?>
    <div class="container-sm mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Entrar</h4>
            </div>
            <div class="card-body">
                <form id="userForm" class="d-flex flex-column align-items-center g-3" method="POST" action="login.php">

                    <div class="col-md-6 w-100 mt-3" style="max-width: 500px;">
                        <label class="form-label">E-mail</label>
                        <input type="text" class="form-control" name="user_email" placeholder="joao@email.com">
                    </div>

                    <div class="col-md-6 w-100 mt-3" style="max-width: 500px;">
                        <label class="form-label">Senha</label>
                        <input type="password" class="form-control" name="user_password" placeholder="Sua senha">

                        <?php if (isset($errors["password"])) { ?>

                            <small class="text-danger"><?php echo $errors['password'][0] ?></small><br>

                        <?php } ?>
                    </div>

                    <div class="col-md-6 w-100 mt-4" style="max-width: 500px;">
                        <button type="submit" class="btn btn-success w-100">Salvar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>