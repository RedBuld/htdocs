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
<?php $this->load->view('market/scripts_checkout'); ?>
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
    $('#step_6').load('/cartview/1');
    $.ajax({
      url: '/shop/load_streets',
      dataType: 'json',
      success: function(data)
      {
        for(var i in data)
        {
          $('#payment_address_street').append('<option value="'+data[i]['name']+'">'+data[i]['name']+'</option>');
        }
        $('#payment_address_street').select2();
      }
    });
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
            $('#step_6').load('/cartview/1');
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
            $('#step_6').load('/cartview/1');
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
            $('#step_6').load('/cartview/1');
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
    <li><a href="<?=$this->config->site_url()?>checkout">Оформление заказа</a></li>
  </ul>
  <div class="row">
    <div id="content" class="col-sm-12">
    <?php if(count($_SESSION['BAG']) > 0) : ?>
      <div id="quickcheckout">
        <div class="wrap">
          <div class="block-title">Оформление заказа</div>
          <div class="block-content">
            <!--левая колонка-->
            <div id="qc_left" class="aqc-column aqc-column-1" style="width:40%">
              <div id="step_2" data-sort="2" data-row="1" data-column="1" data-width="50" class="blocks" style="display: block;">
                <div id="payment_address_wrap">
                  <div class="panel panel-default">
                    <!--ТАБЛИЦА: перс.данные-->
                    <div class="panel-heading">
                      <span class="wrap"><span class="fa fa-fw qc-icon-profile"></span></span> 
                      <span class="text">Персональные данные</span>
                    </div>
                    <div class="panel-body">
                      <div id="payment_address" class="form-horizontal ">
                        <!--правая колонка-->
                        <div id="firstname_input" class="text-input form-group row sort-item required">
                          <div class="col-xs-5">
                            <label class="control-label" for="payment_address_firstname"> 
                              <span class="text" title="">Имя</span> 
                            </label>
                          </div>
                          <div class="col-xs-7"> 
                            <input type="text" name="firstname" id="payment_address_firstname" data-require="require" value="" class="form-control">
                          </div>
                          <div class="col-xs-12 text-danger hidden">Поле "Имя" не может быть пустым</div>
                        </div>
                        <!--правая колонка-->
                        <div id="lastname_input" class="text-input form-group row sort-item required">
                          <div class="col-xs-5">
                            <label class="control-label" for="payment_address_lastname"> 
                              <span class="text" title="">Фамилия</span> 
                            </label>
                          </div>
                          <div class="col-xs-7"> 
                            <input type="text" name="lastname" id="payment_address_lastname" data-require="require" value="" class="form-control">
                          </div>
                          <div class="col-xs-12 text-danger hidden">Поле "Фамилия" не может быть пустым</div>
                        </div>
                        <!--правая колонка-->
                        <div id="telephone_input" class="text-input form-group row sort-item required">
                          <div class="col-xs-5">
                            <label class="control-label" for="payment_address_telephone"> 
                              <span class="text" title="">Телефон</span> 
                            </label>
                          </div>
                          <div class="col-xs-7"> 
                            <input type="text" name="telephone" id="payment_address_telephone" data-require="require" value="" class="form-control">
                          </div>
                          <div class="col-xs-12 text-danger hidden">Поле "Телефон" не может быть пустым</div>
                        </div>
                        <div class="clear"></div>
                      </div>
                    </div>
                  </div>
                  <!--КОНЕЦ ТАБЛИЦЫ-->
                  <!--ТАБЛИЦА: адресс-->
                  <div id="heading_input" class="panel panel-default sort-item heading ">
                    <div class="panel-heading">
                      <span class="wrap">
                        <span class="fa fa-fw qc-icon-payment-address"></span>
                      </span> 
                      <span>Адрес</span>
                    </div>
                    <div class="panel-body">
                      <div class="form-horizontal">
                        <div id="address_street" class="select-input form-group row sort-item required">
                          <div class="col-xs-5">
                            <label class="control-label" for="payment_address_street"> 
                              <span class="text" title="">Улица</span>
                            </label>
                          </div>
                          <div class="col-xs-7">
                            <select name="street" data-require="require" id="payment_address_street" class="form-control">
                              <option value="">--- Выберите улицу ---</option>
                            </select>
                          </div>
                          <div class="col-xs-12 text-danger hidden">Выберите улицу из списка</div>
                        </div>
                        <div id="address_house" class="text-input form-group row sort-item required">
                          <div class="col-xs-5">
                            <label class="control-label" for="payment_address_house"> 
                              <span class="text" title="">Дом</span>
                            </label>
                          </div>
                          <div class="col-xs-7"> 
                            <input type="text" name="house" id="payment_address_house" data-require="require" value="" class="form-control">
                          </div>
                          <div class="col-xs-12 text-danger hidden">Поле "Дом" не может быть пустым</div>
                        </div>
                        <div id="address_apartment" class="text-input form-group row sort-item required">
                          <div class="col-xs-5">
                            <label class="control-label" for="payment_address_apartment"> 
                              <span class="text" title="">Квартира/офис</span>
                            </label>
                          </div>
                          <div class="col-xs-7"> 
                            <input type="text" name="apartment" id="payment_address_apartment" data-require="require" value="" class="form-control">
                          </div>
                          <div class="col-xs-12 text-danger hidden">Поле "Квартира/офис" не может быть пустым</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--КОНЕЦ ТАБЛИЦЫ-->
                </div>
              </div>
            </div>
            <!--КОНЕЦ: левая колонка-->
            <!--правая колонка-->
            <div class="qc-right" style="width:60%; float:left">
              <div class="aqc-column aqc-column-4" style="width:100%">
                <!--ТАБЛИЦА: корзина-->
                <div id="step_6" data-sort="6" data-row="2" data-column="4" data-width="50" class="blocks" style="display: block;"></div>
                <!--КОНЕЦ ТАБЛИЦЫ-->
                <!--ТАБЛИЦА: комментарий-->
                <div id="step_8" data-sort="8" data-row="2" data-column="4" data-width="50" class="blocks" style="display: block;">
                  <div id="confirm_wrap">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <span class="wrap"><span class="fa fa-fw qc-icon-shipping-method"></span></span> 
                        <span class="text">Примечание к заказу</span>
                      </div>
                      <div class="panel-body">
                        <div id="confirm_inputs" class="form-horizontal">
                          <div id="comment_input" class="textarea-input form-group sort-item" data-sort="1">
                            <div class="col-xs-12">
                              <textarea name="comment" id="confirm_comment" data-require="" data-refresh="0" class="form-control" placeholder=" Add Comments About Your Order"></textarea>
                            </div>
                          </div>
                          <div class="clear"></div>
                        </div>
                        <div>
                          <div class="buttons">
                            <div class="right">
                              <button type="button" onclick="validateAllFields()" id="qc_confirm_order" class="button btn btn-primary">Оформить заказ</button>
                            </div>
                          </div>
                        </div>
                        <div class="clear"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--КОНЕЦ ТАБЛИЦЫ-->
              </div>
            </div>
            <!--КОНЕЦ: правая колонка-->
            <script type="text/javascript">
              function validateAllFields(){
                var no_error = true;
                if($('#firstname_input input').val()===''){no_error = false;$('#firstname_input div.col-xs-12').removeClass('hidden');}else{$('#firstname_input div.col-xs-12').addClass('hidden');}
                if($('#lastname_input input').val()===''){no_error = false;$('#lastname_input div.col-xs-12').removeClass('hidden');}else{$('#lastname_input div.col-xs-12').addClass('hidden');}
                if($('#telephone_input input').val()===''){no_error = false;$('#telephone_input div.col-xs-12').removeClass('hidden');}else{$('#telephone_input div.col-xs-12').addClass('hidden');}
                if($('#address_street select').val()===''){no_error = false;$('#address_street div.col-xs-12').removeClass('hidden');}else{$('#address_street div.col-xs-12').addClass('hidden');}
                if($('#address_house input').val()===''){no_error = false;$('#address_house div.col-xs-12').removeClass('hidden');}else{$('#address_house div.col-xs-12').addClass('hidden');}
                if($('#address_apartment input').val()===''){no_error = false;$('#address_apartment div.col-xs-12').removeClass('hidden');}else{$('#address_apartment div.col-xs-12').addClass('hidden');}
                if(no_error){
                  $.ajax({
                    url: '/shop/create_order',
                    type: 'post',
                    data:  $('#quickcheckout input[data-require=require], #quickcheckout select[data-require=require],#quickcheckout textarea'),
                    dataType: 'json',
                    beforeSend: function() {
                    },
                    complete: function() {
                    },
                    success: function(data) {
                      if(data['result'] == "success"){
                        $('#content').html('<h1 class="title">Ваш заказ принят!</h1><p>Ожидайте звонка оператора!</p><div class="buttons"><a href="<?=$this->config->site_url()?>" class="btn btn-primary">Продолжить</a></div></div>');
                      }else{
                        alert('Ошибка');
                      }
                    }
                  });
                }
              }
            </script>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <h1>Корзина</h1>
    <p>Ваша корзина пуста!</p>
  <?php endif; ?>
  </div>
</div>;
<?php $this->load->view('market/design/footer'); ?>
</body>
</html>