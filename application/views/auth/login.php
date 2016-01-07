<html>
<head>
	<meta charset="utf8">
	<title>Вход | Shop-admin</title>
	<?php $this->load->view('scripts'); ?>
	<script type="text/javascript">
	$().ready(login.ready);
	</script>
</head>
<body>
<header id="header" class="navbar navbar-static-top">
	<div class="navbar-header">
		<a class="navbar-brand" href="<?=$this->config->site_url()?>admin">
			CPanel
		</a>
	</div>
</header>
	<div class="container" id="loginForm">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4 well">
				<legend>Авторизация</legend>
				<?php if($error != '') echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">×</a>'.$error.'</div>'; ?>
				<form method="POST" action="<?=$this->config->site_url().'auth/login'?>" accept-charset="UTF-8">
				<div class="form-group">
					<label for="username">Имя пользователя</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user" style="width:20px;"></i></span>
						<input type="text" id="username" class="form-control" name="username" placeholder="Имя пользователя" value="<?=$username?>">
					</div>
				</div>
				<div class="form-group">
					<label for="password">Пароль</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock" style="width:20px;"></i></span>
						<input type="password" id="password" class="form-control" name="password" placeholder="Пароль">
					</div>
				</div>
				<br>
				<button type="submit" name="submit" class="btn btn-block btn-primary">Войти</button>
				</form>    
			</div>
		</div>
	</div>
</body>
</html>