<?php 

/**
 * Ethernet module class
 *
 * @package munkireport
 * @author ofirgalcon
 **/
class Ethernet_controller extends Module_controller
{
	
	/*** Protect methods with auth! ****/
	function __construct()
	{
		// Store module path
		$this->module_path = dirname(__FILE__);
	}

	/**
	 * Default method
	 * @author avb
	 *
	 **/
	function index()
	{
		echo "You've loaded the ethernet module!";
	}

   /**
     * Get Ethernet device names for widget
     *
     * @return void
     * @author ofirgalcon
     **/
     public function get_ethernet_devices()
     {
         
        $sql = "SELECT COUNT(CASE WHEN name <> '' AND name IS NOT NULL THEN 1 END) AS count, name 
                FROM ethernet
                LEFT JOIN reportdata USING (serial_number)
                ".get_machine_group_filter()."
                GROUP BY name
                ORDER BY count DESC";
        
        $out = array();
        $queryobj = new Ethernet_model;
        foreach ($queryobj->query($sql) as $obj) {
            if ("$obj->count" !== "0") {
                $obj->name = $obj->name ? $obj->name : 'Unknown';
                $out[] = $obj;
            }
        }

        jsonView($out);
     }
    
    /**
     * Get Ethernet speeds for widget
     *
     * @return void
     * @author ofirgalcon
     **/
    public function get_ethernet_speed()
    {
        
       $sql = "SELECT COUNT(CASE WHEN max_link_speed <> '' AND max_link_speed IS NOT NULL THEN 1 END) AS count, max_link_speed 
               FROM ethernet
               LEFT JOIN reportdata USING (serial_number)
               ".get_machine_group_filter()."
               GROUP BY max_link_speed
               ORDER BY count DESC";
       
       $out = array();
       $queryobj = new Ethernet_model;
       foreach ($queryobj->query($sql) as $obj) {
           if ("$obj->count" !== "0") {
               $obj->max_link_speed = $obj->max_link_speed ? $obj->max_link_speed : 'Unknown';
               $out[] = $obj;
           }
       }

       jsonView($out);
    }
   
   /**
     * Retrieve data in json format
     *
     **/
    public function get_data($serial_number = '')
    {
        $serial_number = preg_replace("/[^A-Za-z0-9_\-]]/", '', $serial_number);
    
        $sql = "SELECT name, BSD_Device_Name, driver, max_link_speed, pcie_link_speed, pcie_link_width, avb_support, 
                        device_id, revision_id, subsystem_id, subsystem_vendor_id, vendor_id, bus, mac_address, product_name, usb_device_speed, vendor_name, device_type
                        FROM ethernet 
                        WHERE serial_number = '$serial_number'";

        $queryobj = new Ethernet_model();
        jsonView($queryobj->query($sql));
    }
		
} // End class Ethernet_controller
