<?php
class EquipmentController extends AppController {

	var $name = 'Equipment';

	function index() {
		$this->Equipment->recursive = 0;
		$this->set('equipment', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid equipment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('equipment', $this->Equipment->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Equipment->create();
			if ($this->Equipment->save($this->data)) {
				$this->Session->setFlash(__('The equipment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The equipment could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid equipment', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Equipment->save($this->data)) {
				$this->Session->setFlash(__('The equipment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The equipment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Equipment->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for equipment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Equipment->delete($id)) {
			$this->Session->setFlash(__('Equipment deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Equipment was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>