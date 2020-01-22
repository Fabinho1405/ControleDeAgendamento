<?php
    session_start();
   if(!empty($_SESSION['id_usuario']) AND $_SESSION['permissao'] != 1 AND $_SESSION['menu_recepcao'] == 1){
    include_once("conection/connection.php");
    $pdo=conectar();
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

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Adicionando Javascript -->
    <script type="text/javascript" >
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
            //document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
            //document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";
                //document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>



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
                            <strong class="card-title">Cadastrar</strong> Ordem de Fechamento <small>Versão Atualizada.</small>
                        </div>
                        <div class="card-body"> 
                        <?php
                        if(isset($_SESSION['errorCad'])){
                            echo "<div class='alert alert-danger' role='alert'>
                            ".$_SESSION['errorCad']." 
                            </div>";
                            unset($_SESSION['errorCad']);
                        };
                        ?>
                            <form action="actions/actCadastrarOrdemFechamento.php" method="POST" name="cadastrarOrdem">
                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">Nome Completo do Modelo:<b><font color="red">*</font></b></label>
                                </div>
                                <div class="col-12 col-md-6">                  
                                        <input type="text" id="email-input" name="nome_modelo" placeholder="" class="form-control" value="<?php if(!empty($nomemodelo)){echo $nomemodelo;}else{} ?>" required>
                                </div>
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">Data de Nascimento do Modelo:<b><font color="red">*</font></b></label>
                                </div>
                                <div class="col-12 col-md-2">                  
                                        <input type="date" id="email-input" name="nascimento_modelo" placeholder="" class="form-control" value="<?php if(!empty($nomemodelo)){echo $nomemodelo;}else{} ?>" required>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">RG do Modelo:<b><font color="red">*</font></b></label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="text" id="rg" name="rg_modelo" placeholder="" class="form-control" value="" required>
                                </div>
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">CPF do Modelo:<b><font color="red">*</font></b></label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="text" id="cpf" name="cpf_modelo" placeholder="" class="form-control" value="" required>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">Nome Completo do Responsável:</label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" id="text-input" name="responsavel_modelo" placeholder="Preencha apenas se o modelo for menor de 18 anos" class="form-control" value="">
                                </div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-2">
                                <label for="text-input" class=" form-control-label">RG do Responsável:</label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" id="rg2" name="rg_responsavel" placeholder="" class="form-control" value="">
                            </div> 

                            <div class="col col-md-2">
                                <label for="text-input" class=" form-control-label">CPF do Responsável:</label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" id="cpf2" name="cpf_responsavel" placeholder="" class="form-control" value="">
                            </div>      
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-2">
                                <label for="text-input" class=" form-control-label">Estado Civil do Modelo:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-4">
                                <select name="civil_modelo" class="form-control" required>
                                    <option value="">Selecionar ...</option>
                                    <option value="Solteiro">Solteiro</option>
                                    <option value="Casado"> Casado</option>
                                    <option value="Divorciado">Divorciado</option>
                                    <option value="Não Informou">Não Informou</option>                                 
                                </select>
                            </div>  
                            <div class="col col-md-2">
                                <label for="text-input" class=" form-control-label">Profissão do Modelo:</label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" id="rg2" name="profissao_modelo" placeholder="Se não tiver, coloque a do responsável" class="form-control" value="">
                            </div>      
                          </div>

                          <div class="row form-group">
                                <div class="col col-md-2">
                                    <label for="text-input" class=" form-control-label">CEP Informado na Ficha:<b><font color="red">*</font></b></label>
                                </div>
                                <div class="col-12 col-md-3">
                                    <input type="text" id="cep" name="cep" maxlength="9" class="form-control" value="" onblur="pesquisacep(this.value);" required>
                                </div>       
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-2">
                                <label for="text-input" class=" form-control-label">Endereço:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" id="rua" name="rua" placeholder="" class="form-control" value="" required>
                            </div>
                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Número:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" id="text-input" name="numero" placeholder="" class="form-control" value="" required>
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-2">
                                <label for="text-input" class=" form-control-label">Complemento: </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" id="text-input" name="complemento_modelo" placeholder="Ex: Bloco B - Apto 41 / Casa 2" class="form-control" value="">
                            </div>

                            <div class="col col-md-2">
                                <label for="text-input" class=" form-control-label">Bairro:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" id="bairro" name="bairro" placeholder="" class="form-control" value="" required>
                            </div>
                            </div>

                            <div class="row form-group">
                            <div class="col col-md-2">
                                <label for="text-input" class=" form-control-label">Cidade:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" id="cidade" name="cidade" placeholder="" class="form-control" value="" required>
                            </div>

                            <div class="col col-md-2">
                                <label for="text-input" class=" form-control-label">UF:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" id="uf" name="uf" placeholder="" class="form-control" value="" required>
                            </div>
                          </div>  

                          <div class="row form-group">
                            <div class="col col-md-2">
                                <label for="text-input" class=" form-control-label">Telefone Celular:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" id="celular" name="telefoneprincipal_modelo" placeholder="" class="form-control" value="" required>
                            </div>
                            <div class="col col-md-2">
                                <label for="text-input" class=" form-control-label">Telefone Residencial: </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <input type="text" id="residencial" name="telefonesecundario_modelo" placeholder="Caso não houver deixe em branco" class="form-control" value="">
                            </div>
                          </div> 

                          <div class="row form-group">
                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Instagram: </label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" id="text-input" name="instagram_modelo" placeholder="" class="form-control" value="">
                            </div>

                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Facebook: </label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" id="text-input" name="facebook_modelo" placeholder="" class="form-control" value="">
                            </div>

                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">E-mail:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="email" id="text-input" name="email_modelo" placeholder="" class="form-control" value="">
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Nome Artístico: </label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" id="text-input" name="nome_artistico_modelo" placeholder="" class="form-control" value="">
                            </div>

                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Altura:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-1">
                                <input type="text" id="altura" name="altura_modelo" placeholder="" class="form-control" value="">
                            </div>

                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Peso:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-1">
                                <input type="text" id="peso" name="peso_modelo" placeholder="" class="form-control" value="">
                            </div>

                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Manequim:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-1">
                                <input type="text" id="manequim" name="manequim_modelo" placeholder="" class="form-control" value="" maxlenght="3">
                            </div>

                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Sapato:<b><font color="red">*</font></b> </label>
                            </div>
                            <div class="col-12 col-md-1">
                                <input type="text" id="sapatos" name="sapato_modelo" placeholder="" class="form-control" value="">
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Cor dos Olhos:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-3">
                                <select name="olhos_modelo" class="form-control" required>
                                    <option value="">Selecionar ...</option>
                                    <option value="Não Informado">Não Informado</option>
                                    <option value="Azul">Azul</option>
                                    <option value="Verde">Verde</option>
                                    <option value="Castanho Claro">Castanho Claro</option>
                                    <option value="Castanho Escuto">Castanho Escuro</option>                           
                                </select>
                            </div>
                            <div class="col col-md-1"><label for="text-input" class=" form-control-label">Cor do Cabelo:<b><font color="red">*</font></b></label></div>
                            <div class="col-12 col-md-3">
                                <select name="cabelo_modelo" class="form-control" required>
                                    <option value="">Selecionar ...</option>
                                    <option value="Não Informado">Não Informado</option>
                                    <option value="Castanho Claro">Castanho Claro</option>
                                    <option value="Castanho Escuro">Castanho Escuro</option>
                                    <option value="Preto">Preto</option>
                                    <option value="Loiro">Loiro</option>                               
                                </select>
                            </div>   
                            <div class="col col-md-1"><label for="text-input" class=" form-control-label">Etnia:<b><font color="red">*</font></b></label></div>
                            <div class="col-12 col-md-3">
                                <select name="etnia_modelo" class="form-control" required>
                                    <option value="">Selecionar ...</option>
                                    <option value="Não Informado">Não Informado</option>
                                    <option value="Branco">Branco</option>
                                    <option value="Negro">Negro</option>
                                    <option value="Pardo">Pardo</option>
                                    <option value="Albino">Albino</option>                                 
                                </select>
                            </div> 
                          </div>   
                          <div class="row form-group">
                            <div class="col col-md-1"><label for="text-input" class=" form-control-label">Material:<b><font color="red">*</font></b></label></div>
                            <div class="col-12 col-md-3">

                                <?php
                                    if($unidade == 4){
                                ?>
                                <select name="material_modelo" class="form-control">
                                    <option value="Agenciamento">Agênciamento</option>
                                    <option value="B1">Book Fotográfico TIPO 1</option>
                                    <option value="B2">Book Fotográfico TIPO 2</option>
                                    <option value="B3">Book Fotográfico TIPO 3</option>
                                    <option value="B4">Book Fotográfico TIPO 4</option>                            
                                </select>
                                <?php
                                    }else if($unidade == 1){
                                ?>
                                <select name="material_modelo" class="form-control" required>
                                    <option value="">Selecionar ...</option>
                                    <option value="Agenciamento">Agênciamento</option>
                                    <option value="Basic">Book Fotográfico Basic</option>
                                    <option value="Classic">Book Fotográfico Classic</option>
                                    <option value="Elegance">Book Fotográfico Elegance</option>
                                    <option value="Exclusive">Book Fotográfico Exclusive</option>                            
                                </select>
                                <?php
                                    };
                                ?>
                            </div> 
                            <div class="col col-md-1"><label class=" form-control-label">Produtor:<b><font color="red">*</font></b></label></div>
                            <div class="col-12 col-md-3">
                              
                              <select name="select_produtor" id="select" class="form-control" required>
                                    <option value="">Selecionar ...</option>
                                <?php 
                                    $pesquisaProdutor=$pdo->prepare("SELECT * FROM funcionario WHERE menu_produtor=1 AND id_unidade=:unidadeFunc");
                                    $pesquisaProdutor->bindValue(":unidadeFunc", $unidade);
                                    $pesquisaProdutor->execute();
                                    $linhaProdutor=$pesquisaProdutor->fetchall(PDO::FETCH_OBJ);
                                    foreach($linhaProdutor as $rowProdutor){

                                ?>
                                <option value="<?php echo $rowProdutor->id_func; ?>"><?php echo $rowProdutor->nome_completo_func;  ?></option>
                               <?php
                                    };
                               ?>
                              </select>
                            </div>

                            <div class="col col-md-1"><label class=" form-control-label">Scouter:<b><font color="red">*</font></b></label></div>
                            <div class="col-12 col-md-3">
                              
                              <select name="select_scouter" id="select" class="form-control" required>
                                    <option value="">Selecionar ...</option>
                                <?php 
                                    $pesquisaScouter=$pdo->prepare("SELECT * FROM funcionario WHERE menu_scouter_insta=1 AND id_unidade=:unidadeFunc AND acesso_direto=1 OR menu_scouter_ligacao_new=1 AND id_unidade=:unidadeFunc AND acesso_direto=1 OR menu_scouter_face=1 AND id_unidade=:unidadeFunc AND acesso_direto=1 OR menu_scouter_wts=1 AND id_unidade=:unidadeFunc AND acesso_direto=1 ORDER BY nome_completo_func ASC");
                                    $pesquisaScouter->bindValue(":unidadeFunc", $unidade);
                                    $pesquisaScouter->execute();
                                    $linhaScouter=$pesquisaScouter->fetchall(PDO::FETCH_OBJ);
                                    foreach($linhaScouter as $rowScouter){ 
                                ?>
                                <option value="<?php echo $rowScouter->id_func; ?>"><?php echo $rowScouter->nome_completo_func; if(!empty($rowScouter->pseudoNomeFunc)){echo " <b>(".$rowScouter->pseudoNomeFunc.")</b>";}else{ };  ?></option>
                               <?php
                                    };
                               ?>
                              </select>
                            </div>
                          </div>

                          <div class="row form-group"> 
                          <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Inclusão de Poster?: </label>
                            </div>
                            <div class="col-12 col-md-3">
                                <select name="possuiPoster" class="form-control">
                                    <option value='0'>Não</option>
                                    <option value='1'>Sim</option>
                                </select>
                            </div>

                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Valor do Material:<b><font color="red">*</font></b></label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" id="text-input" name="valor_material" placeholder="Ex: 1500" class="form-control" value="" required>
                            </div>
                            
                            <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label">Encaminhar para Estúdio?: </label>
                            </div>
                            <div class="col-12 col-md-3">
                                <select name="encaminhaEstudio" class="form-control">
                                    <option value='1'>Sim</option>
                                    <option value='0'>Não</option>                                    
                                </select>
                            </div>
                          </div>
                          <div class="row form-group">
                          <div class="col col-md-1">
                                <label for="text-input" class=" form-control-label"><input type="submit" value="Cadastrar Ordem"></label>
                            </div>
                            
                          </div>
                          </form>


                          


    


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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#rg").mask("00.000.000-0");
            $("#cpf").mask("000.000.000-00");
            $("#rg2").mask("00.000.000-0");
            $("#cpf2").mask("000.000.000-00");
            $("#celular").mask("(00)00000-0000");
            $("#residencial").mask("(00)0000-0000");
            $("#altura").mask("0.00");
            $("#peso").mask("00.00");
            $("#sapatos").mask("00/00");


            

        });

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