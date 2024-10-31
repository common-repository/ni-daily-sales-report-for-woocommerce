<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_Daily_Sales_Report_For_Woocommerce_Init' ) ) {
	class Ni_Daily_Sales_Report_For_Woocommerce_Init{
		var $nidsrfw_constant = array();  
		 public function __construct($nidsrfw_constant = array()){
			  $this->nidsrfw_constant = $nidsrfw_constant; 
			  add_action('admin_menu', 		array($this,'admin_menu'));	
			  add_action( 'admin_enqueue_scripts',  array(&$this,'admin_enqueue_scripts' ));
			    add_action('wp_ajax_nidsrfw_ajax',  array(&$this, 'nidsrfw_ajax')); /*used in form field name="action" value="my_action"*/
				
				add_action('admin_init', array( &$this, 'admin_init' ) );
		 }
		 /*Add all menu*/
		 function admin_menu(){
		 
				
			add_menu_page(__(  'Daily Report', 'nidsrfw')
			,__(  'Daily Report', 'nidsrfw')
			,$this->nidsrfw_constant['manage_options']
			,$this->nidsrfw_constant['menu']
			,array( $this, 'add_page'), 'dashicons-performance', "57.6361" );
			
			add_submenu_page($this->nidsrfw_constant['menu']
			,__( 'Dashboard', 'nidsrfw' )
			,__( 'Dashboard', 'nidsrfw' )
			,$this->nidsrfw_constant['manage_options']
			,$this->nidsrfw_constant['menu']
			
			
			,array(&$this,'add_page'));
			add_submenu_page($this->nidsrfw_constant['menu']
			,__( 'Daily Sales Report', 'nidsrfw' )
			,__( 'Daily Sales Report', 'nidsrfw' )
			, $this->nidsrfw_constant['manage_options'], 'nidsrfw-daily-sales-report' 
			, array(&$this,'add_page'));
				
				
		 }
		 /*Add all Menu files here*/
		 function add_page(){
	     	$page = sanitize_text_field(isset($_REQUEST["page"])?$_REQUEST["page"]:0);
			
			if ($page  =="nidsrfw-dashboard"){
				include_once("nidsrfw-dashboard.php");
				$obj = new  NiDSRFW_Dashboard(  $this->nidsrfw_constant);
				$obj->page_init();
			}
			
			if ($page  =="nidsrfw-daily-sales-report"){
				include_once("nidsrfw-daily-sales-report.php");
				$obj = new  NiDSRFW_daily_sales_report(  $this->nidsrfw_constant);
				$obj->page_init();
			}
			
			
			
		 }
		 /*All Ajax call handle here*/
		 function nidsrfw_ajax(){
		 	$sub_action = sanitize_text_field(isset($_REQUEST["sub_action"])?$_REQUEST["sub_action"]:"");
			if ($sub_action =="daily_report"){
				
				include_once("nidsrfw-daily-sales-report.php");
				$obj = new  NiDSRFW_daily_sales_report( );
				$obj->ajax_init();
			}
			die;
		 }
		 function admin_init(){
		 	if(isset($_REQUEST['btn_nidsrfw_print'])){
				include_once("nidsrfw-daily-sales-report.php");
				$obj = new  NiDSRFW_daily_sales_report( );
				$obj->print_init();
				die;
			}
			
		 }
		 /*include all script*/
		 function admin_enqueue_scripts(){
			 
			 $page = sanitize_text_field(isset($_REQUEST["page"])?$_REQUEST["page"]:0);
			 if ($page  =="nidsrfw-daily-sales-report" || $page  == "nidsrfw-dashboard"){
				
				
				 wp_enqueue_script('jquery-ui-datepicker');
               
                wp_register_style('nidsrfw-jquery-ui', plugins_url('../admin/css/lib/jquery-ui.css', __FILE__));
                wp_enqueue_style('nidsrfw-jquery-ui');
				
				
				if ($page  == "nidsrfw-dashboard") {
					wp_register_style( 'nidsrfw-font-awesome-css', plugins_url( '../admin/css/font-awesome.css', __FILE__ ));
		 			wp_enqueue_style( 'nidsrfw-font-awesome-css' );
					
					wp_register_script( 'nidsrfw-amcharts-script', plugins_url( '../admin/js/amcharts/amcharts.js', __FILE__ ) );
					wp_enqueue_script('nidsrfw-amcharts-script');
				
		
					wp_register_script( 'nidsrfw-light-script', plugins_url( '../admin/js/amcharts/light.js', __FILE__ ) );
					wp_enqueue_script('nidsrfw-light-script');
				
					wp_register_script( 'nidsrfw-pie-script', plugins_url( '../admin/js/amcharts/pie.js', __FILE__ ) );
					wp_enqueue_script('nidsrfw-pie-script');
				}
				
				
				wp_register_style('nidsrfw-bootstrap-css', plugins_url('../admin/css/lib/bootstrap.min.css', __FILE__ ));
		 		wp_enqueue_style('nidsrfw-bootstrap-css' );
				
				wp_enqueue_script('nidsrfw-bootstrap-script', plugins_url( '../admin/js/lib/bootstrap.min.js', __FILE__ ));
				wp_enqueue_script('nidsrfw-popper-script', plugins_url( '../admin/js/lib/popper.min.js', __FILE__ ));
				 
			 	wp_enqueue_script('nidsrfw-daily-sales-report-script', plugins_url('../admin/js/nidsrfw-daily-sales-report.js', __FILE__), array('jquery'));
			 	
				
				wp_register_style('nidsrfw-style', plugins_url('../admin/css/nidsrfw-daily-sales-report.css', __FILE__ ));
		 		wp_enqueue_style('nidsrfw-style' );
				
				
				wp_enqueue_script('nidsrfw-script', plugins_url('../admin/js/script.js', __FILE__), array('jquery'));
             	wp_localize_script('nidsrfw-script', 'nidsrfw_ajax_object', array('nidsrfw_ajaxurl' => admin_url('admin-ajax.php')));
			 }
			 
		 }
	}	
}
?>