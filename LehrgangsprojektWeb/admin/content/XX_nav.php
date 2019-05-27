<?php

echo "<ul>";
foreach ($admin_menu_items as $admin_menu_item) {

  if (mb_strlen($admin_menu_item["display"]) > 0) {
    echo '<li class="';
    if ($admin_menu_item["url_part"] == $page) {
      echo " menumarked";
    }
    echo '">';
    echo '<a href="' . htmlspecialchars($admin_menu_item["url_part"]) . '">';
    echo htmlspecialchars($admin_menu_item["display"]);
    echo "</a>";
    echo "</li>";
  }
}
echo "</ul>";

 ?>
