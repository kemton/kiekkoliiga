<?php
class HallOfFameAccess extends DatabaseAccess {

	
	private $GET_ALL_HOFS = "SELECT * FROM hof";
	private $ADD_HOF = "INSERT INTO hof SET 
													lahettaja = :adder, 
													ip = :ip, 
													pelaaja = :player, 
													teksti = :text, 
													aika = NOW()";
	
	public function getAllHOF() {
		try {
			$results = parent::executeStatement($this->GET_ALL_HOFS, array());
			$HOFs = array();
			
			foreach($results as $row) {
				$id = $row['hofID'];
				$adder = $row['lahettaja'];
				$ip = $row['ip'];
				$player = $row['pelaaja'];
				$text = $row['teksti'];
				$time = $row['aika'];

				$HOF = new HallOfFame($id, $adder, $ip, $player, $text, $time);
				$HOFs[] = $HOF;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $HOFs;
	}
	
	public function addPlayerToHOF($adder, $ip, $player, $text) {
		try {
			$affectedRows = parent::updateStatement($this->ADD_HOF, array("adder" => $adder, "ip" => $ip, "player" => $player, "text" => $text));
			if($affectedRows == 1) {
				return true;
			}
		} catch (Exception $e) {
			throw $e;
		}
		return false;
	}

}
?>