<?php
require_once __DIR__ . '/../Config/Database.php';

class ProductModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM produk ORDER BY id DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM produk WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function deleteProduct($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM produk WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function createProduct($data)
    {
        $sql = "INSERT INTO produk (nama_produk, harga, stok, deskripsi, gambar) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdiss", $data['nama_produk'], $data['harga'], $data['stok'], $data['deskripsi'], $data['gambar']);
        return $stmt->execute();
    }

    public function updateProduct($id, $data)
    {
        $sql = "UPDATE produk SET nama_produk=?, harga=?, stok=?, deskripsi=?";
        $params = [$data['nama_produk'], $data['harga'], $data['stok'], $data['deskripsi']];
        $types = "sdis";

        if (isset($data['gambar']) && $data['gambar'] !== null) {
            $sql .= ", gambar=?";
            $params[] = $data['gambar'];
            $types .= "s";
        }

        $sql .= " WHERE id=?";
        $params[] = $id;
        $types .= "i";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }
}
