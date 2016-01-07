<html>
<head>
	<meta charset="utf8">
	<title>Редактирование пользователей | Shop-admin</title>
	<?php $this->load->view('scripts'); ?>
	<script type="text/javascript">
	var base_url = <?="'".$this->config->site_url()."'"?>;
	var static_url = <?="'".$this->config->site_url()."'"?>;
	$().ready(edit_users.ready);
	</script>
</head>
<body style="overflow-y: scroll;">
	<div class="container" id="loginForm">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 well">
				<?php
					$username_t = $username;
					if($username=='')
						$username_t = 'Новый пользователь';
					if(mb_strlen($username, 'UTF-8')>25)
						$username_t = substr($username, 0, 22).'...';
					$url = ''.$this->config->site_url().'admin/edit_user/'.$id;
					if($id=='')
						$url = ''.$this->config->site_url().'admin/create_user';
				?>
				<legend><?=$username_t?> <a href="<?=$this->config->site_url()?>admin/users" class="btn btn-default but-back">Назад</a></legend>
				<?php 
				if($error!='')
					echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">×</a>'.$error.'</div>';
				?>
				<form method="POST" action="<?=$url?>" accept-charset="UTF-8">
					<div class="form-group">
						<label for="username">Имя: </label>
						<input type="text" id="username" class="form-control" name="username" placeholder="Имя пользователя" maxlength="200" value="<?=$username?>">
					</div>
					<div class="form-group" id="chpass1">
						<label for="password">Новый пароль: </label>
						<input type="password" id="password" class="form-control" name="password" placeholder="Пароль" maxlength="250" value="<?=$password?>">
					</div>
					<div class="form-group" id="chpass2">
						<label for="password2">Повтор нового пароля: </label>
						<input type="password" id="password2" class="form-control" name="password2" placeholder="Повтор пароля" maxlength="250">
					</div>
					<div class="form-group">
						<label for="rank">Ранг: </label>
						<select id="rank-select" class="form-control" name="rank" d-val="<?=$rank?>">
							<option value="0">Оператор</option>
							<option value="1">Модератор</option>
							<?php if($_SESSION['rank']>2||$new) echo '<option value="2">Главный модератор</option>'?>
						</select>
						<!-- <input type="text" id="rank" class="form-control" name="rank" placeholder="rank" value="<?=$rank?>" maxlength="250">-->
					</div>
					<br>
					<?php
					if($new)
						echo '<button type="submit" name="act" class="btn btn-primary btn-block">Сохранить</button>';
					else
						echo '<div class="btn-group btn-panel col-sm-12"><button type="submit" name="act" class="btn btn-primary col-sm-6">Сохранить</button><button id="del-but" type="button" onclick="del_product('.$id.', \''.$username.'\')" class="btn btn-danger col-sm-6">Удалить</button></div>';
					?>
				</form>    
			</div>
		</div>
	</div>
</body>
</html>