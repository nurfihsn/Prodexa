<?php

require_once __DIR__ . '/../app/Models/ProductModel.php';

$model = new ProductModel();
$products = $model->getAllProducts();

$total_asset = 0;
$low_stock = 0;
foreach ($products as $row) {
    $total_asset += ($row['harga'] * $row['stok']);
    if ($row['stok'] <= 5) $low_stock++;
}

require_once __DIR__ . '/../app/Views/pages/dashboard.php';
