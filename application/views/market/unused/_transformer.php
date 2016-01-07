<html>
<head>
	<meta charset="utf-8">
	<title>Трансформер | Огни Сухоны</title>
	<?php $this->load->view('market/scripts'); ?>
	<script type="text/javascript">
	var bag = <?=$bag?>;
	</script>
</head>
<body>
	<div id="PAGE">
		<div id="HEADER">
			<ul id="menu">
				<li class="firstbut drmenu">
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
					<li class="histlist1el">Трансформер</li>
				</ul>

				<div id="bag" class="histlist1el2" onclick="cartOpen()">
					<i>Корзина</i>&nbsp;&nbsp;<i class="cart"></i>
				</div>
				<div id="cart">
					<img class="cart-loading" src="http://<?=$this->config->base_url()?>static/market/css/img/loading.gif" alt="Загрузка">
					<iframe id="cart-container" src="http://<?=$this->config->site_url()?>cart"></iframe>
				</div>
			</div>

			<div id="container">
				<table id="pizza-basis-menu">
					<tr>
						<td id="pizza-basis-menu-left">
							<ul id="pizza-basis-menu-left-list" class="pizza-basis-menu-list">
								<?php
								foreach ($basis as $key => $v) {
									echo '<li d-id="'.$v['id'].'" d-img="'.$v['img_url'].'">'.$v['name'].'</li>';
								}
								?>
							</ul>
							<img id="pizza-basis-menu-left-img" alt="Соусы" src="">
						</td>
						<td id="pizza-basis-menu-right">
							<ul id="pizza-basis-menu-right-list" class="pizza-basis-menu-list">
								<?php
								foreach ($cheese as $key => $v) {
									echo '<li d-id="'.$v['id'].'" d-img="'.$v['img_url'].'">'.$v['name'].'</li>';
								}
								?>
							</ul>
							<img id="pizza-basis-menu-right-img" alt="Сыры" src="">
						</td>
					</tr>
				</table>
				<div id="pizza-construct">
					<img class="cart-loading" src="http://<?=$this->config->base_url()?>static/market/css/img/loading.gif" alt="Загрузка">
					<div id="pizza-construct-basis" class="pizza-construct-part"></div>
					<div id="pizza-construct-cheese" class="pizza-construct-part"></div>
					<div id="pizza-construct-ingredients" class="pizza-construct-part"></div>
				</div>
				<div id="pizza-ingredients">
					<div id="pizza-ingredients-cheese">
						<div class="btn-group dr-ingr">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Доп. сыры</button>
							<ul class="dropdown-menu">
								<?php
								foreach ($ingredients['cheese'] as $key => $v) {
									echo '<li d-id="'.$v['id'].'" d-name="'.$v['name'].'" d-img="'.$v['img_url'].'"><a href="javascript:;">'.$v['name'].'</a></li>';
								}
								?>
							</ul>
						</div>
					</div>
					<div id="pizza-ingredients-meat">
						<div class="btn-group dropup dr-ingr">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Мясо</button>
							<ul class="dropdown-menu">
								<?php
								foreach ($ingredients['meat'] as $key => $v) {
									echo '<li d-id="'.$v['id'].'" d-name="'.$v['name'].'" d-img="'.$v['img_url'].'"><a href="javascript:;">'.$v['name'].'</a></li>';
								}
								?>
							</ul>
						</div>
					</div>
					<div id="pizza-ingredients-greens">
						<div class="btn-group dr-ingr">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Зелень</button>
							<ul class="dropdown-menu">
								<?php
								foreach ($ingredients['greens'] as $key => $v) {
									echo '<li d-id="'.$v['id'].'" d-name="'.$v['name'].'" d-img="'.$v['img_url'].'"><a href="javascript:;">'.$v['name'].'</a></li>';
								}
								?>
							</ul>
						</div>
					</div>
					<div id="pizza-ingredients-fish">
						<div class="btn-group dropup dr-ingr">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Мясо</button>
							<ul class="dropdown-menu">
								<?php
								foreach ($ingredients['fish'] as $key => $v) {
									echo '<li d-id="'.$v['id'].'" d-name="'.$v['name'].'" d-img="'.$v['img_url'].'"><a href="javascript:;">'.$v['name'].'</a></li>';
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<button id="btn-buy-construct" type="btn">Добавить</button>
			</div>
		</div>
		<div id="FOOTER">
			<strong>Огни Сухоны © 2013</strong>
		</div>
	</div>
</body>
</html>