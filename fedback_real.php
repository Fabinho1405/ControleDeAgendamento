<?php
class Authenticator {

  public static $username = "Admin";
  public static $password = "Agency*9947*";

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
  echo "";
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
<head>
<style type="text/css">
  .myButton {
  -moz-box-shadow:inset 3px 3px 7px -1px #91b8b3;
  -webkit-box-shadow:inset 3px 3px 7px -1px #91b8b3;
  box-shadow:inset 3px 3px 7px -1px #91b8b3;
  background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #768d87), color-stop(1, #6c7c7c));
  background:-moz-linear-gradient(top, #768d87 5%, #6c7c7c 100%);
  background:-webkit-linear-gradient(top, #768d87 5%, #6c7c7c 100%);
  background:-o-linear-gradient(top, #768d87 5%, #6c7c7c 100%);
  background:-ms-linear-gradient(top, #768d87 5%, #6c7c7c 100%);
  background:linear-gradient(to bottom, #768d87 5%, #6c7c7c 100%);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#768d87', endColorstr='#6c7c7c',GradientType=0);
  background-color:#768d87;
  -moz-border-radius:13px;
  -webkit-border-radius:13px;
  border-radius:13px;
  border:2px solid #566963;
  display:inline-block;
  cursor:pointer;
  color:#ffffff;
  font-family:Georgia;
  font-size:12px;
  font-weight:bold;
  text-decoration:none;
  text-shadow:1px 6px 2px #2b665e;
}
.myButton:hover {
  background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #6c7c7c), color-stop(1, #768d87));
  background:-moz-linear-gradient(top, #6c7c7c 5%, #768d87 100%);
  background:-webkit-linear-gradient(top, #6c7c7c 5%, #768d87 100%);
  background:-o-linear-gradient(top, #6c7c7c 5%, #768d87 100%);
  background:-ms-linear-gradient(top, #6c7c7c 5%, #768d87 100%);
  background:linear-gradient(to bottom, #6c7c7c 5%, #768d87 100%);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#6c7c7c', endColorstr='#768d87',GradientType=0);
  background-color:#6c7c7c;
}
.myButton:active {
  position:relative;
  top:1px;
}

  

</style>
<meta charset="utf8">
<title> Resumo Temporário </title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
<?php
echo "<meta HTTP-EQUIV='refresh' CONTENT='5;URL=fedback_real.php'>";
?>
</head>
<body>
<?php
include_once("conection/conexao.php");
?>

<center>
<div id="teste">  
  <div class="container">
<table border="1" style="float: left">
  <thead>
  <tr>
    <td colspan="6"><font size="6px"><center> Quantidade de Agendados HOJE </center></font> </td>
  </tr>
</thead>
<thead>
  <tr>
    <th><center> <b> Nº </b></center></th>
    <th><center> <b> # </b> </center></th>
    <th><center> <b> Modalidade </b> </center> </th>
    <th><center> <b> Funcionário </b></center></th>
    <th><center> <b> Exclusive Matriz </b> </center></th>
    <th><center><b> Exclusive Lapa </b> </center></th>
    <th><center> <b> Impact Agency </b> </center></th>
    <th><center><b>Reagendados </b></center></th>
  </tr>
</thead>
   <?php 
      $total_matriz = '0';
      $total_impact = '0';
      $total_lapa = '0';
      $total_impact = '0';
      $total_reagendado = '0';
      $final_operador = '0';
      $cont_op = '1';
      $consult_funcionarios = "SELECT * FROM funcionario WHERE id_locado = '4'";
      $consulta_funcionario = mysqli_query($conn, $consult_funcionarios);
      while($row_funcionario = mysqli_fetch_assoc($consulta_funcionario)){

        $id_usuario = $row_funcionario['id_func'];
        $consult_matriz = "SELECT * FROM `agendamentos` where DATE(data_cadastro_agendamento) = DATE(NOW()) AND id_func = '$id_usuario' AND id_unidade = '1' AND reagendado = '0'";
        $consulta_matriz = mysqli_query($conn, $consult_matriz);
        $num_result_matriz = mysqli_num_rows($consulta_matriz); 

        $consult_lapa = "SELECT * FROM `agendamentos` where DATE(data_cadastro_agendamento) = DATE(NOW()) AND id_func = '$id_usuario' AND id_unidade = '2' AND reagendado = '0'";
        $consulta_lapa = mysqli_query($conn, $consult_lapa);
        $num_result_lapa = mysqli_num_rows($consulta_lapa); 

        $consult_impact = "SELECT * FROM `agendamentos` where DATE(data_cadastro_agendamento) = DATE(NOW()) AND id_func = '$id_usuario' AND id_unidade = '3' AND reagendado = '0' ";
        $consulta_impact = mysqli_query($conn, $consult_impact);
        $num_result_impact = mysqli_num_rows($consulta_impact); 

        $consult_num_reagendado = "SELECT * FROM agendamentos WHERE DATE(data_cadastro_agendamento) = DATE(NOW()) AND id_func = '$id_usuario' AND reagendado = '1'"; 
        $consulta_num_reagendado = mysqli_query($conn, $consult_num_reagendado);
        $num_reagendado = mysqli_num_rows($consulta_num_reagendado);

    ?>
    <?php
      if($num_result_matriz <> 0 || $num_result_lapa <> 0 || $num_result_impact <> 0){

        
    ?>
    <tbody>
  <tr>
    <td style="
    <?php
      if($row_funcionario['menu_scouter_ligacao'] == 1 && $num_result_matriz >= 30){
        echo 'background-color: blue;color:white;';
      }else if($row_funcionario['menu_scouter_insta'] == 1 && $num_result_matriz >= 15){
        echo 'background-color: blue; color:white;';
      };
    ?>"><?php  echo $cont_op; $cont_op = $cont_op + 1; ?> </td>
    <td style="
    <?php
      if($row_funcionario['menu_scouter_ligacao'] == 1 && $num_result_matriz >= 30){
        echo 'background-color: blue;color:white;';
      }else if($row_funcionario['menu_scouter_insta'] == 1 && $num_result_matriz >= 15){
        echo 'background-color: blue; color:white;';
      };
    ?>"><?php echo $row_funcionario['id_func']; ?> </td>
    <td style="
    <?php
      if($row_funcionario['menu_scouter_ligacao'] == 1 && $num_result_matriz >= 30){
        echo 'background-color: blue;color:white;';
      }else if($row_funcionario['menu_scouter_insta'] == 1 && $num_result_matriz >= 15){
        echo 'background-color: blue; color:white;';
      };
    ?>">
      <?php
      $modalidade = '0';
        if($row_funcionario['menu_scouter_ligacao'] == 1){
            echo "Ligação";
            $modalidade = '1';
        }else if($row_funcionario['menu_scouter_insta'] == 1){
            echo "Instagram";
            $modalidade = '2';
        };
      ?>        
    </td>
    <td style="
    <?php
      if($row_funcionario['menu_scouter_ligacao'] == 1 && $num_result_matriz >= 30){
        echo 'background-color: blue;color:white;';
      }else if($row_funcionario['menu_scouter_insta'] == 1 && $num_result_matriz >= 15){
        echo 'background-color: blue; color:white;';
      };
    ?>"><?php echo $row_funcionario['nome_completo_func'];?></td>
    <td style="
    <?php
      if($row_funcionario['menu_scouter_ligacao'] == 1 && $num_result_matriz >= 30){
        echo 'background-color: blue;color:white;';
      }else if($row_funcionario['menu_scouter_insta'] == 1 && $num_result_matriz >= 15){
        echo 'background-color: blue; color:white;';
      };
    ?>"><center> <?php echo $num_result_matriz; ?> </center> </td>
    <td style="
    <?php
      if($row_funcionario['menu_scouter_ligacao'] == 1 && $num_result_matriz >= 30){
        echo 'background-color: blue;color:white;';
      }else if($row_funcionario['menu_scouter_insta'] == 1 && $num_result_matriz >= 15){
        echo 'background-color: blue; color:white;';
      };
    ?>"><center> <?php echo $num_result_lapa; ?> </center> </td>
    <td style="
    <?php
      if($row_funcionario['menu_scouter_ligacao'] == 1 && $num_result_matriz >= 30){
        echo 'background-color: blue;color:white;';
      }else if($row_funcionario['menu_scouter_insta'] == 1 && $num_result_matriz >= 15){
        echo 'background-color: blue; color:white;';
      };
    ?>"><center> <?php echo $num_result_impact; ?> </center> </td>
    <td style="
    <?php
      if($row_funcionario['menu_scouter_ligacao'] == 1 && $num_result_matriz >= 30){
        echo 'background-color: blue;color:white;';
      }else if($row_funcionario['menu_scouter_insta'] == 1 && $num_result_matriz >= 15){
        echo 'background-color: blue; color:white;';
      };
    ?>"><center> <?php echo $num_reagendado ?> </center> </td>
    <?php
      $total_matriz = $total_matriz + $num_result_matriz;
      $total_impact = $total_impact + $num_result_impact;
      $total_lapa = $total_lapa + $num_result_lapa;
      $total_reagendado = $total_reagendado + $num_reagendado;
    ?>
  </tr>
</tbody>
  <?php 
    };
  };
  ?>
  <tbody>
  <tr>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> <b> TOTAL: </b> </td>
      <td> <b> <center> <?php echo $total_matriz; ?> </center> </b> </td>
      <td> <b> <center> <?php echo $total_lapa; ?> </center> </b> </td>
      <td> <b> <center> <?php echo $total_impact; ?> </center> </b> </td>
      <td> <b> <center> <?php echo $total_reagendado; ?> </center> </b> </td>
      <td> <b>  </b> </td>
  </tr>
</tbody>
</table>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--<table border="1" style="float: left;"> 
  <tr>
    <td colspan="3"><font size="6px">  Pausas do Dia </font> </td>
  </tr>
  <tr>
    <td> Funcionário </td>
    <td> Hora da Pausa </td>
    <td> Horário de Volta </td>
  </tr>
</table>-->
</div>

<div class="container" style="margin-top: 30px; position: relative;">
<a href="rank.php"><button type="button" class="btn btn-warning">Calcular Ticket Médio</button></a>
<a href="teste_listar_agendados.php"><button type="button" class="btn btn-warning">Verificar Agendamentos</button></a>
<a href="teste_agendados_dia.php"><button type="button" class="btn btn-warning">Agendados do Dia</button></a>
<br><br>
<a href="teste_bonificacao.php"><button type="button" class="btn btn-warning">Calcular Bonificação</button></a>
<a href="resumo_dia.php"><button type="button" class="btn btn-warning">Resumo Diário</button></a>

</div>


</body>
</html>