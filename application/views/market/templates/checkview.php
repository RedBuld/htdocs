<?php
  if(count($bag)!=0){
    echo
    '<div id="cart_wrap">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <span class="wrap"><span class="qc-icon-cart"></span></span> 
          <span class="text">Корзина</span>
        </div>
        <div class="qc-checkout-product panel-body ">
          <table class="table table-bordered qc-cart">
            <thead>
              <tr>
                <td class="qc-name ">Название:</td>
                <td class="qc-quantity ">Количество:</td>
                <td class="qc-price   ">Цена:</td>
                <td class="qc-total ">Итого:</td>
              </tr>
            </thead>
            <tbody>';
            foreach ($bag as $key => $v) {
              $this->load->view('market/templates/productincheck', array_merge($v, array('id'=>$key)));
            }
          echo '</tbody>
          </table>
          <div class="form-horizontal qc-summary ">
            <div class="row qc-totals">
              <label class="col-xs-6 control-label">Итого</label>
              <div class="col-xs-6 form-control-static">'.$_SESSION['total']['price'].' руб.</div>
            </div>
          </div>
        </div>
      </div>
    </div>';
  }else{
    echo
    '<div id="cart_wrap">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <span class="wrap"><span class="qc-icon-cart"></span></span> 
          <span class="text">Корзина</span>
        </div>
        <div class="qc-checkout-product panel-body ">
          <p>Ваша корзина пуста!</p>
          <div class="form-horizontal qc-summary ">
              <div class="row qc-totals">
                <label class="col-xs-6 control-label">Итого</label>
                <div class="col-xs-6 form-control-static">'.$_SESSION['total']['price'].' руб.</div>
              </div>
            </div>
          </div>
        </div>
      </div>';
  }
?>