<html>
<head>
	<title></title>
	<?php $this->load->view('scripts'); ?>
</head>
<body>
	<form id="fileForm" method="POST" action="<?=$this->config->site_url()?>upload/image" accept-charset="utf-8" enctype="multipart/form-data">
		<span class="btn btn-success">
			<span>Выберите файл...</span>
			<input id="userfile" type="file" name="userfile" size="20">
		</span>
		<input type="submit" class="btn btn-warning" id="btnSubmit" name="upload" value="Загрузить">
		<br><span id="cho_val"></span>
	</form>
	<div id="progBar" class="progress progress-striped active">
  		<div class="bar" style="width: 100%;"></div>
	</div>
</body>
</html>