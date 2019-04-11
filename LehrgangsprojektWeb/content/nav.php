<?php

echo "<ul>";
foreach ($menu_items as $menu_item) {

  if (mb_strlen($menu_item["display"]) > 0) {
    echo '<li class="';
    if ($menu_item["url_part"] == $page) {
      echo " menumarked";
    }
    echo '">';
    echo '<a href="' . htmlspecialchars($menu_item["url_part"]) . '">';
    echo htmlspecialchars($menu_item["display"]);
    echo "</a>";
    echo "</li>";
  }
}
echo "</ul>";

 ?>
