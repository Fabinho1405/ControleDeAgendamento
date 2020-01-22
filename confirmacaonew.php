<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_scouter_ligacao_new'] == 1){
    include_once("conection/conexao.php");
    include_once("php/verificar_sessao.php");
    $idfuncionario = $_SESSION['id_usuario'];
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
        $qnt_result_pg = 15;
        
        //calcular o inicio visualização
        $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;    
        
        
            ?>
   
            <div class="animated fadeIn">
                <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Confirmação Individual <small>Nesta aba, você fará suas confirmações um dia antes do agendamento de seu cliente. Boa Sorte :)</small></strong>
                        </div>
                        <div class="card-body">
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th><center> Agendados </center> </th>
                        <th><center> Confirmados </center></th>
                        <th><center> Sem Contato </center> </th>                        
                      </tr>
                    </thead>                  
                        <?php  
                            $dia_confirmacao = date("Y-m-d", strtotime("+1 days"));

                            $result_num_agendados = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$dia_confirmacao' AND id_unidade = '$unidade' AND id_func = '$idfuncionario' AND DATEDIFF( data_agendada_agendamento, data_cadastro_agendamento) > '1' ";
                            $resultado_num_agendados = mysqli_query($conn, $result_num_agendados);
                            $qtd_agendados = mysqli_num_rows($resultado_num_agendados);

                            $result_num_confirmados_conf1 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$dia_confirmacao' AND id_unidade = '$unidade' AND id_comparecimento = '3' AND confirmado = '1' AND id_func = '$idfuncionario' AND DATEDIFF( data_agendada_agendamento, data_cadastro_agendamento) > '1' ";     

                            $resultado_num_conf1 = mysqli_query($conn, $result_num_confirmados_conf1);
                            $qtd_confirmados = mysqli_num_rows($resultado_num_conf1);
                            $qtd_sem_contato = "N/D";

                        ?>
                    <tbody>
                      <tr>
                        <td><?php  echo "<center><font size='14'>  ".$qtd_agendados." </font></center>"; ?> </td>
                        <td><?php  echo "<center><font size='14'>  ".$qtd_confirmados." </font></center>"; ?> </td>
                        <td><?php  echo "<center><font size='14'>  ".$qtd_sem_contato." </font></center>"; ?> </td>          
                       
                                        
                      </tr>
                      </form>
                    </tbody>
                  </table>

                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Modelo</th> 
                        <th>Responsável</th>
                        <th>Telefone</th>
                        <th>Telefone 2</th>
                        <th>Horário</th>
                        <th>Resposta </th>
                        <th>+</th>
                      </tr>
                    </thead>  
                    <!-- COMEÇO DA MERDA -->                
                       <?php
                            

                            $confirmacao_p_tentativa = "SELECT * FROM agendamentos ag INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente WHERE data_agendada_agendamento = '$dia_confirmacao' AND id_unidade = '$unidade' AND confirmado = '0' AND fbc_1 = '1' AND id_status_sistema = '1' AND ag.id_func = '$idfuncionario' AND DATEDIFF( data_agendada_agendamento, data_cadastro_agendamento) > '1' ";
                            $confirmacao_p_tentativa_query = mysqli_query($conn, $confirmacao_p_tentativa);
                            $qtd_confirmacao_p_tentativa = mysqli_num_rows($confirmacao_p_tentativa_query);
                            if($qtd_confirmacao_p_tentativa > 0){
                                //EFETUA PRIMEIRO CONTATO DE CONFIRMAÇÃO
                                echo "<center> 1ª CONTATO COM TODOS OS AGENDADOS </center>";
                                while($row_conf = mysqli_fetch_assoc($confirmacao_p_tentativa_query)){
                            ?>

                                <tbody>
                                   <tr>
                                    <td><?php echo $row_conf['id_agendamentos']; ?></td>
                                    <td><?php echo $row_conf['nome_cliente']; ?></td>
                                    <td><?php echo $row_conf['nome_responsavel_cliente']; ?></td>
                                    <td><?php echo $row_conf['telefone_cliente']; ?></td>
                                    <td><?php echo $row_conf['telefone2_cliente']; ?></td>
                                    <td><?php echo $row_conf['hora_agendada_agendamento']; ?></td>
                                    <td>
                                        <form name="contato" action="actions/modificar_confirmacao.php?dataconfirmacao=<?php echo $dia_confirmacao; ?>&idagendamento=<?php echo $row_conf['id_agendamentos']; ?>&fb=1&cli=<?php echo $row_conf['id_cliente']; ?>" method="POST">
                                        <select name="status_confirmacao" class="form-control">
                                            <option value="1">Em Aberto</option>
                                            <option value="2">Confirmou</option>
                                            <option value="3">Reagendou</option> 
                                            <option value="4">Caixa Postal</option>
                                            <option value="5">Não Atende</option>
                                            <option value="6">Desligou</option>
                                            <option value="7">Sem Interesse</option>
                                            <option value="8">DDD de Fora</option>                                                                                                                                                                                                                                                                                                                                      
                                            <option value="9">Irá Retornar</option>
                                        </select>
                                    </td>                                                           
                                    <td><input type="submit" value=">" name="modificar_status">
                                    </td>
                                    </form>
                                    </tr>
                                    </tbody>  
                                <?php

                                }
                            }else{
                                $confirmacao_s_tentativa = "SELECT * FROM agendamentos ag INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente WHERE data_agendada_agendamento = '$dia_confirmacao' AND id_unidade = '$unidade' AND confirmado = '0' AND fbc_2 = '0' AND id_status_sistema = '1' AND ag.id_func = '$idfuncionario' AND DATEDIFF( data_agendada_agendamento, data_cadastro_agendamento) > '1' ";
                                $confirmacao_s_tentativa_query = mysqli_query($conn, $confirmacao_s_tentativa);
                                $qtd_confirmacao_s_tentativa = mysqli_num_rows($confirmacao_s_tentativa_query);
                                if($qtd_confirmacao_s_tentativa > 0){
                                    echo "<center> 2ª CONTATO COM TODOS OS AGENDADOS </center>";
                                    while($row_conf = mysqli_fetch_assoc($confirmacao_s_tentativa_query)){
                            ?>

                                <tbody>
                                   <tr>
                                    <td><?php echo $row_conf['id_agendamentos']; ?></td>
                                    <td><?php echo $row_conf['nome_cliente']; ?></td>
                                    <td><?php echo $row_conf['nome_responsavel_cliente']; ?></td>
                                    <td><?php echo $row_conf['telefone_cliente']; ?></td>
                                    <td><?php echo $row_conf['telefone2_cliente']; ?></td>
                                    <td><?php echo $row_conf['hora_agendada_agendamento']; ?></td>
                                    <td>
                                        <form name="contato" action="actions/modificar_confirmacao.php?dataconfirmacao=<?php echo $dia_confirmacao; ?>&idagendamento=<?php echo $row_conf['id_agendamentos']; ?>&fb=2&cli=<?php echo $row_conf['id_cliente']; ?>" method="POST">
                                        <select name="status_confirmacao">
                                            <option value="1">Em Aberto</option>
                                            <option value="2">Confirmou</option>
                                            <option value="3">Reagendou</option>
                                            <option value="4">Caixa Postal</option>
                                            <option value="5">Não Atende</option>
                                            <option value="6">Desligou</option>
                                            <option value="7">Sem Interesse</option>
                                            <option value="8">DDD de Fora</option>
                                            <option value="9">Irá Retornar</option>
                                        </select>
                                    </td>                                                           
                                    <td><input type="submit" value=">" name="modificar_status"></td>
                                    </form>
                                    </tr>
                                    </tbody>  
                                <?php

                                }
                                }else{
                                    $confirmacao_t_tentativa = "SELECT * FROM agendamentos ag INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente WHERE data_agendada_agendamento = '$dia_confirmacao' AND id_unidade = '$unidade'AND confirmado = '0' AND fbc_3 = '0' AND id_status_sistema = '1' AND ag.id_func = '$idfuncionario' AND DATEDIFF( data_agendada_agendamento, data_cadastro_agendamento) > '1' ";
                                    $confirmacao_t_tentativa_query = mysqli_query($conn, $confirmacao_t_tentativa);
                                    $qtd_confirmacao_t_tentativa = mysqli_num_rows($confirmacao_t_tentativa_query);
                                    if($qtd_confirmacao_t_tentativa > 0){
                                        echo "<center> 3º CONTATO COM AGENDADOS </center>";
                                        while($row_conf = mysqli_fetch_assoc($confirmacao_t_tentativa_query)){
                            ?>

                                <tbody>
                                   <tr>
                                    <td><?php echo $row_conf['id_agendamentos']; ?></td>
                                    <td><?php echo $row_conf['nome_cliente']; ?></td>
                                    <td><?php echo $row_conf['nome_responsavel_cliente']; ?></td>
                                    <td><?php echo $row_conf['telefone_cliente']; ?></td>
                                    <td><?php echo $row_conf['telefone2_cliente']; ?></td>
                                    <td><?php echo $row_conf['hora_agendada_agendamento']; ?></td>
                                    <td>
                                        <form name="contato" action="actions/modificar_confirmacao.php?dataconfirmacao=<?php echo $dia_confirmacao; ?>&idagendamento=<?php echo $row_conf['id_agendamentos']; ?>&fb=3&cli=<?php echo $row_conf['id_cliente']; ?>" method="POST">
                                        <select name="status_confirmacao" class="form-control">
                                            <option value="1">Em Aberto</option>
                                            <option value="2">Confirmou</option>
                                            <option value="3">Reagendou</option>
                                            <option value="4">Caixa Postal</option>
                                            <option value="5">Não Atende</option>
                                            <option value="6">Desligou</option>
                                            <option value="7">Sem Interesse</option>
                                            <option value="8">DDD de Fora</option>
                                            <option value="9">Irá Retornar</option>
                                        </select>
                                    </td>                                                           
                                    <td><input type="submit" value=">" name="modificar_status"></td>
                                    </form>
                                    </tr>
                                    </tbody>  
                                <?php

                                }
                                    }else{
                                        $confirmacao_q_tentativa = "SELECT * FROM agendamentos ag INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente WHERE data_agendada_agendamento = '$dia_confirmacao' AND id_unidade = '$unidade' AND confirmado = '0' AND fbc_4 = '0' AND id_status_sistema = '1' AND ag.id_func = '$idfuncionario' AND DATEDIFF( data_agendada_agendamento, data_cadastro_agendamento) > '1' ";
                                        $confirmacao_q_tentativa_query = mysqli_query($conn, $confirmacao_q_tentativa);
                                        $qtd_confirmacao_q_tentativa = mysqli_num_rows($confirmacao_q_tentativa_query);
                                        if($qtd_confirmacao_q_tentativa > 0){
                                            echo "<center> 4º CONTATO COM AGENDADOS </center>";
                                                while($row_conf = mysqli_fetch_assoc($confirmacao_q_tentativa_query)){
                            ?>

                                <tbody>
                                   <tr>
                                    <td><?php echo $row_conf['id_agendamentos']; ?></td>
                                    <td><?php echo $row_conf['nome_cliente']; ?></td>
                                    <td><?php echo $row_conf['nome_responsavel_cliente']; ?></td>
                                    <td><?php echo $row_conf['telefone_cliente']; ?></td>
                                    <td><?php echo $row_conf['telefone2_cliente']; ?></td>
                                    <td><?php echo $row_conf['hora_agendada_agendamento']; ?></td>
                                    <td>
                                        <form name="contato" action="actions/modificar_confirmacao.php?dataconfirmacao=<?php echo $dia_confirmacao; ?>&idagendamento=<?php echo $row_conf['id_agendamentos']; ?>&fb=4&cli=<?php echo $row_conf['id_cliente']; ?>" method="POST">
                                        <select name="status_confirmacao">
                                            <option value="1">Em Aberto</option>
                                            <option value="2">Confirmou</option>
                                            <option value="3">Reagendou</option>
                                            <option value="4">Caixa Postal</option>
                                            <option value="5">Não Atende</option>
                                            <option value="6">Desligou</option>
                                            <option value="7">Sem Interesse</option>
                                            <option value="8">DDD de Fora</option>
                                            <option value="9">Irá Retornar</option>
                                        </select>
                                    </td>                                                           
                                    <td><input type="submit" value=">" name="modificar_status"></td>
                                    </form>
                                    </tr>
                                    </tbody>  
                                <?php

                                }
                                            }else{
                                                echo "<center>Infelizmente Não Possuimos Agendados Para Esse Dia :( - Se houver algum erro, informe seu <b> SUPERVISOR </b></center>";
                                            }

                                        }
                                    }

                                }
?>

                    <!-- FIM DA MERDA -->
                      </form>
                
                   

                  </table>
                  <?php
                    //Paginção - Somar a quantidade de usuários
        $result_pg = "SELECT COUNT(id_agendamentos) as num_result FROM agendamentos ag 
INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente WHERE data_agendada_agendamento = '$dataconfirmacao' AND id_unidade = '$unidade' AND confirmado = '0' AND ag.id_func = '$idfuncionario' AND DATEDIFF( data_agendada_agendamento, data_cadastro_agendamento) > '1' ";
        $resultado_pg = mysqli_query($conn, $result_pg);
        $row_pg = mysqli_fetch_assoc($resultado_pg);
        //echo $row_pg['num_result'];
        //Quantidade de pagina 
        $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);
        
        //Limitar os link antes depois
        $max_links = 10;
        echo "<a href='confirmacaonew.php?pagina=1'>Primeira</a> ";
        
        for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
            if($pag_ant >= 1){
                echo "<a href='confirmacaonew.php?pagina=$pag_ant'>$pag_ant</a> ";
            }
        }
            
        echo "$pagina ";
        
        for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
            if($pag_dep <= $quantidade_pg){
                echo "<a href='confirmacaonew.php?pagina=$pag_dep'>$pag_dep</a> ";
            }
        }
        
        echo "<a href='confirmacaonew.php?pagina=$quantidade_pg'>Ultima</a>";


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
<script src="JS/jquery.fileuploadmulti.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
     {

     var settings = {
        url: "importar.php",
        method: "POST",
        allowedTypes:"jpg",
        fileName: "file",
        multiple: true,
        
        onSuccess:function(files,data,xhr)
        {
           //faz alguma coisa

        },
     
         afterUploadAll:function()
         {
            $(".upload-bar").css("animation-play-state","paused");
            
         },
        onError: function(files,status,errMsg)
        {       
          
            alert(errMsg);
        }

        
     }
     $("#mulitplefileuploader").uploadFile(settings);
        
     });
</script>
<?php
    }else{
        $_SESSION['msg'] = "<div class='alert alert-info' role='alert'>
                                            Àrea Restrita!
                             </div>";
        header("Location: loginpage.php");

    }

?>