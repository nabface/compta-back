<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\User;
	
	class UserDAO extends DAO {
		
		public function findByGroup($group_id) {
			//TODO
		}
		
		public function removeFromGroup($group_id) {
			//TODO
		}
		
		public function save(User $user) {
			//TODO
		}
		
		public function delete($id) {
			$this->getDb()->delete('users', array('id' => $id));
		}
		
	}
	
?>