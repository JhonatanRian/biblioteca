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
        <form class="row g-3" action="/painel/operarios/operario/?id_op=<?php
                                                                        echo $_GET["id_op"]
                                                                        ?>" method="post">
            <?php
            $id_op = $_GET["id_op"];
            echo "<input type='hidden' name='id' value='$id_op'>";
            ?>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <label class="form-label" for="nome">Nome</label>
                <?php
                $name_op = $op["nomeoperador"];
                echo "<input class='form-control' id='nome' type='text' name='nome' value='$name_op'>";
                ?>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="form-label" for="cpf">cpf</label>
                <?php
                $cpf = $op["cpf"];
                echo "<input class='form-control' id='cpf' type='text' name='cpf' value='$cpf'>";
                ?>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <label class="form-label" for="contato">senha</label>
                <?php
                echo "<input class='form-control' id='senha' type='password' name='senha'>";
                ?>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <?php
                $staff = $op["is_staff"];
                if ($staff == 1) {
                    echo "<input type='checkbox' class='form-check-input' checked name='is_staff' id='is_staff'>";
                } else {
                    echo "<input type='checkbox' class='form-check-input' name='is_staff' id='is_staff'>";
                }
                ?>
                <label class="form-check-label" for="is_staff">é da equipe?</label>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <?php
                $superuser = $op["is_superuser"];
                if ($superuser == 1) {
                    echo "<input type='checkbox' class='form-check-input' checked name='is_superuser' id='is_superuser'>";
                } else {
                    echo "<input type='checkbox' class='form-check-input' name='is_superuser' id='is_superuser'>";
                }
                ?>
                <label class="form-check-label" for="cad-ativo">é admin?</label>
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
                                                            echo $_GET["id_op"];
                                                            ?>'>
            <div class="alert alert-warning">
                Deseja deletar o operario atual?
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