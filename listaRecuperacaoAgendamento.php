<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) && $_SESSION['permissao'] <> 1){
    include_once("conection/connection.php");
    $pdo=conectar();
    //include_once("php/verificar_sessao.php");
    $idfuncionario=$_SESSION['id_usuario'];
    $unidade = $_SESSION['unidade'];
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]--> 
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv=”content-type” content=”text/html; charset=UTF-8″ />
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

    <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/javascriptpersonalizado.js"></script>

     <link href="CSS/uploadfilemulti.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


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
        <?php

        //Receber o número da página
        $pagina_atual = filter_input(INPUT_GET,'pagina', FILTER_SANITIZE_NUMBER_INT);       
        $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
        
        //Setar a quantidade de itens por pagina
        $qnt_result_pg = 1;
        
        //calcular o inicio visualização
        $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;    
        
        
            ?>
   
            <div class="animated fadeIn">
                <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <?php
                                $totalagendamento=$pdo->prepare("SELECT * FROM agendamentos ag INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente INNER JOIN funcionario func ON ag.id_func = func.id_func WHERE ag.data_agendada_agendamento >= '2019-10-01' AND ag.data_agendada_agendamento < date(NOW())  AND ag.id_comparecimento=:comparecimento AND ag.id_unidade=:unidade AND ag.func_recuperacao=:funcRecuperacao AND ag.id_status_sistema=:status ORDER BY qtd_fb_recuperacao ASC");
                                $totalagendamento->bindValue(":comparecimento", '3', PDO::PARAM_INT);
                                $totalagendamento->bindValue(":unidade", $unidade, PDO::PARAM_INT);
                                $totalagendamento->bindValue(":funcRecuperacao", $idfuncionario);
                                $totalagendamento->bindValue(":status", 1, PDO::PARAM_INT);
                                $totalagendamento->execute();
                                $rowTotal=$totalagendamento->rowCount();


                                $agendamentosRec=$pdo->prepare("SELECT * FROM agendamentos ag INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente INNER JOIN funcionario func ON ag.id_func = func.id_func WHERE ag.data_agendada_agendamento >= '2019-10-01' AND ag.data_agendada_agendamento < date(NOW())  AND ag.id_comparecimento=:comparecimento AND ag.id_unidade=:unidade AND ag.func_recuperacao=:funcRecuperacao AND ag.id_status_sistema=:status ORDER BY qtd_fb_recuperacao ASC LIMIT 1");
                                $agendamentosRec->bindValue(":comparecimento", '3', PDO::PARAM_INT);
                                $agendamentosRec->bindValue(":unidade", $unidade, PDO::PARAM_INT);
                                $agendamentosRec->bindValue(":funcRecuperacao", $idfuncionario);
                                $agendamentosRec->bindValue(":status", 1, PDO::PARAM_INT);
                                $agendamentosRec->execute();
                                $rowAgend=$agendamentosRec->fetchall(PDO::FETCH_OBJ);
                            ?>
                            <strong class="card-title">Lista</strong> Telefônica de Recuperação de Agendamento - Total de Agendamentos: <?php echo $rowTotal; ?>
                        </div>
                        <div class="card-body">
                        
                  
                  <?php
                        foreach($rowAgend as $listarAgend){
                  ?>
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Modelo</th>
                        <th>Responsável</th>
                        <th>Telefone</th>
                        <th>Telefone 2</th>                     
                        <th>Resposta </th>
                        <th>+</th>
                      </tr>
                    </thead>                  
                        <?php
                          
                            if($listarAgend->id_meio_captado == 1){
                                $captado="Instagram";
                            }elseif($listarAgend->id_meio_captado == 2){
                                $captado="Whatsapp";
                            }elseif($listarAgend->id_meio_captado == 3){
                                $captado="Ligação";
                            }elseif($listarAgend->id_meio_captado == 4){
                                $captado="Facebook";
                            };
                        ?>
                    <tbody>
                      <tr>
                        <td><?php echo $listarAgend->nome_cliente;?></td>
                        <td><?php echo $listarAgend->nome_responsavel_cliente; ?></td>
                        <td><?php echo $listarAgend->telefone_cliente;  ?></td>
                        <td><?php echo $listarAgend->telefone2_cliente; ?></td>            
                        <td>--</td>
                        <td>--</td>
                    </tr>
                    <tr>
                        <td colspan="6"><center><b>Histórico de Agendamento - Meio: <?php echo $captado; ?> - ID: <?php echo $listarAgend->id_agendamentos; ?></b></center></td>
                    </tr>
                    <tr>
                        <td colspan="2"> Data de Cadastro do Agendamento:</td>
                        <td colspan="2"> <?php echo date("d/m/Y - H:i", strtotime($listarAgend->data_cadastro_agendamento)); ?></td>
                        <td colspan="2"> </td>
                    </tr>
                    <tr>
                        <td colspan="2">Data Agendada: </td>
                        <td colspan="1"><?php echo date("d/m/Y",strtotime($listarAgend->data_agendada_agendamento)); ?></td>
                        <td colspan="2">Horário Agendado: </td>
                        <td colspan="1"><?php echo $listarAgend->hora_agendada_agendamento; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"> Scouter: </td>
                        <td colspan="2"><?php echo $listarAgend->nome_completo_func; ?> </td>
                        <td colspan="2"> </td>
                    </tr>
                    <tr>
                        <td colspan="2">Houve Confirmação?</td>
                        <td colspan="1"><?php if($listarAgend->confirmado == 1){echo "Confirmado";}else{echo "Não foi Confirmado";} ?></td>
                        <td colspan="2">Data/Horário de Confirmação: </td>
                        <td colspan="1"><?php if($listarAgend->confirmado == 1){echo date("d/m/Y H:i", strtotime($listarAgend->confirmado_hour)); }else{ echo "Não Foi Confirmado";}; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6"><center><b>Histórico de Ligação (Em Recuperação) </b></center></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Feedback</b></td>
                        <td colspan="2"><b>Data/Horário</b></td>
                        <td colspan="2"><b>Colaborador</b></td>
                    </tr>
                    <?php 
                        $historicoFeedback=$pdo->prepare("SELECT * FROM log_fedback_recuperacao lfr INNER JOIN status_ligacao sl ON  lfr.status = sl.id_ligacao INNER JOIN funcionario func ON lfr.id_func = func.id_func WHERE lfr.id_agendamento=:idAgendamento");
                        $historicoFeedback->bindValue("idAgendamento", $listarAgend->id_agendamentos);
                        $historicoFeedback->execute();
                        $linhaHistoricoFB=$historicoFeedback->fetchall(PDO::FETCH_OBJ);
                        foreach($linhaHistoricoFB as $rowFB){
                    ?>
                    <tr>
                        <td colspan="2"><?php echo $rowFB->desc_ligacao; ?></td>
                        <td colspan="2"><?php echo date("d/m/Y H:i", strtotime($rowFB->hora_ligacao)); ?></td>
                        <td colspan="2"><?php echo $rowFB->nome_completo_func; ?></td>
                    </tr>
                    <?php
                        };
                    ?>
                    <tr>
                        <td colspan="5">
                            <form method="POST" action="actions/actRegistrarFbRecuperacao.php?idAgendamento=<?php echo $listarAgend->id_agendamentos; ?>&idCliente=<?php echo $listarAgend->id_cliente; ?>">
                                <center>
                                <select name="fbAgendamento" class="form-control">
                                    <option value="3"><center>Caixa Postal</center></option> 
                                    <option value="4"><center>Não Atende</center></option>
                                    <option value="6"><center>Sem Resposta</center></option>
                                    <option value="7"><center>Perdeu o Interesse</center></option> 
                                    <option value="8"><center>Desligou</center></option>                                                  
                                    <option value="9"><center>Reagendar</center></option>    
                                </select>
                            </center>
                            
                        </td>
                        <td> 
                            <input type="submit" name="envio" value=">">
                            </form>
                        </td>
                    </tr>
                    </tbody>
                        
                    
                  </table> 
                  <br><br><br>
                  <?php
                        };
                    ?>
                                 
                        </div> 
                    </div>
                </div>
                </div>
            </div><!-- .animated -->
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

    }

?>