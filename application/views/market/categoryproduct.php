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
<title><?=$category['name']?> | Vegas Pizza</title>
<base href="" />
<meta name="description" content="My Store" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
<body class="common-home bt-wide-boxed">
<!-- Loader -->
<?php $this->load->view('market/functional/loader'); ?>
<div id="bt_container" class="bt-wide-boxed " >
<?php $this->load->view('market/design/header'); ?>
<?php $this->load->view('market/design/slider'); ?>
  <div id="content" class="col-sm-12 nopadding">
    <script type="text/javascript">
      $(window).load(function() {
        $('.display').bind('click', function() {
          $('.sft_quickshop_icon').remove();
        });	
      });
      function getModalContent(product_id){	
        $('.bt-comb.bt-menu-fixed').css('padding-right','17px');
        $.ajax({
          url: '<?=$this->config->site_url()?>qw' + product_id,
          dataType: 'html',
          beforeSend: function() {			
            $('.loading').html('<span class="wait">&nbsp;<img src="<?=$this->config->site_url()?>static/market/image/loading.gif" alt="" /></span>');
            $('#myModal').html('');
          },		
          complete: function() {
            $('.wait').remove();
          },
          success: function(html) {
            $('#myModal').html(html);
            $('#myModal > .modal-dialog').css({
              'width': '95%',
              'max-width': '900px',
            });
          }
        });
      }
    </script> 
    <div class="bt-featured-pro bt-nprolarge-nslider" data-animate="fadeInUp" data-delay="200">
      <div class="box-heading title">
        <h1><?=$category['name']?></h1>
      </div>
      <div class="box-content bt-product-content">
        <div class="bt-items bt-product-grid">
          <div id="boss_featured_0">
            <?php
            foreach ($products as $key => $v) {
              $this->load->view('market/templates/product', $v);
            }
            ?>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <!-- РЕКЛАМА
    <div class="bt-block-home-bg" style="background-image: url(http://demo.bossthemes.com/leather_digistore/image/catalog/bt_leather/bg_home.jpg);">
      <div class="title not-animated" data-animate="zoom-in" data-delay="300">
        <h3>gue Sapien - Lobortis Fringilla</h3>
        <h2>Morbi Diam Feugiat</h2>
        <span>Discover More !</span>
      </div>
    </div>
    -->
  </div>
  <?php $this->load->view('market/design/footer'); ?>
</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"></div>
<div class="loading" style="position:fixed;top:50%;left:50%"></div>
</body>
</html>