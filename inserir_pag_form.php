<?php
    session_start();
    include_once("conection/conexao.php");
    include_once("php/verificar_sessao.php");
      if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['aut_financeiro'] == 1){
    include_once("conection/conexao.php");
    include_once("php/verificar_sessao.php");
    $idfuncionario = $_SESSION['id_usuario'];
    $unidadefunc = $_SESSION['unidade'];
    
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Models Painel Admin</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">
    <link href="assets/css/lib/vector-map/jqvmap.min.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body>
    <?php
        include_once("includes/inc_menu.php");
    ?>
    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php
            include_once("includes/inc_header.php");
         ?><!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active"><?php echo "São Paulo, ".date("d/m/Y"); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
<!--  INICIO PAGE  -->
        <div class="content mt-3">
            <div class="col-sm-12" >
                <div class="col-lg-6">
                    <div class="card" style="max-width: 900px; width: 800px;">
                      <div class="card-header" style="max-width: 900px; width: 800px;">
                        <strong>Histórico</strong> Financeiro do Cliente
                      </div>
                      <?php
                        if(isset($_SESSION['msg_cad'])){
                            echo $_SESSION['msg_cad'];
                            unset($_SESSION['msg_cad']);
                        };
                    ?>
                    <?php
                            $ncontrato = $_GET['ctn'];
                            if($unidadefunc == 4){
                            $select_contrato = "SELECT * FROM clientes_concept WHERE contrato_cc = '$ncontrato'";
                            $exec_select_contrato = mysqli_query($conn, $select_contrato);
                            }else if($unidadefunc == 1){
                               $select_contrato = "SELECT * FROM clientes_exclusive WHERE contrato_cc = '$ncontrato'";
                                $exec_select_contrato = mysqli_query($conn, $select_contrato); 
                            };
                            $row_contrato = mysqli_fetch_assoc($exec_select_contrato);
                    ?>
                      <div class="card-body card-block">
                         <?php
                                                    //CALCULAR VALOR EM ABERTO DO CONTRATO
                                                    if($unidadefunc == 4){
                                                    $valor_total_contrato = $row_contrato['valor_material_cc'];
                                                    $select_pagamentos = "SELECT valor_lancamento FROM lancamento_concept WHERE n_contrato_lancamento = '$ncontrato' AND status_lancamento <> 3 AND status = '1'";
                                                    $exec_select_pagamentos = mysqli_query($conn, $select_pagamentos);
                                                    }else if($unidadefunc == 1){
                                                        $valor_total_contrato = $row_contrato['valor_material_cc'];
                                                    $select_pagamentos = "SELECT valor_lancamento FROM lancamento_exclusive WHERE n_contrato_lancamento = '$ncontrato' AND status_lancamento <> 3 AND status = '1'";
                                                    $exec_select_pagamentos = mysqli_query($conn, $select_pagamentos);
                                                    };
                                                    $final_aberto = 0;
                                                    while($row_pagamento = mysqli_fetch_assoc($exec_select_pagamentos)){
                                                        $valor_atual = $row_pagamento['valor_lancamento'];
                                                        $final_aberto = $final_aberto + $valor_atual;
                                                    }
                                                    $final_aberto_pag = $valor_total_contrato - $final_aberto;                                                   
                                                ?>
                        <div class="card-body">
                                    <p class="text-muted m-b-15">Utilize o menu abaixo para inserir as formas de pagamento corretamente para o cliente. <b>Caso insira alguma informação incorreta favor entrar em contato imediatamente com um responsável</b></p>

                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Detalhes do Contrato</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Histórico de Pagamento</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active show" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Ações</a>
                                            </li>                                           
                                        </ul>
                                        <div class="tab-content pl-3 p-1" id="myTabContent">
                                            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                                               
                                                <h3>Detalhes do Contrato - 
                                                <?php
                                                    if($final_aberto_pag > 0){
                                                        echo "<font color='red'>Em Aberto: R$".$final_aberto_pag."</font>";
                                                    }else{
                                                        echo "<font color='green'>Sem Pendência de Lançamento</font>";
                                                    }  
                                                ?></h3>
                                                <p><b>Nº do Contrato:</b><?php echo $row_contrato['contrato_cc']; ?></p>
                                                <p><b>Nome do Modelo:</b><?php echo $row_contrato['nome_modelo_cc']; ?></p>
                                                <p><b>RG do Modelo:</b><?php echo $row_contrato['rg_modelo_cc']; ?></p>
                                                <p><b>CPF do Modelo:</b><?php echo $row_contrato['cpf_modelo_cc']; ?></p>
                                                <p><b>Nome do Responsável:</b><?php echo $row_contrato['nome_responsavel_cc']; ?></p>
                                                <p><b>RG do Responsável:</b><?php echo $row_contrato['rg_responsavel_cc']; ?></p>
                                                <p><b>CPF do Responsável:</b><?php echo $row_contrato['cpf_responsavel_cc']; ?></p>
                                                <p><b>Material:</b><?php echo $row_contrato['material_cc']; ?></p>
                                                <p><b>Valor Total do Material:</b><?php echo "R$".$row_contrato['valor_material_cc'].",00"; ?></p>
                                            </div>
                                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                <?php
                                                    if($unidadefunc == 4){
                                                    $select_historico_pagamento = "SELECT * FROM lancamento_concept lc
                                                    INNER JOIN status_lancamento st ON lc.status_lancamento = st.id_status_lancamento
                                                    INNER JOIN tipo_pagamento tpl ON lc.tipo_pagamento_lancamento = tpl.id_tp
                                                    WHERE lc.n_contrato_lancamento = '$ncontrato' AND lc.status = '1'";
                                                    $exec_historico_pagamento = mysqli_query($conn, $select_historico_pagamento);
                                                    }else if($unidadefunc == 1){
                                                        $select_historico_pagamento = "SELECT * FROM lancamento_exclusive lc
                                                    INNER JOIN status_lancamento st ON lc.status_lancamento = st.id_status_lancamento
                                                    INNER JOIN tipo_pagamento tpl ON lc.tipo_pagamento_lancamento = tpl.id_tp
                                                    WHERE lc.n_contrato_lancamento = '$ncontrato' AND lc.status = '1'";
                                                    $exec_historico_pagamento = mysqli_query($conn, $select_historico_pagamento);
                                                    };
                                                ?>
                                                <h3>Histórico de Pagamentos</h3>
                                                <table class="table table-striped">
                                                  <thead>
                                                    <tr>
                                                      <th scope="col">#</th>
                                                      <th scope="col">Forma Pgto.</th>
                                                      <th scope="col">Valor</th>
                                                      <th scope="col">Data Agrado</th>
                                                      <th scope="col">Data Lançado</th>
                                                      <th scope="col">Data Baixa</th>
                                                      <th scope="col">Status</th>
                                                      <th scope="col">Acao</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php
                                                        while($row_historico = mysqli_fetch_assoc($exec_historico_pagamento)){
                                                    ?>
                                                    <tr>
                                                      <th scope="row"><?php echo $row_historico['id_lancamento']; ?></th>
                                                      <td><?php echo $row_historico['descricao_tp']; ?></td>
                                                      <td><?php echo "R$".$row_historico['valor_lancamento']; ?></td>
                                                      <td><?php echo $row_historico['data_agrado_lancamento']; ?></td>
                                                      <td><?php echo $row_historico['created_lancamento']; ?></td>
                                                      <td><?php echo $row_historico['data_baixa_lancamento']; ?></td>
                                                      <td>
                                                        <?php 
                                                        if($row_historico['id_status_lancamento'] == 1){
                                                            echo "<font color='blue'>".$row_historico['descricao_status_lancamento']."</font>";
                                                        }else if($row_historico['id_status_lancamento'] == 2){
                                                            echo "<font color='green'>".$row_historico['descricao_status_lancamento']."</font>";
                                                        }else if($row_historico['id_status_lancamento'] == 3){
                                                            echo "<font color='red'>".$row_historico['descricao_status_lancamento']."</font>";
                                                        }else if($row_historico['id_status_lancamento'] == 4){
                                                            echo "<font color='green'>".$row_historico['descricao_status_lancamento']."</font>";
                                                        }else{

                                                        };
                                                       ?></td>
                                                        <td>
                                                            <?php 
                                                            $idlancamento = $row_historico['id_lancamento'];
                                                            if($row_historico['id_status_lancamento'] == 1){
                                                            ?>
                                                            <a href="actions/act_efetuar_baixa.php?situacao_lancamento=2&id_lancamento=<?php echo $idlancamento; ?>&ctn=<?php echo $ncontrato; ?>">Pago</a>
                                                            <br>
                                                            <a href="actions/act_efetuar_baixa.php?situacao_lancamento=3&id_lancamento=<?php echo $idlancamento; ?>&ctn=<?php echo $ncontrato; ?>">Cancelado</a>
                                                            <?php
                                                            };
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        };
                                                    ?>
                                                  </tbody>
                                                </table>
                                            </div>

                                            <div class="tab-pane fade active show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                                <?php
                                                        if($final_aberto_pag > 0){
                                                    ?>
                                                <h3>Inserir Novo Pagamento</h3>
                                                <p>                                                    
                                                    <form method="POST" action="pag_espec.php?ctn=<?php echo $ncontrato; ?>">
                                                        <select name="forma_pagamento" class="form-control" placeholder="Selecione ...">
                                                            <option value="1">Dinheiro</option>
                                                            <option value="2">Cheque</option>
                                                            <option value="3">Boleto Bancário</option>
                                                            <option value="4">Cartão de Débito</option>
                                                            <option value="5">Cartão de Crédito</option>
                                                            <option value="6">Depósito Bancário</option>
                                                            <option value="7">Via Única</option>
                                                        </select>
                                                        <br>
                                                        <input type="submit" name="enviar" class="form-control" value="Adicionar" >

                                                    </form>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <h3>Impressões</h3>
                                                        <p>
                                                            Contrato:
                                                            <?php
                                                                if($unidadefunc == 4){
                                                                    $contrato = $row_contrato['contrato_cc'];
                                                                    $select_contrato = "SELECT * FROM clientes_concept WHERE contrato_cc = '$contrato'";
                                                                    $exec_select_contrato = mysqli_query($conn, $select_contrato);
                                                                    $row_contrato = mysqli_fetch_assoc($exec_select_contrato);

                                                                    $valor_total_contrato = $row_contrato['valor_material_cc'];
                                                                    $select_pagamentos = "SELECT valor_lancamento FROM lancamento_concept WHERE n_contrato_lancamento = '$contrato' AND status_lancamento <> 3 AND status = '1'";
                                                                    $exec_select_pagamentos = mysqli_query($conn, $select_pagamentos);
                                                                    $final_aberto = 0;
                                                                    while($row_pagamento = mysqli_fetch_assoc($exec_select_pagamentos)){
                                                                        $valor_atual = $row_pagamento['valor_lancamento'];
                                                                        $final_aberto = $final_aberto + $valor_atual;
                                                                    }
                                                                    $final_aberto_pag = $valor_total_contrato - $final_aberto;

                                                                    if($final_aberto_pag < 1){
                                                                    echo "<a href='relatorios/contrato_concept.php?cnt=$contrato' target='_blank'><img src='images/print.png' width='25px' height='25px'></a>";
                                                                    }else{
                                                                        echo "Complete as Informacoes Financeiras";
                                                                    };
                                                                }else if($unidadefunc == 1){
                                                                    $contrato = $row_contrato['contrato_cc'];
                                                                    $select_contrato = "SELECT * FROM clientes_exclusive WHERE contrato_cc = '$contrato'";
                                                                    $exec_select_contrato = mysqli_query($conn, $select_contrato);
                                                                    $row_contrato = mysqli_fetch_assoc($exec_select_contrato);

                                                                    $valor_total_contrato = $row_contrato['valor_material_cc'];
                                                                    $select_pagamentos = "SELECT valor_lancamento FROM lancamento_exclusive WHERE n_contrato_lancamento = '$contrato' AND status_lancamento <> 3";
                                                                    $exec_select_pagamentos = mysqli_query($conn, $select_pagamentos);
                                                                    $final_aberto = 0;
                                                                    while($row_pagamento = mysqli_fetch_assoc($exec_select_pagamentos)){
                                                                        $valor_atual = $row_pagamento['valor_lancamento'];
                                                                        $final_aberto = $final_aberto + $valor_atual;
                                                                    }
                                                                    $final_aberto_pag = $valor_total_contrato - $final_aberto;

                                                                    if($final_aberto_pag < 1){
                                                                    echo "<a href='relatorios/contrato_exclusive.php?cnt=$contrato' target='_blank'><img src='images/print.png' width='25px' height='25px'></a>";
                                                                    }else{
                                                                        echo "Complete as Informacoes Financeiras";
                                                                    };
                                                                };
                                                            ?>
                                                            <br>
                                                                Termo de Imagem:
                                                              <?php  
                                                                    if($unidadefunc == 4){
                                                                    $contrato = $row_contrato['contrato_cc'];
                                                                    echo "<a href='relatorios/termo_imagem_concept.php?cnt=$contrato' target='_blank'><img src='images/print.png' width='25px' height='25px' ></a>";
                                                                    }else if($unidadefunc == 1){
                                                                    $icontrato = $row_contrato['contrato_cc'];
                                                                    echo "<a href='relatorios/termo_imagem_exclusive.php?cnt=$contrato' target='_blank'><img src='images/print.png' width='25px' height='25px' ></a>";
                                                                    };
                                                                ?>
                                                        </p>
                                                        <h3>Estúdio</h3>
                                                            <p>
                                                                <?php 
                                                                if($unidadefunc == 4){
                                                                $contrato = $row_contrato['contrato_cc']; 
                                                                ?>
                                                                Encaminhar para Estúdio: <?php echo "<a href='encaminhar_estudio.php?nc=$contrato'><img src='images/cam.png' width='25px' height='25px' ></a>";  ?>
                                                                <?php
                                                                    }else if($unidadefunc == 1){
                                                                    $contrato = $row_contrato['contrato_cc'];
                                                                ?>
                                                                Encaminhar para Estúdio: <?php echo "<a href='encaminhar_estudio.php?nc=$contrato'><img src='images/cam.png' width='25px' height='25px' ></a>";  ?>
                                                                <?php
                                                                    };
                                                                ?>
                                                                <br>
                                                                <?php 
                                                                    if($unidadefunc == 4){
                                                                    $contrato = $row_contrato['contrato_cc'];
                                                                ?>
                                                                    Marcar Retorno: <?php echo "<a href='marcar_retorno.php?ctn=$contrato'><img src='images/retorno.png' width='25px' height='25px' ></a>";  ?>
                                                                <?php
                                                                    }else if($unidadefunc == 1){
                                                                    $contrato = $row_contrato['contrato_cc'];
                                                                ?>
                                                                    Marcar Retorno: <?php echo "<a href='marcar_retorno.php?ctn=$contrato'><img src='images/retorno.png' width='25px' height='25px' ></a>";  ?>
                                                                <?php
                                                                    };
                                                                ?>
                                                            </p>
                                                            <p>
                                                                <h3>Termos de Trabalho</h3>
                                                                <?php
                                                                    if($unidadefunc == 1){
                                                                        $select_termo_trabalho = "SELECT * FROM trab_e_sele_exclusive ts INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas WHERE contrato_cc = '$contrato' AND tipo = '2'";
                                                                        $exec_termo_trabalho = mysqli_query($conn, $select_termo_trabalho);
                                                                        $qtd_trabalhos = mysqli_num_rows($exec_termo_trabalho);
                                                                        if($qtd_trabalhos > 0){
                                                                        while ($row_trabalhos = mysqli_fetch_assoc($exec_termo_trabalho)){
                                                                            $idts = $row_trabalhos['id_ts'];
                                                                            echo $row_trabalhos['descricao_marcas'].": "."<a href='relatorios/termo_comprometimento_exclusive.php?idts=$idts' target='_blank'> Comprometimento </a>";
                                                                            $presenca = $row_trabalhos['compareceu'];
                                                                            if($presenca == 1){
                                                                                $arq = $row_trabalhos['arq_termo'];
                                                                                echo "<a href='relatorios/termo_trabalho_marcas_$arq.php?idts=$idts' target='_blank'> Termo da Marca </a><br>";
                                                                            }else{
                                                                                echo "Aguardando Presença <br>"; 
                                                                            }
                                                                        };
                                                                        }else{
                                                                            echo "Nenhum Trabalho Encontrado";
                                                                        }
                                                                    }else if($unidadefunc == 4){
                                                                        $select_termo_trabalho = "SELECT * FROM trab_e_sele_concept ts INNER JOIN marcas ma ON ts.id_marcas = ma.id_marcas WHERE contrato_cc = '$contrato' AND tipo = '2'";
                                                                        $exec_termo_trabalho = mysqli_query($conn, $select_termo_trabalho);
                                                                        $qtd_trabalhos = mysqli_num_rows($exec_termo_trabalho);
                                                                        if($qtd_trabalhos > 0){
                                                                        while ($row_trabalhos = mysqli_fetch_assoc($exec_termo_trabalho)){
                                                                            $idts = $row_trabalhos['id_ts'];
                                                                            echo $row_trabalhos['descricao_marcas'].": "."<a href='relatorios/termo_comprometimento_exclusive.php?idts=$idts' target='_blank'> Comprometimento </a>";
                                                                            $presenca = $row_trabalhos['compareceu'];
                                                                            if($presenca == 1){
                                                                                $arq = $row_trabalhos['arq_termo'];
                                                                                echo "<a href='relatorios/termo_trabalho_marcas_$arq.php?idts=$idts' target='_blank'> Termo da Marca </a><br>";
                                                                            }else{
                                                                                echo "Aguardando Presença <br>"; 
                                                                            }
                                                                        };
                                                                        }else{
                                                                            echo "Nenhum Trabalho Encontrado";
                                                                        }
                                                                    };
                                                                ?>



                                                            </p>

                                                            <?php
                                                        };
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                </div>                    
                        
                      <div class="card-footer">
                        
                      </div>
                    </div>
<!-- FIM PAGE -->      
            </div>
        </div>
        </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>


    <script src="assets/js/lib/chart-js/Chart.bundle.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/widgets.js"></script>
    <script src="assets/js/lib/vector-map/jquery.vmap.js"></script>
    <script src="assets/js/lib/vector-map/jquery.vmap.min.js"></script>
    <script src="assets/js/lib/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="assets/js/lib/vector-map/country/jquery.vmap.world.js"></script>
    <script>
        ( function ( $ ) {
            "use strict";

            jQuery( '#vmap' ).vectorMap( {
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: [ '#1de9b6', '#03a9f5' ],
                normalizeFunction: 'polynomial'
            } );
        } )( jQuery );



    </script>

</body>
</html>
<?php
    }else{
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Àrea Restrita!
                             </div>";
        header("Location: loginpage.php");

    };
?>
