<?php
/**
 * Album Image model.
 *
 * Manage Album Image data. It uses the FilesList datasource to get
 * sortable and paged results.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Model.AlbumImages
 */
App::uses('AppModel', 'Model');

/**
 * AlbumImage Model
 *
 * @property Album $Album
 */
class AlbumImage extends AppModel
{
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
