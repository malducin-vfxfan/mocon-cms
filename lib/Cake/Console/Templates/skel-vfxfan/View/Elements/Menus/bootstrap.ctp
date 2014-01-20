<?php
/**
 * Menus Bootstrap from Twitter style element.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Elements.Menus
 */

/**
 * menuIterator method
 *
 * Recursively iterate over a threaded array of menu items to display using
 * an unordered list.
 *
 * @param array threaded menu array to display
 * @param Object an instance of the Html Helper
 * @return void
 */

function menuIterator($array, $htmlInstance) {
	foreach ($array as $item) {
		if (!empty($item['children'])) {
			echo "<li class=\"dropdown\">" . $htmlInstance->link($item['Menu']['name'].$htmlInstance->tag('span', '', array('class' => 'caret')), $item['Menu']['link'], array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escapeTitle' => false))."\n";
			echo "<ul class=\"dropdown-menu\">\n";
			menuIterator($item['children'], $htmlInstance);
			echo "</ul>\n";
		} else {
			echo "<li>" . $htmlInstance->link($item['Menu']['name'], $item['Menu']['link'])."\n";
		}
		echo "</li>\n";
	}
}

$menuItems = $this->requestAction('menus/menu');
?>
	<ul class="nav navbar-nav">
		<?php menuIterator($menuItems, $this->Html); ?>
	</ul>
