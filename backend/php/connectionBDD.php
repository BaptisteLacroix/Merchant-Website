<?php

class bdd
{
    protected string $host;
    protected string $username;
    protected string $password;
    protected string $database;
    protected PDO $connection;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect()
    {
        $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
    }

    public function close()
    {
        unset($this->connection);
    }

    public function __sleep()
    {
        // Close the database connection before serialization
        $this->close();

        // Return an array of the variables that should be serialized
        return array('host', 'username', 'password', 'database');
    }

    public function __wakeup()
    {
        // Recreate the database connection when the object is unserialized
        $this->connect();
    }

    public function getProducts()
    {
        $this->__wakeup();
        $sql = 'SELECT * FROM produit;';
        return $this->connection->query($sql);
    }

    public function getProductReference($reference)
    {
        $this->__wakeup();
        $sql = "SELECT * FROM produit WHERE reference_produit LIKE " . "'" . $reference . "';";
        return $this->connection->query($sql);
    }

    public function addNewClient(string $prenom, string $nom, string $email, string $password)
    {
        $this->__wakeup();
        $sql = "INSERT INTO client (prenom_client, nom_client, email_client, password_client) VALUES ('" . $prenom . "', '" . $nom . "', '" . $email . "', '" . $password . "');";
        // if the query is successful, return true
        return $this->connection->query($sql);
    }

    public function getClient(string $email)
    {
        $this->__wakeup();
        $sql = "SELECT * FROM client WHERE email_client LIKE " . "'" . $email . "';";
        return $this->connection->query($sql);
    }

    public function addNewOrder(string $id_client, string $ref_produit, string $quantite, string $prix)
    {
        $this->__wakeup();
        $id_produit = $this->getProductReference($ref_produit)->fetch()['id_produit'];
        $sql = "INSERT INTO panier (id_client, id_produit, quantite, prix) VALUES ('" . $id_client . "', '" . $id_produit . "', '" . $quantite . "', '" . $prix . "');";
        // if the query is successful, return true
        return $this->connection->query($sql);
    }

    public function getOrders(string $id_client)
    {
        $this->__wakeup();
        $sql = "SELECT * FROM panier WHERE id_client LIKE " . "'" . $id_client . "';";
        return $this->connection->query($sql);
    }


    public function getCartQuantity(string $id_client)
    {
        $this->__wakeup();
        $sql = "SELECT * FROM panier WHERE id_client LIKE " . "'" . $id_client . "' GROUP BY id_produit;";
        return $this->connection->query($sql);
    }

}

