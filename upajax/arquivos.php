<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Meus Arquivos</h2>
                                                                                        
  <div class="table-responsive">          
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Código</th>
        <th>Nome</th>
        <th>Tamanho</th>
        <th>Data de importação</th>
        <th>Ações</th>
  
      </tr>
    </thead>
    <tbody id="result">
     
    </tbody>
  </table>
  </div>
</div>

</body>
</html>

<script type="text/javascript">

$(document).ready(function(){
     $.ajax({            
            url:"metodos.php",     
            type:"post",
            data:"metodo=LISTAR_ARQUIVOS",
            beforeSend:function(){
                
            },
            success: function(data){
              $("#result").html(data);
            }
        })

})
</script>