<?php

class bdd
{
    private $pdo;

    public function __construct()
    {
        $this->initPDO();
    }

    private function initPDO()
    {
        if (!$this->pdo) {
            try {
                $this->pdo = new PDO('mysql:host=localhost;dbname=Projet-Web', 'root', '');
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function getProducts()
    {
        $sql = 'SELECT * FROM produit;';
        return $this->pdo->query($sql);
    }

    public function getProductReference($reference)
    {
        $sql = "SELECT * FROM produit WHERE reference_produit LIKE "."'" .  $reference . "';";
        return $this->pdo->query($sql);
    }

}

