<?php
/**
 * Controller actions template.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       templates
 * @subpackage    templates.vfxfan-bootstrap.actions
 */
?>

/**
 * <?php echo $admin ?>index method
 *
 * @return void
 */
	public function <?php echo $admin ?>index() {
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->set('title_for_layout', '<?php echo ucfirst($pluralName); ?>');
		$this->set('<?php echo $pluralName ?>', $this->paginate());
	}

/**
 * <?php echo $admin ?>view method
 *
 * @param string $id
 * @return void
 */
	public function <?php echo $admin ?>view($id = null) {
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException('Invalid <?php echo strtolower($singularHumanName); ?>.');
		}
		// $this-><?php echo $currentModelName; ?>->unbindModel(array('hasMany' => array('')));
		$<?php echo $singularName; ?> = $this-><?php echo $currentModelName; ?>->find('first', array('conditions' => array('<?php echo $currentModelName; ?>.id' => $id)));
		$this->set(compact('<?php echo $singularName; ?>'));
		$this->set('title_for_layout', '<?php echo ucfirst($singularName); ?>: ');
		// if model has a hasMany relationship don't forget to add pagination here and in the view
		// similar to the Groups controller
		// $this->Group->User->recursive = -1;
		// $this->set('users', $this->paginate('User', array('User.group_id' => $group['Group']['id'])));
		// and modify the views accordingly. If not delete pagination in the view.
	}

<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>add method
 *
 * @return void
 */
	public function <?php echo $admin ?>add() {
		if ($this->request->is('post')) {
			$this-><?php echo $currentModelName; ?>->create();
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash('The <?php echo strtolower($singularHumanName); ?> has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
<?php else: ?>
				$this->flash('<?php echo ucfirst(strtolower($currentModelName)); ?> saved.', array('action' => 'admin_index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
<?php endif; ?>
			}
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
				$compact[] = "'{$otherPluralName}'";
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
		$this->set('title_for_layout', 'Add <?php echo ucfirst($singularName); ?>');
	}

<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>edit method
 *
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>edit($id = null) {
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException('Invalid <?php echo strtolower($singularHumanName); ?>.');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash('The <?php echo strtolower($singularHumanName); ?> has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
<?php else: ?>
				$this->flash('The <?php echo strtolower($singularHumanName); ?> has been saved.', array('action' => 'admin_index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
<?php endif; ?>
			}
		} else {
			$this->request->data = $this-><?php echo $currentModelName; ?>->read(null, $id);
		}
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
					$compact[] = "'{$otherPluralName}'";
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?>
		$this->set('title_for_layout', 'Edit <?php echo ucfirst($singularName); ?>');
	}

/**
 * <?php echo $admin ?>delete method
 *
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException('Invalid <?php echo strtolower($singularHumanName); ?>.');
		}
		if ($this-><?php echo $currentModelName; ?>->delete()) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'admin_index'));
<?php else: ?>
			$this->flash('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted'), array('action' => 'admin_index');
<?php endif; ?>
		}
<?php if ($wannaUseSession): ?>
		$this->Session->setFlash('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted.', 'default', array('class' => 'alert alert-error'));
<?php else: ?>
		$this->flash('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted'), array('action' => 'admin_index');
<?php endif; ?>
		$this->redirect(array('action' => 'admin_index'));
	}