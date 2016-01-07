<?php
$n = $name;
if(mb_strlen($name, 'UTF-8')>18)
	$n = substr($name, 0, 15).'...';

$c = '';
if(isset($count))
	$c = $count;
?>
<tr>
  <td class="qc-name   ">
    <a href="<?=$this->config->site_url()?>pid<?=$id?>">
    <img src="<?=$img_little_url?>">
    <?=$name?>
    </a>
    <div class="qc-name-price "><span class="title">Цена:</span> <span class="text"><?=$cost?></span></div>
  </td>
  <td class="qc-quantity   ">
    <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-defaut decrease" onclick="cobtadd.uncart('<?=$id?>');" ><i class="fa fa-minus"></i></button>
      </span>            
      <input type="text" value="<?=$c?>" class="qc-product-qantity form-control text-center" name="cart[<?=$id?>]" data-refresh="<?=$c?>">
      <span class="input-group-btn">
        <button class="btn btn-defaut increase" onclick="cobtadd.cart('<?=$id?>');" ><i class="fa fa-plus"></i></button>
      </span>
    </div>
  </td>
  <td class="qc-price  "><?=$cost?> руб.</td>
  <td class="qc-total  "><?=$price?> руб.</td>
</tr>