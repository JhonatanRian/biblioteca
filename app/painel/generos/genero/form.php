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
        <form class="row g-3" action="/painel/generos/genero/?id_genero=<?php
                                                                        echo $_GET["id_genero"]
                                                                        ?>" method="post">
            <?php
            $id_genero = $_GET["id_genero"];
            echo "<input type='hidden' name='id' value='$id_genero'>";
            ?>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <label class="form-label" for="nome">Nome</label>
                <?php
                $name_genero = $genero["nomegenero"];
                echo "<input class='form-control' id='nome' type='text' name='nome' value='$name_genero'>";
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
            echo $genero["idgenero"];
            ?>'>
            <div class="alert alert-warning">
                Deseja deletar o genero atual?
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