<?php
/**
 * Album Image model.
 *
 * Manage Album Image data. It uses the FilesList datasource to get
 * sortable and paged results.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Model.AlbumImages
 */
App::uses('AppModel', 'Model');
App::uses('Folder', 'Utility');

/**
 * AlbumImage Model
 *
 * @property Album $Album
 */
class AlbumImage extends AppModel {
/**
 * useDbConfig
 *
 * Use the albums database configuration, which uses the FilesList
 * data source.
 *
 * @var array
 */
	public $useDbConfig = 'albums';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Album' => array(
			'className' => 'Album',
		)
	);

/**
 * Overridden paginateCount method
 */
	public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {

		$dir = new Folder($conditions['folder']);
		$files = $dir->find('.*', true);
		return count($files);
	}
}
