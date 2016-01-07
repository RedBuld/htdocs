<div class="i-search">
	<div class="col-sm-4 form-inline"><input class="form-control" id="searchInp" type="text"><button id="searchBut" class="btn btn-default searchButSimple" type="button">Поиск</button><button id="searchButE" class="btn btn-default" type="button">&times;</button></div>
	<a class="btn btn-primary btn-new" href="<?=$this->config->site_url()?>admin/create_user"><i class="fa fa-plus"></i></a>
</div>
<table class="table table-bordered table-striped" id="table-products">
	<thead>
		<tr>
			<td>id</td>
			<td>Имя</td>
			<td>Закодированный пароль</td>
			<td>Ранг</td>
			<td class="col-sm-2">Действия</td>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($data as $key => $v) {
			$panel = '';
			if(($v['rank']==2&&$v['id']==$_SESSION['id'])||($v['rank']<2)||($_SESSION['rank']>2))
				$panel = '<div class="btn-group btn_panel"><button type="button" onclick="document.location.href = \''.$this->config->site_url().'admin/edit_user/'.$v['id'].'\'" class="btn btn-primary"><i class="fa fa-pencil"></i></button><button type="button" onclick="del_user('.$v['id'].', \''.$v['username'].'\')" class="btn btn-danger"><i class="fa fa-trash"></i></button></div>';
			$y = $v['username'];
			if(mb_strlen($v['username'], 'UTF-8')>100)
				$y = substr($v['username'], 0, 97).'...';
			$z = $v['password'];
			if(mb_strlen($v['password'], 'UTF-8')>40)
				$z = substr($v['password'], 0, 37).'...';
			$r = 'Оператор';
			if($v['rank']==1)
				$r = 'Модератор';
			if($v['rank']==2)
				$r = 'Главный модератор';
		 	echo '<tr d-username="'.$v['username'].'"><td>'.$v['id'].'</td><td title="'.$v['username'].'">'.$y.'</td><td title="'.$v['password'].'">'.$z.'</td><td>'.$r.'</td><td>'.$panel.'</td></tr>';
		 } 
		?>
	</tbody>
</table>