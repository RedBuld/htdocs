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
<title>Ошибка | <?=$this->config->site_name()?></title>
<link href="<?=$this->config->site_url()?>static/market/image/catalog/bt_leather/Favicon.jpg" rel="icon" />
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
<body class="error-page bt-wide-boxed">
<!-- Loader -->
<?php $this->load->view('market/functional/loader'); ?>
<div id="bt_container" class="bt-wide-boxed " >
<?php $this->load->view('market/design/header'); ?>
<div class="container">
  <ul class="breadcrumb">
    <li><a href="<?=$this->config->site_url()?>"><i class="fa fa-home"></i></a></li>
    <li><a href="<?=$this->config->site_url()?>">Ошибка</a></li>
  </ul>
  <div class="row">
    <div id="content" class="col-sm-12">
    	<h1 class="title">Страница не найдена</h1>
    	<p>Посмотрите существующие страницы в меню или перейдите <a href="<?=$this->config->site_url()?>">на главную</a>.</p>
    </div>
  </div>
</div>;
<?php $this->load->view('market/design/footer'); ?>
</body>
</html>