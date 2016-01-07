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
<title><?=$name?> | <?=$this->config->site_name()?></title>
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
<body class="product-product-<?=$id?> bt-wide-boxed">
<?php $this->load->view('market/functional/loader'); ?>
<div id="bt_container" class="bt-wide-boxed" >
<?php $this->load->view('market/design/header'); ?>
  <div class="bt-breadcrumb">
    <div class="container">
      <ul class="breadcrumb">
        <li><a href="<?=$this->config->site_url()?>"><i class="fa fa-home"></i></a></li>
        <li><a href="<?=$this->config->site_url()?><?=$category_subname?>"><?=$category?></a></li>
        <li><a href="<?=$this->config->site_url()?>pid<?=$id?>"><?=$name?></a></li>
      </ul>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div id="content" class="col-sm-12">
        <div class="product-info">
          <div class="row">
            <div class="left pull-left col-sm-8 col-xs-12">
              <div class="bt-product-zoom">
                <div class="bosszoomtoolbox" style="display: none;">
                  <ul class="thumbnails">
                    <li>
                      <div id="wrap" style="top:0px;z-index:100;position:relative;">
                        <a href="<?=$img_high_url?>" title="Assumenda accus antium doloremque" class="cloud-zoom" id="zoom1" rel="" style="position: relative; display: block;">
                          <img src="<?=$img_medium_url?>" title="Assumenda accus antium doloremque" alt="Assumenda accus antium doloremque" id="image" style="display: block;">
                        </a>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="right pull-right col-sm-4 col-xs-12">
              <h2><?=$name?></h2>
              <ul class="list-unstyled description">
                <li>Состав: <?=$composition?></li>
                <li>Вес: <?=$weight?></li>
              </ul>
              <div>
                <label class="control-label" for="input-quantity">Количество</label>
                <div class="select_number">                
                  <input type="text" class="text form-control" name="quantity" size="2" id="input-quantity" value="1" />
                  <button onclick="changeQty(0); return false;" class="decrease">-</button>  
                  <button onclick="changeQty(1); return false;" class="increase">+</button>
                </div>
                <input type="hidden" name="product_id" value="<?=$id?>" />
                <div class="price_info">
                  <span class="price-new"><?=$price?> руб.</span>
                </div>
                <div class="cart_button">
                  <div class="boss_cover"><span class="cart_icon"></span></div>
                  <button type="button" id="button-cart-qs" data-loading-text="Загрузка..." class="btn button_cart">В корзину</button>
                </div>
                <div class="btn-group dropdown-share">
                  <ul class="nav">
                    <li class="parent">
                      <a class="btn-wishlist" title="Поделиться"><i class="fa fa-heart"></i></a>
                      <div class="dropdown">
                        <ul>
                          <li><a class="button btn-wishlist" onclick="Share.vkontakte('<?=$this->config->site_url()?>pid<?=$id?>','<?=$name?> | Vegas Pizza','<?=$img_high_url?>','')"><i class="sb sb-vk"></i></a></li>
                          <li><a class="button btn-wishlist" onclick="Share.facebook('<?=$this->config->site_url()?>pid<?=$id?>','<?=$name?> | Vegas Pizza','<?=$img_high_url?>','')"><i class="sb sb-fb"></i></a></li>
                          <li><a class="button btn-wishlist" onclick="Share.odnoklassniki('<?=$this->config->site_url()?>pid<?=$id?>','<?=$name?>')"><i class="sb sb-ok"></i></a></li>
                          <li><a class="button btn-wishlist" onclick="Share.twitter('<?=$this->config->site_url()?>pid<?=$id?>','<?=$name?>')"><i class="sb sb-tw"></i></a></li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                  <!--<button type="button" class="btn-compare" title="Compare this Product" onclick="btadd.compare('40');"><i class="fa fa-retweet"></i></button>-->
                </div>
                <script type="text/javascript"></script>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--
  function changeQty(increase) {
      var qty = parseInt($('.product-info .select_number').find("input").val());
      if ( !isNaN(qty) ) {
          qty = increase ? qty+1 : (qty > 1 ? qty-1 : 1);
          $('.product-info .select_number').find("input").val(qty);
      }
  } 
  
  $.fn.CloudZoom.defaults = {
    position: 'inside',
    tint: '#FFFFFF',
    tintOpacity: 1,
    lensOpacity: 1,
    softFocus: false,
    smoothMove: '3',
    showTitle: false,
    titleOpacity: 0.5,
    adjustX: 0,
    adjustY: 0
  }; 
    
  $('#button-cart-qs').bind('click', function() {
    var id = $('.product-info input[type=\'hidden\']').val();
    var counts = $('.product-info input[type=\'text\']').val();
    $.ajax({
      url: '/shop/add_product?DATA[]='+id+'&cnt='+counts,
      type: 'get',
      dataType: 'json',
      success: function(json) {
      $('.warning, .attention, information, .error').remove();
      $('.alert, .text-danger').remove();
      $('.form-group').removeClass('has-error');
          if (json['result']=='success') {
              addProductNotice(json['last']['name'], '<img src="'+json['last']['img']+'" alt="'+json['last']['name']+'" width="110px">', '<a href="/pid'+id+'">'+json['last']['name']+'</a> добавлен в корзину', 'success');
              $('#cart-total').html(json['total']['counts']+' товар(ов) - '+json['total']['price']+' руб.');
              $('#cart > ul').load('/cart');
              $('#myModal').modal('hide');
              $('#myModal').on('hidden.bs.modal', function () {
                  $('#myModal > .modal-dialog').remove();
                  $('.bt-comb.bt-menu-fixed').css('padding-right','');    
              });
          }
        }
    });
  }); 
  //-->
</script>
<?php $this->load->view('market/design/footer'); ?>
</div>
</body>
</html>