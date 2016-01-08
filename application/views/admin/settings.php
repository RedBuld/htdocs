<ul class="nav nav-tabs" role="tablist" style="margin-top:20px;width:96%;margin-left:2%;">
    <li role="presentation"<? if(!isset($_GET['f'])){echo ' class="active"';};?>><a href="#settings_div" aria-controls="settings_div" role="tab" data-toggle="tab">Сайт</a></li>
    <li role="presentation"<? if(isset($_GET['f'])){echo ' class="active"';};?>><a href="#filters_div" aria-controls="filters_div" role="tab" data-toggle="tab">Фильтры</a></li>
</ul>
<div class="tab-content">
	<div role="tabpanel" class="settings_div tab-pane<? if(!isset($_GET['f'])){echo ' active';};?>" id="settings_div">
		<form action="/admin/settings" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-12">
					<button type="submit" name="act" class="btn btn-primary col-sm-1" style="float:right;"><i class='fa fa-save'></i></button>
				</div>
			</div>
			<div class="form-group required">
		        <label class="col-sm-2 control-label" for="input-name">Название магазина</label>
		        <div class="col-sm-10">
		        	<input type="text" name="storename" value="<?=$settings['storename']['value'];?>" placeholder="Название магазина" id="input-name" class="form-control" required="required">
		        </div>
		    </div>
		    <div class="form-group required">
				<label class="col-sm-2 control-label" for="input-address">Адрес магазина</label>
				<div class="col-sm-10">
					<textarea name="storeaddress" placeholder="Адрес магазина" rows="5" id="input-address" class="form-control" required="required"><?=$settings['storeaddress']['value'];?></textarea>
				</div>
			</div>
			<div class="form-group required">
				<label class="col-sm-2 control-label" for="input-email">E-Mail</label>
				<div class="col-sm-10">
					<input type="text" name="storeemail" value="<?=$settings['storeemail']['value'];?>" placeholder="E-Mail" id="input-email" class="form-control" required="required">
				</div>
			</div>
			<div class="form-group required">
				<label class="col-sm-2 control-label" for="input-phone">Телефон магазина</label>
				<div class="col-sm-10">
					<input type="text" name="storephone" value="<?=$settings['storephone']['value'];?>" placeholder="Телефон магазина" id="input-phone" class="form-control" required="required">
				</div>
			</div>
		</form>
	</div>
	<div role="tabpanel" class="filters_div tab-pane<? if(isset($_GET['f'])){echo ' active';};?>" id="filters_div">
		<form action="/admin/filters" method="post" enctype="multipart/form-data" id="form-filters" class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-12">
					<button type="submit" name="act" class="btn btn-primary col-sm-1" style="float:right;margin-left:5px;"><i class='fa fa-save'></i></button>
					<button type="button" class="btn btn-primary col-sm-1" onclick="createFilter()" style="float:right;"><i class='fa fa-plus'></i></button>
				</div>
			</div>
			<div class="form-group" style="padding:15px;">
	        <?
		        foreach ($filters as $filter => $info) {
		        	echo '<div class="filtag btn-group">';
			        	echo '<span class=" btn btn-primary" disabled>'.$info['name'].' ('.$info['atr'].')</span>';
			        	echo '<button type="button" class="btn btn-primary" onclick="editFilter('.$info['id'].',\''.$info['name'].'\',\''.$info['atr'].'\');"><i class="fa fa-pencil"></i></button>';
		        	echo '</div>';
		        }
	        ?>
	        </div>
		</form>
	</div>
</div>
<style type="text/css">
	.filtag + .filtag {
		margin-left: 10px;
	}
	.filtag span{
		min-width: 150px;
		text-align: center;
	}
</style>