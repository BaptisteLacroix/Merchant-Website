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

    public function connect(): void
    {
        $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
    }

    public function close(): void
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

    public function getProducts(): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = 'SELECT * FROM produit;';
        return $this->connection->query($sql);
    }

    public function getProductReference($reference): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM produit WHERE reference_produit LIKE " . "'" . $reference . "';";
        return $this->connection->query($sql);
    }

    public function addNewClient(string $prenom, string $nom, string $email, string $password): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "INSERT INTO client (prenom_client, nom_client, email_client, password_client) VALUES ('" . $prenom . "', '" . $nom . "', '" . $email . "', '" . $password . "');";
        // if the query is successful, return true
        return $this->connection->query($sql);
    }

    public function getClient(string $email): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM client WHERE email_client LIKE " . "'" . $email . "';";
        return $this->connection->query($sql);
    }

    public function addToCart(string $id_client, string $ref_produit, string $quantite, string $prix): bool|PDOStatement
    {
        $this->__wakeup();
        $id_produit = $this->getProductReference($ref_produit)->fetch()['id_produit'];
        $sql = "insert into panier(id_client, id_produit, quantite, prix) VALUES\n"

            . "('" . $id_client . "', '" . $id_produit . "', '" . $quantite . "', '" . $prix . "');";

        // if the query is successful, return true
        return $this->connection->query($sql);
    }

    public function getCarts(string $id_client): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM panier WHERE id_client LIKE " . "'" . $id_client . "';";
        return $this->connection->query($sql);
    }

    public function getCart(string $id_panier): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM panier WHERE id_panier LIKE " . "'" . $id_panier . "';";
        return $this->connection->query($sql);
    }


    public function getProductsFromCart(string $id_client): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "select * from produit\n"

            . "INNER JOIN panier on produit.id_produit = panier.id_produit\n"

            . "where id_client = " . $id_client . ";";

        return $this->connection->query($sql);
    }

    public function deleteFromCart(string $id_panier): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "DELETE FROM panier WHERE id_panier LIKE " . "'" . $id_panier . "';";
        return $this->connection->query($sql);
    }

    public function updateQuantityCart(string $id_panier, int $newValue): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "UPDATE panier SET quantite = quantite + " . $newValue . " WHERE id_panier LIKE " . "'" . $id_panier . "';";
        return $this->connection->query($sql);
    }

    public function getTotalPrice(string $id_client): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT ROUND(SUM(prix*quantite), 2) as somme FROM panier WHERE id_client LIKE " . "'" . $id_client . "';";
        return $this->connection->query($sql);
    }


    public function insertFacture($id_client)
    {
        $this->__wakeup();
        $client_informations = $this->getClient($id_client)->fetch();
        // mettre dans un json les triplets reference_produit, quantite, prix. Pour tous les paniers du client
        $json = $this->generateJSON($id_client);

        // calculer le prix total ht
        $total_ht = $this->getTotalPrice($id_client)->fetch()['somme'];

        // calculer le prix total ttc
        $total_ttc = $total_ht * 1.2;

        $sql = "INSERT INTO facturation (id_client, date_creation, nom_client, prenom_client, email_client, produits, prix_total_HT, prix_total_TTC)" +
            "VALUES (" . $id_client . ",NOW()," . $client_informations['nom_client'] . "," . $client_informations['prenom_client'] . ","
            . $client_informations['email_client'] . "," . $json . "," . $total_ht . "," . $total_ttc . ");";

        return $this->connection->query($sql);
    }

    private function generateJSON($id_client)
    {
        $carts = $this->getCarts($id_client);
        $json = [];
        foreach ($carts as $cart) {
            $product = $this->getProductReference($cart['id_produit'])->fetch();
            $json[] = [
                'reference_produit' => $product['reference_produit'],
                'quantite' => $cart['quantite'],
                'prix' => $cart['prix']
            ];
        }
        return $json;
    }

    public function getFacture($id_client): bool|PDOStatement
    {
        $this->__wakeup();
        //Get the most recent facture fromid_client and date
        $sql = "SELECT * FROM facture WHERE id_client LIKE " . "'" . $id_client . "' ORDER BY date_creation DESC LIMIT 1;";
        return $this->connection->query($sql);
    }
}

