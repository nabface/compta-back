<?php
	
	namespace Compta\Domain;
	
	class User {
		
		private $id,
		        $name,
		        $color,
		        $groups,
		        $depenses;
		
		public function getId() { return $this->id; }
		public function getName() { return $this->name; }
		public function getColor() { return $this->color; }
		public function getGroups() { return $this->groups; }
		public function getDepenses() { return $this->depenses; }
		
		public function setId($id) {
			$id = (int) $id;
			if ($id <= 0) return NULL;
			$this->id = $id;
			return $this;
		}
		public function setName($name) {
			$name = (string) $name;
			$length = strlen($name);
			if ($length = 0 || $length > 255) return NULL;
			$this->name = $name;
			return $this;
		}
		public function setColor($color) {
			$color = (string) $color;
			$length = strlen($color);
			if ($length = 0 || $length > 255) return NULL;
			$this->color = $color;
			return $this;
		}
		public function setGroups(array $groups) {
			if (count($groups) == 0) $this->groups = NULL;
			else {
				foreach ($groups as $group) {
					$group = (int) $groups;
					if ($group <= 0) return NULL;
				}
				$this->groups = $groups;
			}
			return $this;
		}
		public function setDepenses(array $depenses) {
			foreach ($depenses as $depense) {
				$depense = (int) $depense;
				if ($depense <= 0) return NULL;
			}
			$this->depenses = $depenses;
			return $this;
		}
		
		public function addGroup($group_id) {
			$groups = $this->getGroups();
			if (!is_array($groups) || !in_array($group_id, $groups)) {
				$groups[] = $group_id;
				$this->setGroups($groups);
			}
			return $this;
		}
		
		public function removeGroup($group_id) {
			$groups = $this->getGroups();
			$groups_new = [];
			foreach ($groups as $id)
				if ($id != $group_id) $groups_new[] = $id;
			$this->setGroups($groups_new);
			return $this;
		}
		
	}
	
?>
