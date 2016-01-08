<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title><?=$category['name'].' | '.$settings['storename']['value']?></title>
<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0">
<?php $this->load->view('market/scripts'); ?>
<script type="text/javascript">
$(document).ready(function(){
	$(window).scroll(function() {
    var height_header = $('.header-container').height()-$('.menu').height();			
    if($(window).scrollTop() > height_header) {
      $('.menu').addClass('fixed');
    } else {
      $('.menu').removeClass('fixed');
    }
  });
});
  $
</script>
</head>
<body>
<!-- Loader -->
<?php $this->load->view('market/design/header'); ?>
<div id="content">
	<div class="col-xs-3">
		<div class="filters">
			<form name="form" action="" method="post">
  				<div class="panel panel-default">
  					<div class="panel-heading">Цена</div>
  					<div class="panel-body">
  						<input type="range" min="0" max="180" step="20" value="0,180" />
  					</div>
					<?php
					foreach ($allfilters as $filter => $value) {
						if(in_array($value['id'],explode(',',$category['filters']))){
							echo '<div class="panel-heading">'.$value['name'].'</div>';
							echo '<div class="panel-body">';
							$temp = array();
							foreach ($products as $product => $v) {
								if(!in_array( $v[$value['parameter']] , $temp )){
					                $temp[] = $v[$value['parameter']];
					                echo '<label><input type="checkbox" value="'.$v[$value['parameter']].'" name="'.$value['parameter'].'[]">'.$v[$value['parameter']].' '.$value['atr'].'</label>';
					            }
							}
							echo '</div>';
						}
					}
					?>
					<div class="panel-footer">
				    	<input type="submit" class="btn btn-block btn-search" name="filter" value="Показать" />
					</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-xs-9">
		<div class="product-filter">
			<div class="limit-sort hidden-xs">
				<div class="display hidden-xs">
					<button type="button" f-type="elem-3" class="f-view btn-grid active" title="Grid-3"><i class="fa fa-th"></i></button>
					<button type="button" f-type="elem-2" class="f-view btn-grid" title="Grid-2"><i class="fa fa-th-large"></i></button>
					<button type="button" f-type="elem-1" class="f-view btn-list" title="List"><i class="fa fa-th-list"></i></button>
				</div>
			</div>
		</div>
		<diw class="row">
			<?php
				if(isset($test)) echo $test;
			    foreach ($products as $key => $v) {
			      $this->load->view('market/templates/product', array_merge($v, array('filters'=>$category['filters'])));
			    }
			?>
		</diw>
	</div>
</div>
<script type="text/javascript">
	$('.f-view').click(function(){
		$('.item').attr('class','item '+$(this).attr('f-type'));
		$('.f-view').removeClass('active');$(this).addClass('active');
	});
	$('input[type=range]').nativeMultiple({
	    stylesheet: "slider",
	    onCreate: function() {
	        console.log(this);
	    },
	    onChange: function(first_value, second_value) {
	        console.log('onchange', [first_value, second_value]);
	    },
	    onSlide: function(first_value, second_value) {
	        console.log('onslide', [first_value, second_value]);
	    }
	});
</script>
<?php #$this->load->view('market/design/footer'); ?>
</div>
</body>
</html>