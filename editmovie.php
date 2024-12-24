<?php

    require_once("templates/header.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    // Verifica se usuário está autenticado

    $userDAO = new UserDAO($conn, $BASE_URL);
    $movieDAO = new MovieDAO($conn, $BASE_URL);
    
    $user = new User();

    $userData = $userDAO->verifyToken(true);

    // Pegar id do filme
    $id = filter_input(INPUT_GET, "id");

    if(empty($id)) {

        $message->setMessage("O filme não foi encontrado!", "error", "index.php");

    } else {

        $movie = $movieDAO->findById($id);

        // Verifica se o filme existe
        if(!$movie) {

            $message->setMessage("O filme não foi encontrado!", "error", "index.php");

        }

    }

    // Checar se o filme tem imagem
    if($movie->image == "") {

        $movie->image = "movie_cover.jpg";

    }

?>

    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 offset-md-1">
                    <h1><?= $movie->title ?></h1>
                    <p class="page-description">Altere os dados do filme no formulário abaixo:</p>
                    <form id="edit-movie-form" action="<?= $BASE_URL ?>movie_process.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="update">
                        <input type="hidden" name="id" value="<?= $movie->id ?>">
                        <div class="mb-3">
                            <label for="title" class="form-label">Título:</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do seu filme" value="<?= $movie->title ?>">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagem:</label>
                            <input type="file" class="form-control" name="image" id="image">
                        </div>
                        <div class="mb-3">
                            <label for="length" class="form-label">Duração:</label>
                            <input type="text" class="form-control" id="length" name="length" placeholder="Digite a duração filme" value="<?= $movie->length ?>">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoria:</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">Selecione</option>
                                <option value="Ação" <?= $movie->category === "Ação" ? "selected" : "" ?>>Ação</option>
                                <option value="Drama" <?= $movie->category === "Drama" ? "selected" : "" ?>>Drama</option>
                                <option value="Comédia" <?= $movie->category === "Comédia" ? "selected" : "" ?>>Comédia</option>
                                <option value="Fantasias / Ficção" <?= $movie->category === "Fantasias / Ficção" ? "selected" : "" ?>>Fantasias / Ficção</option>
                                <option value="Romance" <?= $movie->category === "Romance" ? "selected" : "" ?>>Romance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="trailer" class="form-label">Trailer:</label>
                            <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer" value="<?= $movie->trailer ?>">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição:</label>
                            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme..."><?= $movie->description ?></textarea>
                        </div>
                        <input type="submit" class="btn card-btn" value="Editar Filme">
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>/img/movies/<?= $movie->image ?>')"></div>
                </div>
            </div>
        </div>
    </div>

<?php

    require_once("templates/footer.php");

?>