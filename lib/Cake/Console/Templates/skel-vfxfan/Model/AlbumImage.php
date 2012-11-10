<?php
/**
 * Album Image model.
 *
 * Manage Album Image data. It uses the FilesList datasource to get
 * sortable and paged results.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       album_images
 * @subpackage    album_images.model
 */
App::uses('AppModel', 'Model');
App::uses('MySanitize', 'Utility');
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
}
