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
<title>Корзина | <?=$this->config->site_name()?></title>
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
        }, 200);
      }
    });
    $('#cart > ul').load('/cart_overview');
    $('#content').load('/cartview/0');
  });
  var cobtadd = {
    'cart': function(product_id) {
      $.ajax({
        url: '/shop/add_product?DATA[]='+product_id+'&cnt=1',
        type: 'get',
        dataType: 'json',
        success: function(json) {
          if (json['result']=='success') {
            addProductNotice(json['last']['name'], '<img src="'+json['last']['img']+'" alt="'+json['last']['name']+'" width="110px">', '<a href="/pid'+product_id+'">'+json['last']['name']+'</a> добавлен в <a href="/cart">корзину</a>', 'success');
            $('#cart-total').html(json['total']['counts']+' товар(ов) - '+json['total']['price']+' руб.');
            $('#content.carttable').load('/cartview/0');
          }
        }
      });
    },
    'uncart': function(product_id) {
      $.ajax({
        url: '/shop/rem_product?DATA[]='+product_id,
        type: 'get',
        dataType: 'json',
        success: function(json) {
          if (json['result']=='success') {
            addProductNotice(json['last']['name'], '<img src="'+json['last']['img']+'" alt="'+json['last']['name']+'" width="110px">', '<a href="/pid'+product_id+'">'+json['last']['name']+'</a> удалён из <a href="/cart">корзины</a>', 'success');
            $('#cart-total').html(json['total']['counts']+' товар(ов) - '+json['total']['price']+' руб.');
            $('#content.carttable').load('/cartview/0');
          }
        }
      });
    },
    'remove': function(product_id) {
      $.ajax({
        url: '/shop/del_product?DATA[]='+product_id,
        type: 'get',
        dataType: 'json',
        success: function(json) {
          if (json['result']=='success') {
            addProductNotice(json['last']['name'], '<img src="'+json['last']['img']+'" alt="'+json['last']['name']+'" width="110px">', '<a href="/pid'+product_id+'">'+json['last']['name']+'</a> удалён из <a href="/cart">корзины</a>', 'success');
            $('#cart-total').html(json['total']['counts']+' товар(ов) - '+json['total']['price']+' руб.');
            $('#content.carttable').load('/cartview/0');
          }
        }
      });
    } 
  };
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
<body class="checkout-cart bt-wide-boxed">
<!-- Loader -->
<?php $this->load->view('market/functional/loader'); ?>
<div id="bt_container" class="bt-wide-boxed " >
<?php $this->load->view('market/design/header'); ?>
<div class="container">
  <ul class="breadcrumb">
    <li><a href="<?=$this->config->site_url()?>"><i class="fa fa-home"></i></a></li>
    <li><a href="<?=$this->config->site_url()?>cart">Корзина</a></li>
  </ul>
  <div class="row">
    <div id="content" class="col-sm-12 carttable"></div>
  </div>
</div>
<?php $this->load->view('market/design/footer'); ?>
</body>
</html>