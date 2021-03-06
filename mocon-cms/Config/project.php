<?php
/**
 * Project configuration.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Config
 */
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
    'Security' => array(
        'BlowfishAdvanced' => array(
            'salt_prefix' => '2y', // can be 2y, 2a or 2x; 2a is legacy for PHP < 5.3.7, 2y is perferred but CakePHP only uses 2a
            'cost' => 10 // two digit cost parameter must be in range 04-31
        )
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
    'Bootstrap' => array(
        'css_version' => '', // Bootstrap CDN: 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css'
        'js_version' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js',
    ),
    'Jquery' => array(
        'version' => 'http://code.jquery.com/jquery-1.11.2.min.js',
    ),
    'JqueryUi' => array(
        'version' => 'https://code.jquery.com/ui/1.11.2/jquery-ui.js',
        'theme' => 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css',
    ),
    'FontAwesome' => array(
        'version' => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
    ),
    'Google' => array(
        'Analytics' => array(
            'trackerCode' => '',
            'trackerSite' => 'auto'
        ),
        'Maps' => array(
            'key' => '',
        ),
        'SiteVerification' => array(
            'key' => ''
        ),
        'Search' => array(
            'action' => 'http://google.com/search',
            'sitesearch' => 'example.com',
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
