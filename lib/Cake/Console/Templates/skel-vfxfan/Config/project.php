<?php
/**
 * Project configuration.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       app
 * @subpackage    app.config
 */
if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://');
}
$config = array(
	'Meta' => array(
		'author' => 'Manuel Alducin',
		'generator' => 'VFXfan CMS',
		'description' => 'description'
	),
	'Admin' => array(
		'date_select' => array(
			'min_year' => '',
			'max_year' => '',
			'year_range' => 5,
		),
	),
	'Posts' => array(
		'latest_num' => 5,
	),
	'Events' => array(
		'upcoming_num' => 5,
	),
	'AddThis' => array(
		'pubid' => '',
		'title' => '',
		'style_32' => false,
		'posts' => true,
	),
	'Jquery' => array(
		'version' => 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js',
	),
	'JqueryUi' => array(
		'version' => 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js',
		'theme' => '',
	),
	'Google' => array(
		'Analytics' => array(
			'trackerCode' => '',
		),
		'Maps' => array(
			'key' => '',
		),
		'SiteVerification' => array(
			'key' => ''
		),
	),
	'TinyMCE' => array(
		'active' => false,
	),
	'Twitter' => array(
		'profile' => 'malducin',
		'widget_width' => '300',
		'widget_height' => '300',
		'widget_num_tweets' => '4',
		'widget_interval' => 30000,
		'widget_shell_bg' => '#333333',
		'widget_shell_color' => '#ffffff',
		'widget_tweets_bg' => '#000000',
		'widget_tweets_color' => '#ffffff',
		'widget_tweets_links' => '#0069d6',
		'widget_scrollbar' => 'false',
		'widget_live' => 'false',
	),
	'YouTube' => array(
		'feed' => '',
	),
);