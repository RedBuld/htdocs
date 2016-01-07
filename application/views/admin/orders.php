<table style="margin-top: 30px;" class="table table-bordered table-striped" id="table-products">
	<thead>
		<tr>
			<td>№</td>
			<td>Имя</td>
			<td>Адрес</td>
			<td>Телефон</td>
			<td>Цена</td>
			<td>Время</td>
			<td>Доп. информация</td>
			<td class="col-sm-2">Действия</td>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($data as $key => $v) {
			$n = $v['name'];
			if(mb_strlen($v['name'], 'UTF-8')>50)
				$n = substr($v['name'], 0, 47).'...';
			$a = $v['address'];
			if(mb_strlen($v['address'], 'UTF-8')>50)
				$a = substr($v['address'], 0, 47).'...';
			$i = $v['info'];
			if(mb_strlen($v['info'], 'UTF-8')>50)
				$i = substr($v['info'], 0, 47).'...';
			$p = $v['price'].' руб.';
			$t = date('H:i:s d.m.Y', strtotime($v['datestamp']));
			echo '<tr>
				<td>'.$v['id'].'</td>
				<td title="'.$v['name'].'">'.$n.'</td>
				<td title="'.$v['address'].'">'.$a.'</td>
				<td>'.$v['phone'].'</td>
				<td>'.$p.'</td>
				<td>'.$t.'</td>
				<td title="'.$v['info'].'">'.$i.'</td>
				<td><div class="btn-group btn_panel"><button type="button" class="btn btn-primary" onclick="openOrderText(\''.$v['text'].'\')"><i class="fa fa-reorder"></i></button>
				<button onclick="document.location.href = \''.$this->config->site_url().'admin/real_del_order/'.$v['id'].'\';" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button></div></td>
			</tr>';
		} 
		?>
	</tbody>
</table>