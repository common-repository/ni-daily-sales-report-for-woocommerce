<?php
/*
Plugin Name: Ni Daily Sales Report For Woocommerce
Description: Ni Daily Sales Report for Woocommerce provides the sales analysis for any sales periods.
Author: anzia
Version: 1.1.1
Author URI: http://naziinfotech.com/
Plugin URI: https://wordpress.org/plugins/ni-daily-sales-report-for-woocommerce/
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/agpl-3.0.html
Requires at least: 4.7
Tested up to: 6.5.3
WC requires at least: 3.0.0
WC tested up to: 8.9.1
Last Updated Date: 31-May-2024
Requires PHP: 7.0


*/
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_Daily_Sales_Report_For_Woocommerce' ) ) {
	class Ni_Daily_Sales_Report_For_Woocommerce{
		var $nidsrfw_constant = array();  
		 public function __construct(){
			 $this->nidsrfw_constant = array(
				 "prefix" 		  => "nidsrfw-",
				 "manage_options" => "manage_options",
				 "menu"   		  => "nidsrfw-dashboard",
				 "file_path"   	  => __FILE__,
				);
			include("includes/ni-daily-sales-report-for-woocommerce-init.php");
			$obj_init =  new Ni_Daily_Sales_Report_For_Woocommerce_Init($this->nidsrfw_constant);
		 }
	}
	$obj = new Ni_Daily_Sales_Report_For_Woocommerce();
}
?>