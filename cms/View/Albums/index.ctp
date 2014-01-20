<?php
/**
 * Albums admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Albums
 */
$this->extend('/Common/index');

$this->assign('title', 'Albums');
$this->assign('contentId', 'albums');
?>
		<?php foreach ($albums as $album): ?>
		<article class="album-contents">
			<?php echo $this->FormatImage->idImage('albums/'.$album['Album']['year'], $album['Album']['id'], array('class' => 'img-thumbnail pull-right'), 'albums'); ?>
			<header>
				<h2><?php echo $album['Album']['name']; ?></h2>
				<time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($album['Album']['created'])); ?>">
					<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($album['Album']['created'])); ?>
				</time>
			</header>
			<p><?php echo $album['Album']['description']; ?></p>
			<p><?php echo $this->Html->link('View album »', array('controller' => 'albums', 'action' => 'view', $album['Album']['slug'])); ?></p>
		</article>
		<hr />
		<?php endforeach; ?>
