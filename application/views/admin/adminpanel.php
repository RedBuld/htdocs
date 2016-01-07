<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf8">
	<title>Shop-admin</title>
	<?php $this->load->view('scripts'); ?>
	<script type="text/javascript">
    var base_url = <?="'".$this->config->site_url()."'"?>;
    var static_url = <?="'".$this->config->site_url()."'"?>;
    var content = '<?=$content?>';
	$().ready(admin.ready);
	</script>
</head>
<body>
<header id="header" class="navbar navbar-static-top">
	<div class="navbar-header">
		<a type="button" id="button-menu" class="pull-left"><i class="fa fa-dedent fa-lg"></i></a>
		<a class="navbar-brand" href="<?=$this->config->site_url()?>admin">
			CPanel
		</a>
	</div>
	<ul class="nav pull-right">
		<li>
			<a href="<?=$this->config->site_url();?>" target="_blank">
				<span class="hidden-xs hidden-sm hidden-md">Перейти к сайту</span>
			</a>
		</li>
		<li>
			<a href="<?=$this->config->site_url();?>auth/logout">
				<span class="hidden-xs hidden-sm hidden-md">Выход</span>
				<i class="fa fa-sign-out fa-lg"></i>
			</a>
		</li>
	</ul>
</header>
<nav id="column-left" style="overflow:hidden;">
	<div id="profile">
		<div>
			<a><img src="<?php echo $this->config->site_url(); ?>static/img/avatar.png" alt="<?php echo $_SESSION['username'];?>"></a>
		</div>
		<div>
			<h4><?php echo $_SESSION['username'];?></h4>
			<?php
			$r = 'Оператор';
			if($_SESSION['rank']==1)
				$r = 'Модератор';
			if($_SESSION['rank']==2)
				$r = 'Администратор';
			if($_SESSION['rank']==3)
				$r = 'Создатель';
			echo '<small>'.$r.'</small>';
			?>
		</div>
	</div>
	<ul id="menu">
		<li><a d-val="orders" href="<?=$this->config->site_url()?>admin/orders"><i class="fa fa-dashboard fa-fw"></i> <span>Заказы</span></a></li>
		<?php if($rank>0) echo '
		<li><a d-val="products" href="'.$this->config->site_url().'admin/products"><i class="fa fa-tags fa-fw"></i> <span>Товар</span></a></li>
		'; ?>
		<?php if($rank>1) echo '
		<li><a d-val="category" href="'.$this->config->site_url().'admin/category"><i class="fa fa-folder-open fa-fw"></i> <span>Категории</span></a></li>
		'; ?>
		<li><a d-val="users" href="<?=$this->config->site_url()?>admin/users"><i class="fa fa-users fa-fw"></i> <span>Пользователи</span></a></li>
		<?php if($rank>1) echo '<li><a d-val="settings" href="'.$this->config->site_url().'admin/settings"><i class="fa fa-cog fa-fw"></i> <span>Настройки</span></a></li>';?>
	</ul>
</nav>
<div id="content">
	<?php if($warning['text'] != '') echo '<div class="alert alert-'.$warning['type'].'"><a class="close" data-dismiss="alert" href="#">×</a>'.$warning['text'].'</div>'; ?>
	<?php $this->load->view('admin/'.$content, $data); ?>
</div>
</body>
</html>