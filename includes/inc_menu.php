    <?php
        $unidade = $_SESSION['unidade'];
    ?>
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><img src="images/logonovo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
            </div>
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"> 
                        <a href="index.php"> <i class="menu-icon fa fa-home"></i>Pagina Inicial <br><center> <?php if($unidade == 1){echo "Agency Exclusive";}else if($unidade == 4){echo "Agency Concept";}; ?></center></a>
                    </li>
                    <?php  
                        if($_SESSION['menu_gerencia'] == 1){ 
                            include_once("incMenuGerenciaTele.php");
                        }else{
                            
                        };

                       if($_SESSION['menu_auditoria'] == 1){
                            include_once("incMenuAuditoria.php");
                        }else{
                            
                        };

                        if($_SESSION['menu_recepcao'] == 1){
                            include_once("incMenuRecepcao.php");
                        }else{

                        };

                        if($_SESSION['menu_scouter_ligacao_new'] == 1){
                            include_once("incMenuScouterLigacao.php");
                        }else{

                        };

                        if($_SESSION['menu_scouter_face'] == 1){
                            include_once("incMenuScouterFace.php");
                        }else{

                        };

                        if($_SESSION['menu_scouter_insta'] == 1){
                            include_once("incMenuScouterInsta.php");
                        }else{

                        };

                        if($_SESSION['menu_scouter_wts'] == 1){
                            include_once("incMenuScouterWhatsapp.php");
                        }else{

                        };

                        if($_SESSION['menu_confirmacao'] == 1){
                            include_once("incMenuConfirmacao.php");
                        }else{

                        };

                        if($_SESSION['menu_produtor'] == 1){
                            include_once("incMenuProdutor.php");
                        }else{

                        };

                        if($_SESSION['menu_edicao'] == 1){
                            include_once("incMenuEdicao.php");
                        }else{

                        };

                        if($_SESSION['menu_fotografo'] == 1){
                            include_once("incMenuFotografo.php");
                        }else{

                        };

                        if($_SESSION['menu_producao'] == 1){
                            include_once("incMenuProducao.php");
                        }else{

                        };

                        if($_SESSION['menu_gerente_agencia'] == 1){
                            include_once("incMenuGerenciaAgencia.php");
                        }else{

                        };

                        if($_SESSION['menu_ligacao_interna'] == 1){
                            include_once("incMenuLigacaoInterna.php");
                        }else{

                        };
                     ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->