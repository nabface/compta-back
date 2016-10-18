<?php
	
	namespace Compta\Domain;
	
	class User {
		
		private $id,
		        $name,
		        $color_id,
		        $groups;
		
		public function getId() { return $this->id; }
		public function getName() { return $this->name; }
		public function getColorId() { return $this->color_id; }
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
		public function setColorId($color_id) {
			$color_id = (int) $color_id;
			if ($color_id <= 0) return NULL;
			$this->color_id = $color_id;
			return $this;
		}
		public function setGroups(array $groups) {
			foreach ($groups as $group) {
				$group = (int) $groups;
				if ($group <= 0) return NULL;
			}
			$this->groups = $groups;
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
			$groups = $this->getGroups;
			if (!in_array($group_id, $groups)) {
				$groups[] = $group_id;
				$this->setGroups($groups);
			}
			return $this;
		}
		
	}
	
?>
