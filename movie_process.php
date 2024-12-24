<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);
    $userDAO = new UserDAO($conn, $BASE_URL);
    $movieDAO = new MovieDAO($conn, $BASE_URL);

    // Verifica o tipo do formulário
    $type = filter_input(INPUT_POST, "type");

    // Resgata dados do usuário
    $userData = $userDAO->verifyToken();

    if($type === "create") {

        // Receber dados dos inputs
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");

        $movie = new Movie();

        // Validação mínima de dados
        if(!empty($title) && !empty($length) && !empty($category)) {

            $movie->title = $title;
            $movie->description = $description;
            $movie->trailer = $trailer;
            $movie->category = $category;
            $movie->length = $length;
            $movie->users_id = $userData->id;

            // Upload de imagem do filme
            if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                $image = $_FILES["image"];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                $jpgArray = ["image/jpeg", "image/jpg"];
    
                // Checagem do tipo de imagem
                if(in_array($image["type"], $imageTypes)) {
    
                    // Checar se jpg
                    if(in_array($image["type"], $jpgArray)) {
    
                        $imageFile = imagecreatefromjpeg($image["tmp_name"]);
    
                    } else {
    
                        // Imagem é png
                        $imageFile = imagecreatefrompng($image["tmp_name"]);
    
                    }
    
                    $imageName = $movie->imageGenerateName();
    
                    imagejpeg($imageFile, "./img/movies/" . $imageName, 100);
    
                    $movie->image = $imageName;
    
                } else {
    
                    $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
    
                }

            }

        } else {

            $message->setMessage("Você precisa adicionar pelo menos: título, descrição e categoria!", "error", "back");

        }

        $movieDAO->create($movie);

    } else if($type === "delete") {

        // Recebe dados do form
        $id = filter_input(INPUT_POST, "id");

        $movie = $movieDAO->findById($id);

        if($movie) {

            // Verificar se o filme é do usuário
            if($movie->users_id === $userData->id) {

                $movieDAO->destroy($movie->id);
                
            } else {

                $message->setMessage("Informações inválidas!", "error", "index.php");

            }

        } else {

            $message->setMessage("Informações inválidas!", "error", "index.php");

        }

    } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");

    }

?>