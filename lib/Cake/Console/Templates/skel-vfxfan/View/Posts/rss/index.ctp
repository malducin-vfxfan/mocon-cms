<?php
/**
 * Posts RSS view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       posts
 * @subpackage    posts.views.rss
 */

$this->set('documentData', array('xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

$last_pub_date = date('r', strtotime($posts[0]['Post']['created']));
$this->set('channelData', array(
	'title' => 'Most Recent Site News',
	'link' => $this->Html->url('/', true),
	'description' => 'Most recent Site news.',
	'language' => 'en-us',
	'copyright' => 'Copyright 2011-'.date('Y').', '.FULL_BASE_URL,
	'generator' => 'VFXfan.com CMS',
	'image' => array('url' => '/img/rss_site.png', 'width' => 100, 'height' => 100),
	'atom:link' => array('attrib' => array('href' => $this->Html->url(array('controller' => 'posts', 'action' => 'index.rss')), 'rel' => 'self', 'type' => 'application/rss+xml')),
	'pubDate' => $last_pub_date,
	'lastBuildDate' => $last_pub_date
	)
);

foreach ($posts as $post) {

	$postLink = array(
		'controller' => 'posts',
		'action' => 'view',
		$post['Post']['slug']
    );

	$pub_date = date('r', strtotime($post['Post']['created']));
	echo $this->Rss->item(array(), array(
		'title' => html_entity_decode($post['Post']['title']),
		'link' => $postLink,
		'description' =>  html_entity_decode($post['Post']['summary']),
		'dc:creator' => $post['User']['username'],
		'pubDate' => $pub_date)
	);
}
?>