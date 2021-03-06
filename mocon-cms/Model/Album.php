<?php
/**
 * Album model.
 *
 * Manage Album data. Albums have a thumbnail and their image folder
 * contains a thumbnails folder. It assumes the actual image and
 * thumbnail have the same name, the only thing that distinguishes
 * them is their location.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Model.Albums
 */
App::uses('AppModel', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Album Model
 *
 */
class Album extends AppModel
{
/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';
/**
 * Default order
 *
 * @var array
 */
    public $order = array('Album.created' => 'DESC');
/**
 * Validation rules
 *
 * @var array
 */
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notEmpty'),
                'message' => 'This field cannot be left blank.',
                'required' => true,
                'last' => true, // Stop validation after this rule
            ),
            'maxlength' => array(
                'rule' => array('maxLength', 128),
                'message' => 'Names must be no larger than 128 characters long.',
                'required' => true,
                'last' => true, // Stop validation after this rule
            ),
            'isunique' => array(
                'rule' => array('isUnique'),
                'message' => 'This name has already been taken.',
                'required' => true,
                'last' => true // Stop validation after this rule
            ),
        ),
        'description' => array(
            'notempty' => array(
                'rule' => array('notEmpty'),
                'message' => 'This field cannot be left blank.',
                'required' => true,
                'last' => true, // Stop validation after this rule
            ),
            'maxlength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'Descriptions must be no larger than 255 characters long.',
                'required' => true,
                'last' => true, // Stop validation after this rule
            ),
        ),
        'slug' => array(
            'notempty' => array(
                'rule' => array('notEmpty'),
                'message' => 'This field cannot be left blank.',
                'required' => true,
                'last' => true, // Stop validation after this rule
            ),
            'alphanumericextended' => array(
                'rule' => array('alphaNumericDashUnderscoreSpaceColon'),
                'message' => 'Names must only contain letters, numbers, spaces, dashes, underscores and colons.',
                'required' => true,
                'last' => true // Stop validation after this rule
            ),
            'maxlength' => array(
                'rule' => array('maxLength', 128),
                'message' => 'Slugs must be no larger than 128 characters long.',
                'required' => true,
                'last' => true, // Stop validation after this rule
            ),
            'isunique' => array(
                'rule' => array('isUnique'),
                'message' => 'This slug has already been taken.',
                'required' => true,
                'last' => true // Stop validation after this rule
            ),
        ),
    );

/**
 * constructor method
 *
 * Create virtual fields.
 *
 * @param mixed $id The id to start the model on
 * @param string $table The table to use for this model
 * @param string $ds The connection name this model is connected to
 * @return void
 */
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->virtualFields['year'] = sprintf('YEAR(%s.created)', $this->alias);
    }

/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'AlbumImage' => array(
            'className' => 'AlbumImage',
        )
    );

/**
 * Preview images order
 *
 * @var array
 */
    public $orderPreviewImages = array('md', 'sm', 'xs', 'ml', 'lg');

/**
 * beforeValidate method
 *
 * If id doesn't exist (when adding a new record), create a slug from
 * the lowercase inflection of the album name.
 *
 * @return boolean
 */
    public function beforeValidate($options = array())
    {
        if (!empty($this->data)) {
            if (!$this->id) {
                $this->data['Album']['slug'] = strtolower(Inflector::slug($this->data['Album']['name'], '-'));
            }
            $this->data = $this->_cleanData($this->data);
        }
        return true;
    }

/**
 * afterSave method
 *
 * Create the album images folder and the thumbnails folder inside it.
 *
 * @param boolean $created
 * @return void
 */
    public function afterSave($created, $options = array())
    {
        if ($created) {
            $options = array('conditions' => array('Album.id' => $this->id));
            $album = $this->find('first', $options);
            if ($album) {
                $folder = WWW_ROOT.'img'.DS.'albums'.DS.$album['Album']['year'].DS.sprintf("%010d", $this->id);
                $dir = new Folder();
                if (!is_file($folder)) {
                    $dir->create($folder);
                }
                $dir->create($folder.DS.'thumbnails');
                $dir->create($folder.DS.'preview');
            }
        }
    }

/**
 * beforeDelete method
 *
 * Delete all images inside the thumbnails folder and the image album
 * folder and remove the folders. Then remove the folder thumbnail.
 * It returns true hen the operation completes, even if there's a
 * problem removing something.
 *
 * @param boolean $cascade
 * @return boolean
 */
    public function beforeDelete($cascade = true)
    {
        $options = array('conditions' => array('Album.id' => $this->id));
        $album = $this->find('first', $options);

        if ($album) {
            $folder = WWW_ROOT.'img'.DS.'albums'.DS.$album['Album']['year'].DS.sprintf("%010d", $this->id);
            $dir = new Folder($folder);

            $dir->delete();
        }

        return true;
    }

/**
 * afterFind method
 *
 * Add preview_images to the results.
 *
 * @param array $results
 * @param boolean $primary
 * @return array
 */
    public function afterFind($results, $primary = false)
    {
        foreach ($results as $key => $val) {
            // check to see we have an id key, for example to exclude distinct years list
            if (isset($results[$key]['Album']['id']) && isset($results[$key]['Album']['year']) && $primary) {
                $dir = new Folder(WWW_ROOT.'img'.DS.'albums'.DS.$results[$key]['Album']['year'].DS.sprintf("%010d", $results[$key]['Album']['id']).DS.'preview');
                foreach ($this->orderPreviewImages as $value) {
                    $images[$value] = $dir->find('.*\.'.$value.'\.jpg', true);
                    $results[$key]['Album']['preview_images'] = $images;
                }
                $others = $dir->find('.*(?!\.xs|\.sm|\.md|\.ml|\.lg|\.vl|\.xl).{3}\.jpg', true);
                $results[$key]['Album']['preview_images']['others'] = $others;
            }
        }
        return $results;
    }

/**
 * _cleanData method
 *
 * Cleans data array from forms.
 *
 * @param array $data Array of data to clean.
 * @return array
 */
    private function _cleanData($data)
    {
        $data['Album']['name'] = Album::clean(Album::purify($data['Album']['name']));
        $data['Album']['slug'] = Album::clean(Album::purify($data['Album']['slug']), array('encode' => false));
        $data['Album']['description'] = Album::clean(Album::purify($data['Album']['description']));
        return $data;
    }

/**
 * getAlbumThumbnails method
 *
 * Return a sorted list of all images in an album thumbnails folder.
 *
 * @param string $id
 * @return array
 */
    public function getAlbumThumbnails($id = null, $year = null)
    {
        if (!$id || !$year) return array();

        $dir = new Folder(WWW_ROOT.'img'.DS.'albums'.DS.$year.DS.sprintf("%010d", $id).DS.'thumbnails');
        $images = $dir->find('.*', true);

        return $images;
    }

/**
 * deleteFile method
 *
 * Delete an Album file inside the album images folder. It deletes
 * both the image and its thumbnail or a preview image. Returns true
 * if the images are deleted, false otherwise.
 *
 * @param string $filename
 * @return boolean
 */
    public function deleteFile($path = null)
    {
        if (empty($path)) return false;

        $file = new File($path);
        $result = $file->delete();

        return $result;
    }

}
