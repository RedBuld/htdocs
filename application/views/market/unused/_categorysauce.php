<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=$category['name']?> | Огни Сухоны</title>
	<?php $this->load->view('market/scripts'); ?>
	<script type="text/javascript">
	var bag = <?=$bag?>;
	</script>
</head>
<body>
	<div id="PAGE">
		<div id="HEADER">
			<ul id="menu">
				<li class="firstbut_selected drmenu">
					<div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"></button>
						<ul class="dropdown-menu">
							<?php
							foreach ($allcategory as $key => $v) {
								if($v['type']==1&&$v['num']!=0)
									echo '<li><a href="http://'.$this->config->site_url().$v['subname'].'">'.$v['name'].'</a></li>';
							}
							?>
							<li class="divider"></li>
							<?php
							foreach ($allcategory as $key => $v) {
								if($v['type']==0&&$v['num']!=0)
									echo '<li><a href="http://'.$this->config->site_url().$v['subname'].'">'.$v['name'].'</a></li>';
							}
							?>
						</ul>
					</div>
				</li>
				<li class="devider"></li>
				<li class="thirdbut" onmouseover="this.className='thirdbut_hover'" onmouseout="this.className='thirdbut'"><a href="http://<?=$this->config->site_url()?>about"></a></li>
				<li class="devider"></li>
				<li class="fourthbut" onmouseover="this.className='fourthbut_hover'" onmouseout="this.className='fourthbut'"></li>
			</ul>
			<div id="logo"><a href="http://<?=$this->config->site_url()?>"></a></div>
		</div>
		<div id="SLIDER">
			<?php $this->load->view('market/slider'); ?>
		</div>
		<div id="SECTION">
			<div id="historybar">
				
				<ul id="historylist">
					<li class="cango drmenu">
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Меню</button>
							<ul class="dropdown-menu">
								<?php
								foreach ($allcategory as $key => $v) {
									if($v['type']==1&&$v['num']!=0)
										echo '<li><a href="http://'.$this->config->site_url().$v['subname'].'">'.$v['name'].'</a></li>';
								}
								?>
								<li class="divider"></li>
								<?php
								foreach ($allcategory as $key => $v) {
									if($v['type']==0&&$v['num']!=0)
										echo '<li><a href="http://'.$this->config->site_url().$v['subname'].'">'.$v['name'].'</a></li>';
								}
								?>
							</ul>
						</div>
					</li>
					<li>/</li>
					<li><?=$category['name']?></li>
				</ul>
				<button id="orderBut" type="button">Оформить заказ</button>
				<div id="bag" onclick="cartOpen()">
					<i>Корзина</i>&nbsp;&nbsp;<i class="cart"></i>
				</div>
				<div id="cart">
					<img class="cart-loading" src="http://<?=$this->config->base_url()?>static/market/css/img/loading.gif" alt="Загрузка">
					<iframe id="cart-container" src="http://<?=$this->config->site_url()?>cart"></iframe>
				</div>
			</div>

			<div id="container">
				<table id="marketcontainer">
					<thead>
						<td></td>
						<td></td>
						<td></td>
					</thead>
					<tbody>
						<tr>
						<?php
						foreach ($sauce as $key => $v) {
							if((int)$key % 3 == 0 && (int)$key != 0)
								echo '</tr><tr>';
							$this->load->view('market/templates/sauce', $v);
						}
						?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div id="FOOTER">
			<strong>Огни Сухоны © 2013</strong>
		</div>
	</div>
</body>
</html>