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
<title>О нас | <?=$this->config->site_name()?></title>
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
<body class="information-information bt-wide-boxed">
<!-- Loader -->
<?php $this->load->view('market/functional/loader'); ?>
<div id="bt_container" class="bt-wide-boxed " >
<?php $this->load->view('market/design/header'); ?>
<div class="container">
  <ul class="breadcrumb">
    <li><a href="<?=$this->config->site_url()?>"><i class="fa fa-home"></i></a></li>
    <li><a href="<?=$this->config->site_url()?>about">О нас</a></li>
  </ul>
  <div class="row">
    <div id="content" class="col-sm-12">
      <div id="about-div">
       	<ul class="nav nav-tabs" id="aboutTab">
      		<li class="active"><a href="#info-tab" data-toggle="tab">Информация</a></li>
      		<li><a href="#jobs-tab" data-toggle="tab">Вакансии</a></li>
      	</ul>
      	<div class="tab-content">
    			<div class="tab-pane fade in active" id="info-tab">
            <?php $this->load->view('market/functional/info');?>
          </div>
    			<div class="tab-pane fade" id="jobs-tab">
          <?php if(count($jobs)>0):?>
    				<form class="form-horizontal" role="form" id="jobs_form">
    			  	<div class="form-group">
    			    	<label for="inputName" class="col-lg-2 control-label">Ф.И.О.:</label>
    			    	<div class="col-lg-10">
    			      		<input type="text" name="name" class="form-control" id="inputName" maxlength="256" placeholder="Ф.И.О.">
    			    	</div>
    			  	</div>
    			  	<div class="form-group">
    			    	<label for="inputTel" class="col-lg-2 control-label">Телефон:</label>
    			    	<div class="col-lg-10">
    			      		<input type="text" name="tel" class="form-control" id="inputTel" maxlength="12" placeholder="Телефон">
    			    	</div>
    			  	</div>
    			  	<div class="form-group">
    			    	<label for="inputInfo" class="col-lg-2 control-label">Информация:</label>
    			    	<div class="col-lg-10">
    			      		<input type="text" name="info" class="form-control" id="inputInfo" maxlength="1000" placeholder="Информация">
    			    	</div>
    			  	</div>
    			  	<div class="form-group">
    			    	<label for="inputJob" class="col-lg-2 control-label">Вакансия:</label>
    			    	<div class="col-lg-10">
    			      		<select name="job" id="inputJob" placeholder="Вакансия">
    			      			<?php
    			      			foreach ($jobs as $key => $v) {
    			      				echo '<option value="'.$v['id'].'">'.$v['name'].'</option>';
    			      			}
    			      			?>
    			      		</select>
    			    	</div>
    			  	</div>
    			  	<div class="form-group">
    			  		<?=$captcha?>
    			  	</div>
    			  	<div class="form-group">
      					<div class="col-lg-offset-2 col-lg-10">
      							<button type="button" id="JobSendBut" class="btn but-n" onclick="sendJob()">Отправить</button>
      					</div>
    					</div>
      			 </form>
              <script type="text/javascript">
                sendJob = function() {
                var getStr, name, ok, tel, tel1;
                name = $('#inputName').val();
                tel = $('#inputTel').val();
                ok = true;
                $('#jobs_form .er-er').remove();
                $('#JobSendBut').blur().hide();
                if (name === '') {
                  $('#inputName').addEr('Это поле должно быть заполнено.');
                  ok = false;
                }
                if (tel === '') {
                  $('#inputTel').addEr('Это поле должно быть заполнено.');
                  ok = false;
                } else {
                  tel1 = tel.replace(/\s/g, '').replace(/\(/g, '').replace(/\)/g, '').replace(/\+/g, '');
                  if (!(/^[0-9()\-+ ]+$/.test(tel) && (tel1.length === 11 || tel1.length === 6))) {
                    $('#inputTel').addEr('Телефон введен неверно.');
                    ok = false;
                  }
                }
                if (ok) {
                  getStr = $('#jobs_form').serialize();
                  $.get('/shop/add_job?' + getStr, function(data) {
                    var a, c;
                    $('#recaptcha_reload').click();
                    $('#JobSendBut').show();
                    if (data['result'] === 'success') {
                      a = new Btn('a', 'Ок', 'but-n', true);
                      c = new Modal('Вакансия подана', 'Вакансия успешно подана.', [a], true, 200);
                      c.create();
                      c.show();
                      $('#inputTel').val('');
                      $('#inputName').val('');
                      $('#inputInfo').val('');
                    } else {
                      a = new Btn('a', 'Ок', 'but-n', true);
                      c = new Modal('Ошибка', 'Код с картинки введен неправильно.', [a], true, 200);
                      c.create();
                      c.show();
                    }
                  });
                } else {
                  $('#JobSendBut').show();
                }
              };
              </script>
            <?php else:?>
              <p>Вакансий нет</p>
            <?php endif?>
      			</div>
      	</div>
      </div>
    </div>
  </div>
</div>;
<?php $this->load->view('market/design/footer'); ?>
</body>
</html>