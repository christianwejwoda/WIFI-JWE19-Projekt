
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php
      foreach ($menu_items as $menu_item) {

        if (mb_strlen($menu_item["display"]) > 0) {
          echo '<li class="nav-item">';
          echo '<a class="nav-link ';
          if ($menu_item["url_part"] == $page) {
             echo " nav-item-active";
          } else {
            echo " text-white";
          }
          echo '" href="' . htmlspecialchars($menu_item["url_part"]) . '">';
          echo htmlspecialchars($menu_item["display"]);
          echo "</a>";
          echo "</li>";
        }
      }
       ?>
    </ul>
  </div>
</div>
</nav>
