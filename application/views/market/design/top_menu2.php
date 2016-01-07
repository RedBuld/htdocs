    <div class="bt-comb fadeInDown">
      <div class="container">
        <div class="row">
          <div id="bt_mainmenu" class="col-sm-12 pull-left">
            <a class="open-panel"><i class="fa fa-bars"></i></a>
            <nav class="mega-menu">
              <a class="close-panel"><i class="fa fa-times-circle"></i></a>
              <ul class="nav nav-pills">
                <!-- html-->
                <?php
                foreach ($allcategory as $key => $v) {
                  if($v['num']!=0)
                  {
                    echo 
                    '<li class="parent">
                      <a title="'.$v['name'].'" href="'.$this->config->site_url().$v['subname'].'">'.$v['name'].'</a>
                    </li>';
                  }
                }
                ?>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>