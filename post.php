<?php

    require_once('functions.php');
    require_once('./config/db.php');

    header('Content-Type: application/json; charset=utf-8');
    $name = @$_POST['name'];
    $email = @$_POST['email'];
    $file = @$_FILES['file'];
    $errors = [];

    if (empty($name)) {
        array_push($errors, "Nama tidak boleh kosong");
    }

    if (empty($email)) {
        array_push($errors, "Email tidak boleh kosong");
    }


    $query = "SELECT COUNT(*) FROM users WHERE email = :email";
    $sql = $connection->prepare($query);
    $sql->bindParam(":email", $email, PDO::PARAM_STR);
    $sql->execute();

    if ($sql->fetchColumn() > 0) {
        array_push($errors, "Email sudah digunakan");
    }

    if (empty($file)) {
        array_push($errors, "File tidak boleh kosong");
    }

    if (count($errors) > 0) {
        echo json_encode(array(
            "success" => False,
            "message" => "Gagal menyimpan data",
            "errors" => $errors
        ));
        exit();
    }
    
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = './uploads/' . generateRandomString() . '.' . $ext;

    $uploaded = move_uploaded_file($file['tmp_name'], $filename);

    if (!$uploaded) {
        echo json_encode(array(
            "success" => False,
            "message" => "Gagal menyimpan data",
            "errors" => ['Gagal mengupload file']
        ));
        exit();
    }


    $query = "INSERT INTO users (name, email, photo) VALUES (:name, :email, :photo)";
    $sql = $connection->prepare($query);
    $sql->bindParam(":name", $name, PDO::PARAM_STR);
    $sql->bindParam(":email", $email, PDO::PARAM_STR);
    $sql->bindParam(":photo", $filename, PDO::PARAM_STR);
    if (!$sql->execute()) {
        echo json_encode(array(
            "success" => False,
            "message" => "Gagal menyimpan data",
            "errors" => ['Gagal myimpan ke database']
        ));
        exit();
    }

    echo json_encode(array(
        "success" => True,
        "message" => "berhasil menyimpan data",
        "errors" => []
    ));
?>