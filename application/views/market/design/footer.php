<div class="footer-container">
  <footer>
    <div class="container">
      <div class="footer_column">
        <div class="row">
          <div class="column left col-sm-4 col-xs-12 not-animated" data-animate="fadeInUp" data-delay="200">
            <div class="footer-contact">
              <h3 style="text-transform:none;">Связаться с нами</h3>
              <div class="contact-us not-animated" data-animate="fadeInUp" data-delay="300">
                <div class="address"><i class="fa fa-map-marker"></i>
                  <span><?=$settings['storeaddress']['value']; ?></span>
                </div>
                <div class="email"><i class="fa fa-envelope-o"></i>
                  <span><?=$settings['storeemail']['value']; ?></span>
                </div>
                <div class="phone"><i class="fa fa-phone"></i>
                  <span><?=$settings['storephone']['value']; ?></span>
                </div>
              </div>
            </div>
          </div>
          <div class="column col-sm-8 col-xs-12 not-animated" data-animate="fadeInUp" data-delay="300">
            <div class="bt-newletter col-sm-6 col-xs-12">
              <div class="footer-newletter">
                <div class="title">
                  <h3 style="text-transform:none;">Хочешь всегда быть в курсе?</h3>
                  <p>Подпишись!</p>
                </div>
                <div>
                  <div class="newletter-content">
                    <div class="frm_subscribe">
                      <form name="subscribe" id="subscribe"   >
                        <table>
                          <tr>
                            <td>
                              <div class="boss-newletter">
                                <input class="form-control input-new" size="50" type="text" placeholder="Адрес электронной почты" name="subscribe_email" id="subscribe_email">
                                <a class="btn btn-new">Подписаться</a>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td id="subscribe_result"></td>
                          </tr>
                        </table>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="column col-sm-6 col-xs-12 not-animated" data-animate="fadeInUp" data-delay="200">
              <div class="row">
                <div class="column col-sm-6 col-xs-12 not-animated" data-animate="fadeInUp" data-delay="200"></div>
                <div class="column col-sm-6 col-xs-12 not-animated" data-animate="fadeInUp" data-delay="200" style="text-align:right;">
                  <h3>Информация</h3>
                  <ul>
                    <li><a href="<?=$this->config->site_url()?>contact">Обратная связь</a></li>
                    <li><a href="<?=$this->config->site_url()?>sitemap">Карта сайта</a></li>
                    <li><a href="<?=$this->config->site_url()?>about">О нас</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="powered">
      <div class="container">
        <div class="row">
          <div class="powered col-sm-12 col-xs-12">
            <div id="powered">
              <p> Copyright 2015 ©<span> Design for <a href="<?=$this->config->site_url()?>"><?=$this->config->site_name()?></a></span></p>
              <p><span>Powered by <a href="http://vk.com/el_paramore">RedBuld</a></span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</div>
<script type="text/javascript">
  $(function(){
    $(window).scroll(function(){
      if($(this).scrollTop()>200){
        $('#back_top').fadeIn();
      }
      else{
        $('#back_top').fadeOut();
      }
    });
    $("#back_top").click(function (e) {
      e.preventDefault();
      $('body,html').animate({scrollTop:0},800,'swing');
    });
  });
</script>
<div id="back_top" class="back_top" title="Back To Top"><span><i class="fa fa-angle-up"></i></span></div>