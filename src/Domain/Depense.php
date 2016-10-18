<?php
	
	namespace Compta\Domain;
	
	class Depense {
		
		private $id,
		        $montant,
		        $date,
		        $name,
		        $group_id,
		        $user_id,
		        $users;
		
		public function getId() { return $this->id; }
		public function getMontant() { return $this->montant; }
		public function getDate() { return $this->date; }
		public function getName() { return $this->name; }
		public function getGroupId() { return $this->group_id; }
		public function getUserId() { return $this->user_id; }
		public function getUsers() { return $this->users; }
		
		public function setId($id) {
			$id = (int) $id;
			if ($id <= 0) return NULL;
			$this->id = $id;
			return $this;
		}
		public function setMontant($montant) {
			$montant = (float) $montant;
			if ($montant <= 0) return NULL;
			$this->montant = $montant;
			return $this;
		}
		public function setDate($date) {
			$date = (int) $date;
			if ($date < 0) return NULL;
			$this->date = $date;
			return $this;
		}
		public function setName($name) {
			$name = (string) $name;
			$length = strlen($name);
			if ($length = 0 || $length > 255) return NULL;
			$this->name = $name;
			return $this;
		}
		public function setGroupId($group_id) {
			$group_id = (int) $group_id;
			if ($group_id <= 0) return NULL;
			$this->group_id = $group_id;
			return $this;
		}
		public function setUserId($user_id) {
			$user_id = (int) $user_id;
			if ($user_id <= 0) return NULL;
			$this->user_id = $user_id;
			return $this;
		}
		public function setUsers(array $users) {
			foreach ($users as $user) {
				$user = (int) $users;
				if ($user <= 0) return NULL;
			}
			$this->users = $users;
			return $this;
		}
		
		public function addUser($user_id) {
			$users = ( $this->getUsers() !== NULL ) ? $this->getUsers() : [] ;
			if (!in_array($user_id, $users)) {
				$users[] = $user_id;
				$this->setUsers($users);
			}
			return $this;
		}
		
	}
	
?>
