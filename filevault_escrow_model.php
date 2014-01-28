<?php
// @author gmarnin

class Filevault_escrow_model extends Model {

	function __construct($serial='')
	{
		parent::__construct('id', 'filevault_escrow'); //primary key, tablename
		$this->rs['id'] = 0;
		$this->rs['serial_number'] = $serial; $this->rt['serial_number'] = 'VARCHAR(255) UNIQUE';
		$this->rs['EnabledDate'] = '';
		$this->rs['EnabledUser'] = '';
		$this->rs['HardwareUUID'] = '';
		$this->rs['LVGUUID'] = '';
		$this->rs['LVUUID'] = '';
		$this->rs['PVUUID'] = '';
		$this->rs['RecoveryKey'] = '';
		$this->rs['SerialNumber'] = '';		   
		$this->rs['HddSerial'] = '';
		
		// Create table if it does not exist
		$this->create_table();
		
		if ($serial)
		{
			$this->retrieve_one('serial_number=?', $serial);
		}
		
		$this->serial = $serial;
		  
	}

function process($data)
	{
		require_once(APP_PATH . 'lib/CFPropertyList/CFPropertyList.php');
		$parser = new CFPropertyList();
		$parser->parse($data);
		
		$plist = $parser->toArray();

		foreach(array('EnabledDate', 'EnabledUser', 'HardwareUUID', 'LVGUUID', 'LVUUID', 'PVUUID', 'RecoveryKey', 'SerialNumber', 'HddSerial') AS $item)
		{
			if (isset($plist[$item]))
			{
				$this->$item = $plist[$item];
			}
			else
			{
				$this->$item = '';
			}
		}

		$this->save();
	}
}