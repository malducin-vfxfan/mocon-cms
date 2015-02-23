<?php
/**
 * Menu helper.
 *
 * Menu helper. Contains methods to display a menu, defined by parent
 * child relationships.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.Helper
 */

/**
 * Menu Helper
 *
 * @property MenuImageHelper $MenuHelper
 * @property array $helpers
 */
class MenuHelper extends AppHelper
{

/**
 * Helpers
 *
 * @var array
 */
    public $helpers = array('Html');

/**
 * bootstrapMenu method
 *
 * Return a properly formatted Bootstrap menu
 *
 * @param $menuItems array
 * @return string
 */
    public function bootstrapMenu($menuItems)
    {
        return $this->Html->tag('ul', $this->bootstrapMenuIterator($menuItems), array('class' => 'nav navbar-nav'));
    }

/**
 * bootstrapMenuIterator method
 *
 * Generate the menu items, which are in a parent/child relationship
 *
 * @param $menuItems array
 * @return string
 */
    private function bootstrapMenuIterator($menuItems)
    {
        if (empty($menuItems)) return;

        $menu = array();

        foreach ($menuItems as $item) {
            if (!empty($item['children'])) {
                $menu[] = '<li class="dropdown">' . $this->Html->link($item['Menu']['name'].$this->Html->tag('span', '', array('class' => 'caret')), $item['Menu']['link'], array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escapeTitle' => false));
                $menu[] = '<ul class="dropdown-menu">';
                $menu[] = $this->bootstrapMenuIterator($item['children']);
                $menu[] = '</ul>';
            } else {
                $menu[] = '<li>' . $this->Html->link($item['Menu']['name'], $item['Menu']['link']);
            }
            $menu[] = '</li>';
        }

        return implode($menu, "\n");
    }
}
