       
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

                            <div class="card col-md-6 no-padding ">
                                <div class="card-body">
                                    <div class="h1 text-muted text-right mb-4">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="h4 mb-0">
                                        <span class="count">
                                            <?php
                                                $select_agendados_mes = "SELECT * FROM `agendamentos` WHERE id_func = '$idfuncionario' AND MONTH(data_cadastro_agendamento) = MONTH(NOW());";
                                                 $exec_select_agendados_mes = mysqli_query($conn, $select_agendados_mes);
                                                 $qtd_agendados_mes = mysqli_num_rows($exec_select_agendados_mes);
                                                 echo $qtd_agendados_mes;
                                            ?>
                                        </span>
                                    </div>
                                    <small class="text-muted text-uppercase font-weight-bold">Agendados(Mês)</small>
                                    <div class="progress progress-xs mt-3 mb-0 bg-flat-color-2" style="width: 40%; height: 5px;"></div>
                                </div>
                            </div>
                            <br>
                            <!-- CARD DE ATUALIZAÇÕES -->
                           <div class="card col-md-12 no-padding ">
                                <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">Atualizações!</h4>
                                            <p>Mantenha sempre os padrões solicitados pelo sistema, assim poderemos ter um melhor funcionamento e evitarmos futuros problemas. Caso ainda tenha dúvidas, solicite ao seu supervisor.</p>
                                            <hr>
                                            <p class="mb-0">- Admin Sistema</p>
                            </div>
                           </div>
                           <!-- FIM CARD -->

                            <!-- INICIO GRAFICO -->
                        <div class="card col-md-12 no-padding ">
                            <script type="text/javascript">
                              google.charts.load('current', {'packages':['corechart']});
                              google.charts.setOnLoadCallback(drawChart);
                              function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                  ['Data', 'Fichas Liberadas', 'Agendados no Dia', 'Presença na Agência', 'Agendados para o Dia', 'Quantidade de Ligações'],
                                  <?php
                                    $mesatual = date("m");
                                    $d1 = '2019-'.$mesatual.'-01';
                                    $datasemnada = date("Y-m-d");
                                    $d2 = date('Y-m-d', strtotime("+3 days",strtotime($datasemnada)));
                                    $timestamp1 = strtotime( $d1 );
                                    $timestamp2 = strtotime( $d2 );
                                    $pdo=conectar();
                                    while ($timestamp1 <= $timestamp2)
                                    {                                         

                                        $dataexibida = date('d/m/Y', $timestamp1);
                                        $datapesquisa = date('Y-m-d', $timestamp1);

                                        $qtdFichaLiberada=$pdo->prepare("SELECT * FROM controle_ligacao WHERE id_func=:idFunc AND date(data_liberada_stand_by)=:dataAtual");
                                        $qtdFichaLiberada->bindValue(":idFunc", $idfuncionario);
                                        $qtdFichaLiberada->bindValue(":dataAtual", $datapesquisa);
                                        $qtdFichaLiberada->execute();
                                        $qtdTotalFichaLiberada=$qtdFichaLiberada->rowCount();

                                        $qtdFeedBack=$pdo->prepare("SELECT * FROM controle_fb_ligacao WHERE date(hora_ligacao) = :dataAtual AND id_func=:idFunc");
                                                $qtdFeedBack->bindValue(":dataAtual", $datapesquisa);
                                                $qtdFeedBack->bindValue(":idFunc", $idfuncionario);
                                                $qtdFeedBack->execute();
                                                $qtdTotalFeedBack=$qtdFeedBack->rowCount();

                                        $totalAgendamentos=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFunc AND date(data_cadastro_agendamento)=:dataAtual AND reagendado=:reagendado");
                                        $totalAgendamentos->bindValue(":idFunc", $idfuncionario);
                                        $totalAgendamentos->bindValue(":dataAtual", $datapesquisa);
                                        $totalAgendamentos->bindValue(":reagendado", 0);
                                        $totalAgendamentos->execute();
                                        $qtdTotalAgendamentos=$totalAgendamentos->rowCount();

                                        $totalAgendamentosDia=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFunc AND date(data_agendada_agendamento)=:dataAtual AND reagendado=:reagendado");
                                        $totalAgendamentosDia->bindValue(":idFunc", $idfuncionario);
                                        $totalAgendamentosDia->bindValue(":dataAtual", $datapesquisa);
                                        $totalAgendamentosDia->bindValue(":reagendado", 0);
                                        $totalAgendamentosDia->execute();
                                        $qtdTotalAgendamentosDia=$totalAgendamentosDia->rowCount();

                                        $presencaAgencia=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFunc AND date(data_agendada_agendamento)=:dataAtual AND id_comparecimento=:comparecimento");
                                        $presencaAgencia->bindValue(":idFunc", $idfuncionario);
                                        $presencaAgencia->bindValue(":dataAtual", $datapesquisa);
                                        $presencaAgencia->bindValue(":comparecimento", 1);
                                        $presencaAgencia->execute();
                                        $qtdTotalPresencaAgencia=$presencaAgencia->rowCount();


                                  ?>          
                                  ['<?php echo $dataexibida; ?>', <?php echo $qtdTotalFichaLiberada; ?>,<?php echo $qtdTotalAgendamentos; ?>,<?php echo $qtdTotalPresencaAgencia; ?>, <?php echo $qtdTotalAgendamentosDia; ?>,<?php echo $qtdTotalFeedBack; ?>],
                                  <?php
                                    $timestamp1 += 86400;
                                    };
                                  ?>
                                ]);

                                var options = { 
                                  title: 'Desempenho Mensal Individual',
                                  curveType: 'function',
                                  legend: { position: 'bottom' }
                                };

                                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                                chart.draw(data, options);
                              }
                            </script>
                            <div id="curve_chart" style="width: 100%; height: 600px"></div>
                        </div>
                       
                     