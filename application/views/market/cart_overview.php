<?php
  if(count($bag)!=0){
    echo
    '<li>
    <table class="table table-striped">
    <tbody>';
    foreach ($bag as $key => $v) {
      $this->load->view('market/templates/productinbag', array_merge($v, array('id'=>$key)));
    }
    echo
    '</tbody>
    </table>
    </li>
    <li class="last">
      <div class="cart_bottom">
        <table class="minicart_total">
        <tbody>
        <tr>
          <td class="left">Итого</td>
          <td class="right">'.$_SESSION['total']['price'].' руб.</td>
        </tr>
        </tbody>
        </table>

          <a href="'.$this->config->site_url().'cart" class="btn btn-default">Корзина</a>
          &nbsp;
          <a href="'.$this->config->site_url().'checkout" class="btn btn-checkout">Оформить</a>

      </div>
    </li>';
  }else{
    echo '<li><p class="text-center">Ваша корзина пуста!</p></li>';
  }
?>