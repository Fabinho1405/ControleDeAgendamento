<?php
class Authenticator {

  public static $username = "fichasecreta";
  public static $password = "Agency@9947";

  public static function check() {
    if (
      isset($_SERVER['PHP_AUTH_USER']) &&
      isset($_SERVER['PHP_AUTH_PW']) &&
      $_SERVER['PHP_AUTH_USER'] == self::$username &&
      $_SERVER['PHP_AUTH_PW'] == self::$password
    ) {
      return true;
    } else {
      header('WWW-Authenticate: Basic realm="Please login."');
      header('HTTP/1.0 401 Unauthorized');
      die("Usuário ou senha incorretos!");
    }
  }

}

if(Authenticator::check()){
  echo "Você tem acesso ao conteúdo!";
  $pagina = "content.html";
  if(isset($_POST)){
    if(isset($_POST["conteudo"])){
      $fopen = fopen($pagina,"w+");
      fwrite($fopen,$_POST["conteudo"]);
      fclose($fopen);
    }
  }
}
else return null;
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Subir Lista Para Scouter</title>
	<head>
	<body>
		<h1>Subir Lista Para Scouter</h1>
		
		<form method="POST" action="processa.php" enctype="multipart/form-data">
			<label>Arquivo</label>
			<input type="file" name="arquivo"><br><br>
			<input type="submit" value="Enviar">
		</form>
		
	</body>
</html>