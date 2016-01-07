<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" title="Close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div class="modal-body">
      <div id="notification"></div>
      <div id="content">
        <div class="row">
          <div class="product-info-qs product-info">
            <div class="col-sm-6">
              <ul class="thumbnails">
                <li>
                    <a href="<?=$img_high_url?>" title="Dolorpelle accus antium doloremque" class="cloud-zoom" id='bt_zoom' rel="">
                        <img src="<?=$img_medium_url?>" title="Dolorpelle accus antium doloremque" alt="Dolorpelle accus antium doloremque" id="image" />
                    </a>
                </li>
              </ul>
            </div>
            <div class="col-sm-6">
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
                  <button type="button" id="button-cart-qs" data-loading-text="Loading..." class="btn button_cart">В корзину</button>
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
              </div>
            </div>
          </div>
        </div>
      </div>
      <script src="<?=$this->config->site_url()?>static/market/javascript/jquery/magnific/jquery.magnific-popup.min.js" type="text/javascript"></script>
      <script src="<?=$this->config->site_url()?>static/market/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
      <script src="<?=$this->config->site_url()?>static/market/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
      <link href="<?=$this->config->site_url()?>static/market/javascript/jquery/magnific/magnific-popup.css" rel="stylesheet" type="text/css">
      <link href="<?=$this->config->site_url()?>static/market/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
      <script type="text/javascript"><!--
        function changeQty(increase) {
            var qty = parseInt($('.product-info-qs .select_number').find("input").val());
            if ( !isNaN(qty) ) {
                qty = increase ? qty+1 : (qty > 1 ? qty-1 : 1);
                $('.product-info-qs .select_number').find("input").val(qty);
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
        $('.cloud-zoom').CloudZoom();
        	
        $('#button-cart-qs').bind('click', function() {
            var id = $('.product-info-qs input[type=\'hidden\']').val();
            var counts = $('.product-info-qs input[type=\'text\']').val();
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
                    $('#cart > ul').load('/cart_overview');
                    $('#myModal').modal('hide');
                    $('#myModal').on('hidden.bs.modal', function () {
                        $('#myModal > .modal-dialog').remove();
                        $('.bt-comb.bt-menu-fixed').css('padding-right','');    
                    });
                }
              }
        	});
        }); 
        //--></script>	
	    </div>
	  </div>
	</div>
</div>