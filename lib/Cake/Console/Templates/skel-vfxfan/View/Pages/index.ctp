<?php
/**
 * Short description.
 *
 * Long description.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    pages
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
	<section class="span6">
		<?php echo $this->element('Posts/latest_posts'); ?>
	</section>
	<section class="span6">
		<?php echo $this->element('Events/upcoming_events'); ?>
	</section>
</div>
