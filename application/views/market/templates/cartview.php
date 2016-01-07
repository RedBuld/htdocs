<?php
  if(count($bag)!=0){
    echo
    '<h1 class="title">Корзина</h1>
    <div class="cart-info">
      <table class="table">
        <thead>
          <tr>
            <td class="image" colspan="2">Наименование</td>
            <td class="quantity">Количество</td>
            <td class="product-price">Стоимость</td>
            <td class="total">Итого</td>
          </tr>
        </thead>
        <tbody>';
        foreach ($bag as $key => $v) {
          $this->load->view('market/templates/productincart', array_merge($v, array('id'=>$key)));
        }
        echo
        '</tbody>
      </table>
    </div>
    <div class="cart-total">
      <table>
        <tbody>
          <tr>
            <td class="left">Итого:</td>
            <td class="right">'.$_SESSION['total']['price'].' руб.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="buttons">
      <div><a href="'.$this->config->site_url().'checkout" class="btn btn-checkout">Оформление</a></div>
    </div>';
  }else{
    echo
    '<h1 class="title">Корзина</h1>
    <p>Ваша корзина пуста!</p>';
  }
?>