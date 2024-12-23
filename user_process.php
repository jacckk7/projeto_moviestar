<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $userDAO = new UserDAO($conn, $BASE_URL);

    // Verifica o tipo do formulário
    $type = filter_input(INPUT_POST, "type");

    // Atualizar usuário
    if($type === "update") {

        // Resgata dados do usuário
        $userData = $userDAO->verifyToken();

        // Receber dados do post
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");

        // Preencher os dados do usuário
        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->email = $email;
        $userData->bio = $bio;

        // Upload da imagem
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            // Checagem do tipo de imagem
            if(in_array($image["type"], $imageTypes)) {

                // Checar se jpg
                if(in_array($image, $jpgArray)) {

                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                } else {

                    // Imagem é png
                    $imageFile = imagecreatefrompng($image["tmp_name"]);

                }

                $imageName = $userData->imageGenerateName();

                imagejpeg($imageFile, "./img/users/" . $imageName, 100);

                $userData->image = $imageName;

            } else {

                $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");

            }

        }

        $userDAO->update($userData);

    } else if($type === "changepassword") {

        // Atualizar senha do usuário

    } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");

    }

?>