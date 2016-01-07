<div class="header-container">
  <header>
    <div id="top-header">
      <div class="nav">
        <div class="container">
          <div class="row">
            <nav>
              <div class="contact">
                <span class="email pull-left">
                  <i class="fa fa-envelope-o"></i>Email: <?=$settings['storeemail']['value']; ?>
                </span>
                <span class="telnumber pull-left" style="margin-left:30px;">
                  <i class="fa fa-phone"></i>Звоните: <?=$settings['storephone']['value']; ?>
                </span>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div id="bottom-header">
      <div class="nav">
        <div class="container">
          <div class="row">
            <div id="logo" class="col-xs-12 col-md-3 col-sm-12">
              <a href="<?=$this->config->site_url();?>">
                <img src="<?=$this->config->site_url();?>static/market/image/logow.png" alt="<?=$settings['storename']['value']; ?>" class="img-responsive">
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('market/design/top_menu'); ?>
    </div>
  </header>
</div>
