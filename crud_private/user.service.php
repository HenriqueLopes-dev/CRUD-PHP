<?php
class UserService
{

    private $connection;
    private $user;

    public function __construct(Connection $connection, User $user)
    {
        $this->connection = $connection->connect();
        $this->user = $user;
    }

    public function create()
    {
        $same_email_user = $this->findBy('email', $this->user->email);

        if ($same_email_user != null) {
            $_SESSION['errors']['email'][] = 'Já existe um usuário cadastrado com este Email!';
            header("Location: criar_user.php");
            exit;
        }



        $query = 'INSERT INTO tb_user(name, email, password) VALUES(:name, :email, :password)';
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':name', $this->user->name);
        $stmt->bindValue(':email', $this->user->email);
        $stmt->bindValue(':password', $this->user->password);
        $stmt->execute();
    }

    public function read()
    {
        $user = $this->findBy('id', $this->user->id);

        if ($user == null) {
            echo 'Usuário não encontrado';
            exit;
        }

        return $user;
    }

    public function update(User $user_update)
    {
        $user = $this->findBy('id', $user_update->id);

        if ($user == null) {
            echo 'Usuário não encontrado';
            exit;
        }

        if (strlen(trim($user_update->name)) < 3 || strlen($user_update->name) > 70) {
            $_SESSION['errors']['name'][] = 'Campo Nome deve ter entre 3 e 70 caracteres!';
        }

        $same_email_user = $this->findBy('email', $user_update->email);
        if ($same_email_user != null && $same_email_user->id != $user->id) {
            $_SESSION['errors']['email'][] = 'Já existe um usuário cadastrado com este Email!';
        }

        if (strlen($user_update->email) < 5 || strlen($user_update->email) > 255) {
            $_SESSION['errors']['email'][] = "Campo Email deve ter entre 5 e 255 caracteres!";
        }

        if (!filter_var($user_update->email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errors']['email'][] = "Campo Email inválido!";
        }

        if (!empty($_SESSION['errors'])) {
            $_SESSION['errors']['id'] = $user->id;

            header('Location: index.php');
            exit;
        }

        $query = 'UPDATE tb_user SET name = :name, email = :email WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id', $user->id);
        $stmt->bindValue(':name', $user_update->name);
        $stmt->bindValue(':email', $user_update->email);
        $stmt->execute();

        $_SESSION['logged']['name'] = $user_update->name;
    }


    public function delete($id)
    {
        $user = $this->findBy('id', $id);

        if ($user == null) {
            echo 'Usuário não encontrado';
            exit;
        }

        $query = 'DELETE FROM tb_user WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function list()
    {
        $query = "SELECT id, name, email, created_at FROM tb_user LIMIT 10";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function login()
    {
        $same_email_user = $this->findBy('email', $this->user->email);
        if (!isset($same_email_user)) {
            $_SESSION['errors']['password'][] = 'Senha ou Email inválidos!';
            header('Location: login.php');
            exit;
        }

        if (!password_verify($this->user->password, $same_email_user->password)) {
            $_SESSION['errors']['password'][] = 'Senha ou Email inválidos!';
            header('Location: login.php');
            exit;
        }

        $_SESSION['logged']['id'] = $same_email_user->id;
        $_SESSION['logged']['name'] = $same_email_user->name;
    }

    private function findBy($attr, $value)
    {
        $query = "SELECT * FROM tb_user WHERE $attr = :value";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

}

?>