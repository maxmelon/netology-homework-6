<?php

$uploadDir = "uploads/";
$uploadFile = $uploadDir . basename($_FILES["testJson"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($uploadFile, PATHINFO_EXTENSION);

if (!file_exists($uploadDir) || (file_exists($uploadDir) && !is_dir($uploadDir))) {
    mkdir($uploadDir);
}

if (move_uploaded_file($_FILES['testJson']['tmp_name'], $uploadFile)) {
    echo 'Файл успешно загружен! Просмотреть ' . '<a href="list.php">список тестов</a>' . ".\n";
} else {
echo "Не удалось переместить файл в директорию на сервере\n";
}

