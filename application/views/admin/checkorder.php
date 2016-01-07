<html>
<head>
	<meta charset="utf8">
	<title>Оформление заказа | Shop-admin</title>
	<?php $this->load->view('scripts'); ?>
	<script type="text/javascript">
	var base_url = <?="'".$this->config->site_url()."'"?>;
	var static_url = <?="'".$this->config->site_url()."'"?>;
	</script>
	<style type="text/css">
		body {background: #f5f5f5 !important;}
	</style>
</head>
<body style="overflow-y: scroll;">
	<div class="container" id="LoginForm">
		<div class="row">
			<div class="span6 offset3 well well-large" id="order-check">
				<?php
				$mline = '<br><br><i class="underline_">-------------------------------------------------------------------------------------------------------------------</i>';
				echo '<div class="person_info">Имя: <strong>'.$name.'</strong><br>Телефон: <strong>'.$phone.'</strong><br>Адрес: <strong>'.$address.'</strong>';
				if($info!='')
					echo '<p>Доп. информация: <strong>'.$info.'</strong></p>';
				echo '</div><br>';
				foreach (explode('*** ', $text) as $key => $text) {
					$text = str_replace("**: ", '<i class="order_counter">', $text);
					$text = str_replace(":** ", '</i>', $text);
					if($text!='')
						echo '<hr>'.$text;
				}
				echo $mline;
				$newPrice = $price;
				echo '<p>Итог: <strong>'.$newPrice.'</strong> руб.</p>';
				?>
				<br><br>
				<button type="button" onclick="orderBack()" id="order-back" class="btn btn-block btn-inverse">Вернуться назад</button>
			</div>
		</div>
	</div>
</body>
</html>