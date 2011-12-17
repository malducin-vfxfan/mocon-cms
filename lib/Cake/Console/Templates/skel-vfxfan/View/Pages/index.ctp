<?php
/**
 * Pages index view.
 *
 * Main page (root) of the site.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       pages
 * @subpackage    pages.views
 */
?>
<div class="row">
	<article class="page-content">
		<h1><?php echo $mainpage['Page']['title']; ?></h1>
		<?php echo $mainpage['PageSection'][0]['content'];?>
	</article>
</div>
<div>&nbsp;</div>
<div class="row">
	<section class="latest-posts">
		<?php echo $this->element('Posts/latest_posts'); ?>
	</section>
	<section class="upcoming-events">
		<?php echo $this->element('Events/upcoming_events'); ?>
	</section>
</div>
