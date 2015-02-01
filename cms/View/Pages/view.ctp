<?php
/**
 * Pages view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Pages
 */
$this->extend('/Common/view');

$this->assign('title', $page['Page']['title']);
?>
		<?php foreach ($pageSections as $pageSection): ?>
			<h2><?php echo $pageSection['PageSection']['title'];?></h2>
			<?php echo $pageSection['PageSection']['content'];?>
			<?php $this->assign('sectionModified', $pageSection['PageSection']['modified']); ?>
		<?php endforeach; ?>
