<?php
require_once '../../vendor/autoload.php';

use Unisinos\Notas\Models\UniNotas;
$uniNotas = new UniNotas();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Unisinos</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <h2 class="header-name"><i class="fa-solid fa-user" style="margin-right: 4px"></i>Braian</h2> 
        <h1 class="header-title">Unisinos Notas</h1> 
        <h2 class="header-ra"><i class="fa-solid fa-id-card" style="margin-right: 4px"></i>1833298</h2> 
    </header>

    <div class="buttons">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-right: 4px"><i class="fa-solid fa-graduation-cap"></i> Nova Cadeira</button>
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModale" style="margin-left: 4px"><i class="fa-solid fa-plus"></i> Nota</button>
    </div>

    <div class="space">
        <div class="body-table">
            <?php 
                $cadeiras = $uniNotas->getCadeira();
                for($i = 0; $i < $cadeiras['qtd']; $i++) {
            ?>
            
            <a href="javascript:void(0)" onclick="openCadeira(<?=$cadeiras['cadeira'][$i]['id'];?>)" class="row-chair">
                <div class="line">
                    <div class="line-title" style="background-color: <?=$cadeiras['cadeira'][$i]['cor'];?>">
                        <?=($cadeiras['cadeira'][$i]['status']) == 1 ? "<i class='fa-solid fa-circle-check' style='margin-right: 25px'></i>" : "<i class='fa-solid fa-hourglass' style='margin-right: 25px'></i>";?>
                        <span class="span-line-title"><?=$cadeiras['cadeira'][$i]['nome_cadeira'];?></span>
                    </div>
                    <div class="line-body">
                        <div class="GA">
                            <span>GA</span>
                            <?php if($cadeiras['cadeira'][$i]['nota_ga'] != 0) { ?>
                                <span><?=number_format($cadeiras['cadeira'][$i]['nota_ga'], 1, ',', '');?></span>
                            <?php } else { ?>
                                <span>0</span>
                            <?php } ?>
                        </div>
                        <?php if($cadeiras['cadeira'][$i]['nota_gb'] != 0) { ?>
                        <div class="GB">
                            <span>GB</span>
                            <span><?=number_format($cadeiras['cadeira'][$i]['nota_gb'], 1, ',', '');?></span>
                        </div>
                        <?php } ?>
                        <?php if($cadeiras['cadeira'][$i]['status'] == 2) { ?>
                            <div class="GF">
                                <span>Faltam</span>
                                <?php if($cadeiras['cadeira'][$i]['nota_ga'] != 0) { ?>
                                    <span><?=number_format($uniNotas->calculaNotaFalta($cadeiras['cadeira'][$i]['nota_ga']), 1, ',', '');?></span>
                                <?php } else { ?>
                                    <span><?=number_format($uniNotas->calculaNotaFalta(0), 1, ',', '');?></span>
                                <?php } ?>
                                
                            </div>
                        <?php } ?>
                        
                    </div>
                    <div class="line-end" 
                        style="background-color: 
                        <?php
                            $media = number_format($uniNotas->calculaMedia($cadeiras['cadeira'][$i]['nota_ga'] == null ? '0' : $cadeiras['cadeira'][$i]['nota_ga'], $cadeiras['cadeira'][$i]['nota_gb'] == null ? '0' : $cadeiras['cadeira'][$i]['nota_gb']), 1, ',', '');
                            if($cadeiras['cadeira'][$i]['status'] == 2) {
                                echo '#CCCCCC';
                            } else {
                                if($media >= 6){
                                    echo 'rgb(135 255 120);';    
                                } else {
                                    echo 'rgb(255, 94, 94)';
                                }
                            }
                        ?>"
                    >
                        <div class="media">
                            <span>Média</span>
                            <span><?=$media?></span>
                        </div>
                    </div>
                </div>
            </a>
            <?php } ?>

        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Criar novo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nome Cadeira</label>
                    <input class="form-control" type="text" id="nome_cadeira_modal">
                </div>
                <div class="mb-3">
                    <label class="form-label">Cor</label>
                    <input type="color" class="form-control form-control-color" id="cor_modal" value="#563d7c">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="nova_cadeira">Salvar</button>
            </div>
            </div>
        </div>
    </div>
    <!-- /MODAL -->

    <!-- MODAL ADD NOTA -->
    <div class="modal fade" id="exampleModale" tabindex="-1" aria-labelledby="exampleModaleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Criar novo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Nome Cadeira</label>
                            <select class="form-select" id="select-cadeiras">
                                <option>Selecione</option>
                                <?php 
                                    $cadeiras_select = $uniNotas->getIdNomeCadeiras();
                                    for($j = 0; $j < $cadeiras_select['qtd']; $j++) {
                                ?>
                                <option value="<?=$cadeiras_select['cadeira'][$j]['id'];?>"><?=$cadeiras_select['cadeira'][$j]['nome_cadeira'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="margin-spacer"></div>
                    <div id="form-add-notas" style="display: none">
                        <div class="row">
                            <div class="col-3">
                                <label class="form-label">Grau</label>
                                <select class="form-select" id="select_grau">
                                    <option>A</option>
                                    <option>B</option>
                                </select>
                            </div>
                            <div class="col-9">
                                <label class="form-label">Descrição</label>
                                <input class="form-control" type="text" id="descricao_nota">
                            </div>
                        </div>
                        <div class="margin-spacer"></div>
                        <div class="row">
                            <div class="col">
                                <label class="form-label">Nota</label>
                                <input class="form-control" type="number" min="0" max="10" id="nota_grau">
                            </div>
                            <div class="col">
                                <label class="form-label">Nota Max</label>
                                <input class="form-control" type="number" min="0" max="10" id="nota_max_grau">
                            </div>
                        </div>
                        <div class="margin-spacer"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="nova_nota">Salvar</button>
            </div>
            </div>
        </div>
    </div>
    <!-- /MODAL ADD NOTA -->
    
    
    
    <script type="text/javascript" src="assets/js/javascript.js"></script>
</body>
</html>