<html>
<head>
	<meta charset="utf8">
	<title>Создание категории | Shop-admin</title>
	<?php $this->load->view('scripts'); ?>
	<script type="text/javascript">
	var base_url = <?="'".$this->config->site_url()."'"?>;
	var static_url = <?="'".$this->config->site_url()."'"?>;
	$().ready(edit_category.ready);
	</script>
</head>
<body style="overflow-y: scroll;">
	<div class="container" id="loginForm">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 well">
				<?php
					$name_t = $name;
					if($name=='')
						$name_t = 'Новая категория';
					if(mb_strlen($name, 'UTF-8')>25)
						$name_t = substr($name, 0, 22).'...';
					$url = $this->config->site_url().'admin/edit_category/'.$id;
					if($id=='')
						$url = $this->config->site_url().'admin/create_category';
				?>
				<legend><?=$name_t?> <a href="<?=$this->config->site_url()?>admin/category" class="btn btn-default but-back">Назад</a></legend>
				<?php 
				if($error!='')
					echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">×</a>'.$error.'</div>';
				?>
				<form method="POST" action="<?=$url?>" accept-charset="UTF-8">

					<div class="form-group">
						<label for="name">Название: </label>
						<input type="text" id="name" class="form-control" name="name" placeholder="Название категории" maxlength="250" value="<?=$name?>">
					</div>

					<div class="form-group">
						<label for="parent_id">Родительская категория: </label>
						<input type="hidden" id="parent_id" class="form-control" name="parent_id" value="<?=$parent_id?>">
						<select id="for_parent_id" class="form-control" placeholder="Родительская категория">
							<option value="0">--Нет--</option>
							<?php
								foreach ($allcategory as $menu) {
								    echo '<option value="'.$menu['id'].'">'.$this->shop_model->get_parents_by_id($menu['id'],$menu['name']).'</option>';
								    if(isset($menu['childs'])) {
						    			morethentwo($menu['childs']);
								    }
								}
								function morethentwo($dataset)
								{
									$CI = get_instance();
								   	foreach ($dataset as $menu) {
										echo '<option value="'.$menu['id'].'">'.$CI->shop_model->get_parents_by_id($menu['id'],$menu['name']).'</option>';
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
						<label for="for_filters">Фильтры: <a href="/admin/settings?f" class="btn btn-primary"><i class="fa fa-plus"></i></a></label>
						<input type="hidden" name="filters" id="filters" value="<?=$filters?>">
						<select id="for_filters" class="form-control" placeholder="Фильтры" multiple>
							<?php
								foreach ($forfilters as $filter) {
								    echo '<option value="'.$filter['id'].'">'.$filter['name'].'</option>';
								}
							?>
						</select>
					</div>
					<br>
					<?php
					if($new)
						echo '<button type="submit" name="act" class="btn btn-primary btn-block">Сохранить</button>';
					else
						echo '<div class="btn-group btn-panel col-sm-12"><button type="submit" name="act" class="btn btn-primary col-sm-6">Сохранить</button><button id="del-but" type="button" onclick="del_category(\''.$menu['id'].'\', \''.$menu['name'].'\')" class="btn btn-danger col-sm-6">Удалить</button></div>';
					?>
				</form>    
			</div>
		</div>
	</div>
	<style>
	.select2-search-choice {
	    color: #000 !important;
	    background-color: #f0ad4e !important;
	    background-image: none !important;
	    -webkit-box-shadow: 0 0 2px #ffffff inset, 0 1px 0 rgba(0,0,0,0.05);
	    -moz-box-shadow: 0 0 2px #ffffff inset, 0 1px 0 rgba(0,0,0,0.05);
	    box-shadow: 0 0 2px #ffffff inset, 0 1px 0 rgba(0,0,0,0.05);
	    border: 1px solid #eea236 !important;
	    padding: 8px 10px 8px 23px !important;
	}
	.select2-search-choice-close {
	    top: 9px;
	}
	.select2-container-multi .select2-search-choice-close {
	    left: 8px;
	}
	</style>
</body>
</html>