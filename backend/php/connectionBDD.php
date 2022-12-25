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

    public function addNewProduct($img, $fournisseur, $reference, $status, $marque, $type, $aspect, $taille, $couleur, $publicPrice, $boughtPrice, $titre, $descriptif, $quantite): PDOStatement|bool
    {
        $this->__wakeup();
        $sql = "INSERT INTO produit (id_fournisseur, image, reference, status, marque_produit, type_produit, aspect_produit, taille_produit, couleur_produit, prix_public_produit, prix_achat_produit, titre_produit, descriptif_produit, quantite_produit)" .
            "VALUES ('" . $fournisseur . "', '" . $img . "', '" . $reference . "', '" . $status . "', '" . $marque . "', '" . $type . "', '" . $aspect . "', '" . $taille . "', '" . $couleur . "', '" . $publicPrice . "', '" . $boughtPrice . "', '" . $titre . "', '" . $descriptif . "','" . $quantite . "')";
        return $this->connection->query($sql);
    }

    public function getProducts(): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = 'SELECT * FROM produit;';
        return $this->connection->query($sql);
    }

    public function getProductByid($id_product): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM produit WHERE id_produit = '" . $id_product . "';";
        return $this->connection->query($sql);
    }

    public function getProductByReference($reference): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM produit WHERE reference_produit LIKE " . "'" . $reference . "';";
        return $this->connection->query($sql);
    }

    public function updateProductStocksByReference($reference_produit, $new_quantity): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "UPDATE produit SET quantite_produit = " . $new_quantity . " WHERE reference_produit LIKE " . "'" . $reference_produit . "';";
        return $this->connection->query($sql);
    }

    public function addNewClient(string $prenom, string $nom, string $email, string $password): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "INSERT INTO client (prenom_client, nom_client, email_client, password_client) VALUES ('" . $prenom . "', '" . $nom . "', '" . $email . "', '" . $password . "');";
        // if the query is successful, return true
        return $this->connection->query($sql);
    }

    public function getAllClient(): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM client;";
        return $this->connection->query($sql);
    }

    public function getClient(string $email): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM client WHERE email_client LIKE " . "'" . $email . "';";
        return $this->connection->query($sql);
    }

    public function deleteCartClient($id_client)
    {
        $this->__wakeup();
        $sql = "DELETE FROM panier WHERE id_client = " . $id_client . ";";
        return $this->connection->query($sql);
    }

    public function updateClient($id_client, $lastname, $firstname, $email, $mobilephone, $address, $postalCode, $city, $country)
    {
        $this->__wakeup();
        $sql = "UPDATE client SET nom_client = '" . $lastname . "', prenom_client = '" . $firstname . "', email_client = '" . $email . "', telephone_client = '" . $mobilephone . "', adresse_client = '" . $address . "', code_postal_client = '" . $postalCode . "', ville_client = '" . $city . "', pays_client = '" . $country . "' WHERE id_client = " . $id_client . ";";
        return $this->connection->query($sql);
    }

    public function addToCart(string $id_client, string $ref_produit, string $quantite, string $prix): bool|PDOStatement
    {
        $this->__wakeup();
        $id_produit = $this->getProductByReference($ref_produit)->fetch()['id_produit'];
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

    public function getAllFacture(): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM facturation;";
        return $this->connection->query($sql);
    }

    public function insertNewFacture($email_client): bool|PDOStatement
    {
        $this->__wakeup();
        $client_informations = $this->getClient($email_client)->fetch();
        $id_client = $client_informations['id_client'];

        // mettre dans un json les triplets reference_produit, quantite, prix. Pour tous les paniers du client
        $json = $this->getTotalCart($id_client);

        // calculer le prix total ht
        $total_ht = $this->getTotalPrice($id_client)->fetch()['somme'];

        // calculer le prix total ttc
        $total_ttc = $total_ht * 1.2;
        // round ttc to 2 decimals
        $total_ttc = round($total_ttc, 2);

        $sql = "INSERT INTO facturation (id_client, date_creation, nom_client, prenom_client, email_client, produits, prix_total_HT, prix_total_TTC)" .
            "VALUES (" . $id_client . ",NOW(),'" . $client_informations['nom_client'] . "','" . $client_informations['prenom_client'] . "','"
            . $client_informations['email_client'] . "','" . $json . "'," . $total_ht . "," . $total_ttc . ");";

        return $this->connection->query($sql);
    }

    public function getTotalCart($id_client): bool|string
    {
        $carts = $this->getCarts($id_client);
        $json = [];
        foreach ($carts as $cart) {
            $product = $this->getProductByid($cart['id_produit'])->fetch();
            $json[] = [
                'reference_produit' => $product['reference_produit'],
                'quantite' => $cart['quantite'],
                'prix' => $cart['prix']
            ];
        }
        return json_encode($json);
    }

    public function getFacture($id_client): bool|PDOStatement
    {
        $this->__wakeup();
        //Get the most recent facture fromid_client and date
        $sql = "SELECT * FROM facturation WHERE id_client LIKE " . "'" . $id_client . "' ORDER BY date_creation DESC LIMIT 1;";
        return $this->connection->query($sql);
    }

    public function getTotalHT($facture): float|int
    {
        $this->__wakeup();
        $JSON = json_decode($facture['produits']);
        $total_ht = 0;
        foreach ($JSON as $product) {
            $total_ht += $product->prix * $product->quantite;
        }
        return $total_ht;
    }

    public function getAllSuppliers(): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM fournisseur;";
        return $this->connection->query($sql);
    }

    public function getAdminByClientId(string $id_client): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM admin WHERE id_client = " . $id_client . ";";
        return $this->connection->query($sql);
    }

    public function addAdmin(string $id_client): bool|PDOStatement
    {
        $this->__wakeup();
        $id_admin = $this->getAdminByClientId($id_client);
        // If the client is already an admin, return false
        $sql = "INSERT INTO admin (id_client) VALUES (" . $id_client . ") ON DUPLICATE KEY UPDATE id_client = " . $id_client . ";";
        if ($id_admin->rowCount() > 0) {
            $id = $id_admin->fetch()['id_admin'];
            $sql = "INSERT INTO admin (id_admin, id_client) VALUES (" . $id . "," . $id_client . ") ON DUPLICATE KEY UPDATE id_client = " . $id_client . ";";
        }
        return $this->connection->query($sql);
    }

    public function removeAdmin(string $id_client): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "DELETE FROM admin WHERE id_client = " . $id_client . ";";
        return $this->connection->query($sql);
    }

    function getAllData()
    {
        $this->__wakeup();
        // get all the json from facturation
        $factures = $this->getAllFacture()->fetchAll();
        $json = [];
        for ($i = 0; $i < count($factures); $i++) {
            $json[] = json_decode($factures[$i]['produits'], true);
        }

        $data = [];
        foreach ($json as $facture) {
            foreach ($facture as $product) {
                $data[] = $product;
            }
        }

        // delete all the duplicates and sum the quantities
        $data = array_reduce($data, function ($acc, $item) {
            $key = $item['reference_produit'];
            if (isset($acc[$key])) {
                $acc[$key]['quantite'] += $item['quantite'];
            } else {
                $acc[$key] = $item;
            }
            return $acc;
        }, []);

        return json_encode($data);
    }

    public function getTotalRevenueTTC()
    {
        $this->__wakeup();
        $sql = "SELECT ROUND(SUM(prix_total_TTC), 2) as somme FROM facturation;";
        return $this->connection->query($sql)->fetch()['somme'];
    }

    public function getTotalRevenueHT()
    {
        $this->__wakeup();
        $sql = "SELECT ROUND(SUM(prix_total_HT), 2) as somme FROM facturation;";
        return $this->connection->query($sql)->fetch()['somme'];
    }

    public function getTotalQuantity()
    {
        $this->__wakeup();
        $get_all_data = json_decode($this->getAllData(), true);
        $total_quantity = 0;
        foreach ($get_all_data as $product) {
            $total_quantity += $product['quantite'];
        }
        return $total_quantity;
    }

    public function getRevenueProduct($reference_product): float|int
    {
        $this->__wakeup();
        // get all data and sum the price of the product
        $get_all_data = json_decode($this->getAllData(), true);
        $total_price = 0;
        foreach ($get_all_data as $product) {
            if ($product['reference_produit'] == $reference_product) {
                $total_price += $product['prix'] * $product['quantite'];
            }
        }
        return $total_price;
    }


    public function getQuantityProduct($reference_produit)
    {
        $this->__wakeup();
        // get all data and sum the quantity of the product
        $get_all_data = json_decode($this->getAllData(), true);
        $total_quantity = 0;
        foreach ($get_all_data as $product) {
            if ($product['reference_produit'] == $reference_produit) {
                $total_quantity += $product['quantite'];
            }
        }
        return $total_quantity;
    }


    public function getFactureByDate($date): bool|PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM facturation WHERE date_creation LIKE " . "'" . $date . "';";
        return $this->connection->query($sql);
    }

    public function getBoughtPrice($reference_product): float|int
    {
        $this->__wakeup();
        $sql = "SELECT prix_achat_produit FROM produit WHERE reference_produit LIKE " . "'" . $reference_product . "';";
        return $this->connection->query($sql)->fetch()['prix_achat'];
    }

    public function getAllTotalBoughtProduct(): float|int
    {
        $this->__wakeup();
        $get_all_data = json_decode($this->getAllData(), true);
        $total_bought_price = 0;
        foreach ($get_all_data as $product) {
            $total_bought_price += $this->getBoughtPrice($product['reference_produit']) * $product['quantite'];
        }
        return $total_bought_price;
    }

    public function getRevenueByDate($date): float|int
    {
        $this->__wakeup();
        $sql = "SELECT ROUND(SUM(prix_total_TTC), 2) as somme FROM facturation WHERE date_creation LIKE " . "'" . $date . "';";
        return $this->connection->query($sql)->fetch()['somme'];
    }

    public function getPurshasingPriceForEachMonth(): array
    {
        $this->__wakeup();
        $sql = "SELECT MONTH(date_commande) AS month, ROUND(SUM(cout), 2) AS total_cost FROM Commande_produit WHERE YEAR(date_commande) = YEAR(NOW()) GROUP BY MONTH(date_commande)";
        $purchases = [];
        foreach ($this->connection->query($sql)->fetchAll() as $purchase) {
            $purchases[$purchase['month']] = $purchase['total_cost'];
        }
        return $purchases;
    }

    public function getSalesPriceForEachMonth(): array
    {
        $this->__wakeup();
        // Select from the current year
        $sql = "SELECT MONTH(date_creation) AS month, ROUND(SUM(prix_total_TTC), 2) AS total_sales FROM facturation WHERE YEAR(date_creation) = YEAR(NOW()) GROUP BY MONTH(date_creation)";
        $sales = [];
        foreach ($this->connection->query($sql)->fetchAll() as $sale) {
            $sales[$sale['month']] = $sale['total_sales'];
        }
        return $sales;
    }

    public function getProfit(): float
    {
        $this->__wakeup();
        $purchases = $this->getPurshasingPriceForEachMonth();
        $sales = $this->getSalesPriceForEachMonth();
        $profit = 0;
        // get the profit for all the year
        for ($i = 1; $i <= 12; $i++) {
            if (isset($purchases[$i]) && isset($sales[$i])) {
                $profit += $sales[$i] - $purchases[$i];
            } else if (isset($purchases[$i])) {
                $profit -= $purchases[$i];
            } else if (isset($sales[$i])) {
                $profit += $sales[$i];
            }
        }
        return $profit;
    }
}

