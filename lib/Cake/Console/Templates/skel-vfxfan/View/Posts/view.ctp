<?php
/**
 * Posts view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Posts.View
 */
$this->extend('/Common/view');

$this->assign('title', $post['Post']['title']);
$this->assign('contentCreated', $post['Post']['created']);
$this->assign('contentAuthor', $post['User']['username']);
$this->assign('sectionModified', $post['Post']['modified']);
$this->assign('contentThumbnail', $this->FormatImage->idImage('posts/'.$post['Post']['year'], $post['Post']['id'], array('class' => 'img-thumbnail pull-right'), 'posts'));
?>
		<div>
			<?php
				if (Configure::read('AddThis.posts')) {
					echo $this->element('AddThis/post', array('slug' => $post['Post']['slug'], 'post_title' => $post['Post']['title']));
				}
			?>
		</div>
		<p class="contents-summary">
			<?php echo $post['Post']['summary']; ?>
		</p>
		<div class="contents">
			<?php echo $post['Post']['content']; ?>
		</div>
