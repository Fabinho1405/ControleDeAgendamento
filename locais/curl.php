

<?php
ini_set('allow_url_fopen', 1);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/vieirafbo/");
//
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER[‘HTTP_USER_AGENT’]);

$pagina =  curl_exec($ch);


echo "<textarea cols=”300″ rows=”300″ ><?php echo $pagina; ?></textarea>";

$var1 = explode('<title>',$pagina);
$var2 = explode('Instagram', $var1['1']);
$var3 = explode('(', $var2[0]);
$var4 = explode(')', $var3[1]);
$var5 = explode('@', $var4[0]);
$nomeContaInsta = $var5[1];

echo "Nome da Conta: ".$nomeContaInsta;


phpinfo();

?>