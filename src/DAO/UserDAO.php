<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\User;
	
	class UserDAO extends DAO {
		
		private $groupDAO;
		
		private function getGroupDAO() { return $this->groupDAO; }
		
		public function setGroupDAO(GroupDAO $groupDAO) {
			$this->groupDAO = $groupDAO;
			return $this;
		}
		
		private function get($id) {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('users')
			      ->where('id = :id')
			      ->setParameter(':id', $id);
			$result = $query->execute()->fetch(\PDO::FETCH_ASSOC);
			$user = new User();
			$user->setId($result['id'])
			     ->setName($result['name'])
			     ->setColorId($result['color_id']);
			return $user;
		}
		
		public function findByGroup($group_id) {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('mapping_groups')
			      ->where('group_id = ?')
			      ->setParameter(0, $group_id);
			$users_id = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
			$users = [];
			foreach ($users_id as $user_id) {
				$user = $this->get($user_id['user_id']);
				$id = $user->getId();
				$users[] = array(
					'Id' => $user->getId(),
					'username' => $user->getName(),
					'usergroup' => $this->groupDAO->get($group_id)->getName(),
					'usercolor' => $this->getColorName($user->getColorId())
				);
			}
			return $users;
		}
		
		private function getColorName($id) {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('colors')
			      ->where('id = :id')
			      ->setParameter(':id', $id);
			$result = $query->execute()->fetch(\PDO::FETCH_ASSOC);
			return $result['name'];
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