<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste</title>
    <script language="JavaScript"> 
function pergunta(){ 
   if (confirm('Tem certeza que quer enviar este formulário?')){ 
      document.seuformulario.submit() 
   }  
} 
</script> 
</head>
<body>
<form name=seuformulario action="">
<input type="text" name="teste">
<input type=button onclick="pergunta()" value="Enviar"> 
</form>
    
</body>
</html>