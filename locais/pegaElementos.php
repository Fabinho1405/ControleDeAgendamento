<?php


// URL DO SITE
$url = 'http://www.instagram.com/marinamary19/';

// PEGANDO TODO CONTEUDO
$dadosSite = @file_get_contents($url); 

$erro=0;
$msgErro="";

if($dadosSite){

$var1 = explode('<title>',$dadosSite);
$var2 = explode('Instagram', $var1['1']);
$var3 = explode('(', $var2[0]);
$var4 = explode(')', $var3[1]);
$var5 = explode('@', $var4[0]);
$nomeContaInsta = $var5[1];

$var6 = explode('<script type="text/javascript">window._sharedData', $dadosSite);
$var7 = explode('</script>', $var6[1]);
$var8 = explode('"edge_followed_by":{"count":', $var7[0]);
$var9 = explode("}", $var8[1]);
$seguidoresContaInsta = $var9[0];

$var10 = explode('"edge_follow":{"count":', $var7[0]);
$var11 = explode("}", $var10[1]);
$seguindoContaInsta = $var11[0];

$var12 = explode('edge_owner_to_timeline_media":{"count":', $var7[0]);
$var13 = explode(',', $var12[1]);
$postagensContaInsta = $var13[0];


//echo "<br> Nome da Conta: ".$nomeContaInsta."</br>";
//echo "<br> Qtd. Seguidores: ".$seguidoresContaInsta."</br>";
//echo "<br> Qtd. Seguindo: ".$seguindoContaInsta."</br>";
//echo "<br> Qtd. Postagens: ".$postagensContaInsta."</br>";
    $minimoSeguidores=100;
    $minimoSeguindo=100;
    $minimoPostagem=10;

    if($nomeContaInsta == $nomeContaInsta){
        if($seguidoresContaInsta >= $minimoSeguidores){
            if($seguindoContaInsta >= $minimoSeguindo){
                if($postagensContaInsta >= $minimoPostagem){
                    $erro = 0;
                    $msgErro = "Conta Cadastrada com Sucesso";
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

if($erro == 1){
    echo $msgErro;
}else{
    echo $msgErro;
};





?>