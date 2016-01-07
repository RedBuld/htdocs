<div class="i-search">
	<div class="col-sm-4 form-inline"><input class="form-control" id="searchInp" type="text"><button id="searchBut" class="btn btn-default searchButSimple" type="button">Поиск</button><button id="searchButE" class="btn btn-default" type="button">&times;</button></div>
	<a href="/admin/create_category" class="btn btn-new btn-primary"><i class="fa fa-plus"></i></a>
</div>
<table class="table table-bordered table-striped" id="table-products">
	<thead>
		<tr>
			<td>Название</td>
			<td class="col-sm-1">Активность</td>
			<td class="col-sm-2">Действия</td>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($data as $menu) {
			    echo '<tr d-title="'.$menu['name'].'" d-name="'.$menu['name'].'" title="'.$menu['name'].'"><td>'.$this->shop_model->get_parents_by_id($menu['id'],$menu['name']).'</td><td><button type="button" onclick="document.location.href = \''.$this->config->site_url().'admin/category_change_used/'.$menu['id'].'\'" class="btn btn-';
			    if($menu['active']){echo 'success';}else{echo 'danger';}
			    echo ' btn-block"><i class="fa fa-power-off"></i></button></td><td><div class="btn-group btn_panel"><button type="button" onclick="document.location.href = \''.$this->config->site_url().'admin/edit_category/'.$menu['id'].'\'" class="btn btn-primary"><i class="fa fa-pencil"></i></button><button class="btn btn-danger" onclick="delCategory(\''.$menu['id'].'\', \''.$menu['name'].'\')"><i class="fa fa-trash fa-fw"></i></button></div></td></tr>';
			    if(isset($menu['childs'])) {
	    			morethentwo($menu['childs']);
			    }
			}
			function morethentwo($dataset)
			{
				$CI = get_instance();
			   	foreach ($dataset as $menu) {
					echo '<tr d-title="'.$menu['name'].'" d-name="'.$menu['name'].'" title="'.$menu['name'].'"><td>'.$CI->shop_model->get_parents_by_id($menu['id'],$menu['name']).'</td><td><button type="button" onclick="document.location.href = \''.$CI->config->site_url().'admin/category_change_used/'.$menu['id'].'\'" class="btn btn-';
					if($menu['active']){echo 'success';}else{echo 'danger';}
					echo ' btn-block"><i class="fa fa-power-off"></i></button></td><td><div class="btn-group btn_panel"><button type="button" onclick="document.location.href = \''.$CI->config->site_url().'admin/edit_category/'.$menu['id'].'\'" class="btn btn-primary"><i class="fa fa-pencil"></i></button><button class="btn btn-danger" onclick="delCategory(\''.$menu['id'].'\', \''.$menu['name'].'\')"><i class="fa fa-trash fa-fw"></i></button></div></td></tr>';
        			if(isset($menu['childs']))
		    		{
		    			morethentwo($menu['childs']);
					}
				}
			}
		?>
	</tbody>
</table>