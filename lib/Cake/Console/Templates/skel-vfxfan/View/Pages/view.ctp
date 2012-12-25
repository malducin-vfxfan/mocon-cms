<?php
/**
 * Pages view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       pages
 * @subpackage    pages.views
 */
$this->extend('/Common/view');

$this->assign('title', $page['Page']['title']);
?>
		<?php foreach ($pageSections as $pageSection): ?>
			<h2><?php echo $pageSection['PageSection']['title'];?></h2>
			<?php echo $pageSection['PageSection']['content'];?>
			<?php $this->assign('sectionModified', $pageSection['PageSection']['modified']); ?>
		<?php endforeach; ?>
