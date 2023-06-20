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
        <form class="row g-3" action="/painel/alunos/aluno/?id_aluno=<?php
                                                                        echo $_GET["id_aluno"]
                                                                        ?>" method="post">
            <?php
            $id_aluno = $_GET["id_aluno"];
            echo "<input type='hidden' name='id' value='$id_aluno'>";
            ?>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <label class="form-label" for="nome">Nome</label>
                <?php
                $name_aluno = $aluno["nomealuno"];
                echo "<input class='form-control' id='nome' type='text' name='nome' value='$name_aluno'>";
                ?>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="form-label" for="cpf">cpf</label>
                <?php
                $phone = $aluno["cpfaluno"];
                echo "<input class='form-control' id='cpf' type='text' name='cpf' value='$phone'>";
                ?>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <label class="form-label" for="contato">contato</label>
                <?php
                $phone = $aluno["telefone"];
                echo "<input class='form-control' id='contato' type='tel' name='contato' value='$phone'>";
                ?>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <label class="form-label" for="curso">curso</label>
                <?php
                $curso = $aluno["curso"];
                echo "<input value='$curso' class='form-control' id='curso' type='text' name='curso'>";
                ?>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <label class="form-label" for="turma">turma</label>
                <?php
                $turma = $aluno["turma"];
                echo "<input value='$turma' class='form-control' id='turma' type='text' name='turma'>";
                ?>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <?php
                $exalun = $aluno["ex-aluno"];
                if ($exalun == 1) {
                    echo "<input type='checkbox' class='form-check-input' checked name='ex-aluno' id='ex-aluno'>";
                } else {
                    echo "<input type='checkbox' class='form-check-input' value='' name='ex-aluno' id='ex-aluno'>";
                }
                ?>
                <label class="form-check-label" for="ex-aluno">ex-aluno</label>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <?php
                $cad = $aluno["cadastroativo"];
                if ($cad == 1) {
                    echo "<input type='checkbox' class='form-check-input' checked name='cad-ativo' id='cad-ativo'>";
                } else {
                    echo "<input type='checkbox' class='form-check-input' value='' name='cad-ativo' id='cad-ativo'>";
                }
                ?>
                <label class="form-check-label" for="cad-ativo">cadastro ativo?</label>
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
                                                            echo $_GET["id_aluno"];
                                                            ?>'>
            <div class="alert alert-warning">
                Deseja deletar o aluno atual?
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