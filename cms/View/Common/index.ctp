<?php
/**
 * Common index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, ILMfan (http://ilmfan.com)
 * @link          http://ilmfan.com ILMfan
 * @package       vfxfan-base.View.Common
 */
?>
<section id="<?php echo $this->fetch('contentId'); ?>">
	<h1><?php echo $this->fetch('title'); ?></h1>
	<?php echo $this->fetch('content'); ?>

	<nav class="paginator">
		<p>
		<?php
			echo $this->Paginator->counter(array(
				'format' => 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
			));
		?>
		</p>

		<ul class="pagination">
		<?php
			echo $this->Paginator->prev('« previous', array('tag' => 'li', 'disabledTag' => 'span'), null, array());
			echo $this->Paginator->numbers(array('separator' => '', 'first' => 'first', 'last' => 'last', 'tag' => 'li', 'currentTag' => 'span', 'currentClass' => 'active'));
			echo $this->Paginator->next('next »', array('tag' => 'li', 'disabledTag' => 'span'), null, array());
		?>
		</ul>
	</nav>
</section>
