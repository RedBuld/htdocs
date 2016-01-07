<html>
<head>
	<meta charset="utf8">
	<title>Редактирование товара | Shop-admin</title>
	<?php $this->load->view('scripts'); ?>
	<script type="text/javascript">
	var base_url = <?="'".$this->config->site_url()."'"?>;
	var static_url = <?="'".$this->config->site_url()."'"?>;
	$().ready(edit_products.ready);
	</script>
</head>
<body style="overflow-y: scroll;">
	<div class="container" id="loginForm">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 well">
				<?php
					$name_t = $name;
					if($name=='')
						$name_t = 'Новый товар';
					if(mb_strlen($name, 'UTF-8')>25)
						$name_t = substr($name, 0, 22).'...';
					$url = $this->config->site_url().'admin/edit_product/'.$id;
					if($id=='')
						$url = $this->config->site_url().'admin/create_product';
				?>
				<legend><?=$name_t?> <a href="<?=$this->config->site_url()?>admin/products" class="btn btn-default but-back">Назад</a></legend>
				<?php 
				if($error!='')
					echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">×</a>'.$error.'</div>';
				?>
				<form method="POST" action="<?=$url?>" accept-charset="UTF-8">

					<div class="form-group">
						<label for="name">Название: </label>
						<input type="text" id="name" class="form-control" name="name" placeholder="Название продукта" maxlength="250" value="<?=$name?>">
					</div>

					<div class="form-group">
						<label for="category">Категория: </label>
						<input type="hidden" id="category" class="form-control" name="category" value="<?=$category?>">
						<select id="for_category" placeholder="Категория" class="form-control">
							<option value=""></option>
							<?php
								foreach ($allcategory as $menu) {
								    echo '<option value="'.$menu['name'].'">'.$this->shop_model->get_parents_by_id($menu['id'],$menu['name']).'</option>';
								    if(isset($menu['childs'])) {
						    			morethentwo($menu['childs']);
								    }
								}
								function morethentwo($dataset)
								{
									$CI = get_instance();
								   	foreach ($dataset as $menu) {
										echo '<option value="'.$menu['name'].'">'.$CI->shop_model->get_parents_by_id($menu['id'],$menu['name']).'</option>';
					        			if(isset($menu['childs']))
							    		{
							    			morethentwo($menu['childs']);
										}
									}
								}
							?>
						</select>
					</div>
					
					<div class="form-group">
						<label for="price">Цена: </label>
						<div class="input-group">
							<input type="number" id="price" class="form-control" name="price" placeholder="Цена" value="<?=$price?>">
							<span class="input-group-addon">руб.</span>
						</div>
					</div>

					<div class="form-group">
						<label>Изображение: </label>
						<div id="for_img_loader">
							<?php 
							if($img!='stay')
								echo '<img src="'.$this->config->site_url().'uploads/image/high/'.$img.'" alt="'.$img.'">';
							?>
							<div style="height:10px; width:1px;"></div>
						</div>
					</div>
					<input name="img" id="img" value="<?php if($new){echo($img);}else{echo('stay');}?>" type="hidden">
					<?php
						foreach ($forfilters as $filter => $value) {
							echo '<div class="form-group">';
							echo '<label for="'.$value['parameter'].'">'.$value['name'].': </label>';
							echo '<input id="'.$value['parameter'].'" name="'.$value['parameter'].'" placeholder="'.$value['name'].'" value="'.$$value['parameter'].'" class="form-control">';
							echo '</div>';
						}
					?>
					<br>
					<?php
					if($new)
						echo '<button type="submit" name="act" class="btn btn-primary btn-block">Сохранить</button>';
					else
						echo '<div class="btn-group btn_panel btn-del-save"><button type="submit" name="act" class="btn btn-primary">Сохранить</button><button type="button" onclick="del_product('.$id.', \''.$name.'\')" class="btn btn-danger">Удалить</button></div>';
					?>
				</form>    
			</div>
		</div>
	</div>
</body>
</html>