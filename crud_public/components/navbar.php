<nav class="navbar navbar-expand-lg navbar-white bg-primary">
    <div class="container-sm">
        <a class="navbar-brand text-white" href="index.php">CRUD PHP</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="criar_user.php">Criar usuário</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <?php if (!isset($_SESSION['logged'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="login.php">Entrar</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <span class="nav-link text-white">
                            Olá, <?php echo htmlspecialchars($_SESSION['logged']['name']); ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="logout.php">Sair</a>
                    </li>
                <?php } ?>
            </ul>

        </div>
    </div>
</nav>