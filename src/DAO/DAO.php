<?php
	
	namespace Compta\DAO;
	
	use Doctrine\DBAL\Connection;
	
	abstract class DAO 
	{
		
		private $db;
		
		public function __construct(Connection $db) { $this->db = $db; }
		
		protected function getDb() { return $this->db; }
		
		protected function getObject($info, $table, $class) {
			$where = (is_numeric($info)) ? 'id = :info' : 'name = :info' ;
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from($table)
			      ->where($where)
			      ->setParameter(':info', $info);
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, $class);
			return $statement->fetch();
		}
		
	}
	
?>
