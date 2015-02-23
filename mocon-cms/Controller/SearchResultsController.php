<?php
/**
 * SearchResults controller.
 *
 * Display results of a custom google search for the site.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Controller.SearchResults
 */
App::uses('AppController', 'Controller');
/**
 * SystemInfos Controller
 *
 * @property SearchResult $SearchResult
 */
class SearchResultsController extends AppController
{
/**
 * Models to use
 *
 * @var array
 */
    public $uses = array();

/**
 * admin_index method
 *
 * @return void
 */
    public function index()
    {
        $this->set('title_for_layout', 'Search Results');
    }

}
