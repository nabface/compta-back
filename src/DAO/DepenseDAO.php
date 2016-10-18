<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\Depense;
	
	class DepenseDAO extends DAO {
		
		private $groupDAO;
		
		private function getGroupDAO() { return $this->groupDAO; }
		
		public function setGroupDAO(GroupDAO $groupDAO) {
			$this->groupDAO = $groupDAO;
			return $this;
		}
		
		public function findByGroup($group_id) {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('depenses')
			      ->where('group_id = ?')
			      ->setParameter(0, $group_id);
			$list = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
			$depenses = [];
			foreach ($list as $row) {
				$depense = new Depense();
				$depense->setId($row['id'])
				        ->setMontant($row['montant'])
				        ->setDate($row['date'])
				        ->setName($row['name'])
				        ->setGroupId($row['group_id'])
				        ->setUserId($row['user_id']);
				$query = $this->getDb()->createQueryBuilder();
				$query->select('*')
				      ->from('mapping_users')
				      ->where('depense_id = ?')
				      ->setParameter(0, $depense->getId());
				$users_id = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
				$users = '';
				$users_nb = 0;
				foreach ($users_id as $user_id) {
					$users .= ($users == '') ?
						$user_id['user_id'] :
						','.$user_id['user_id'] ;
					$users_nb++;
				}
				$depenses[] = array(
					'Id' => $depense->getId(),
					'Montant' => $depense->getMontant(),
					'Payeur' => $depense->getUserId(),
					'Concernes' => $users,
					'Date' => $depense->getDate(),
					'nbConcernes' => $users_nb,
					'usergroup' => $this->groupDAO->get($group_id)->getName(),
					'Description' => $depense->getName()
				);
			}
			return $depenses;
		}
		
		public function deleteByGroup($group_id) {
			//TODO
		}
		
		public function deleteByUser($user_id) {
			//TODO
		}
		
		public function save(Depense $depense) {
			//TODO
		}
		
		public function delete($id) {
			$this->getDb()->delete('depenses', array('id' => $id));
		}
		
	}
	
?>