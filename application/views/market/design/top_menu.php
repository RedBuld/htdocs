<?php
function horizontal_menu($dataset) {
  foreach ($dataset as $menu) {
    echo '<li><a href="/'.$menu["subname"].'">'.$menu["name"].'</a>';
    if(isset($menu['childs'])) {
      echo '<ul>';
      foreach ($menu['childs'] as $ochild => $childo) {
        echo '<li><a href="/'.$childo["subname"].'">'.$childo['name'].'</a>';
        if(isset($childo['childs']))
        {
          chhildcats($childo['childs']);
        }
        echo '</li>';
      }
      echo '</ul>';
    }
    echo '</li>';
  }
}
function chhildcats($dataset){
  echo '<ul>';
  foreach ($dataset as $menu) {
    if(isset($menu['childs']))
    {
      echo '<li><a href="'.$menu["subname"].'">'.$menu['name'].'</a>';
      chhildcats($menu['childs']);
    }else{
      echo '<li><a href="'.$menu["subname"].'">'.$menu['name'].'</a>';
    }
    echo '</li>';
  }
  echo '</ul>';
}
?>
<div class="navbar menu">
  <div class="navbar-inner">
    <div class="container">
      <div class="hormenu col-xs-12">
        <nav>
          <ul>
            <?php horizontal_menu($menu);?>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>