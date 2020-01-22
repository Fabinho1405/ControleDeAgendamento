<?php

    include_once("../conection/connection.php");
    $pdo=conectar();
    $unidade = 1; 
    


     function limpaAcentos($valor){
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("(", "", $valor);
        $valor = str_replace(")", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
        };  
           
        $cadastro = Array(
            "nomeCliente"=>$_POST['nome_modelo'],
            "idadeCliente"=>$_POST['nascimento_modelo'],
            "telefonePrincipal"=>limpaAcentos($_POST['telefone_principal']),
            "telefoneSecundario"=>limpaAcentos($_POST['telefone_secundario']),
            "nomeResponsavel"=>$_POST['nome_responsavel'],
            "email"=>$_POST['email'],
            "contaCaptacao"=>$_POST['select_conta_insta'],
            "instaCliente"=>$_POST['instaCli'],
            "dataAgendada"=>$_POST['data_agendada'],
            "horaAgendada"=>$_POST['hora_agendada'] 
        ); 

        function CadastrarAgendamento($nome, $nascimento, $telefone1, $telefone2, $nomeResponsavel){
            echo "OLÁ SENHOR SOU O ". $nome . "<br> Idade: ". $nascimento . "<br> Telefone 1: " . $telefone1 . "<br> Telefone 2: ". $telefone2;  

        };

        

// Verifica o instagram
            // URL DO SITE
            
ini_set('allow_url_fopen', 1); 
echo "CONTA DIGITADA: ".$cadastro['instaCliente'];
$contaDigitada=$cadastro['instaCliente'];

$ch = curl_init();
$url="https://www.instagram.com/".$contaDigitada."/";
echo "<br> URL DIGITADA: ".$url;

curl_setopt($ch, CURLOPT_URL, $url);
//
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER[‘HTTP_USER_AGENT’]);

$dadosSite =  curl_exec($ch);

 echo "<br> <textarea cols=”300″ rows=”300″ ><?php echo $dadosSite; ?></textarea>";

$erro=0;
$msgErro="";

if($dadosSite){

$var1 = explode('<title>',$dadosSite);
$var2 = explode('Instagram', $var1['1']);
$var3 = explode('(', $var2[0]);
$var4 = explode(')', $var3[1]);
$var5 = explode('@', $var4[0]);
$var5[1] = $cadastro['instaCliente'];
$nomeContaInsta = $var5[1];

$var6 = explode('<script type="text/javascript">window._sharedData', $dadosSite);
$var7 = explode('</script>', $var6[1]);
$var8 = explode('"edge_followed_by":{"count":', $var7[0]);
$var9 = explode("}", $var8[1]);
$var9[0] = 200; //PASSAR DIRETO APAGAR ESSA LINHA PARA CONFERIR CERTO
$seguidoresContaInsta = $var9[0];

$var10 = explode('"edge_follow":{"count":', $var7[0]);
$var11 = explode("}", $var10[1]);
$var11[0] = 200; //PASSAR DIRETO APAGAR ESSA LINHA PARA CONFERIR CERTO
$seguindoContaInsta = $var11[0];

$var12 = explode('edge_owner_to_timeline_media":{"count":', $var7[0]);
$var13 = explode(',', $var12[1]);
$var13[0] = 50; //PASSAR DIRETO APAGAR ESSA LINHA PARA CONFERIR CERTO
$postagensContaInsta = $var13[0];


echo "<br> Nome da Conta: ".$nomeContaInsta."</br>";
echo "<br> Qtd. Seguidores: ".$seguidoresContaInsta."</br>";
echo "<br> Qtd. Seguindo: ".$seguindoContaInsta."</br>";
echo "<br> Qtd. Postagens: ".$postagensContaInsta."</br>";
    $minimoSeguidores=100;
    $minimoSeguindo=100;
    $minimoPostagem=10;

    if($nomeContaInsta == $contaDigitada){
        if($seguidoresContaInsta >= $minimoSeguidores){
            if($seguindoContaInsta >= $minimoSeguindo){
                if($postagensContaInsta >= $minimoPostagem){
                    $erro = 0;
                    //VERIFICA SE JÁ POSSUI NA TABELA DE CLIENTES
                    //echo $cadastro['telefonePrincipal']." - ".$cadastro['telefoneSecundario'];
                    if($unidade == 1){
                        $selectCliente=$pdo->prepare("SELECT * FROM clientes_exclusive WHERE telefone_residencial_cc = :telefone OR telefone_celular_cc = :telefone OR instagram_cc = :instagram");
                        $selectCliente->bindValue(":telefone", $cadastro['telefonePrincipal']);
                        $selectCliente->bindValue(":instagram", $nomeContaInsta);
                        $selectCliente->execute();
                        $qtdRet = $selectCliente->rowCount();

                        if($qtdRet == NULL){

                            $selectCliente2=$pdo->prepare("SELECT * FROM clientes_exclusive WHERE telefone_residencial_cc = :telefone OR telefone_celular_cc = :telefone OR instagram_cc = :instagram");
                            $selectCliente2->bindValue(":telefone", $cadastro['telefoneSecundario']);
                            $selectCliente2->bindValue(":instagram", $nomeContaInsta);
                            $selectCliente2->execute();
                            $qtdRet2 = $selectCliente2->rowCount();
                            
                            if($qtdRet2 == NULL ){
                                $selectClienteTele=$pdo->prepare("SELECT * FROM agendamentos ag
                                INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente 
                                WHERE ag.id_unidade = :unidade AND cli.telefone_cliente = :telefone 
                                OR ag.id_unidade = :unidade AND cli.telefone2_cliente = :telefone
                                OR cli.url_instagram = :instagram");
                               $selectClienteTele->bindValue(":telefone", $cadastro['telefonePrincipal']);
                               $selectClienteTele->bindValue(":unidade", $unidade);
                               $selectClienteTele->bindValue(":instagram", $cadastro['instaCliente']);
                               $selectClienteTele->execute();
                               $qtdRetTele=$selectClienteTele->rowCount(); 
                               
                               if($qtdRetTele == NULL){
                                    $selectClienteTele2=$pdo->prepare("SELECT * FROM agendamentos ag
                                    INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente 
                                    WHERE ag.id_unidade = :unidade AND cli.telefone_cliente = :telefone 
                                    OR ag.id_unidade = :unidade AND cli.telefone2_cliente = :telefone
                                    OR cli.url_instagram = :instagram");
                                $selectClienteTele2->bindValue(":telefone", $cadastro['telefoneSecundario']);
                                $selectClienteTele2->bindValue(":unidade", $unidade);
                                $selectClienteTele2->bindValue(":instagram", $cadastro['instaCliente']);
                                $selectClienteTele2->execute();
                                $qtdRetTele2=$selectClienteTele2->rowCount(); 

                                if($qtdRetTele2 == NULL){
                                    //FUNCAO DE CADASTRO
                                    CadastrarAgendamento($cadastro['nomeCliente'], $cadastro['idadeCliente'], $cadastro['telefonePrincipal'], $cadastro['telefoneSecundario'], $cadastro['nomeResponsavel']);
                                }else{
                                    //FUTURAMENTE AQUI ANALISA SE O CADASTRO TEM MAIS DE 90 DIAS. CASO TENHA PODE SER CADASTRADO
                                    $erro = 1;
                                    $msgErro = "Possuimos uma duplicidade";
                                }
                               }else{
                                    //FUTURAMENTE AQUI ANALISA SE O CADASTRO TEM MAIS DE 90 DIAS. CASO TENHA PODE SER CADASTRADO
                                    $erro = 1;
                                    $msgErro = "Possuimos uma duplicidade";
                               }
                            }else{
                                $erro = 1;
                                $msgErro = "Este número ou Instagram já é agênciado."; 
                            }
                        }else{
                            $erro = 1;
                            $msgErro = "Este número ou Instagram já é agênciado."; 
                        }
                    }else if($unidade == 4){

                    }else{
                        $erro = 1;
                        $msgErro = "Sua unidade não corresponde a nenhuma cadastrada. Entre em contato com o suporte.";
                    }
                }else{
                    $erro = 1;
                    $msgErro = "A conta do Instagram não tem o requisito de no mínimo <b>".$minimoPostagem."</b> postagens para ser cadastrada no sistema."; 
                }
            }else{
                $erro = 1;
                $msgErro = "A conta do Instagram não tem o requisito de estar seguindo no mínimo <b>".$minimoSeguindo."</b> pessoas para ser cadastrada no sistema.";
            }
        }else{
            $erro = 1;
            $msgErro = "A conta do Instagram não tem o requisito de no mínimo <b>".$minimoSeguidores."</b> seguidores para ser cadastrada no sistema.";
        }
    }else{
        $erro = 1;
        $msgErro = "O Instagram que foi buscado não condiz com o inscrito no campo de cadastro. Peça ajuda ao Suporte.";
    }
}else{
    $erro=1;
    $msgErro="O Instagram não existe ou o Usuário foi digitado de forma incorreta.";
};

echo $msgErro;          
        

        
        

        
        
        ?>

    

    