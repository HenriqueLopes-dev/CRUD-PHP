<?php

class Connection
{

    private $host = 'localhost';
    private $db_name = 'crud';
    private $user = 'root';
    private $pass = '';



    public function connect()
    {
        try {

            return new PDO(
                "mysql:host=$this->host;dbname=$this->db_name",
                "$this->user",
                "$this->pass",
            );

        } catch (PDOException $e) {
            echo '<p>' . $e->getMessage() . '</p>';
        }

    }
}

?>