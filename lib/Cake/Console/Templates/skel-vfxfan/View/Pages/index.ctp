<?php
/**
 * Pages index view.
 *
 * Main page (root) of the site.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Pages.View
 */
?>
<article>
	<header>
		<h1><?php echo $mainpage['Page']['title']; ?></h1>
	</header>
	<?php echo $mainpage['PageSection'][0]['content'];?>
</article>
<div>&nbsp;</div>
<div class="row">
	<section id="latest-posts">
		<?php echo $this->element('Posts/latest_posts', $posts); ?>
		<?php echo $this->Html->link('Previous posts »', array('controller' => 'posts', 'action' => 'index')); ?>
	</section>
	<section id="upcoming-events">
		<?php echo $this->element('Events/upcoming_events', $events); ?>
		<?php echo $this->Html->link('More events »', array('controller' => 'events', 'action' => 'index')); ?>
	</section>
</div>
