<?php
$resp = $EmprestimosLivrosQuery->GetInfoEmprestimos($_GET["id_aluno"], 5);
?>

<div class="col-sm-12 col-md-12 col-lg-12 mt-1">
    <div class="card">
        <div class="card-header">
            Informações sobre alugéis do aluno
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <?php
                            echo "👨‍🎓 " . $aluno["nomealuno"] . " ";
                            $numalugels = $EmprestimosLivrosQuery->CountEmpAluno($_GET["id_aluno"]);
                            if ($numalugels >= 3 ){
                                $classt = "danger";
                            }else if ($numalugels == 2) {
                                $classt = "warning";
                            }else {
                                $classt = "primary";
                            }

                            echo "<span class='badge text-bg-$classt float-end'>STATUS</span>";
                            ?>
                            
                        </div>
                        <div class="card-body">
                            <ul class="list-group" id="alugeis-aluno">
                                <?php
                                $count = 0;
                                foreach ($resp as $valor) {
                                    $count++;
                                    $idAluguel = $valor["ordememprestimos"];
                                    if ($count == 1) {
                                        echo "<li value='$idAluguel' class='list-group-item list-group-item-action active' aria-current='true'>";
                                    } else {
                                        echo "<li value='$idAluguel' class='list-group-item list-group-item-action' aria-current='true'>";
                                    }
                                    echo "<div class='d-flex w-100 justify-content-between'>";
                                    echo "<h5 class='mb-1'>";
                                    echo $valor["nomelivro"];
                                    echo "</h5>";
                                    echo "<small>";
                                    echo $valor["diasatrasado"] . "  Dias atrasados";
                                    echo "</small>";


                                    echo "</div>";
                                    echo "<p class='mb-1'>";
                                    echo "Data prevista para devolução: " . $valor["dataprevistadevolucao"];
                                    echo "</p>";
                                    echo "<small>";
                                    echo "Data de empréstimo: " . $valor["dataemprestimo"];
                                    echo "</small>";

                                    echo "</li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            Atualizar ou deletar aluguel
                        </div>
                        <div class="card-body">
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
                                    Sem informações para continuar
                                </div>
                                <div class="tab-pane fade" id="delete-tab-pane" role="tabpanel" aria-labelledby="delete-tab" tabindex="0">
                                    Sem informações para continuar
                                </div>
                            </div>
                            <div id="err-danger" class="d-none alert alert-danger mt-1">
                            </div>
                            <div id="err-success" class="d-none alert alert-success mt-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>