 <h3 class="menu-title">Recepção</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Cliente</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-calendar"></i><a href="marcar_presenca.php">Marcar Presença</a></li>              
                            <li><i class="fa fa-calendar"></i><a href="pesquisar_cliente_ag.php">Pesquisar Contrato</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Despesas</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-calendar"></i><a href="lancar_despesas.php">Lancar Despesa</a></li>                
                            <li><i class="fa fa-calendar"></i><a href="listar_despesas.php">Listar Despesas</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Financeiro</a>
                        <ul class="sub-menu children dropdown-menu">
                            <?php if($_SESSION['unidade'] == 1){ ?>
                            <li><i class="fa fa-calendar"></i><a href="cadastrarOrdemFechamento">Ordem de Fechamento</a></li> 
                            <?php }else{ ?>
                                <li><i class="fa fa-calendar"></i><a href="cadastrarOrdemFechamento">Ordem de Fechamento</a></li>
                            <?php }; ?>     
                            <li><i class="fa fa-calendar"></i><a href="ultimas_baixas.php">Ultimas Baixas</a></li>
                        </ul> 
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Fechamentos</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-calendar"></i><a href="resumo_dia_ag.php">Resumo do Dia</a></li>
                            <li><i class="fa fa-calendar"></i><a href="fila_contratos.php">Fila de Contratos</a></li>
                            <li><i class="fa fa-calendar"></i><a href="puxarContratoRecep.php">Encaminhar P.C</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Trabalhos e Seleções</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-calendar"></i><a href="encaminha_trabalho.php">Marcar Trabalho</a></li>
                            <li><i class="fa fa-calendar"></i><a href="encaminha_selecao.php">Marcar Seleção</a></li>
                        </ul>
                    </li> 