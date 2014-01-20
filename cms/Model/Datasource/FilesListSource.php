<?php
/**
 * Files List data source.
 *
 * A simple datasource to list the files in the given directory. Could
 * be useful when needing to list a great number of files and use
 * pagination, for example an image gallery that does not use the
 * database.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Model.Datasource
 */
/**
 * FilesListSource Data Source
 *
 */
class FilesListSource extends DataSource {
/**
 * An optional description of the datasource
 *
 * @var string
 */
	public $displayField = 'A files list datasource.';
/**
 * Our default config options. These options will be customized in our
 * app/Config/database.php and will be merged in the __construct().
 * By default list the files in the web root directory.
 */
	public $config = array(
		'basePath' => WWW_ROOT,
	);

/**
 * Since datasources normally connect to a database there are a few things
 * we must change to get them to work without a database.
 */
/**
 * listSources() is for caching. You'll likely want to implement caching in
 * your own way with a custom datasource. So just 'return null'.
 */
	public function listSources($data = null) {
		return null;
	}

/**
 * calculate() is for determining how we will count the records and is
 * required to get update() and delete() to work.
 *
 * We don't count the records here but return a string to be passed to
 * read() which will do the actual counting. The easiest way is to just
 * return the string COUNT and check for it in read() where
 * $data['fields'] == 'COUNT'.
 */
	public function calculate(Model $Model, $func, $params = array()) {
		return 'COUNT';
	}

/**
 * Implement the R in CRUD. Calls to Model::find() arrive here.
 */
	public function read(Model $Model, $queryData = array(), $recursive = null) {
		// check to see if we defined a directory in the paginate conditions
		 if (!empty($queryData['conditions']['directory'])) {
		 	$directory = $this->config['basePath'].$queryData['conditions']['directory'].DS;
		 } else {
		 	$directory = $this->config['basePath'];
		 }

		$files = array();
		$filesList = new DirectoryIterator($directory);

		foreach ($filesList as $filename) {
			if ($filename->isFile()) {
				$files[] = $filename->getBasename();
			}
		}

		/**
		 * Here we do the actual count as instructed by our calculate()
		 * method above. We just count the number of elements in the
		 * files array.
		 *
		 * We also call the funtion to sort and paginate the results.
		 */

		if ($files) {
			if ($queryData['fields'] == 'COUNT') {
				return array(array(array('count' => count($files))));
			}

			// used for sorting
			$files = $this->__sortItems($files, $queryData['order'][0]);

			//used for pagination
			$files = $this->__getPage($files, $queryData);

		} else {
			if ($queryData['fields'] == 'COUNT') {
				return array(array(array('count' => count($files))));
			}
		}

		/**
		 * Return the results in an array which uses the model alias
		 * name.
		 */
		return array($Model->alias => $files);
	}

/**
 * Sort the files list
 *
 * We use the sort constants defined for standard multi sort
 * arrays, just for the heck of it.
 */
	private function __sortItems($files, $order) {
		if (empty($order)) {
			return $files;
		}

		switch(strtolower($order)) {
			case 'asc':
				$direction = SORT_ASC;
				break;
			case 'desc':
				$direction = SORT_DESC;
				break;
			default:
				throw new CakeException('Invalid sorting direction');
		}

		if ($direction == SORT_ASC) {
			sort($files);
		} else {
			rsort($files);
		}

		return $files;
	}

/**
 * Get a paginated result using array slicing. We also set the
 * default limit to 20, like regular pagination.
 */
	private function __getPage($files = null, $data = array()) {
		if (empty($data['limit'])) {
			return $files;
		}

		if (!isset($data['limit']) || empty($data['limit'])) {
			$limit = 20;
		} else {
			$limit = $data['limit'];
		}
		$page = $data['page'];

		$offset = $limit * ($page - 1);

		return array_slice($files, $offset, $limit);;
	}

}
