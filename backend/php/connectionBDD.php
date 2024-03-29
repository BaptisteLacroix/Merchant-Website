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

    public function addNewProduct(string $img, string $fournisseur, string $reference, string $status, string $marque,
                                  string $type, string $aspect, string $taille, string $couleur, string $publicPrice,
                                  string $boughtPrice, string $titre, string $descriptif, string $quantite): PDOStatement
    {
        $this->__wakeup();
        $sql = "INSERT INTO produit (id_fournisseur, image, reference_produit, status, marque_produit, type_produit,
aspect_produit, taille_produit, couleur_produit, prix_public_produit, prix_achat_produit,
titre_produit, descriptif_produit, quantite_produit) VALUES (:fournisseur, :img, :reference, :status, :marque, :type, :aspect, :taille, :couleur, :publicPrice, :boughtPrice, :titre, :descriptif, :quantite)";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':fournisseur' => $fournisseur, ':img' => $img, ':reference' => $reference, ':status' => $status, ':marque' => $marque, ':type' => $type, ':aspect' => $aspect, ':taille' => $taille, ':couleur' => $couleur, ':publicPrice' => $publicPrice, ':boughtPrice' => $boughtPrice, ':titre' => $titre, ':descriptif' => $descriptif, ':quantite' => $quantite]);
        return $sth;
    }

    public function getProducts(): PDOStatement
    {
        $this->__wakeup();
        $sql = 'SELECT * FROM produit';
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        return $sth;
    }

    public function searchProduct(string $search): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM produit WHERE titre_produit LIKE :search OR reference_produit LIKE :search OR marque_produit LIKE :search OR type_produit LIKE :search OR aspect_produit LIKE :search OR taille_produit LIKE :search OR couleur_produit LIKE :search OR descriptif_produit LIKE :search";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':search' => '%' . $search . '%']);
        return $sth;
    }

    public function getProductByid(string $id_product): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM produit WHERE id_produit = :id_product";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_product' => $id_product]);
        return $sth;
    }

    public function getProductByReference(string $reference): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM produit WHERE reference_produit = :reference";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':reference' => $reference]);
        return $sth;
    }

    public function deleteProductById(string $id_produit): PDOStatement
    {
        $this->__wakeup();
        $sql = "DELETE FROM produit WHERE id_produit = :id_produit";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_produit' => $id_produit]);
        return $sth;
    }


    public function updateProductStocksByReference(string $reference_produit, string $new_quantity): PDOStatement
    {
        $this->__wakeup();
        $sql = "UPDATE produit SET quantite_produit = :new_quantity WHERE reference_produit = :reference_produit";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':new_quantity' => $new_quantity, ':reference_produit' => $reference_produit]);
        return $sth;
    }


    public function addNewClient(string $prenom, string $nom, string $email, string $password): PDOStatement
    {
        $this->__wakeup();
        $sql = "INSERT INTO client (prenom_client, nom_client, email_client, password_client) VALUES (:prenom, :nom, :email, :password)";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':prenom' => $prenom, ':nom' => $nom, ':email' => $email, ':password' => $password]);
        return $sth;
    }


    public function addNewClientAllValues(string $prenom, string $nom, string $email, string $password, string $address, string $postalCode, string $city, string $country, string $phone): PDOStatement
    {
        $this->__wakeup();
        $sql = "INSERT INTO client (prenom_client, nom_client, email_client, password_client, adresse_client, code_postal_client, ville_client, pays_client, telephone_client) VALUES (:prenom, :nom, :email, :password, :address, :postalCode, :city, :country, :phone)";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':prenom' => $prenom, ':nom' => $nom, ':email' => $email, ':password' => $password, ':address' => $address, ':postalCode' => $postalCode, ':city' => $city, ':country' => $country, ':phone' => $phone]);
        return $sth;
    }


    public function getClientById($id_client): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM client WHERE id_client = :id_client";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_client' => $id_client]);
        return $sth;
    }


    public function getAllClient(): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM client";
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        return $sth;
    }


    public function getClient(string $email): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM client WHERE email_client = :email";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':email' => $email]);
        return $sth;
    }


    public function searchClient(string $search): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM client WHERE email_client LIKE :search OR prenom_client LIKE :search OR nom_client LIKE :search OR adresse_client LIKE :search OR code_postal_client LIKE :search OR ville_client LIKE :search OR pays_client LIKE :search OR telephone_client LIKE :search";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':search' => '%' . $search . '%']);
        return $sth;
    }


    public function deleteCartClient(string $id_client): PDOStatement
    {
        $this->__wakeup();
        $sql = "DELETE FROM panier WHERE id_client = :id_client";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_client' => $id_client]);
        return $sth;
    }


    public function updateClient(string $id_client, string $lastname, string $firstname, string $email,
                                 string $mobilephone, string $address, string $postalCode, string $city, string $country): PDOStatement
    {
        $this->__wakeup();
        $sql = "UPDATE client SET nom_client = :lastname, prenom_client = :firstname, email_client = :email, telephone_client = :mobilephone, adresse_client = :address, code_postal_client = :postalCode, ville_client = :city, pays_client = :country WHERE id_client = :id_client";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':lastname' => $lastname, ':firstname' => $firstname, ':email' => $email, ':mobilephone' => $mobilephone, ':address' => $address, ':postalCode' => $postalCode, ':city' => $city, ':country' => $country, ':id_client' => $id_client]);
        return $sth;
    }


    public function deleteClientById($id_client): PDOStatement
    {
        $this->__wakeup();
        $sql = "DELETE FROM client WHERE id_client = :id_client";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_client' => $id_client]);
        return $sth;
    }


    public function addToCart(string $id_client, string $ref_produit, string $quantite, string $prix): PDOStatement
    {
        $this->__wakeup();
        $id_produit = $this->getProductByReference($ref_produit)->fetch()['id_produit'];
        $sql = "INSERT INTO panier(id_client, id_produit, quantite, prix) VALUES (:id_client, :id_produit, :quantite, :prix)";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_client' => $id_client, ':id_produit' => $id_produit, ':quantite' => $quantite, ':prix' => $prix]);
        return $sth;
    }


    public function getCarts(string $id_client): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM panier WHERE id_client = :id_client";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_client' => $id_client]);
        return $sth;
    }


    public function getCart(string $id_panier): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM panier WHERE id_panier = :id_panier";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id_panier' => $id_panier]);
        return $stmt;
    }


    public function getProductsFromCart(string $id_client): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM produit INNER JOIN panier ON produit.id_produit = panier.id_produit WHERE id_client = :id_client";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id_client' => $id_client]);
        return $stmt;
    }


    public function deleteFromCart(string $id_panier): PDOStatement
    {
        $this->__wakeup();
        $sql = "DELETE FROM panier WHERE id_panier = :id_panier";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id_panier' => $id_panier]);
        return $stmt;
    }


    public function updateQuantityCart(string $id_panier, int $newValue): PDOStatement
    {
        $this->__wakeup();
        $sql = "UPDATE panier SET quantite = quantite + :quantite WHERE id_panier = :id_panier";
        $sth = $this->connection->prepare($sql);
        $sth->execute(['quantite' => $newValue, 'id_panier' => $id_panier]);
        return $sth;
    }

    public function getTotalPrice(string $id_client): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT ROUND(SUM(prix*quantite), 2) as somme FROM panier WHERE id_client = :id_client";
        $sth = $this->connection->prepare($sql);
        $sth->execute(['id_client' => $id_client]);
        return $sth;
    }

    public function getAllFacture(): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM facturation";
        $sth = $this->connection->query($sql);
        return $sth;
    }

    public function insertNewFacture(string $email_client): PDOStatement
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
            "VALUES (:id_client, NOW(), :nom_client, :prenom_client, :email_client, :produits, :prix_total_HT, :prix_total_TTC)";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_client' => $id_client, ':nom_client' => $client_informations['nom_client'], ':prenom_client' => $client_informations['prenom_client'], ':email_client' => $client_informations['email_client'], ':produits' => $json, ':prix_total_HT' => $total_ht, ':prix_total_TTC' => $total_ttc]);
        return $sth;
    }

    public function getTotalCart(string $id_client): string
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

    public function getFacture(string $id_client): PDOStatement
    {
        $this->__wakeup();
        //Get the most recent facture fromid_client and date
        $sql = "SELECT * FROM facturation WHERE id_client = :id_client ORDER BY date_creation DESC LIMIT 1";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_client' => $id_client]);
        return $sth;
    }

    public function getTotalHT(string $facture): float
    {
        $JSON = json_decode($facture['produits']);
        $total_ht = 0;
        foreach ($JSON as $product) {
            $total_ht += $product->prix * $product->quantite;
        }
        return $total_ht;
    }

    public function getAllSuppliers(): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM fournisseur";
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        return $sth;
    }

    public function searchSupplier(string $search): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM fournisseur WHERE nom_fournisseur LIKE :search OR adresse_fournisseur LIKE :search OR code_postal_fournisseur LIKE :search OR ville_fournisseur LIKE :search OR pays_fournisseur LIKE :search OR telephone_fournisseur LIKE :search OR email_fournisseur LIKE :search";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':search' => '%' . $search . '%']);
        return $sth;
    }


    public function getSupplierById(string $id_fournisseur): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM fournisseur WHERE id_fournisseur = :id_fournisseur";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_fournisseur' => $id_fournisseur]);
        return $sth;
    }


    public function getAdminByClientId(string $id_client): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM admin WHERE id_client = :id_client";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_client' => $id_client]);
        return $sth;
    }

    /*
        public function addAdmin(string $id_client): PDOStatement
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
    */

    public function addAdmin(string $id_client): PDOStatement
    {
        $this->__wakeup();
        $id_admin = $this->getAdminByClientId($id_client);
        // If the client is already an admin, return false
        if ($id_admin->rowCount() > 0) {
            return false;
        }
        $sql = "INSERT INTO admin (id_client) VALUES (:id_client)";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_client' => $id_client]);
        return $sth;
    }


    public function removeAdmin(string $id_client): PDOStatement
    {
        $this->__wakeup();
        $sql = "DELETE FROM admin WHERE id_client = :id_client";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_client' => $id_client]);
        return $sth;
    }


    function getAllData(bool $getByYear = false): string
    {
        // get all the json from facturation
        $factures = $this->getAllFacture()->fetchAll();
        $json = [];
        for ($i = 0; $i < count($factures); $i++) {
            if ($getByYear && str_contains($factures[$i]['date_creation'], date("Y")))
                $json[] = json_decode($factures[$i]['produits'], true);
            else if (!$getByYear)
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
        $sql = "SELECT ROUND(SUM(prix_total_TTC), 2) as somme FROM facturation";
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        return $sth->fetch()['somme'];
    }


    public function getTotalRevenueTTCByYears()
    {
        $this->__wakeup();
        $sql = "SELECT ROUND(SUM(prix_total_TTC), 2) as somme FROM facturation WHERE YEAR(date_creation) = YEAR(NOW());";
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        $total = $sth->fetch()['somme'];
        if ($total == null)
            return 0;
        return $total;
    }


    public function getTotalRevenueHT()
    {
        $this->__wakeup();
        $sql = "SELECT ROUND(SUM(prix_total_HT), 2) as somme FROM facturation";
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        return $sth->fetch()['somme'];
    }


    public function getRevenueProduct(string $reference_product, bool $checkThisYear): float
    {
        // get all data and sum the price of the product
        $get_all_data = json_decode($this->getAllData($checkThisYear), true);
        $total_price = 0;
        foreach ($get_all_data as $product) {
            if ($product['reference_produit'] == $reference_product) {
                $total_price += $product['prix'] * $product['quantite'];
            }
        }
        return $total_price;
    }


    public function getQuantityProduct(string $reference_produit, bool $checkThisYear): float
    {
        // get all data and sum the quantity of the product
        $get_all_data = json_decode($this->getAllData($checkThisYear), true);
        $total_quantity = 0;
        foreach ($get_all_data as $product) {
            if ($product['reference_produit'] == $reference_produit) {
                $total_quantity += $product['quantite'];
            }
        }
        return $total_quantity;
    }

    public function getFactureByDate(string $date): PDOStatement
    {
        $this->__wakeup();
        $sql = "SELECT * FROM facturation WHERE date_creation LIKE :date";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':date' => $date]);
        return $sth;
    }


    public function getBoughtPrice(string $reference_product): float
    {
        $this->__wakeup();
        $sql = "SELECT prix_achat_produit FROM produit WHERE reference_produit = :reference_product";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':reference_product' => $reference_product]);
        return $sth->fetch()['prix_achat_produit'];
    }


    public function getAllTotalBoughtProduct(): float|int
    {
        $get_all_data = json_decode($this->getAllData(), true);
        $total_bought_price = 0;
        foreach ($get_all_data as $product) {
            $total_bought_price += $this->getBoughtPrice($product['reference_produit']) * $product['quantite'];
        }
        return $total_bought_price;
    }

    public function getRevenueByDate(string $date): float
    {
        $this->__wakeup();
        $sql = "SELECT ROUND(SUM(prix_total_TTC), 2) as somme FROM facturation WHERE date_creation = :date";
        $sth = $this->connection->prepare($sql);
        $sth->execute(['date' => $date]);
        return $sth->fetch()['somme'];
    }

    public function getPurshasingPriceForEachMonth(): array
    {
        $this->__wakeup();
        $sql = "SELECT MONTH(date_commande) AS month, ROUND(SUM(cout), 2) AS total_cost FROM commande_produit WHERE YEAR(date_commande) = YEAR(NOW()) GROUP BY MONTH(date_commande)";
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        $purchases = [];
        foreach ($sth->fetchAll() as $purchase) {
            $purchases[$purchase['month']] = $purchase['total_cost'];
        }
        return $purchases;
    }

    public function getSalesPriceForEachMonth(): array
    {
        $this->__wakeup();
        $sql = "SELECT MONTH(date_creation) AS month, ROUND(SUM(prix_total_TTC), 2) AS total_sales FROM facturation WHERE YEAR(date_creation) = YEAR(NOW()) GROUP BY MONTH(date_creation)";
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        $sales = $sth->fetchAll();
        $result = array();
        foreach($sales as $sale){
            $result[$sale['month']] = $sale['total_sales'];
        }
        return $result;

    }

    public function getProfit(): float
    {
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

    public function getStatusByRef(string $reference_produit): bool
    {
        $this->__wakeup();
        $sql = "SELECT status FROM produit WHERE reference_produit = :reference";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':reference' => $reference_produit]);
        return $sth->fetch()['status'];
    }


    public function updateStatus(string $reference_produit): PDOStatement
    {
        $this->__wakeup();
        $status = !$this->getStatusByRef($reference_produit);
        $sql = "UPDATE produit SET status = :status WHERE reference_produit = :reference_produit";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':status' => $status, ':reference_produit' => $reference_produit]);
        return $sth;
    }

    public function addNewCommandeProduit(string $reference, string $stocks, string $boughtPrice): PDOStatement
    {
        $this->__wakeup();
        $product = $this->getProductByReference($reference)->fetch();
        $sql = "INSERT INTO commande_produit (id_produit, quantite, cout) VALUES (:id_produit, :quantite, :cout)";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_produit' => $product['id_produit'], ':quantite' => $stocks, ':cout' => $boughtPrice * $stocks]);
        return $sth;
    }

    public function deleteSupplierById($id_supplier): PDOStatement
    {
        $this->__wakeup();
        $sql = "DELETE FROM fournisseur WHERE id_fournisseur = :id_supplier";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':id_supplier' => $id_supplier]);
        return $sth;
    }


    public function addNewSupplier($name, $address, $postalCode, $city, $country, $phone, $email): PDOStatement
    {
        $this->__wakeup();
        $sql = "INSERT INTO fournisseur (nom_fournisseur, adresse_fournisseur, code_postal_fournisseur, ville_fournisseur, pays_fournisseur, telephone_fournisseur, email_fournisseur) VALUES (:name, :address, :postalCode, :city, :country, :phone, :email)";
        $sth = $this->connection->prepare($sql);
        $sth->execute([':name' => $name, ':address' => $address, ':postalCode' => $postalCode, ':city' => $city, ':country' => $country, ':phone' => $phone, ':email' => $email]);
        return $sth;
    }

    public function updateImage(string $imgContent, string $reference): bool
    {
        $this->__wakeup();
        $sql = "UPDATE produit SET image = :imgContent WHERE reference_produit = :reference";
        $sth = $this->connection->prepare($sql);
        return $sth->execute([':imgContent' => $imgContent, ':reference' => $reference]);
    }


    public function resetPassword(string $email, string $password): bool
    {
        $this->__wakeup();
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE client SET password_client = :password WHERE email_client = :email";
        $sth = $this->connection->prepare($sql);
        return $sth->execute([':password' => $password, ':email' => $email]);
    }

    public function getTotalQuantity(bool $checkThisYear): int
    {
        $get_all_data = json_decode($this->getAllData($checkThisYear), true);
        $total_quantity = 0;
        foreach ($get_all_data as $product) {
            $total_quantity += $product['quantite'];
        }
        return $total_quantity;
    }

    public function checkStocksStatus(): bool
    {
        $this->__wakeup();
        $sql = "SELECT * FROM produit WHERE quantite_produit <= 3";
        $sth = $this->connection->prepare($sql);
        $sth->execute();
        return $sth->rowCount() > 0;
    }
}

