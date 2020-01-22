<!DOCTYPE html>
<html>
<head>
	<title>Teste fechamento</title>
	<style type="text/css">
		.table-aguardo label {
    width: 60%;
    display: inline-block;
    background-color: green;
    cursor: pointer;    
}
.table-aguardo input[type="checkbox"] {
    display: none;
}
.table-aguardo input:checked + label {
    background-color: red;
}

.table-aguardo table {
    display: none;
}
.table-aguardo input:checked ~ table {
    display: table;
}
	</style>
	
</head>
<body>
<center>
	<form method="POST" action="actions/act_ordem_de_fechamento.php">
		<label>Id Cliente:</label>
		<input type="text" name="idcliente">
		<br><br>
		<label>Id Produtor:</label>
		<input type="text" name="idprodutor">
		<br><br>
		<label>Valor do Fechamento:</label>
		<input type="text" name="valorfechamento">
		<br><br>
		<div class="table-aguardo">
  <input id="aguardando" type="checkbox">
  <label for="aguardando" class="header"><font size="6px"color="white">Boleto Bancário </font></label>
   <table cellspacing="0">
      <tr>
      	<td>Boleto Bancário</td>
         <td><input type="radio" name="boleto" value="Sim">Sim <input type="radio" name="boleto" value="Não"> Não </td>     
      </tr>     
      <tr>
         <td>Valor do Boleto:</td>
         <td><input type="text" name="valor_boleto"></td>
      </tr>
      <tr>
         <td>Data do Vencimento:</td>
         <td><input type="date" name="data_vencimento_boleto"></td>
      </tr>
      <tr>
         <td>Quantidade de Vezes:</td>
         <td><input type="number" name="quantidade_vezes_boleto"></td>
      </tr>
   </table>
</div>
<div class="table-aguardo">
  <input id="finalizado" type="checkbox">
  <label for="finalizado" class="header"><font size="6px"color="white">Cartão</font></label>
   <table cellspacing="0">     
      <tr>
         <td>Bandeira:</td>
         <td>
         	<select name="bandeira">
         		<option value="MasterCard">MasterCard</option>
         		<option value="Elo">Elo</option>
         		<option value="Visa">Visa</option>	
         	</select>
         </td>
      </tr>
      <tr>
         <td>Quantidade de Vezes:</td>
         <td><input type="number" name="quantidade_vezes_cartao"></td>
      </tr>
      <tr>
         <td>Valor de Parcela:</td>
         <td><input type="text" name="valor_cartao"></td>
      </tr>
   </table>
</div>

<div class="table-aguardo">
  <input id="entrada" type="checkbox">
  <label for="entrada" class="header"><font size="6px"color="white">Entrada no Dia</font></label>
   <table cellspacing="0">     
      <tr>
         <td>Modalidade:</td>
         <td>
         	<select name="bandeira">
         		<option>Dinheiro</option>
         		<option>Cartão</option>	
         	</select>
         </td>
      </tr>
      <tr>
         <td>Bandeira: (caso seja cartão)</td>
         <td>
         	<select name="bandeira">
         		<option>Mastercard</option>
         		<option>Elo</option>
         		<option>Visa</option>	
         	</select>
         </td>
      </tr>
      <tr>
         <td>Valor:</td>
         <td><input type="number" name=""></td>
      </tr>
   </table>
</div>		
<br><br>
<input type="submit" value="Solicitar Ordem" name="">
	</form>
</center>
</body>
</html>