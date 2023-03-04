<?php

use CFPropertyList\CFPropertyList;

class Ethernet_model extends \Model {

	function __construct($serial='')
	{
		parent::__construct('id', 'ethernet'); // Primary key, tablename
		$this->rs['id'] = '';
		$this->rs['serial_number'] = $serial;
		$this->rs['name'] = '';
		$this->rs['device_id'] = '';
		$this->rs['BSD_Device_Name'] = '';
		$this->rs['driver'] = ''; 
		$this->rs['max_link_speed'] = '';
		$this->rs['pcie_link_speed'] = '';
		$this->rs['pcie_link_width'] = '';
		$this->rs['avb_support'] = '';
		$this->rs['vendor_name'] = '';
		$this->rs['revision_id'] = '';
		$this->rs['subsystem_id'] = '';
		$this->rs['subsystem_vendor_id'] = '';
		$this->rs['vendor_id'] = '';
		$this->rs['bus'] = '';
		$this->rs['mac_address'] = '';
		$this->rs['product_name'] = '';
		$this->rs['product_id'] = '';
		$this->rs['usb_device_speed'] = '';
		$this->rs['device_type'] = '';

		if ($serial) {
			$this->retrieve_record($serial);
		}

		$this->serial_number = $serial;
	}
	
// ------------------------------------------------------------------------

	/**
	* Get Ethernet device names for widget
	*
	**/
	public function get_ethernet_devices()
	{
		$out = array();
		$sql = "SELECT COUNT(CASE WHEN name <> '' AND name IS NOT NULL THEN 1 END) AS count, name 
			FROM ethernet
			LEFT JOIN reportdata USING (serial_number)
			".get_machine_group_filter()."
			GROUP BY name
			ORDER BY count DESC";

		foreach ($this->query($sql) as $obj) {
			if ("$obj->count" !== "0") {
				$obj->name = $obj->name ? $obj->name : 'Unknown';
				$out[] = $obj;
			}
		}
		return $out;
	}

	/**
	* Get Ethernet speeds for widget
	*
	**/
	public function get_ethernet_speed()
	{
		$out = array();
		$sql = "SELECT COUNT(CASE WHEN max_link_speed <> '' AND max_link_speed IS NOT NULL THEN 1 END) AS count, max_link_speed 
			FROM ethernet
			LEFT JOIN reportdata USING (serial_number)
			".get_machine_group_filter()."
			GROUP BY max_link_speed
			ORDER BY count DESC";

		foreach ($this->query($sql) as $obj) {
			if ("$obj->count" !== "0") {
				$obj->max_link_speed = $obj->max_link_speed ? $obj->max_link_speed : 'Unknown';
				$out[] = $obj;
			}
		}
		return $out;
	}

	/**
	* Process data sent by postflight
	*
	* @param string data
	* @author ofirgalcon
	**/
	function process($plist)
	{
		// Check if we have data
		if ( ! $plist){
			throw new Exception("Error Processing Request: No property list found", 1);
		}

		// Delete previous set        
		$this->deleteWhere('serial_number=?', $this->serial_number);

		$parser = new CFPropertyList();
		$parser->parse($plist, CFPropertyList::FORMAT_XML);
		$myList = $parser->toArray();

		foreach ($myList as $device) {

			// Check if we have a name
			if( ! array_key_exists("name", $device)){
				continue;
			}

			foreach ($this->rs as $key => $value) {
				$this->rs[$key] = $value;
				if(array_key_exists($key, $device))
				{
					$this->rs[$key] = $device[$key];
				} else if ($key != "serial_number") {
					$this->rs[$key] = null;
				}
			}

			// Save the device, save the game
			$this->id = '';
			$this->save();
		}
	}
}
