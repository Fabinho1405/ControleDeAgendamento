<?php
	include_once("connection.php");
	$pdo=conectar();

	$resultEventos=$pdo->prepare("SELECT * FROM retorno_exclusive");
	$resultEventos->execute();
	$linhaEventos=$resultEventos->fetchAlWl(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset='utf-8' />
			<link href='css/fullcalendar.min.css' rel='stylesheet' />
			<link href='css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
			<link href='css/personalizado.css' rel='stylesheet' />
			<script src='js/moment.min.js'></script>
			<script src='js/jquery.min.js'></script>
			<script src='js/fullcalendar.min.js'></script>
			<script src='locale/pt-br.js'></script>
		<script>
			$(document).ready(function() {
				$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					defaultDate: Date(),
					navLinks: true, // can click day/week names to navigate views
					editable: false,
					eventLimit: true, // allow "more" link when too many events
					events: [
						<?php
								foreach($linhaEventos as $rowEventos){	
						?>
								{
								id: '<?php echo "1"; ?>',
								title: '<?php echo "Retorno - ".$rowEventos->contrato_cc; ?>',
								start: '<?php echo $rowEventos->data_rt." ".$rowEventos->horario_rt; ?>',
								end: '<?php echo $rowEventos->data_rt." ".$rowEventos->horario_rt; ?>',
								color: '<?php echo "#0071c5"; ?>',
								},<?php
							}
						?>
					]
				});
			});
		</script>
	</head>
	<body>

		<div id='calendar'></div>

	</body>
</html>
