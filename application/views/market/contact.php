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
<title>Обратная связь | <?=$this->config->site_name()?></title>
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
<body class="contact bt-wide-boxed">
<?php $this->load->view('market/functional/loader'); ?>
<div id="bt_container" class="bt-wide-boxed" >
<?php $this->load->view('market/design/header'); ?>
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="<?=$this->config->site_url()?>"><i class="fa fa-home"></i></a></li>
      <li><a href="<?=$this->config->site_url()?>contact">Отзывы</a></li>
    </ul>
    <div class="row">
      <div id="content" class="col-sm-12">
        <h1>Отзывы</h1>
        <form id="enquiryForm" class="form-horizontal">
          <legend>Контактная форма</legend>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name">Имя</label>
            <div class="col-sm-10">
              <input type="text" name="name" value="" id="input-name" class="form-control">
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email">E-Mail</label>
            <div class="col-sm-10">
              <input type="text" name="email" value="" id="input-email" class="form-control">
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-enquiry">Сообщение</label>
            <div class="col-sm-10">
              <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"></textarea>
            </div>
          </div>
          <div class="form-group">
            <?=$captcha?>
          </div>
          <div class="form-group">
            <div class="buttons">
              <div class="pull-left">
                <button type="button" class="btn btn-primary" id="sendEnquiryBut" onclick="sendEnquiry();">Отправить</button>
              </div>
            </div>
          </div>
        </form>
        <script type="text/javascript">
          sendEnquiry = function() {
            var getStr, name, ok, tel, tel1;
            name = $('#input-name').val();
            email = $('#input-email').val();
            enquiry = $('#input-enquiry').val();
            ok = true;
            $('#enquiryForm .er-er').remove();
            $('#sendEnquiryBut').blur().hide();
            if (name === '') {
              $('#input-name').addEr('Это поле должно быть заполнено.');
              ok = false;
            }
            if (email === '') {
              $('#input-email').addEr('Это поле должно быть заполнено.');
              ok = false;
            } else {
              if (!(/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i.test(email))) {
                $('#input-email').addEr('Email введен неверно.');
                ok = false;
              }
            }
            if (enquiry === '') {
              $('#input-enquiry').addEr('Это поле должно быть заполнено.');
              ok = false;
            }
            if (ok) {
              getStr = $('#enquiryForm').serialize();
              $.get('/shop/add_contact?' + getStr, function(data) {
                var a, c;
                $('#recaptcha_reload').click();
                $('#sendEnquiry').show();
                if (data['result'] === 'success') {
                  a = new Btn('a', 'Ок', 'but-n', true);
                  c = new Modal('Сообщение отправлено', 'Сообщение успешно отправлено.', [a], true, 200);
                  c.create();
                  c.show();
                  $('#input-name').val('');
                  $('#input-email').val('');
                  $('#input-enquiry').val('');
                  a.setOnclick(function() {
                    document.location.reload();
                  });
                } else {
                  a = new Btn('a', 'Ок', 'but-n', true);
                  c = new Modal('Ошибка', 'Код с картинки введен неправильно.', [a], true, 200);
                  c.create();
                  c.show();
                }
              });
            } else {
              $('#sendEnquiryBut').show();
            }
          };
        </script>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('market/design/footer'); ?>
</body>
</html>