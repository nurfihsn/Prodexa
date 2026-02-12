<?php

class Database
{
    private $conn;

    private function loadEnv($filePath)
    {
        $env = [];
        if (file_exists($filePath)) {
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || strpos($line, '#') === 0) continue;
                [$key, $value] = explode('=', $line, 2);
                $env[trim($key)] = trim($value);
            }
        }
        return $env;
    }

    public function __construct()
    {
        $env = $this->loadEnv(__DIR__ . '/../../.env');

        $host     = $env['DB_HOST'] ?? '127.0.0.1';
        $port     = $env['DB_PORT'] ?? 3306;
        $username = $env['DB_USERNAME'] ?? 'root';
        $password = $env['DB_PASSWORD'] ?? '';
        $database = $env['DB_DATABASE'] ?? 'admin_produk';

        $this->conn = mysqli_connect($host, $username, $password, $database, $port);

        if (!$this->conn) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }

        mysqli_set_charset($this->conn, "utf8");
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
