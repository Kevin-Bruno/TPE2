<?php

class ProductsModel{
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=lubricentro;charset=utf8', 'root', '');
    }

    public function getAll() {
        $query = $this->db->prepare("SELECT * FROM products");
        $query->execute();

        // 3. obtengo los resultados
        $products = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $products;
    }

    public function get($id) {
        $query = $this->db->prepare("SELECT * FROM products WHERE ID_Products = ?");
        $query->execute([$id]);
        $product = $query->fetch(PDO::FETCH_OBJ);
        
        return $product;
    }
    public function orderASC(){
        $query = $this->db->prepare("SELECT * FROM products ORDER BY price ASC");
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }
    public function orderDESC(){
        $query = $this->db->prepare("SELECT * FROM products ORDER BY price DESC");
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    function insert($name, $details, $price,$id){
        $query = $this->db->prepare('INSERT INTO products ( name, details , price,ID_Category_FK) VALUES (?,?,?,?)');
        $query->execute([$name,$details, $price,$id]);
        return $this->db->lastInsertId();
    }

    function delete($id) {
        $query = $this->db->prepare('DELETE FROM products WHERE ID_Products = ?');
        $query->execute([$id]);
    }

    function update($name,$details,$price,$category,$id){
        $query = $this->db->prepare('UPDATE products SET name =?, details =?,price=?, ID_Category_FK = ? WHERE ID_Products=?');
        $query->execute([$name,$details,$price,$category,$id]);
    }



}