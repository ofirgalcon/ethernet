Ethernet module
==============

Provides the status of Ethernet devices.

Data can be viewed under the Ethernet Devices tab on the client details page or using the Ethernet list view.

Based on Thunderbolt module by tuxudo

Table Schema
---
* name - varchar(255) - Name of the Ethernet device
* device_id - varchar(255) - Device ID
* BSD_Device_Name - varchar(255) - BSD device name
* driver - boolean - driver
* max_link_speed - varchar(255) - Maximum Link speed
* pcie_link_width - varchar(255) - PCIe Link width
* pcie_link_speed - varchar(255) - PCIe Device name
* product_name - varchar(255) - Product name
* revision_id - varchar(255) - Revision ID
* vendor_name - varchar(255) - Vendor name
* subsystem_id - varchar(255) - Subsystem ID
* subsystem_vendor_id - varchar(255) - Subsystem Vendor ID
* vendor_id - varchar(255) - Vendor ID
* avb_support - varchar(255) - AVB support
* usb_device_speed - varchar(255) - USB link speed
* bus - varchar(255) - Bus
* mac_address - varchar(255) - MAC address
* product_id - varchar(255) - Product ID
* device_type - varchar(255) - Device type


