<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class Ethernet extends Migration
{
    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->create('ethernet', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_number')->nullable();
            $table->string('name')->nullable();
            $table->string('device_id')->nullable();
            $table->string('BSD_Device_Name')->nullable();
            $table->string('driver')->nullable();
            $table->string('max_link_speed')->nullable();
            $table->string('pcie_link_width')->nullable();
            $table->string('pcie_link_speed')->nullable();
            $table->string('product_name')->nullable();
            $table->string('revision_id')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('subsystem_id')->nullable();
            $table->string('subsystem_vendor_id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('avb_support')->nullable();
            $table->string('usb_device_speed')->nullable();
            $table->string('bus')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('product_id')->nullable();
            $table->string('device_type')->nullable();
            
            $table->index('serial_number');
            $table->index('name');
            $table->index('device_id');
            $table->index('BSD_Device_Name');
            $table->index('driver');
            $table->index('max_link_speed');
            $table->index('pcie_link_width');
            $table->index('pcie_link_speed');
            $table->index('product_name');
            $table->index('revision_id');
            $table->index('avb_support');
            $table->index('subsystem_id');
            $table->index('subsystem_vendor_id');
            $table->index('vendor_id');
            $table->index('usb_device_speed');
            $table->index('bus');
            $table->index('mac_address');
            $table->index('product_id');
            $table->index('device_type');
         });
    }
    
    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->dropIfExists('ethernet');
    }
}
