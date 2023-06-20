<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="update-tab" data-bs-toggle="tab" data-bs-target="#update-tab-pane" type="button" role="tab" aria-controls="update-tab-pane" aria-selected="true">Atualizar</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="delete-tab" data-bs-toggle="tab" data-bs-target="#delete-tab-pane" type="button" role="tab" aria-controls="delete-tab-pane" aria-selected="false">Deletar</button>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="update-tab-pane" role="tabpanel" aria-labelledby="update-tab" tabindex="0">
        <form class="row g-3" action="/painel/livros/livro/?id_livro=<?php
                                                                        echo $_GET["id_livro"]
                                                                        ?>" method="post">
            <?php
            $id_livro = $_GET["id_livro"];
            echo "<input type='hidden' name='id' value='$id_livro'>";
            ?>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <label class="form-label" for="nome">Nome</label>
                <?php
                $name_livro = $livro["nomelivro"];
                echo "<input class='form-control' id='nome' type='text' name='nome' value='$name_livro'>";
                ?>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="form-label" for="autor">Nome do Autor</label>
                <?php
                $autor = $livro["nomeautor"];
                echo "<input class='form-control' id='autor' type='text' name='autor' value='$autor'>";
                ?>

            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-floating">
                    <?php
                    echo "<select name='genero' class='form-select' id='genero' aria-label='Generos literarios'>";
                    $generos = $GeneroQuery->GetInfoGeneros(0, 0);
                    foreach ($generos as $genero) {
                        $id_genero = $genero["idgenero"];
                        $nome_genero = $genero["nomegenero"];
                        if ($id_genero == $livro["genero"]) {
                            echo "<option selected value='$id_genero'>$nome_genero</option>";
                        } else {
                            echo "<option value='$id_genero'>$nome_genero</option>";
                        }
                    }
                    echo "</select>";
                    ?>
                    <label for="floatingSelect">Genero Literario:</label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <?php
                $qtde = $livro["qtde"];
                echo "<input value='$qtde' class='form-control' id='qtde' type='number' name='qtde'>";
                ?>

            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-floating">
                    <?php
                    $sinopse = $livro["sinopse"];
                    echo "<textarea value='$sinopse' name='sinopse' class='form-control' id='sinopse'>$sinopse</textarea>";
                    ?>
                    <label for="sinopse">Sinopse</label>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <?php
                $cad = $livro["cadastroativo"];
                if ($cad) {
                    echo "<input checked type='checkbox' class='form-check-input' name='cad-ativo' id='cad-ativo'>";
                } else {
                    echo "<input type='checkbox' class='form-check-input' name='cad-ativo' id='cad-ativo'>";
                }
                ?>
                <label class="form-check-label" for="cad-ativo">cadastro ativo?</label>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 ">
                <label for="corcapa" class="form-label">Cor do livro</label>

                <?php
                echo "<select multiple name='corcapa' class='form-select' id='corcapa' aria-label='Cor da Capa'>";
                foreach ($CORESCAPAS as $key => $value) {
                    if ($livro['corcapa'] == $value) {
                        echo "<option selected value='$value'>$value</option>";
                    } else {
                        echo "<option value='$value'>$value </option>";
                    }
                }
                echo "</select>";
                ?>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="form-label" for="fonte">Fonte do titulo da capa:</label>
                <?php
                echo "<select multiple name='fonte' class='form-select' id='fonte' aria-label='Fonte do livro'>";
                foreach ($FONTESCAPAS as $key => $value) {
                    if ($livro["fonte"] == $value) {
                        echo "<option class='$value' selected value='$value'>$value</option>";
                    } else {
                        echo "<option class='$value' value='$value'>$value</option>";
                    }
                }
                echo "</select>";
                ?>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                <button class="btn btn-success" type="submit">Atualizar</button>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                <?php

                if ($resp != NULL) {
                    if ($resp[0]) {
                        echo "<div class='alert alert-success'>";
                        echo $resp[1];
                        echo "</div>";
                    } else {
                        echo "<div class='alert alert-danger'>";
                        echo $resp[1];
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </form>
    </div>
    <div class="tab-pane fade" id="delete-tab-pane" role="tabpanel" aria-labelledby="delete-tab" tabindex="0">
        <form id="form-delete" class="text-center" action="">
            <input type="hidden" name="id_delete" value='<?php
            echo $livro["idlivro"];
            ?>'>
            <div class="alert alert-warning">
                Deseja deletar o livro atual?
            </div>
            <button id="btn-delete" class="btn btn-danger">
                Deletar
            </button>
        </form>
    </div>
</div>
<br>
<div id="err-danger" class="alert alert-danger d-none">

</div>