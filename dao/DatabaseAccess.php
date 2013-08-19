<?php
/**
 * Kiekkoliiga Database Object extends PDO. All sql statements execute throught this class.
 *
 * @return FetchAssoc
 * @return rowCount
 */
abstract class DatabaseAccess {
	static private $PDOInstance;

	public function __construct() {
		if(!self::$PDOInstance) {
			try {
				$options = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => true, PDO::ERRMODE_EXCEPTION => true);
				self::$PDOInstance = new PDO(DSN, USERNAME, PASSWORD, $options);
				self::$PDOInstance->exec("set names utf8");
			} catch (PDOException $e) {
				die("PDO CONNECTION ERROR: " . $e->getMessage() . "<br/>");
			}
		}
		return self::$PDOInstance;
	}
	
	public function executeStatement($sql, $bind = array()) {
		try {
			$stmt = self::$PDOInstance->prepare($sql);
			$stmt->execute($bind);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			throw $e;
		}
		
		return $result;
	}

	public function updateStatement($sql, $bind = array()) {
		try {
			$stmt = self::$PDOInstance->prepare($sql);
			$stmt->execute($bind);
			$result = $stmt->rowCount();
		} catch (Exception $e) {
			throw $e;
		}
			
		return $result;
	}
	
	public function beginTransaction() {
		try {
			return self::$PDOInstance->beginTransaction();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function commit() {
		try {
			return self::$PDOInstance->commit();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	
	public function rollBack() {
		try {
			return self::$PDOInstance->rollBack();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function lastInsertId() {
		try {
			return self::$PDOInstance->lastInsertId();
		} catch (Exception $e) {
			throw $e;
		}
	}
	
}
?>