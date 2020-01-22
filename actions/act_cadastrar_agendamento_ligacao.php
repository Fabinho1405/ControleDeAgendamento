<?php                         
                            session_start();
                            ob_start();
                            include_once("../conection/conexao.php");
                             $idfuncionario = $_SESSION['id_usuario'];
                             $unidade = $_SESSION['unidade'];
                             $idficha = $_GET['idficha'];
 
                             $nome_modelo = $_POST['nomecliente'];
                             $idade = $_POST['idade_cliente'];
                             $telefone_principal = $_POST['telefoneprincipal'];
                             $telefone_secundario = $_POST['telefonesecundario'];
                             $nome_responsavel = $_POST['responsavel'];
                             $data_agendamento = $_POST['data_agendado'];
                             $hora_agendamento = $_POST['hora_agendado'];
                             $select_unidade = $_POST['select_unidade'];

                             if(empty($nome_modelo)){
                                 $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Nome do Cliente!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                             }else if(empty($idade)){
                                $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Idade do Cliente!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                             }else if(empty($telefone_principal)){
                                $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Telefone Principal do Cliente!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                             }else if(empty($data_agendamento)){
                                $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Data de Agendamento!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                             }else if(empty($hora_agendamento)){
                                $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Hora do Agendamento!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                             }else if(empty($select_unidade)){
                                $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Unidade do Agendamento!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                             }else{
                                //VERIFICA DUPLICIDADE NO NÚMERO DE TELEFONE
                                $select_duplicidade_num = "SELECT id_cliente FROM cliente WHERE telefone_cliente = '$telefone_principal'";
                                $exec_select_duplicidade_num = mysqli_query($conn, $select_duplicidade_num);
                                $cont_linha_result = mysqli_num_rows($exec_select_duplicidade_num);

                                if($cont_linha_result > 0){
                                    //TEM DUPLICIDADE EM RELAÇÃO AO NÚMERO
                                    $_SESSION['msgcad'] = "<div class='alert alert-warning' role='alert'>Cliente já cadastrado. Entre em contato com o seu supervisor. #14006</div>";
                                    header("Location: ../cadastrar_agendamento_ligacao.php");

                                }else{

                                //Insere no LOG apenas de ligação que a ficha foi agendada
                                    $select_n_fedback = "SELECT * FROM controle_fb_ligacao WHERE id_ficha = $idficha";
                                    $exec_select_n_fedback = mysqli_query($conn, $select_n_fedback);
                                    $qtd_select_n_fedback = mysqli_num_rows($exec_select_n_fedback);
                                    $qtd_final_n_fedback = $qtd_select_n_fedback + 1;

                                    $log_ficha_agendado = "INSERT controle_fb_ligacao(id_func, num_fedback, id_unidade, hora_ligacao, id_ficha,status) VALUES ($idfuncionario,$qtd_final_n_fedback,$unidade,NOW(),$idficha, 2)";
                                    mysqli_query($conn, $log_ficha_agendado);


                             //Desabilitar Ficha do Sistema
                            $desabilitar_cliente_ficha = "UPDATE controle_ligacao SET id_status_sistema = 0, id_extracao = 1, id_func = '$idfuncionario', data_extracao = NOW(), ultimo_fedback = NOW(), qtd_feedback = '$qtd_final_n_fedback' WHERE id_controle = '$idficha'";
                            $desabilitar_cliente_ficha_resultado = mysqli_query($conn, $desabilitar_cliente_ficha);

                            // Cadastrar o Cliente
                            $inserir_cliente = "INSERT INTO cliente (nome_cliente, telefone_cliente,telefone2_cliente,idade_cliente,nome_responsavel_cliente, id_meio_captado, data_cadastro_cliente,id_func) VALUES ('$nome_modelo','$telefone_principal','$telefone_secundario','$idade','$nome_responsavel','3',NOW(),'$idfuncionario')";
                            $inserir_cliente_resultado = mysqli_query($conn, $inserir_cliente);
                            
                            // Procurar Novo Cliente
                            $procurar_cliente = "SELECT * FROM cliente WHERE nome_cliente = '$nome_modelo' AND telefone_cliente = '$telefone_principal'";
                            $procurar_cliente_resultado = mysqli_query($conn, $procurar_cliente);
                            $row_procurar_cliente = mysqli_fetch_assoc($procurar_cliente_resultado);
                            $id_new_cliente = $row_procurar_cliente['id_cliente']; 

                            //Cadastrar Agendamento Com Novo Cliente
                            $data_agendamento_ajuste = date('Y-m-d', strtotime($data_agendamento));
                            $inserir_agendamento = "INSERT INTO agendamentos (id_agendamentos,data_agendada_agendamento,hora_agendada_agendamento,data_cadastro_agendamento,id_conta_utilizada,id_cliente, id_meio_captado, id_status_auditoria,id_status_sistema, id_func, id_comparecimento, id_unidade, confirmado, id_ficha) VALUES (NULL, '$data_agendamento_ajuste', '$hora_agendamento', NOW(), NULL, '$id_new_cliente', '3', '2', '1', '$idfuncionario', '3', '$select_unidade', '0', '$idficha')";

                            $inserir_agendamento_resultado = mysqli_query($conn, $inserir_agendamento); 
                            $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";

                             //LOG                                   
                               $ip_log = $_SERVER['REMOTE_ADDR'];
                               $idfuncionario = $_SESSION['id_usuario'];
                               $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'agendamento inserido LIG -> CLI: $id_new_cliente | FICH_OFF: $idficha', 'ALERTA', '$idfuncionario');";
                              $exec_insert_log = mysqli_query($conn, $insert_log);
                            //FIM LOG

                            header("Location:../cadastrar_agendamento_ligacao.php");
                        }
                        }


                            
                            







?>