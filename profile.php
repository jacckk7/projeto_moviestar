<?php

    require_once("templates/header.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    // Verifica se usuário está autenticado

    $userDAO = new UserDAO($conn, $BASE_URL);
    $movieDAO = new MovieDAO($conn, $BASE_URL);
    
    $user = new User();

    // Pegar id do usuário
    $id = filter_input(INPUT_GET, "id");

    if(empty($id)) {

        if(!empty($userData)) {

            $id = $userData->id;

        } else {

            $message->setMessage("Usuário não encontrado!", "error", "index.php");

        }

    } else {

        $userData = $userDAO->findById($id);

        // Se não encontrar usuário
        if(!$userData) {

            $message->setMessage("Usuário não encontrado!", "error", "index.php");

        }

    }

    $fullName = $user->getFullName($userData);

    if($userData->image == "") {
        $userData->image = "user.png";
    }

    // Filmes que o usuário adicionou
    $userMovies = $movieDAO->getMoviesByUserId($id);

?>

    <div id="main-container" class="container-fluid">
        <div class="col-md-8 offset-md-2">
            <div class="row profile-container">
                <div class="col-md-12">
                    <h1 class="page-title"><?= $fullName ?></h1>
                    <div id="profile-image-container"  style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                    <h3 class="about-title">Sobre:</h3>
                    <?php if(!empty($userData->bio)): ?>
                        <p class="profile-description"><?= $userData->bio ?></p>
                    <?php else: ?>
                        <p class="profile-description">O usuário ainda não escreveu nada aqui...</p>
                    <?php endif; ?>
                </div>
                <div class="col-md-12 added-movies-container">
                    <h3>Filmes que enviou:</h3>
                    <?php if(count($userMovies) === 0): ?>
                        <p class="empty-list">O usuário ainda não enviou filmes.</p>
                    <?php else: ?>
                        <?php foreach($userMovies as $movie): ?>
                            <?php require("templates/movie_card.php"); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php

    require_once("templates/footer.php");

?>