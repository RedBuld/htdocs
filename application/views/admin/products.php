<div class="i-search">
	<div class="col-sm-4 form-inline"><input class="form-control" id="searchInp" type="text"><button id="searchBut" class="btn btn-default searchButSimple" type="button">Поиск</button><button id="searchButE" class="btn btn-default" type="button">&times;</button></div>
	<a class="btn btn-primary btn-new" href="<?=$this->config->site_url()?>admin/create_product"><i class="fa fa-plus"></i></a>
</div>
<table class="table table-bordered table-striped" id="table-products">
	<thead>
		<tr>
			<td>№</td>
			<td>Название</td>
			<td>Категория</td>
			<td>Фильтры</td>
			<td>Цена</td>
			<td>Изображение</td>
			<td class="col-sm-2">Действия</td>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($data as $key => $v) {
			$panel = '<div class="btn-group btn_panel"><button type="button" onclick="document.location.href = \''.$this->config->site_url().'admin/edit_product/'.$v['id'].'\'" class="btn btn-primary"><i class="fa fa-pencil"></i></button><button type="button" onclick="del_product('.$v['id'].', \''.$v['name'].'\')" class="btn btn-danger"><i class="fa fa-trash"></i></button></div>';
			$t = '';
			foreach ($filters as $filter => $value) {
				if($v[$value['parameter']]!='')
					$t .= '<p>'.$value['name'].': '.$v[$value['parameter']].' '.$value['atr'].'</p>';
			}
			$y = $v['name'];
			if(mb_strlen($v['name'], 'UTF-8')>100)
				$y = substr($v['name'], 0, 97).'...';
		 	echo '<tr d-title="'.$v['name'].'" d-name="'.$v['name'].'"><td>'.$v['id'].'</td><td title="'.$y.'">'.$y.'</td><td>'.$v['category'].'</td><td title="'.$t.'">'.$t.'</td><td>'.$v['price'].'</td><td><a class="prod_img" d-img="'.$v['img'].'" href="#img">Просмотреть</a></td><td>'.$panel.'</td></tr>';
		 } 
		?>
	</tbody>
</table>