<div id="form_pesquisa" style="width: auto; height: auto;float: left;margin-left: 70px; background-color: #C0C0C0; border-style:solid;border-width: 1px;padding: 10px;box-shadow: 5px 10px #888888" class="container">
  <h2> Resumo </h2>
<form action="" name="resumo_rapido" method="POST">
  <label>Dia:</label>
  <input type="date" name="dataresumo">
  <br><br>
  <label>Unidade</label>
  <select name="unidade">
    <option value="1">Matriz</option>
    <option value="2">Lapa</option>
    <option value="3">Impact</option>

  </select>
  <br><br>
  <input type="submit" name="resumo" value="Verificar" class="myButton" style="width: 150px">
</form>
<?php
if(!empty($_POST['resumo'])){

  $date = $_POST['dataresumo'];
  $unidade = $_POST['unidade'];

  $pesquisa_resumo = "SELECT * FROM `agendamentos` WHERE `data_agendada_agendamento`= '$date' AND `id_unidade` = '$unidade' AND reagendado = '0'";
  $pesquisa_resumo_query = mysqli_query($conn, $pesquisa_resumo);
  $cont_pesquisa_resumo = mysqli_num_rows($pesquisa_resumo_query);

  $pesquisa_resumo_reagendado = "SELECT * FROM `agendamentos` WHERE `data_agendada_agendamento`= '$date' AND `id_unidade` = '$unidade' AND reagendado = '1'";
  $pesquisa_resumo_reagendado_query = mysqli_query($conn, $pesquisa_resumo_reagendado);
  $cont_pesquisa_reagendado = mysqli_num_rows($pesquisa_resumo_reagendado_query);

  if($cont_pesquisa_resumo <> 0){
  echo "<center>Agendados: <b> ".$cont_pesquisa_resumo." </b></center><br>";
  echo "<center>Reagendados: <b> ".$cont_pesquisa_reagendado." </b></center><br>";
  $soma_total = $cont_pesquisa_resumo + $cont_pesquisa_reagendado;
  echo "<center>Previsão de Comparecimento: <b> ".$soma_total." </b></center><br>";
  }else{
    echo "<center> Nenhum Agendamento :( </center>";
  }
}


?>
</div>