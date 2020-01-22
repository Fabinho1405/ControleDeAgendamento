<?php                         
                            session_start();
                            ob_start();
                            include_once("../conection/conexao.php");
                             $idfuncionario = $_SESSION['id_usuario'];
                         
                            
                                $nomecliente = $_POST['nomecliente'];
                                $telefoneprincipal = $_POST['telefoneprincipal'];
                                $telefonesecundario = $_POST['telefonesecundario'];
                                $responsavel = $_POST['responsavel'];
                                $dataagendamento = $_POST['data_agendado'];
                                $horaagendamento = $_POST['hora_agendado'];
                                $conta_utilizada = $_POST['select_conta'];
                                $emailcliente = $_POST['email'];
                                $url_instagram = $_POST['urlinsta'];
                                $select_unidade = $_POST['select_unidade'];
                                $idade_cliente = $_POST['idade_cliente'];


                                /*echo $nomecliente."<br>";
                                echo $telefoneprincipal."<br>";
                                echo $telefonesecundario."<br>";
                                echo $responsavel."<br>";
                                echo $dataagendamento."<br>";
                                echo $horaagendamento."<br>";
                                echo $conta_utilizada."<br>";
                                echo $emailcliente."<br>";
                                echo $url_instagram."<br>";
                                echo $idfuncionario; */
                                //VERIFICAR ANTES DE INSERIR O CLIENTE SE ELE JA EXISTE

                                //VERIFICAR SE HÁ CAMPOS EM BRANCO
                                if(empty($nomecliente)){
                                    $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Nome do Cliente!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");

                                }else if(empty($idade_cliente)){
                                    $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Idade do Cliente!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                                }else if(empty($telefoneprincipal)){
                                    $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Telefone Principal do Cliente!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                                }else if(empty($dataagendamento)){
                                    $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Data do Agendamento!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                                }else if(empty($horaagendamento)){
                                    $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Hora do Agendamento!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                                }else if(empty($url_instagram)){
                                    $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o URL do Instagram!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                                }else if(empty($select_unidade)){
                                    $_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha a Unidade do Agendamento!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
                                }else{
                                    //VERIFICAR SE ESSE CLIENTE JÁ ESTA EM SISTEMA PELO TELEFONE
                                    $verif_cliente_telefoneprinc = "SELECT * FROM cliente WHERE telefone_cliente = '$telefoneprincipal'";
                                    $result_verif_cliente_telefoneprinc = mysqli_query($conn, $verif_cliente_telefoneprinc);
                                    $cont_verif_cliente_telefoneprinc = mysqli_num_rows($result_verif_cliente_telefoneprinc);
                                    //VERIFICAR SE ESSE CLIENTE JÁ ESTA EM SISTEMA PELA URL DO INSTAGRAM
                                    $verif_cliente_urlinsta = "SELECT * FROM cliente WHERE url_instagram = '$url_instagram' ";
                                    $result_verif_cliente_urlinsta = mysqli_query($conn, $verif_cliente_urlinsta);
                                    $cont_verif_cliente_urlinsta = mysqli_num_rows($result_verif_cliente_urlinsta);

                                    //
                                    if($cont_verif_cliente_telefoneprinc > 0){
                                        $_SESSION['msgcad'] = "<div class='alert alert-warning' role='alert'>
                                            Cliente já cadastrado! Entre em contato com seu supervisor. #14001
                                    </div>";
                                    header("Location:../cadastrar_agendamento_insta.php");
                                    }else if($cont_verif_cliente_urlinsta > 0){
                                         $_SESSION['msgcad'] = "<div class='alert alert-warning' role='alert'>
                                            Cliente já cadastrado! Entre em contato com seu supervisor. #14002
                                    </div>";
                                    header("Location:../cadastrar_agendamento_insta.php");
                                    }else{
                                $inserir_cliente = "INSERT INTO cliente (nome_cliente, telefone_cliente,telefone2_cliente,nome_responsavel_cliente,email_cliente,url_instagram,data_cadastro_cliente,id_func, idade_cliente, id_meio_captado) VALUES ('$nomecliente','$telefoneprincipal','$telefonesecundario','$responsavel','$emailcliente','$url_instagram',NOW(),'$idfuncionario', '$idade_cliente', '1')";

                                $inserir_cliente_resultado = mysqli_query($conn, $inserir_cliente);
                               $procurar_cliente = "SELECT * FROM cliente WHERE nome_cliente = '$nomecliente' AND telefone_cliente = '$telefoneprincipal'";

                                $procurar_cliente_resultado = mysqli_query($conn, $procurar_cliente);
                                $row_procurar_cliente = mysqli_fetch_assoc($procurar_cliente_resultado);
                                $id_new_cliente = $row_procurar_cliente['id_cliente']; 
                                $data_agendamento_ajuste = date('Y-m-d', strtotime($dataagendamento));
                                $inserir_agendamento = "INSERT INTO agendamentos (data_agendada_agendamento, hora_agendada_agendamento, data_cadastro_agendamento, id_cliente, id_status_sistema, id_func, id_comparecimento, id_conta_utilizada, id_unidade, id_meio_captado) VALUES ('$data_agendamento_ajuste','$horaagendamento',NOW(),'$id_new_cliente','1','$idfuncionario','3', '$conta_utilizada', '$select_unidade', '1')";
                                $inserir_agendamento_resultado = mysqli_query($conn, $inserir_agendamento); 
                            $_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Registrado com Sucesso!
                             </div>";
                            header("Location:../cadastrar_agendamento_insta.php");
                                }
                            }                          
                        
?>