<?php
/**
 * Pages index view.
 *
 * Main page (root) of the site.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Pages
 */
?>
<?php if (!empty($mainpage)): ?>
<article>
	<header>
		<h1><?php echo $mainpage['Page']['title']; ?></h1>
	</header>
	<?php echo $mainpage['PageSection'][0]['content'];?>
</article>
<div>&nbsp;</div>
<?php endif; ?>
<div class="row">
	<section id="latest-posts" class="half-page-section">
		<?php echo $this->element('Posts/latest_posts', $posts); ?>
		<?php echo $this->Html->link('Previous Posts', array('controller' => 'posts', 'action' => 'index'), array('class' => 'btn btn-info btn-lg', 'escape' => false)); ?>
	</section>
	<section id="upcoming-events" class="half-page-section">
		<?php echo $this->element('Events/upcoming_events', $events); ?>
		<?php echo $this->Html->link('More Events', array('controller' => 'events', 'action' => 'index'), array('class' => 'btn btn-info btn-lg', 'escape' => false)); ?>
	</section>
</div>
