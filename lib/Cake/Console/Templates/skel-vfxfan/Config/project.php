<?php
/**
 * Project configuration.
 *
 * Project configuration.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    config
 */
$config = array(
	'Meta' => array(
		'keywords' => 'keywords',
		'description' => 'description'
	),
	'Admin' => array(
		'date_select' => array(
			'min_year' => '',
			'max_year' => '',
			'year_range' => 5,
		),
	),
	'AddThis' => array(
		'pubid' => '',
		'title' => '',
		'style_32' => false,
		'posts' => true,
	),
	'Jquery' => array(
		'version' => '',
	),
	'JqueryUi' => array(
		'version' => '',
		'theme' => '',
	),
	'GoogleAnalytics' => array(
		'trackerCode' => '',
	),
	'GoogleMaps' => array(
		'key' => '',
	),
	'TinyMCE' => array(
		'active' => false,
	),
	'Twitter' => array(
		'profile' => 'malducin',
		'widget_width' => '300',
		'widget_height' => '300',
		'widget_num_tweets' => '4',
		'widget_shell_bg' => '#333333',
		'widget_shell_color' => '#ffffff',
		'widget_tweets_bg' => '#000000',
		'widget_tweets_color' => '#ffffff',
		'widget_tweets_links' => '#0069d6',
	),
	'YouTube' => array(
		'feed' => '',
	),
);