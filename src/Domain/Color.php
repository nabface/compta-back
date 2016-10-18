<?php
	
	namespace Compta\Domain;
	
	class Color {
		
		private $id,
		        $name;
		
		public function getId() { return $this->id; }
		public function getName() { return $this->name; }
		
		public function setId($id) {
			$id = (int) $id;
			if ($id <= 0) return NULL;
			$this->id = $id;
			return $this;
		}
		public function setName($name) {
			$name = strtolower((string) $name);
			$length = strlen($name);
			if ($length == 0 || $length > 255) return NULL;
			$this->name = $name;
			return $this;
		}
		
	}
	
?>
