<?php
function view_cat ($dataset) {
  foreach ($dataset as $menu) {
    echo '<li class="parent"><a href="/'.$menu["subname"].'">'.$menu["name"].' '.$menu["id"].'=>'.$menu["parent_id"].'</a>';
    if(isset($menu['childs'])) {
      echo '<ul class="nav nav-pills nav-stacked dropdown">';
      foreach ($menu['childs'] as $ochild => $childo) {
        echo '<li class="parent"><a href="/'.$childo["subname"].'">'.$childo['name'].'</a>';
        if(isset($childo['childs']))
        {
          echo '<ul class="nav nav-pills nav-stacked dropdown side">';
          foreach ($childo['childs'] as $tchild => $childt) {
            echo '<li><a href="'.$childt["subname"].'">'.$childt['name'].'</a></li>';
          }
          echo '</ul>';
        }
        echo '</li>';
      }
      echo '</ul>';
    }
    echo '</li>';
  }
}
?>
<header>
<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <ul class="nav nav-pills">
        <?php view_cat($allcategory);?>
      </ul>
    </div>
  </div>
</div>
</header>
<style type="text/css">
  .menu ul{list-style-type: none;}
  .dropdown {
    background-clip: padding-box;
    background-color: #ccc;
    border: none;
    float: left;
    font-size: 13px;
    list-style: outside none none;
    min-width: 160px;
    text-align: left;
    padding: 0;
    position: absolute;
    opacity: 0;
    left: -9999px;
    transition: transform 500ms ease 0ms, opacity 0.3s linear 0s;
    -webkit-transition: -webkit-transform 500ms ease 0ms, opacity 0.3s linear 0s;
    -moz-transition: -moz-transform 500ms ease 0ms, opacity 0.3s linear 0s;
    -moz-backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    transform-origin: 0 0;
    -moz-transform-origin: 0 0;
    -webkit-transform-origin: 0 0;
    visibility: hidden;
    z-index: 998;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2), 0 -2px 10px rgba(0, 0, 0, 0.2);
    -webkit-box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2), 0 -2px 10px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2), 0 -2px 10px rgba(0, 0, 0, 0.2);
  }
  .parent:hover > .dropdown {
    opacity: 1;
    top: 100%;
    visibility: visible;
    left: 0;
    transform: scale(1,1);
    -webkit-transform: scale(1,1);
    -moz-transform: scale(1,1);
  }
  .parent:hover > .dropdown.side {
    opacity: 1;
    visibility: visible;
    left: 100%;
    top:0;
    transform: scale(1,1);
    -webkit-transform: scale(1,1);
    -moz-transform: scale(1,1);
  }
</style>