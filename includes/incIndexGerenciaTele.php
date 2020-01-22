                        <div class="card col-md-6 no-padding ">
                                <div class="card-body">
                                    <div class="h1 text-muted text-right mb-4">
                                        <i class="fa fa-user-plus"></i>
                                    </div>
                                    <div class="h4 mb-0">
                                        <span class="count">
                                            <?php
                                                $contagem_agendamento = "SELECT id_agendamentos FROM agendamentos WHERE data_agendada_agendamento = DATE(NOW()) AND id_comparecimento = '1' AND id_unidade = '$unidadefunc'";
                                                $resultado_contagem_agendamento = mysqli_query($conn, $contagem_agendamento);
                                                $resultado_final_agendamento = mysqli_num_rows($resultado_contagem_agendamento);
                                                echo $resultado_final_agendamento;
                                            ?>
                                        </span>
                                    </div>
                                    <small class="text-muted text-uppercase font-weight-bold">Subidas (Dia)</small>
                                    <div class="progress progress-xs mt-3 mb-0 bg-flat-color-2" style="width: 40%; height: 5px;"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-money text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Fechamento Total(Dia)</div>
                                        <div class="stat-digit">
                                        <?php 

                                            if($unidadefunc == 4){
                                            $select_fechamentos = "SELECT * FROM clientes_concept WHERE DATE(data_cadastro_cc) = DATE(NOW())";
                                            $exec_fechamentos = mysqli_query($conn, $select_fechamentos);
                                            $valor_inicial = 0;
                                            while($row_valores = mysqli_fetch_assoc($exec_fechamentos)){
                                                $valor_inicial = $valor_inicial + $row_valores['valor_material_cc'];
                                            };

                                            }else if($unidadefunc == 1){
                                                $select_fechamentos = "SELECT * FROM clientes_exclusive WHERE DATE(data_cadastro_cc) = DATE(NOW())";
                                            $exec_fechamentos = mysqli_query($conn, $select_fechamentos);
                                            $valor_inicial = 0;
                                            while($row_valores = mysqli_fetch_assoc($exec_fechamentos)){
                                                $valor_inicial = $valor_inicial + $row_valores['valor_material_cc'];
                                            };
                                            }

                                           // echo "R$".number_format($valor_inicial, 2, ',', '.')."<br><small><a href='fechamento_diario.php'>Detalhes</a></small>";
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>