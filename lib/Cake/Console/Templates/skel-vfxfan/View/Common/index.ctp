<?php
/**
 * Common index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, ILMfan (http://ilmfan.com)
 * @link          http://ilmfan.com ILMfan
 * @package       views
 * @subpackage    views.common
 */
?>
<div class="row">
	<section class="page-content" id="<?php echo $this->fetch('contentId'); ?>">
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

			<div class="paging">
			<?php
				echo $this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => '', 'first' => 'first', 'last' => 'last'));
				echo $this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));
			?>
			</div>
		</nav>
	</section>
</div>
