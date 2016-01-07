<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]>
<html dir="ltr" lang="en" class="ie8">
<![endif]-->
<!--[if IE 9 ]>
<html dir="ltr" lang="en" class="ie9">
<![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->    
<html dir="ltr">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Карта сайта | <?=$this->config->site_name()?></title>
<link href="<?=$this->config->site_url()?>Favicon.png" rel="icon" />
<?php $this->load->view('market/scripts'); ?>
<script type="text/javascript"><!--
  $(document).ready(function() {
    var loader = $("body").DEPreLoad({
      OnStep: function(percent) {
        $("#depreload .cs_perc").text(percent + "%");
      },
      OnComplete: function() {
        setTimeout(function(){
          $("#depreload").css('display','none');
          $(".bosszoomtoolbox").css('display','block');
        }, 200);
      }
    });
    $('#cart > ul').load('/cart_overview');
  });
  //--></script>
<script type="text/javascript"><!--
  $(window).scroll(function() {
    var height_header = $('#bt_header').height();  			
    if($(window).scrollTop() > height_header) {
      $('.bt-comb').addClass('bt-menu-fixed animated');
    } else {
      $('.bt-comb').removeClass('bt-menu-fixed animated');
    }
  });
  //--></script>
</head>
<body class="sitemap bt-wide-boxed">
<?php $this->load->view('market/functional/loader'); ?>
<div id="bt_container" class="bt-wide-boxed" >
<?php $this->load->view('market/design/header'); ?>
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="<?=$this->config->site_url()?>"><i class="fa fa-home"></i></a></li>
      <li><a href="<?=$this->config->site_url()?>sitemap">Карта сайта</a></li>
    </ul>
    <div class="row">
      <div id="content" class="col-sm-12">
        <h1>Карта сайта</h1>
          <div class="col-sm-3">
            <ul>
              <h3>Информация</h3>
              <li><a href="<?=$this->config->site_url()?>">Главная</a></li>
              <li><a href="<?=$this->config->site_url()?>cart">Корзина</a></li>
              <li><a href="<?=$this->config->site_url()?>checkout">Оформление заказа</a></li>
              <li><a href="<?=$this->config->site_url()?>about">О нас</a></li>
              <li><a href="<?=$this->config->site_url()?>">Конфиденциальность</a></li>
              <li><a href="<?=$this->config->site_url()?>contact">Отзывы</a></li>
            </ul>
          </div>
          <?php
            foreach ($allcategory as $key => $v) {
              if($v['type']==1&&$v['num']!=0)
              {
                echo '<div class="col-sm-3"><ul><h3><a href="'.$this->config->site_url().$v['subname'].'">'.$v['name'].'</a></h3>';
                for($i = 0; $i < count($allproducts[$key]); $i++) {
                  echo '<li><a href="'.$this->config->site_url().'pid'.$allproducts[$key][$i]['id'].'">'.$allproducts[$key][$i]['name'].'</a></li>';
                }
                echo '</ul></div>';
              }
            }
          ?>
      </div>
    </div>
  </div>
<?php $this->load->view('market/design/footer'); ?>
</div>
</body>
</html>