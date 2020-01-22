                <div class="card col-md-6 no-padding ">
                                <div class="card-body">
                                    <div class="h1 text-muted text-right mb-4">
                                        <i class="fa fa-user-plus"></i>
                                    </div>
                                    <div class="h4 mb-0">
                                        <span class="count">
                                            <?php
                                                $contagem_agendamento = "SELECT id_agendamentos FROM agendamentos WHERE id_func = '$idfuncionario'AND reagendado = '0' AND id_status_auditoria = '2' AND DATE(data_cadastro_agendamento) = DATE(NOW())";
                                                $resultado_contagem_agendamento = mysqli_query($conn, $contagem_agendamento);
                                                $resultado_final_agendamento = mysqli_num_rows($resultado_contagem_agendamento);
                                                echo $resultado_final_agendamento;
                                            ?>
                                        </span>
                                    </div>
                                    <small class="text-muted text-uppercase font-weight-bold">Novos Agendamentos (Dia)</small>
                                    <div class="progress progress-xs mt-3 mb-0 bg-flat-color-2" style="width: 40%; height: 5px;"></div>
                                </div>
                            </div>
                <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-money text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Pontuação(Mês)</div>
                                        <div class="stat-digit">
                                        <?php
                                            $comissao_mensal = "SELECT SUM(`din_instagram_bon`) AS valor_insta, SUM(`din_wts_bon`) AS valor_wts, SUM(`din_lig_bon`) AS valor_lig FROM `bonificacao` WHERE `id_func` = '$idfuncionario' AND MONTH(`data_registro_bon`) = MONTH(DATE(NOW()))";
                                            $result_comissao_mensal = mysqli_query($conn, $comissao_mensal);
                                            $row_comissao_mensal = mysqli_fetch_assoc($result_comissao_mensal);
                                            $din_insta = $row_comissao_mensal['valor_insta'];
                                            $din_lig = $row_comissao_mensal['valor_lig'];
                                            $din_wts = $row_comissao_mensal['valor_wts'];
                                            $comissao_final = $din_lig + $din_wts + $din_insta;
                                            echo $comissao_final."Pontos";
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-layout-grid2 text-warning border-warning"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Agendados(Mês)</div>
                                        <div class="stat-digit"><?php 
                                         $select_agendados_mes = "SELECT * FROM `agendamentos` WHERE id_func = '$idfuncionario' AND MONTH(data_cadastro_agendamento) = MONTH(NOW());";
                                         $exec_select_agendados_mes = mysqli_query($conn, $select_agendados_mes);
                                         $qtd_agendados_mes = mysqli_num_rows($exec_select_agendados_mes);
                                         echo $qtd_agendados_mes;
                                        ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-layout-grid2 text-warning border-warning"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Comparecimento(Mês)</div>
                                        <div class="stat-digit"><?php echo "0"; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-6 no-padding ">
                                <div class="card-body">
                                    <div class="h1 text-muted text-right mb-4">
                                        <i class="fa fa-user-plus"></i>
                                    </div>
                                    <div class="h4 mb-0">
                                        <span class="count">
                                            <?php
                                            
                                            ?>
                                        </span>
                                    </div>
                                    <small class="text-muted text-uppercase font-weight-bold">Agendamentos Negados</small>
                                    <div class="progress progress-xs mt-3 mb-0 bg-flat-color-2" style="width: 40%; height: 5px;"></div>
                                </div>
                            </div>
                            <!-- FIM NEGADOS -->
                        <!-- AGENDAMENTOS NA AUDITORIA -->
                            <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-layout-grid2 text-warning border-warning"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Agendamentos em Auditoria</div>
                                        <div class="stat-digit"><?php 
                                            $select_agendados_aguardando = "SELECT * FROM `agendamentos` WHERE id_func = '$idfuncionario' AND id_status_auditoria = '1' AND reagendado = '0' AND MONTH(data_cadastro_agendamento) = MONTH(NOW());";
                                            $exec_select_agendados_aguardando = mysqli_query($conn, $select_agendados_aguardando);
                                            $qtd_agendados_aguardando = mysqli_num_rows($exec_select_agendados_aguardando);
                                            if($qtd_agendados_aguardando > 0){
                                                echo $qtd_agendados_aguardando;
                                            }else{
                                                echo "0";
                                            };
                                        ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FIM AGENDAMENTOS -->
                    <!-- AGENDAMENTOS NO SISTEMA -->
                        <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-layout-grid2 text-warning border-warning"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Agendamentos em Sistema</div>
                                        <div class="stat-digit"><?php 
                                            $select_agendados_sistema = "SELECT * FROM `agendamentos` WHERE id_func = '$idfuncionario'";
                                            $exec_select_agendados_sistema = mysqli_query($conn, $select_agendados_sistema);
                                            $qtd_agendados_sistema = mysqli_num_rows($exec_select_agendados_sistema);
                                            if($qtd_agendados_sistema > 0){
                                                echo $qtd_agendados_sistema;
                                            }else{
                                                echo "0";
                                            };
                                        ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FIM AGENDAMENTOS NO SISTEMA -->
                    <!-- -->

                    <!-- ######### FIM INDEX SCOUTER ######## -->
                    