<?php
session_start();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['user_name'] ?? '';
    $email = $_POST['user_email'] ?? '';
    $password = $_POST['user_password'] ?? '';

    if (strlen($name) < 3 || strlen($name) > 70) {
        $errors['name'][] = "Campo Nome deve ter entre 3 e 70 caracteres!";
    }

    if (strlen($email) < 5 || strlen($email) > 255) {
        $errors['email'][] = "Campo Email deve ter entre 5 e 255 caracteres!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'][] = "Campo Email inválido!";
    }

    if (strlen($password) < 8 || strlen($password) > 70) {
        $errors['password'][] = "Campo Senha deve ter entre 3 e 70 caracteres!";
    }

    $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/";
    if (!preg_match($regex, $password)) {
        $errors['password'][] = "Campo Senha deve ter no mínimo uma letra minúscula, maiúscula e um número!";
    }

    if (empty($errors)) {
        $_SESSION['user_data'] = [
            'action' => 'create',
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        header("Location: user_controller.php");
        exit;
    }

    $_SESSION["errors"] = $errors;
    header("Location: criar_user.php");
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
                <h4 class="mb-0">Criar Usuário</h4>
            </div>
            <div class="card-body">
                <form id="userForm" class="d-flex flex-column align-items-center g-3" method="POST"
                    action="criar_user.php">

                    <div class="col-md-6 w-100" style="max-width: 500px;">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="user_name" placeholder="João Silva">

                        <?php if (isset($errors["name"])) { ?>
                            <?php foreach ($errors["name"] as $error) { ?>
                                <small class="text-danger"><?php echo $error ?></small><br>
                            <?php }
                        } ?>

                    </div>

                    <div class="col-md-6 w-100 mt-3" style="max-width: 500px;">
                        <label class="form-label">E-mail</label>
                        <input type="text" class="form-control" name="user_email" placeholder="joao@email.com">

                        <?php if (isset($errors["email"])) { ?>
                            <?php foreach ($errors["email"] as $error) { ?>

                                <small class="text-danger"><?php echo $error ?></small><br>

                            <?php }
                        } ?>

                    </div>

                    <div class="col-md-6 w-100 mt-3" style="max-width: 500px;">
                        <label class="form-label">Senha</label>
                        <input type="password" class="form-control" name="user_password" placeholder="Sua senha">

                        <?php if (isset($errors["password"])) { ?>
                            <?php foreach ($errors["password"] as $error) { ?>
                                <small class="text-danger"><?php echo $error ?></small><br>
                            <?php }
                        } ?>
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