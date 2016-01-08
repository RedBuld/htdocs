<?php
$n = $name;
if(mb_strlen($name, 'UTF-8')>20)
	$n = substr($name, 0, 17).'...';
?>
<div class="item elem-3">
  <div class="product-thumb bt-item transition">
    <div class="image">
      <a href="<?=$this->config->site_url()?>pid<?=$id?>" d-id="<?=$id?>"><img src="<?=$img_little_url?>" alt="<?=$n?>" title="<?=$n?>" class="img-responsive" /></a>
    </div>
    <div class="small_detail">
      <div class="caption">
        <div class="name"><a href="<?=$this->config->site_url()?>pid<?=$id?>"><?=$n?></a></div>
        <p class="price">
          <span class="price-new"><?=$price?>&nbsp;руб.</span>
        </p>
      </div>
    </div>
    <div class="button-group">
      <button class="btn-cart" type="button" onclick="btadd.cart('<?=$id?>');"><i class="fa fa-shopping-cart"></i>&nbsp;В корзину</button>
    </div>
  </div>
</div>