<?php
$n = $name;
if(mb_strlen($name, 'UTF-8')>18)
	$n = substr($name, 0, 15).'...';

$c = '';
if(isset($count))
	$c = $count.' x';
?>
<tr>
	<td class="text-center">
		<div class="image">
			<a href="<?=$this->config->site_url()?>pid<?=$id?>">
				<img src="<?=$img_little_url?>" alt="<?=$n?>" title="<?=$n?>" class="img-thumbnail" width="160px">
			</a>
			<div class="remove">
				<button type="button" onclick="btadd.remove('<?=$id?>');;" title="Удалить" class="btn-remove">
					<i class="fa fa-times"></i>
				</button>
			</div>
			<div class="plus">
				<button type="button" onclick="btadd.cart('<?=$id?>');" title="Больше" class="btn-plus">
					<i class="fa fa-plus"></i>
				</button>
			</div>
			<div class="minus">
				<button type="button" onclick="btadd.uncart('<?=$id?>');" title="Меньше" class="btn-minus">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>
	</td>
	<td class="text-left">
		<div class="name">
			<a href="<?=$this->config->site_url()?>pid<?=$id?>"><?=$n?></a>
		</div>
		<div class="price"> <?=$c?> <?=$cost?> руб.</div>
	</td>
</tr>