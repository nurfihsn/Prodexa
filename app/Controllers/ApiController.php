<?php
require_once __DIR__ . '/../Models/ProductModel.php';
require_once __DIR__ . '/../Services/UploadService.php';

class ApiController
{
    private $model;
    private $uploadService;

    public function __construct()
    {
        $this->model = new ProductModel();
        $this->uploadService = new UploadService();
    }

    public function handleRequest($action)
    {
        header('Content-Type: application/json');

        switch ($action) {
            case 'get_one':
                $this->getOne();
                break;
            case 'delete':
                $this->delete();
                break;
            case 'save':
                $this->save();
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        }
    }

    private function getOne()
    {
        $id = (int)($_GET['id'] ?? 0);
        $result = $this->model->getProductById($id);

        if ($result) echo json_encode(['status' => 'success', 'data' => $result]);
        else echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
    }

    private function save()
    {
        $id = $_POST['id'] ?? null;
        $data = [
            'nama_produk' => $_POST['nama_produk'],
            'harga' => str_replace('.', '', $_POST['harga']),
            'stok' => $_POST['stok'],
            'deskripsi' => $_POST['deskripsi'],
            'gambar' => null
        ];

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $data['gambar'] = $this->uploadService->handleImageUpload($_FILES['gambar']);
            if (!$data['gambar']) {
                echo json_encode(['status' => 'error', 'message' => 'Gagal upload gambar.']);
                return;
            }
        }

        if (!empty($id)) {
            if ($data['gambar']) {
                $oldData = $this->model->getProductById($id);
                $this->uploadService->deleteImage($oldData['gambar']);
            }
            $success = $this->model->updateProduct($id, $data);
        } else {
            $success = $this->model->createProduct($data);
        }

        echo json_encode(['status' => $success ? 'success' : 'error']);
    }

    private function delete()
    {
        $id = (int)($_POST['id'] ?? 0);
        $product = $this->model->getProductById($id);

        if ($this->model->deleteProduct($id)) {
            $this->uploadService->deleteImage($product['gambar']);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus database']);
        }
    }
}
