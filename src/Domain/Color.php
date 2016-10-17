<?php
	
	namespace Compta\Domain;
	
	class Color {
		
		private $id,
		        $color;
		
		public function getId() { return $this->id; }
		public function getColor() { return $this->color; }
		
		public function setId($id) {
			$id = (int) $id;
			if ($id <= 0) return NULL;
			$this->id = $id;
			return $this;
		}
		public function setColor($color) {
			$color = strtolower((string) $color);
			$pattern = preg_quote('/^([0-9a-f]{6}|[0-9a-f]{3})$/');
			if (preg_match($pattern, $color) != 1) return NULL;
			$this->color = $color;
			return $this;
		}
		
	}
	
?>
