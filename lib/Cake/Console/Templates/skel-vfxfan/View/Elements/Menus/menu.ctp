<?php
/**
 * Menus default element.
 *
 * Menus default element.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    menus
 */

/**
 * menuIterator method
 *
 * Recursively iterate over a threaded array of menu items to display using
 * an unordered list.
 *
 * @return void
 */

function menuIterator($array, $htmlInstance) {
	foreach ($array as $item) {
		echo "<li>" . $htmlInstance->link($item['Menu']['name'], $item['Menu']['link']);

		if (!empty($item['children'])) {
			echo "<ul>\n";
			menuIterator($item['children'], $htmlInstance);
			echo "</ul>\n";
		}
		echo "\n</li>\n";
	}
}

$menuItems = $this->requestAction('menus/menu');
?>
<nav id="menu">
	<ul>
		<li><?php echo $this->Html->link('Home', '/'); ?></li>
		<?php
			menuIterator($menuItems, $this->Html);
		?>
	</ul>
</nav>
