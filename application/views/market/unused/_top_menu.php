    <div class="bt-comb fadeInDown">
      <div class="container">
        <div class="row">
          <div id="bt_mainmenu" class="col-sm-9 pull-left">
            <a class="open-panel"><i class="fa fa-bars"></i></a>
            <nav class="mega-menu">
              <a class="close-panel"><i class="fa fa-times-circle"></i></a>
              <ul class="nav nav-pills">
                <li class="parent">
                  <p class="plus visible-xs">+</p>
                  <a href="http://demo.bossthemes.com/leather_digistore/index.php">Категории</a>
                  <div class="dropdown drop-grid-6-5">
                    <div class="menu-row row-col-5">
                      <!-- html-->
                      <?php
                      $t=0;$e=0;
                      foreach ($allcategory as $key => $v) {
                        if($v['type']==1&&$v['num']!=0)
                        {
                          $t++;$e++;
                          echo 
                          '<div class="menu-column row-grid-1">
                            <div class="staticblock">
                              <div class="bt-store">
                                <div class="bt-image">
                                  <a title="'.$v['name'].'" href="http://'.$this->config->site_url().$v['subname'].'">
                                    <img src="http://'.$this->config->base_url().'static/market/image/catalog/bt_leather/leather.png" alt="'.$v['name'].'">
                                  </a>
                                </div>
                                <a title="'.$v['name'].'" href="http://'.$this->config->site_url().$v['subname'].'">'.$v['name'].'</a>
                              </div>
                            </div>
                          </div>';
                        }
                        if($t==5 && $e != count($allcategory))
                        {
                          echo '</div><div class="menu-row row-col-5">';
                          $t=0;
                        }
                      }
                      ?>
                    </div>
                  </div>
                </li>
                <li class="parent">
                  <p class="plus visible-xs">+</p>
                  <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/category&amp;path=20">PAGES</a>
                  <div class="dropdown drop-grid-6-6">
                    <div class="menu-row row-col-6" style=" ">
                      <div class="menu-column row-grid-2">
                        <!-- html-->
                        <div class="staticblock">
                          <a href="http://demo.bossthemes.com/leather_digistore/index.php"><img src="http://<?=$this->config->base_url()?>static/market/image/catalog/bt_leather/logo.png" alt="logo" title="logo"></a>
                          <p>Pellentesque tortor est, dictum non vierra, aliquet sit amet justo. Nulla pulvinar eros eu tempor pellentesque. Curabitr nenatis ligula ut convallis ornare. Fusce auctor et justo ege
                            felis at, placerat pulvinar sem. Fusce ac mauris vitae augus tesque mi dolor, placerat eget tempor interdum, feugiat vel ipsum. Fusce et dui vel dolor lacinia lacinia. Proin dignisim congue luctus a a purus. Cras suscipit consectetur semper. odio. Nullam convallis massa turpis. Sed euismod tincidunt cursus. Donec at accumsan dolor, vel feugiat enim. Nam consequat iaculis aliquet.
                          </p>
                        </div>
                      </div>
                      <div class="menu-column row-grid-1">
                        <!-- category -->
                        <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/category&amp;path=25" class="parent">
                        On Sales								</a>
                        <ul class="column category">
                          <li class="col-grid-1 ">
                            <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/category&amp;path=93">
                            Ea commod										</a>
                          </li>
                          <li class="col-grid-1 ">
                            <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/category&amp;path=92">
                            Haecenas										</a>
                          </li>
                          <li class="col-grid-1 ">
                            <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/category&amp;path=32">
                            Fugitsed										</a>
                          </li>
                          <li class="col-grid-1 sub_category">
                            <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/category&amp;path=28">
                            Magni										</a>
                            <div class="sub_menu">
                              <ul>
                                <li ><a href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/category&amp;path=28_36">Mauris arcu</a></li>
                              </ul>
                            </div>
                          </li>
                          <li class="col-grid-1 ">
                            <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/category&amp;path=29">
                            Nemo										</a>
                          </li>
                          <li class="col-grid-1 ">
                            <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/category&amp;path=31">
                            Sitpernatu										</a>
                          </li>
                          <li class="col-grid-1 ">
                            <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/category&amp;path=30">
                            Voluptatem										</a>
                          </li>
                        </ul>
                      </div>
                      <div class="menu-column row-grid-1">
                        <!-- html-->
                        <div class="staticblock">
                          <div class="bt-page">
                            <h3>Page</h3>
                            <ul>
                              <li><a title="About Us" href="http://demo.bossthemes.com/leather_digistore/index.php?route=information/information&amp;information_id=4">About Us</a></li>
                              <li><a title="Contact Us" href="http://demo.bossthemes.com/leather_digistore/index.php?route=information/contact">Contact Us</a></li>
                              <li><a title="Pricing Page" href="http://demo.bossthemes.com/leather_digistore/index.php?route=information/information&amp;information_id=8">Pricing Page</a></li>
                              <li><a title="Product Compare Page" href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/compare">Product Compare Page</a></li>
                              <li><a title="Testimonials" href="http://demo.bossthemes.com/leather_digistore/index.php?route=bossthemes/boss_testimonial">Testimonials</a></li>
                              <li><a title="FAQs" href="http://demo.bossthemes.com/leather_digistore/index.php?route=information/information&amp;information_id=7">FAQs</a></li>
                              <li><a title="Product landing page" href="http://demo.bossthemes.com/leather_digistore/index.php?route=bossthemes/btlandingpage">Product landing page</a></li>
                              <li><a title="Promotional page" href="http://demo.bossthemes.com/leather_digistore/index.php?route=bossthemes/btpromotional">Promotional page</a></li>
                              <li><a title="Typography" href="http://demo.bossthemes.com/leather_digistore/index.php?route=information/information&amp;information_id=9">Typography</a></li>
                              <li><a title="Deals" href="http://demo.bossthemes.com/leather_digistore/index.php?route=bossthemes/btdeals">Deals</a></li>
                              <li><a title="Brand" href="http://demo.bossthemes.com/leather_digistore/index.php?route=product/manufacturer">Brand</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="menu-column row-grid-2">
                        <!-- html-->
                        <div class="staticblock"><iframe src="http://player.vimeo.com/video/32448092" height="360" width="640"></iframe></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="parent">
                  <p class="plus visible-xs">+</p>
                  <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=bossblog/bossblog">BLOG</a>
                  <div class="dropdown drop-grid-6-1">
                    <div class="menu-row row-col-1" style="  background-image: url(http://<?=$this->config->base_url()?>static/market/image/catalog/bt_leather/bgr-menu4.jpg)">
                      <div class="menu-column row-grid-1">
                        <!-- html-->
                        <div class="staticblock">
                          <div class="bt-blog-page">
                            <ul>
                              <li><a title="Blog full width" href="leather_digistore.html#">Blog full width</a></li>
                              <li><a title="Blog left sidebar" href="leather_digistore.html#">Blog left sidebar</a></li>
                              <li><a title="Blog right sidebar" href="leather_digistore.html#">Blog right sidebar</a></li>
                              <li><a title="Post full width" href="leather_digistore.html#">Post full width</a></li>
                              <li><a title="Post left sidebar" href="leather_digistore.html#">Post left sidebar</a></li>
                              <li><a title="Post right sidebar" href="leather_digistore.html#">Post right sidebar</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li >
                  <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=information/contact">CONTACT</a>
                </li>
              </ul>
            </nav>
          </div>
          <div class="col-sm-3 pull-right bt-search">
            <div id="search" class="input-group pull-right">
              <input type="text" name="search" value="" placeholder="Search" class="form-control input-lg" />
              <button type="button" title="search" class="btn btn-search"><i class="fa fa-search"></i></button>
            </div>
          </div>
          <div class="col-sm-3 pull-right bt-small-logo">
            <a href="http://demo.bossthemes.com/leather_digistore/index.php?route=common/home"><img src="http://<?=$this->config->base_url()?>static/market/image/catalog/bt_leather/logo.png" title="Opencart Leather Store" alt="Opencart Leather Store" class="img-responsive" /></a>
          </div>
        </div>
      </div>
    </div>