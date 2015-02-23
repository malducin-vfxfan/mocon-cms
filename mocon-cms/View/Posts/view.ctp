<?php
/**
 * Posts view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.Posts
 */
$this->extend('/Common/view');

$this->assign('title', $post['Post']['title']);
$this->assign('contentCreated', $post['Post']['created']);
$this->assign('contentAuthor', $post['User']['username']);
$this->assign('sectionModified', $post['Post']['modified']);

$preview_image = $this->FormatImage->getPreviewImage($post['Post']['preview_images']);

if (!empty($preview_image)) {
	$this->assign('contentPreviewImage', $this->Html->image('posts/'.$post['Post']['year'].'/'.sprintf("%010d", $post['Post']['id']).'/'.$preview_image, array('class' => 'img-responsive center-block', 'alt' => $post['Post']['title'], 'title' => $post['Post']['title'])));
}
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
