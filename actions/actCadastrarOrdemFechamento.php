<?php
    session_start();
    ob_start();
    include_once("../conection/connection.php");
    $pdo=conectar();
    $idfuncionario = $_SESSION['id_usuario'];
	$unidadefunc = $_SESSION['unidade'];

    if($unidadefunc == 1){ 

    
        function limpaAcentos($valor){
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("(", "", $valor);
        $valor = str_replace(")", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
        };

        function validaCPF($cpf) {

            // Verifica se um número foi informado
            if(empty($cpf)) {
                return false;
            }
        
            // Elimina possivel mascara
            $cpf = preg_replace("/[^0-9]/", "", $cpf);
            $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
            
            // Verifica se o numero de digitos informados é igual a 11 
            if (strlen($cpf) != 11) {
                return false;
            }
            // Verifica se nenhuma das sequências invalidas abaixo 
            // foi digitada. Caso afirmativo, retorna falso
            else if ($cpf == '00000000000' || 
                $cpf == '11111111111' || 
                $cpf == '22222222222' || 
                $cpf == '33333333333' || 
                $cpf == '44444444444' || 
                $cpf == '55555555555' || 
                $cpf == '66666666666' || 
                $cpf == '77777777777' || 
                $cpf == '88888888888' || 
                $cpf == '99999999999') {
                return false;
             // Calcula os digitos verificadores para verificar se o
             // CPF é válido
             } else {   
                
                for ($t = 9; $t < 11; $t++) {
                    
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf{$c} != $d) {
                        return false;
                    }
                }
        
                return true;
            }
        };

        function idadeModelo($data){
   
            // Separa em dia, mês e ano
            list($ano, $mes, $dia) = explode('-', $data);
        
            // Descobre que dia é hoje e retorna a unix timestamp
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            // Descobre a unix timestamp da data de nascimento do fulano
            $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
        
            // Depois apenas fazemos o cálculo já citado :)
            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
            return $idade;

        };

    

    $cadastro = Array(
        "nomeModelo"=>$_POST['nome_modelo'],
        "dataNascimento"=>$_POST['nascimento_modelo'],
        "idadeModelo"=>idadeModelo($_POST['nascimento_modelo']),
        "rgModelo"=>limpaAcentos($_POST['rg_modelo']),
        "cpfModelo"=>limpaAcentos($_POST['cpf_modelo']),
        "responsavelModelo"=>$_POST['responsavel_modelo'],
        "rgResponsavel"=>limpaAcentos($_POST['rg_responsavel']),
        "cpfResponsavel"=>limpaAcentos($_POST['cpf_responsavel']),
        "estadoCivil"=>$_POST['civil_modelo'],
        "profissao"=>$_POST['profissao_modelo'],
        "cep"=>$_POST['cep'],
        "endereco"=>$_POST['rua'],
        "numero"=>$_POST['numero'],
        "complemento"=>$_POST['complemento_modelo'],
        "bairro"=>$_POST['bairro'],
        "cidade"=>$_POST['cidade'],
        "uf"=>$_POST['uf'],
        "telefonePrincipal"=>limpaAcentos($_POST['telefoneprincipal_modelo']),
        "telefoneSecundario"=>limpaAcentos($_POST['telefonesecundario_modelo']),
        "instagram"=>$_POST['instagram_modelo'],
        "facebook"=>$_POST['facebook_modelo'],
        "email"=>$_POST['email_modelo'],
        "nomeArtistico"=>$_POST['nome_artistico_modelo'],
        "altura"=>limpaAcentos($_POST['altura_modelo']),
        "peso"=>limpaAcentos($_POST['peso_modelo']),
        "manequim"=>$_POST['manequim_modelo'],
        "sapato"=>$_POST['sapato_modelo'],
        "olhos"=>$_POST['olhos_modelo'],
        "cabelo"=>$_POST['cabelo_modelo'],
        "etnia"=>$_POST['etnia_modelo'],
        "material"=>$_POST['material_modelo'],
        "produtor"=>$_POST['select_produtor'],
        "scouter"=>$_POST['select_scouter'],
        "poster"=>$_POST['possuiPoster'],
        "valor"=>$_POST['valor_material'],
        "estudio"=>$_POST['encaminhaEstudio']
    );

    //VERIFICA DUPLICIDADE
    $duplicidade=0;
    if(idademodelo($cadastro['dataNascimento']) >= 18){
        //CONFERE CPF DO MODELO
        $verificaContrato=$pdo->prepare("SELECT * FROM clientes_exclusive WHERE cpf_modelo_cc=:nCPF");
        $verificaContrato->bindValue(":nCPF", $cadastro['cpfModelo']);
        $verificaContrato->execute();
        $qtdContrato=$verificaContrato->rowCount();
        if($qtdContrato >= 1){
            // JÁ EXISTE UM CONTRATO DESTE NESTE CPF
            $duplicidade = 1;
        }else{
            //NÃO EXISTE
            $duplicidade = 0;
        }
    }else{
        $duplicidade=0;
    }

    if($duplicidade == 0){
    $inserirContrato=$pdo->prepare("INSERT clientes_exclusive(  nome_modelo_cc,rg_modelo_cc,cpf_modelo_cc,nome_responsavel_cc,rg_responsavel_cc,cpf_responsavel_cc,nascimento_cc,idade_cc,estado_civil_cc,CEP_cc,endereco_cc,numero_cc,complemento_cc,bairro_cc,telefone_residencial_cc,telefone_celular_cc,instagram_cc,facebook_cc,email_cc,nome_artistico_cc,altura_cc,peso_cc,manequim_cc,sapatos_cc,cor_dos_olhos_cc,cor_do_cabelo_cc,cor_da_pele_cc,material_cc,valor_material_cc,id_produtor,id_scouter,poster_cc,data_cadastro_cc)
                                    VALUES(:nomeModelo,
                                            :rgModelo,
                                            :cpfModelo,
                                            :nomeResponsavel,
                                            :rgResponsavel,
                                            :cpfResponsavel,
                                            :nascimentoModelo,
                                            :idadeModelo,
                                            :estadoCivil,
                                            :CEPModelo,
                                            :ruaModelo,
                                            :numeroModelo,
                                            :complementoModelo,
                                            :bairroModelo,
                                            :telefoneCelularP,
                                            :telefoneCelularS,
                                            :instagramModelo,
                                            :facebookModelo,
                                            :emailModelo,
                                            :nomeArtistico,
                                            :alturaModelo,
                                            :pesoModelo,
                                            :manequimModelo,
                                            :sapatosModelo,
                                            :corDosOlhosModelo,
                                            :corDosCabelosModelo,
                                            :corDaPeleModelo,
                                            :materialModelo,
                                            :valorMaterialModelo,
                                            :produtorModelo,
                                            :scouterModelo,
                                            :possuiPoster,
                                            NOW()
                                    )");
        $inserirContrato->bindValue(":nomeModelo", $cadastro['nomeModelo']);
        $inserirContrato->bindValue(":rgModelo", $cadastro['rgModelo']);
        $inserirContrato->bindValue(":cpfModelo", $cadastro['cpfModelo']);
        $inserirContrato->bindValue(":nomeResponsavel", $cadastro['responsavelModelo']);
        $inserirContrato->bindValue(":rgResponsavel", $cadastro['rgResponsavel']);
        $inserirContrato->bindValue(":cpfResponsavel", $cadastro['cpfResponsavel']);
        $inserirContrato->bindValue(":nascimentoModelo", $cadastro['dataNascimento']);
        $inserirContrato->bindValue(":idadeModelo", $cadastro['idadeModelo']);
        $inserirContrato->bindValue(":estadoCivil", $cadastro['estadoCivil']);
        $inserirContrato->bindValue(":CEPModelo", $cadastro['cep']);
        $inserirContrato->bindValue(":ruaModelo", $cadastro['endereco']);
        $inserirContrato->bindValue(":numeroModelo", $cadastro['numero']);
        $inserirContrato->bindValue(":complementoModelo", $cadastro['complemento']);
        $inserirContrato->bindValue(":bairroModelo", $cadastro['bairro']);
        $inserirContrato->bindValue(":telefoneCelularP", $cadastro['telefonePrincipal']);
        $inserirContrato->bindValue(":telefoneCelularS", $cadastro['telefoneSecundario']);
        $inserirContrato->bindValue("instagramModelo", $cadastro['instagram']);
        $inserirContrato->bindValue(":facebookModelo", $cadastro['facebook']);
        $inserirContrato->bindValue(":emailModelo", $cadastro['email']);
        $inserirContrato->bindValue(":nomeArtistico", $cadastro['nomeArtistico']);
        $inserirContrato->bindValue(":alturaModelo", $cadastro['altura']);
        $inserirContrato->bindValue(":pesoModelo", $cadastro['peso']);
        $inserirContrato->bindValue(":manequimModelo", $cadastro['manequim']);
        $inserirContrato->bindValue(":sapatosModelo", $cadastro['sapato']);
        $inserirContrato->bindValue(":corDosOlhosModelo", $cadastro['olhos']);
        $inserirContrato->bindValue(":corDosCabelosModelo", $cadastro['cabelo']);
        $inserirContrato->bindValue(":corDaPeleModelo", $cadastro['etnia']);
        $inserirContrato->bindValue(":materialModelo", $cadastro['material']);
        $inserirContrato->bindValue(":valorMaterialModelo", $cadastro['valor']);
        $inserirContrato->bindValue(":produtorModelo", $cadastro['produtor']);
        $inserirContrato->bindValue(":scouterModelo", $cadastro['scouter']);
        $inserirContrato->bindValue(":possuiPoster", $cadastro['poster']);
    $error=0;
    $MSGerror="";

    if($cadastro['idadeModelo'] <= 18){
        //VERIFICA SE O CPF DO RESPONSÁVEL É VÁLIDO
        if(validaCPF($cadastro[cpfResponsavel]) == true){
            //VERIFICA SE A INSERÇÃO DO CONTRATO FOI CORRETA
            if($inserirContrato->execute()){
                $pesquisaCliente=$pdo->prepare("SELECT * FROM clientes_exclusive WHERE rg_modelo_cc=:rgModelo AND cpf_modelo_cc=:cpfModelo AND idade_cc=:idadeModelo ORDER BY contrato_cc DESC LIMIT 1");
                $pesquisaCliente->bindValue(":rgModelo", $cadastro['rgModelo']);
                $pesquisaCliente->bindValue(":cpfModelo", $cadastro['cpfModelo']);
                $pesquisaCliente->bindValue(":idadeModelo", $cadastro['idadeModelo']);
                $pesquisaCliente->execute();
                $qtdRetorno=$pesquisaCliente->rowCount();              

                //VERIFICA SE HÁ O ENCAMINHAMENTO PARA O ESTÚDIO
                if($cadastro['estudio'] = 1 && $qtdRetorno >= 1){
                    $rowCliente=$pesquisaCliente->fetch(PDO::FETCH_OBJ);

                    $encaminhaEstudio=$pdo->prepare("INSERT estudio_exclusive (contrato_cc, func_encaminhou_ec, obs_func_encaminhou, liberado_espera_ec, id_motivo_estudio, created) 
                                                        VALUES (:nContrato, :funcEncaminhou, :obsFunc, 1, :motivoEncaminhado, NOW())");
                    $encaminhaEstudio->bindValue(":Contrato", $rowCliente->contrato_cc);
                    $encaminhaEstudio->bindValue(":funcEncaminhou", $idfuncionario);
                    $encaminhaEstudio->bindValue(":obsFunc", "...");
                    $encaminhaEstudio->binValue(":motivoEncaminhado", 1);
                    if($encaminhaEstudio->execute()){
                        echo "ENCAMINHADO PARA O ESTÚDIO";
                    }else{
                        $error = 1;
                        $MSGerror = "Erro ao encaminhar para o estúdio";
                    }
                }else{
                    $error = 1;
                    $MSGerror = "Erro ao tentar encaminhar para o estúdio";
                }
            }else{
                $error = 1;
                $MSGerror = "Contrato não foi inserido de forma correta";
            }
        }else{
            $error = 1;
            $MSGerror="CPF do Responsável é Inválido";
        };
    }else{
        //VERIFICA SE O CPF DO MODELO É VÁLIDO
        if(validaCPF($cadastro[cpfModelo]) == true){
            if($inserirContrato->execute()){
                $pesquisaCliente=$pdo->prepare("SELECT * FROM clientes_exclusive WHERE rg_modelo_cc=:rgModelo AND cpf_modelo_cc=:cpfModelo AND idade_cc=:idadeModelo AND material_cc=:materialModelo ORDER BY contrato_cc DESC LIMIT 1");
                $pesquisaCliente->bindValue(":rgModelo", $cadastro['rgModelo']);
                $pesquisaCliente->bindValue(":cpfModelo", $cadastro['cpfModelo']);
                $pesquisaCliente->bindValue(":idadeModelo", $cadastro['idadeModelo']);
                $pesquisaCliente->bindValue(":materialModelo", $cadastro['material']);
                $pesquisaCliente->execute();
                $qtdRetorno=$pesquisaCliente->rowCount();              

                //VERIFICA SE HÁ O ENCAMINHAMENTO PARA O ESTÚDIO
                if($cadastro['estudio'] == 1 && $qtdRetorno == 1){
                    $rowCliente=$pesquisaCliente->fetch(PDO::FETCH_OBJ);

                    $encaminhaEstudio=$pdo->prepare("INSERT estudio_exclusive (contrato_cc, func_encaminhou_ec, obs_func_encaminhou, liberado_espera_ec, id_motivo_estudio, created) 
                                                        VALUES (:nContrato, :funcEncaminhou, :obsFunc, 1, :motivoEncaminhado, NOW())");
                    $encaminhaEstudio->bindValue(":nContrato", $rowCliente->contrato_cc);
                    $encaminhaEstudio->bindValue(":funcEncaminhou", $idfuncionario);
                    $encaminhaEstudio->bindValue(":obsFunc", "S/INFO");
                    $encaminhaEstudio->bindValue(":motivoEncaminhado", 1);                

                    if($encaminhaEstudio->execute()){
                        $error=0;
                    }else{
                        $error = 1;
                        $MSGerror = "Erro ao encaminhar para o estúdio";
                    }
                }elseif($cadastro['estudio'] == 0 && $qtdRetorno == 1){
                    $error=0;
                }else{
                    $error = 1;
                    $MSGerror = "Contrato não foi inserido.";
                }
            }else{
                $error = 1;
                $MSGerror = "Contrato não foi inserido de forma correta";
            }
        }else{
            $error = 1;
            $MSGerror="CPF do Modelo é Inválido";
            
        };
    }; 

    if($error == 0){ 
        //ENCAMINHA PARA INSERIR A FORMA DE PAGAMENTO
        header("Location:../inserir_pag_form.php?ctn=$rowCliente->contrato_cc");
    }else{
        $_SESSION['errorCad']=$MSGerror;
        header("Location:../cadastrarOrdemFechamento");

    };
    echo "<br><br><br><br>";  


    //print_r($cadastro);

    
    }else{
        //DUPLICIDADE ENCONTRADA
        $_SESSION['errorCad']="Já obtemos um contrato neste CPF, pesquise.";
        header("Location:../cadastrarOrdemFechamento");
    }
}else if($unidadefunc == 4){


    function limpaAcentos($valor){
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("(", "", $valor);
        $valor = str_replace(")", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
        };

        function validaCPF($cpf) {

            // Verifica se um número foi informado
            if(empty($cpf)) {
                return false;
            }
        
            // Elimina possivel mascara
            $cpf = preg_replace("/[^0-9]/", "", $cpf);
            $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
            
            // Verifica se o numero de digitos informados é igual a 11 
            if (strlen($cpf) != 11) {
                return false;
            }
            // Verifica se nenhuma das sequências invalidas abaixo 
            // foi digitada. Caso afirmativo, retorna falso
            else if ($cpf == '00000000000' || 
                $cpf == '11111111111' || 
                $cpf == '22222222222' || 
                $cpf == '33333333333' || 
                $cpf == '44444444444' || 
                $cpf == '55555555555' || 
                $cpf == '66666666666' || 
                $cpf == '77777777777' || 
                $cpf == '88888888888' || 
                $cpf == '99999999999') {
                return false;
             // Calcula os digitos verificadores para verificar se o
             // CPF é válido
             } else {   
                
                for ($t = 9; $t < 11; $t++) {
                    
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf{$c} != $d) {
                        return false;
                    }
                }
        
                return true;
            }
        };

        function idadeModelo($data){
   
            // Separa em dia, mês e ano
            list($ano, $mes, $dia) = explode('-', $data);
        
            // Descobre que dia é hoje e retorna a unix timestamp
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            // Descobre a unix timestamp da data de nascimento do fulano
            $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
        
            // Depois apenas fazemos o cálculo já citado :)
            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
            return $idade;

        };

    

    $cadastro = Array(
        "nomeModelo"=>$_POST['nome_modelo'],
        "dataNascimento"=>$_POST['nascimento_modelo'],
        "idadeModelo"=>idadeModelo($_POST['nascimento_modelo']),
        "rgModelo"=>limpaAcentos($_POST['rg_modelo']),
        "cpfModelo"=>limpaAcentos($_POST['cpf_modelo']),
        "responsavelModelo"=>$_POST['responsavel_modelo'],
        "rgResponsavel"=>limpaAcentos($_POST['rg_responsavel']),
        "cpfResponsavel"=>limpaAcentos($_POST['cpf_responsavel']),
        "estadoCivil"=>$_POST['civil_modelo'],
        "profissao"=>$_POST['profissao_modelo'],
        "cep"=>$_POST['cep'],
        "endereco"=>$_POST['rua'],
        "numero"=>$_POST['numero'],
        "complemento"=>$_POST['complemento_modelo'],
        "bairro"=>$_POST['bairro'],
        "cidade"=>$_POST['cidade'],
        "uf"=>$_POST['uf'],
        "telefonePrincipal"=>limpaAcentos($_POST['telefoneprincipal_modelo']),
        "telefoneSecundario"=>limpaAcentos($_POST['telefonesecundario_modelo']),
        "instagram"=>$_POST['instagram_modelo'],
        "facebook"=>$_POST['facebook_modelo'],
        "email"=>$_POST['email_modelo'],
        "nomeArtistico"=>$_POST['nome_artistico_modelo'],
        "altura"=>limpaAcentos($_POST['altura_modelo']),
        "peso"=>limpaAcentos($_POST['peso_modelo']),
        "manequim"=>$_POST['manequim_modelo'],
        "sapato"=>$_POST['sapato_modelo'],
        "olhos"=>$_POST['olhos_modelo'],
        "cabelo"=>$_POST['cabelo_modelo'],
        "etnia"=>$_POST['etnia_modelo'],
        "material"=>$_POST['material_modelo'],
        "produtor"=>$_POST['select_produtor'],
        "scouter"=>$_POST['select_scouter'],
        "poster"=>$_POST['possuiPoster'],
        "valor"=>$_POST['valor_material'],
        "estudio"=>$_POST['encaminhaEstudio']
    );

    //VERIFICA DUPLICIDADE
    $duplicidade=0;
    if(idademodelo($cadastro['dataNascimento']) >= 18){
        //CONFERE CPF DO MODELO
        $verificaContrato=$pdo->prepare("SELECT * FROM clientes_concept WHERE cpf_modelo_cc=:nCPF");
        $verificaContrato->bindValue(":nCPF", $cadastro['cpfModelo']);
        $verificaContrato->execute();
        $qtdContrato=$verificaContrato->rowCount();
        if($qtdContrato >= 1){
            // JÁ EXISTE UM CONTRATO DESTE NESTE CPF
            $duplicidade = 1;
        }else{
            //NÃO EXISTE
            $duplicidade = 0;
        }
    }else{
        $duplicidade=0;
    }

    if($duplicidade == 0){
    $inserirContrato=$pdo->prepare("INSERT clientes_concept(  nome_modelo_cc,rg_modelo_cc,cpf_modelo_cc,nome_responsavel_cc,rg_responsavel_cc,cpf_responsavel_cc,nascimento_cc,idade_cc,estado_civil_cc,CEP_cc,endereco_cc,numero_cc,complemento_cc,bairro_cc,telefone_residencial_cc,telefone_celular_cc,instagram_cc,facebook_cc,email_cc,nome_artistico_cc,altura_cc,peso_cc,manequim_cc,sapatos_cc,cor_dos_olhos_cc,cor_do_cabelo_cc,cor_da_pele_cc,material_cc,valor_material_cc,id_produtor,id_scouter,poster_cc,data_cadastro_cc)
                                    VALUES(:nomeModelo,
                                            :rgModelo,
                                            :cpfModelo,
                                            :nomeResponsavel,
                                            :rgResponsavel,
                                            :cpfResponsavel,
                                            :nascimentoModelo,
                                            :idadeModelo,
                                            :estadoCivil,
                                            :CEPModelo,
                                            :ruaModelo,
                                            :numeroModelo,
                                            :complementoModelo,
                                            :bairroModelo,
                                            :telefoneCelularP,
                                            :telefoneCelularS,
                                            :instagramModelo,
                                            :facebookModelo,
                                            :emailModelo,
                                            :nomeArtistico,
                                            :alturaModelo,
                                            :pesoModelo,
                                            :manequimModelo,
                                            :sapatosModelo,
                                            :corDosOlhosModelo,
                                            :corDosCabelosModelo,
                                            :corDaPeleModelo,
                                            :materialModelo,
                                            :valorMaterialModelo,
                                            :produtorModelo,
                                            :scouterModelo,
                                            :possuiPoster,
                                            NOW()
                                    )");
        $inserirContrato->bindValue(":nomeModelo", $cadastro['nomeModelo']);
        $inserirContrato->bindValue(":rgModelo", $cadastro['rgModelo']);
        $inserirContrato->bindValue(":cpfModelo", $cadastro['cpfModelo']);
        $inserirContrato->bindValue(":nomeResponsavel", $cadastro['responsavelModelo']);
        $inserirContrato->bindValue(":rgResponsavel", $cadastro['rgResponsavel']);
        $inserirContrato->bindValue(":cpfResponsavel", $cadastro['cpfResponsavel']);
        $inserirContrato->bindValue(":nascimentoModelo", $cadastro['dataNascimento']);
        $inserirContrato->bindValue(":idadeModelo", $cadastro['idadeModelo']);
        $inserirContrato->bindValue(":estadoCivil", $cadastro['estadoCivil']);
        $inserirContrato->bindValue(":CEPModelo", $cadastro['cep']);
        $inserirContrato->bindValue(":ruaModelo", $cadastro['endereco']);
        $inserirContrato->bindValue(":numeroModelo", $cadastro['numero']);
        $inserirContrato->bindValue(":complementoModelo", $cadastro['complemento']);
        $inserirContrato->bindValue(":bairroModelo", $cadastro['bairro']);
        $inserirContrato->bindValue(":telefoneCelularP", $cadastro['telefonePrincipal']);
        $inserirContrato->bindValue(":telefoneCelularS", $cadastro['telefoneSecundario']);
        $inserirContrato->bindValue("instagramModelo", $cadastro['instagram']);
        $inserirContrato->bindValue(":facebookModelo", $cadastro['facebook']);
        $inserirContrato->bindValue(":emailModelo", $cadastro['email']);
        $inserirContrato->bindValue(":nomeArtistico", $cadastro['nomeArtistico']);
        $inserirContrato->bindValue(":alturaModelo", $cadastro['altura']);
        $inserirContrato->bindValue(":pesoModelo", $cadastro['peso']);
        $inserirContrato->bindValue(":manequimModelo", $cadastro['manequim']);
        $inserirContrato->bindValue(":sapatosModelo", $cadastro['sapato']);
        $inserirContrato->bindValue(":corDosOlhosModelo", $cadastro['olhos']);
        $inserirContrato->bindValue(":corDosCabelosModelo", $cadastro['cabelo']);
        $inserirContrato->bindValue(":corDaPeleModelo", $cadastro['etnia']);
        $inserirContrato->bindValue(":materialModelo", $cadastro['material']);
        $inserirContrato->bindValue(":valorMaterialModelo", $cadastro['valor']);
        $inserirContrato->bindValue(":produtorModelo", $cadastro['produtor']);
        $inserirContrato->bindValue(":scouterModelo", $cadastro['scouter']);
        $inserirContrato->bindValue(":possuiPoster", $cadastro['poster']);
    $error=0;
    $MSGerror="";

    if($cadastro['idadeModelo'] <= 18){
        //VERIFICA SE O CPF DO RESPONSÁVEL É VÁLIDO
        if(validaCPF($cadastro[cpfResponsavel]) == true){
            //VERIFICA SE A INSERÇÃO DO CONTRATO FOI CORRETA
            if($inserirContrato->execute()){
                $pesquisaCliente=$pdo->prepare("SELECT * FROM clientes_concept WHERE rg_modelo_cc=:rgModelo AND cpf_modelo_cc=:cpfModelo AND idade_cc=:idadeModelo ORDER BY contrato_cc DESC LIMIT 1");
                $pesquisaCliente->bindValue(":rgModelo", $cadastro['rgModelo']);
                $pesquisaCliente->bindValue(":cpfModelo", $cadastro['cpfModelo']);
                $pesquisaCliente->bindValue(":idadeModelo", $cadastro['idadeModelo']);
                $pesquisaCliente->execute();
                $qtdRetorno=$pesquisaCliente->rowCount();              

                //VERIFICA SE HÁ O ENCAMINHAMENTO PARA O ESTÚDIO
                if($cadastro['estudio'] = 1 && $qtdRetorno >= 1){
                    $rowCliente=$pesquisaCliente->fetch(PDO::FETCH_OBJ);

                    $encaminhaEstudio=$pdo->prepare("INSERT estudio_concept (contrato_cc, func_encaminhou_ec, obs_func_encaminhou, liberado_espera_ec, id_motivo_estudio, created) 
                                                        VALUES (:nContrato, :funcEncaminhou, :obsFunc, 1, :motivoEncaminhado, NOW())");
                    $encaminhaEstudio->bindValue(":Contrato", $rowCliente->contrato_cc);
                    $encaminhaEstudio->bindValue(":funcEncaminhou", $idfuncionario);
                    $encaminhaEstudio->bindValue(":obsFunc", "...");
                    $encaminhaEstudio->binValue(":motivoEncaminhado", 1);
                    if($encaminhaEstudio->execute()){
                        echo "ENCAMINHADO PARA O ESTÚDIO";
                    }else{
                        $error = 1;
                        $MSGerror = "Erro ao encaminhar para o estúdio";
                    }
                }else{
                    $error = 1;
                    $MSGerror = "Erro ao tentar encaminhar para o estúdio";
                }
            }else{
                $error = 1;
                $MSGerror = "Contrato não foi inserido de forma correta";
            }
        }else{
            $error = 1;
            $MSGerror="CPF do Responsável é Inválido";
        };
    }else{
        //VERIFICA SE O CPF DO MODELO É VÁLIDO
        if(validaCPF($cadastro[cpfModelo]) == true){
            if($inserirContrato->execute()){
                $pesquisaCliente=$pdo->prepare("SELECT * FROM clientes_concept WHERE rg_modelo_cc=:rgModelo AND cpf_modelo_cc=:cpfModelo AND idade_cc=:idadeModelo AND material_cc=:materialModelo ORDER BY contrato_cc DESC LIMIT 1");
                $pesquisaCliente->bindValue(":rgModelo", $cadastro['rgModelo']);
                $pesquisaCliente->bindValue(":cpfModelo", $cadastro['cpfModelo']);
                $pesquisaCliente->bindValue(":idadeModelo", $cadastro['idadeModelo']);
                $pesquisaCliente->bindValue(":materialModelo", $cadastro['material']);
                $pesquisaCliente->execute();
                $qtdRetorno=$pesquisaCliente->rowCount();              

                //VERIFICA SE HÁ O ENCAMINHAMENTO PARA O ESTÚDIO
                if($cadastro['estudio'] == 1 && $qtdRetorno == 1){
                    $rowCliente=$pesquisaCliente->fetch(PDO::FETCH_OBJ);

                    $encaminhaEstudio=$pdo->prepare("INSERT estudio_concept (contrato_cc, func_encaminhou_ec, obs_func_encaminhou, liberado_espera_ec, id_motivo_estudio, created) 
                                                        VALUES (:nContrato, :funcEncaminhou, :obsFunc, 1, :motivoEncaminhado, NOW())");
                    $encaminhaEstudio->bindValue(":nContrato", $rowCliente->contrato_cc);
                    $encaminhaEstudio->bindValue(":funcEncaminhou", $idfuncionario);
                    $encaminhaEstudio->bindValue(":obsFunc", "S/INFO");
                    $encaminhaEstudio->bindValue(":motivoEncaminhado", 1);                

                    if($encaminhaEstudio->execute()){
                        $error=0;
                    }else{
                        $error = 1;
                        $MSGerror = "Erro ao encaminhar para o estúdio";
                    }
                }elseif($cadastro['estudio'] == 0 && $qtdRetorno == 1){
                    $error=0;
                }else{
                    $error = 1;
                    $MSGerror = "Contrato não foi inserido.";
                }
            }else{
                $error = 1;
                $MSGerror = "Contrato não foi inserido de forma correta";
            }
        }else{
            $error = 1;
            $MSGerror="CPF do Modelo é Inválido";
            
        };
    }; 

    if($error == 0){ 
        //ENCAMINHA PARA INSERIR A FORMA DE PAGAMENTO
        header("Location:../inserir_pag_form.php?ctn=$rowCliente->contrato_cc");
    }else{
        $_SESSION['errorCad']=$MSGerror;
        header("Location:../cadastrarOrdemFechamento");

    };
    echo "<br><br><br><br>";  


    //print_r($cadastro);

    
    }else{
        //DUPLICIDADE ENCONTRADA
        $_SESSION['errorCad']="Já obtemos um contrato neste CPF, pesquise.";
        header("Location:../cadastrarOrdemFechamento");
    }


}else{
    echo "SEM PROGRAMAÇÃO PARA ESTE CONTRATO";
}

    

    

    




?>