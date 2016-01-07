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
	<div class="col-sm-3">
		<div class="filters">
			<form name="form" action="" method="post">
  				<table>
				<?php
				foreach ($allfilters as $filter => $value) {
					if(in_array($value['id'],explode(',',$category['filters']))){
						echo '<tr><td>'.$value['name'].'</td><td></td></tr>';
						$temp = array();
						foreach ($products as $product => $v) {
							if(!in_array( $v[$value['parameter']] , $temp )){
				                $temp[] = $v[$value['parameter']];
				                echo '<tr><td><label><input type="checkbox" value="'.$v[$value['parameter']].'" name="'.$value['parameter'].'[]">'.$v[$value['parameter']].'</label></td></tr>';
				            }
						}
					}
				}
				?>
				<tr>
			      <td>
			        <input type="submit" name="filter" value="Подобрать ноутбуки" />
			      </td>
			    </tr>
				</table>
			</form>
		</div>
	</div>
	<div class="col-sm-9">
	<div class="row">
	<?php
		if(isset($test)) echo $test;
	    /*foreach ($products as $key => $v) {
	      $this->load->view('market/templates/product', array_merge($v, array('filters'=>$category['filters'])));
	    }*/
	?>
	</div>
	</div>
</div>
<?php #$this->load->view('market/design/footer'); ?>
</div>
</body>
</html>