<?php

    require_once("templates/header.php");
    require_once("dao/UserDAO.php");

    // Verifica se usuário está autenticado

    $user = new User();
    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

?>

    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 new-movie-container">
            <h1 class="page-title">Adicionar Filme</h1>
            <p class="page-description">Adicione sua crítica e compartilhe com o mundo!"</p>
            <form action="<?= $BASE_URL ?>movie_process.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="type" value="create">
                <div class="mb-3">
                    <label for="title" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do seu filme">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Imagem:</label>
                    <input type="file" class="form-control" name="image" id="image">
                </div>
                <div class="mb-3">
                    <label for="length" class="form-label">Duração:</label>
                    <input type="text" class="form-control" id="length" name="length" placeholder="Digite a duração filme">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Categoria:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Selecione</option>
                        <option value="Ação">Ação</option>
                        <option value="Drama">Drama</option>
                        <option value="Comédia">Comédia</option>
                        <option value="Fantasias / Ficção">Fantasias / Ficção</option>
                        <option value="Romance">Romance</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="trailer" class="form-label">Trailer:</label>
                    <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descrição:</label>
                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme..."></textarea>
                </div>
                <input type="submit" class="btn card-btn" value="Adicionar Filme">
            </form>
        </div>
    </div>
   
<?php

    require_once("templates/footer.php");

?>