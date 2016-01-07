<?php
$n = $name;
if(mb_strlen($name, 'UTF-8')>18)
	$n = substr($name, 0, 15).'...';

$c = '';
if(isset($count))
	$c = $count;
?>
<tr>
  <td class="image">
    <a href="<?=$this->config->site_url()?>pid<?=$id?>">
      <img src="<?=$img_little_url?>" alt="<?=$n?>" title="<?=$n?>" class="img-thumbnail" width="160px">
    </a>
  </td>
  <td class="name">
    <a href="<?=$this->config->site_url()?>pid<?=$id?>"><?=$n?></a>
  </td>
  <td class="quantity">
    <div class="input-group btn-block" style="max-width: 200px;">
      <input type="text" name="quantity" value="<?=$c?>" size="1" class="form-control">
      <span class="input-group-btn">
        <button type="button" onclick="cobtadd.cart('<?=$id?>');" title="Больше" class="btn-plus">
          <i class="fa fa-plus"></i>
        </button>
        <button type="button" onclick="cobtadd.uncart('<?=$id?>');" title="Меньше" class="btn-minus">
          <i class="fa fa-minus"></i>
        </button>
        <button type="button" onclick="cobtadd.remove('<?=$id?>');" title="Удалить" class="btn-remove">
          <i class="fa fa-times"></i>
        </button>
      </span>
    </div>
  </td>
  <td class="product-price"><?=$cost?> руб.</td>
  <td class="total"><?=$price?> руб.</td>
</tr>