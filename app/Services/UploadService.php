<?php
class UploadService
{
    private $uploadDir;

    public function __construct()
    {
        $this->uploadDir = __DIR__ . '/../../public/uploads/';
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function handleImageUpload($file)
    {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed) || $file['size'] > 5 * 1024 * 1024) {
            return false;
        }

        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $safeName = preg_replace('/[^a-zA-Z0-9 \-_]/', '', $originalName);
        $safeName = substr($safeName, 0, 50);
        $filename = time() . '_' . $safeName . '.' . $ext;

        if (move_uploaded_file($file['tmp_name'], $this->uploadDir . $filename)) {
            return $filename;
        }

        return false;
    }

    public function deleteImage($filename)
    {
        if ($filename && file_exists($this->uploadDir . $filename)) {
            unlink($this->uploadDir . $filename);
        }
    }
}
