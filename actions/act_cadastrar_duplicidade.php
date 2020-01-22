<?php                         
                            session_start();
                            ob_start();
                            include_once("../conection/conexao.php");
                             $idfuncionario = $_SESSION['id_usuario'];
 
                             $nome_modelo = $_POST['nomecliente'];
                             $idade = $_POST['idade_cliente'];
                             $telefone_principal = $_POST['telefoneprincipal'];
                             $telefone_secundario = $_POST['telefonesecundario'];
                             $nome_responsavel = $_POST['responsavel'];
                             $data_agendamento = $_POST['data_agendado'];
                             $hora_agendamento = $_POST['hora_agendado'];
                             $select_unidade = $_POST['select_unidade'];
                             $select_scouter = $_POST['select_scouter'];

                             if(empty($nome_modelo)){
                                 $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Nome do Cliente!
                                    </div>";
                                    header("Location:../cadastrar_agendamento_ligacao.php");
                             }else if(empty($idade)){
                                $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Idade do Cliente!
                                    </div>";
                                    header("Location:../cadastrar_agendamento_ligacao.php");
                             }else if(empty($telefone_principal)){
                                $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Telefone Principal do Cliente!
                                    </div>";
                                    header("Location:../cadastrar_agendamento_ligacao.php");
                             }else if(empty($data_agendamento)){
                                $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Data de Agendamento!
                                    </div>";
                                    header("Location:../cadastrar_agendamento_ligacao.php");
                             }else if(empty($hora_agendamento)){
                                $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Hora do Agendamento!
                                    </div>";
                                    header("Location:../cadastrar_agendamento_ligacao.php");
                             }else if(empty($select_unidade)){
                                $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Unidade do Agendamento!
                                    </div>";
                                    header("Location:../cadastrar_agendamento_ligacao.php");
                             }else{

                            // Cadastrar o Cliente
                            $inserir_cliente = "INSERT INTO cliente (nome_cliente, telefone_cliente,telefone2_cliente,idade_cliente,nome_responsavel_cliente, id_meio_captado, data_cadastro_cliente,id_func) VALUES ('$nome_modelo','$telefone_principal','$telefone_secundario','$idade','$nome_responsavel','3',NOW(),'$select_scouter')";
                            $inserir_cliente_resultado = mysqli_query($conn, $inserir_cliente);
                            
                            // Procurar Novo Cliente
                            $procurar_cliente = "SELECT * FROM cliente WHERE nome_cliente = '$nome_modelo' AND telefone_cliente = '$telefone_principal'";
                            $procurar_cliente_resultado = mysqli_query($conn, $procurar_cliente);
                            $row_procurar_cliente = mysqli_fetch_assoc($procurar_cliente_resultado);
                            $id_new_cliente = $row_procurar_cliente['id_cliente']; 

                            //Cadastrar Agendamento Com Novo Cliente
                            $data_agendamento_ajuste = date('Y-m-d', strtotime($data_agendamento));
                            $inserir_agendamento = "INSERT INTO agendamentos (id_agendamentos,data_agendada_agendamento,hora_agendada_agendamento,data_cadastro_agendamento,id_conta_utilizada,id_cliente, id_meio_captado, id_status_auditoria,id_status_sistema, id_func, id_comparecimento, id_unidade, confirmado) VALUES (NULL, '$data_agendamento_ajuste', '$hora_agendamento', NOW(), NULL, '$id_new_cliente', NULL, NULL, '1', '$select_scouter', '3', '$select_unidade', '0')";

                            $inserir_agendamento_resultado = mysqli_query($conn, $inserir_agendamento); 
                            $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
                            header("Location:../cadastrar_agendamento_ligacao.php");
                        }


                            
                            







?>