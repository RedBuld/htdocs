<?php
$n = $name;
if(mb_strlen($name, 'UTF-8')>20)
	$n = substr($name, 0, 17).'...';
?>
<div class="bt-item-extra element-4">
  <div class="product-thumb bt-item transition">
    <div class="image">
      <a href="<?=$this->config->site_url()?>pid<?=$id?>" d-id="<?=$id?>"><img src="<?=$img_little_url?>" alt="<?=$n?>" title="<?=$n?>" class="img-responsive" /></a>
      <div class="dropdown d-<?=$id?>">
        <ul>
          <li><a class="button btn-wishlist" onclick="Share.vkontakte('<?=$this->config->site_url()?>pid<?=$id?>','<?=$name?>','<?=$img_high_url?>','<?=$name?>')"><i class="sb sb-vk"></i></a></li>
          <li><a class="button btn-wishlist" onclick="Share.facebook('<?=$this->config->site_url()?>pid<?=$id?>','<?=$name?>','<?=$img_high_url?>','<?=$name?>')"><i class="sb sb-fb"></i></a></li>
          <li><a class="button btn-wishlist" onclick="Share.odnoklassniki('<?=$this->config->site_url()?>pid<?=$id?>','<?=$name?>')"><i class="sb sb-ok"></i></a></li>
          <li><a class="button btn-wishlist" onclick="Share.twitter('<?=$this->config->site_url()?>pid<?=$id?>','<?=$name?>')"><i class="sb sb-tw"></i></a></li>
        </ul>
      </div>
      <div class="button-group bt-button-group hidden-xs">
        <button class="btn-cart" type="button" onclick="btadd.cart('<?=$id?>');"><i class="fa fa-shopping-cart"></i></button>
        <button class="btn-wishlist shorty" type="button" title="Поделится" data-id="<?=$id?>"><i class="fa fa-heart"></i></button>
        <button  title ="Quick View" onclick="getModalContent(<?=$id?>);" class="sft_quickshop_icon" data-toggle="modal" data-target="#myModal">
          <span class="qs_icon">
            <i class="fa fa-search"></i>
          </span>
        </button>
      </div>
    </div>
    <div class="small_detail">
      <div class="caption">
        <div class="name"><a href="<?=$this->config->site_url()?>pid<?=$id?>"><?=$n?></a></div>
        <p class="price">
          <span class="price-new"><?=$price?>&nbsp;руб.</span>
        </p>
      </div>
    </div>
    <div class="button-group visible-xs">
      <button class="btn-cart" type="button" onclick="btadd.cart('<?=$id?>');"><i class="fa fa-shopping-cart"></i>&nbsp;В корзину</button>
      <button class="btn-wishlist" type="button" title="Поделиться"><i class="fa fa-heart"></i></button>
    </div>
  </div>
</div>