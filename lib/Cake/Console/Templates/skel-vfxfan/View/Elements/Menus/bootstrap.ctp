<?php
/**
 * Menus Bootstrap from Twitter style element.
 *
 * Menus Bootstrap from Twitter style element.
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
		if (!empty($item['children'])) {
			echo "<li class=\"dropdown\">" . $htmlInstance->link($item['Menu']['name'], $item['Menu']['link'], array('class' => 'dropdown-toggle'))."\n";
			echo "<ul class=\"dropdown-menu\">\n";
			menuIterator($item['children'], $htmlInstance);
			echo "</ul>\n";
		}
		else {
			echo "<li>" . $htmlInstance->link($item['Menu']['name'], $item['Menu']['link'])."\n";
		}
		echo "\n</li>\n";
	}
}

$menuItems = $this->requestAction('menus/menu');
?>
	<ul class="nav">
		<li class="active"><?php echo $this->Html->link('Home', '/'); ?></li>
		<?php
			menuIterator($menuItems, $this->Html);
		?>
	</ul>
