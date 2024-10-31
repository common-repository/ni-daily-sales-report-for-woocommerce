<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'NiDSRFW_daily_sales_report' ) ) {
	class NiDSRFW_daily_sales_report{
		 /*Setting variable*/
		 var $nidsrfw_constant = array();  
		 public function __construct($nidsrfw_constant = array()){
			  $this->nidsrfw_constant = $nidsrfw_constant; 
			
		 }
		 /*Call the main function*/
		 function page_init(){
		     $start_date             =  sanitize_text_field(isset($_REQUEST["start_date"])?$_REQUEST["start_date"]:$this->get_today_date());
             $end_date               =  sanitize_text_field(isset($_REQUEST["end_date"])?$_REQUEST["end_date"]:$this->get_today_date());
			 
			
		 	?>
            <div class="container-fluid" id="nidsrfw">
            <form autocomplete="off" name="frm_daily_report" id="frm_daily_report">
            	<div class="row">
            	<div class="col-md-12"  style="padding:0px;">
					<div class="card" style="max-width:60% ">
						<div class="card-header nidsrfw-bg-c-deepPurple">
							<?php esc_html_e(  'Search Report'  ,'nidsrfw'); ?>
						</div>
						<div class="card-body">
							<div class="form-group row">
								<div class="col-sm-2">
									<label><?php esc_html_e(  'Start Date'  ,'nidsrfw'); ?></label>
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control _datepicker" name="start_date"  id="start_date" value="<?php   esc_html_e(    $start_date ); ?>" />
								</div>
								<div class="col-sm-2">
									<label><?php esc_html_e(  'End Date'  ,'nidsrfw'); ?></label>
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control _datepicker" name="end_date" id="end_date" value="<?php   esc_html_e(    $end_date ); ?>" >
								</div>
								
							</div>
							<div class="form-group row" style="display:none">
								<div class="col-sm-2">
									<label><?php esc_html_e(  'Order Status'  ,'nidsrfw'); ?></label>
								</div>
								<div class="col-sm-4">
									<select class="form-control" multiple >
										<option value="">Test 1</option>
										<option value="">Test 1</option>
										<option value="">Test 1</option>
										<option value="">Test 1</option>
									</select>
								</div>
								
							</div>
							
							<div class="form-group row">
								<div class="col-sm-12 text-right">
									<input type="submit" class="btn btn-primary buttontrets rounded-0 shadow " value="Search">
                                    <input type="button" class="btn btn-primary buttontrets rounded-0 shadow " value="reset" style="display:none">
								</div>
								
								
							</div>
						</div>
					</div>
				</div>	
			</div>
            <input type="hidden" name="action"  id="action" value="nidsrfw_ajax"/>
            <input type="hidden" name="sub_action" id="sub_action"  value="daily_report" />
            </form>
			
			
        	
            
			<div class="row">
				<div class="col-md-12"  style="padding:0px; max-width:60%">
					<div class="card">
                    	<div class="card-header nidsrfw-bg-c-pink">
							<?php esc_html_e(  'Sales Analysis'  ,'nidsrfw'); ?>
						</div>
						<div class="card-body">
							<div class="table-responsive  nidsrfw-table">
                            	
                                <div class="_nidsrfw_ajax_content"></div>
                                
                            </div>
							
						</div>
					</div>
				</div>
				</div>
        	</div>
            
            <?php
		 }
		  /*Order meta key*/
		 function get_order_meta_key(){
		 	$order_meta_key = array();
			
			$order_meta_key[] = "_order_total";
			$order_meta_key[] = "_cart_discount";
			$order_meta_key[] = "_cart_discount_tax";
			$order_meta_key[] = "_order_shipping";
			$order_meta_key[] = "_order_shipping_tax";
			$order_meta_key[] = "_order_tax";
			$order_meta_key[] = "_cart_discount";
				
			return apply_filters('nidsrfw_order_meta_key', $order_meta_key );
			
		 }
		 /*Get Summary Data*/
		 function get_data(){
		 	$new_data= array();
			$order_totals = $this->get_order_meta_query();
			$order_status  = $this->get_order_status_query();
			$product_line_total  =$this->get_product_line_total();
			$order_refund = $this->get_order_refund();
			
			if (count($order_totals)> 0)
			$new_data["order_total"] = array("title"=>"Order Totals", "data"=>$order_totals);
			if (count($order_status)> 0)
			$new_data["order_status"] = array("title"=>"Order Status", "data"=>$order_status);
			if (count($product_line_total)> 0)
			$new_data["product_line_total"] = array("title"=>"Product Line Total", "data"=>$product_line_total);
			if (count($order_refund)> 0)
			$new_data["refund_total"] = array("title"=>"Refund Total", "data"=>$order_refund);
			
			return $new_data;
		 }
		 /*Display Table*/
		 function get_data_table(){
			 
				$rows =  $this->get_data();
			 $start_date             =  sanitize_text_field(isset($_REQUEST["start_date"])?$_REQUEST["start_date"]:$this->get_today_date());
             $end_date               =  sanitize_text_field(isset($_REQUEST["end_date"])?$_REQUEST["end_date"]:$this->get_today_date());
			if (count($rows) > 0){
			?>
            
            <div class="text-right">
             <form method="post">
                        <input type="submit" value="Print"  class="btn btn-primary buttontrets rounded-0 shadow noprint" name="btn_nidsrfw_print" id="btn_nidsrfw_print" />
                        <input type="hidden" name="start_date" value="<?php echo $start_date ; ?>" />
                        <input type="hidden" name="end_date" value="<?php echo $end_date ; ?>" />
                      </form> 
            </div>
            
            
            
            <table class="table table-striped table-hover dashboard-task-infos">
            <?php
            foreach($rows as $key=>$value){
			?>
              <thead class="shadow-sm p-3 mb-5 bg-white rounded">
            <tr>
            	<th colspan="2" ><?php esc_html_e( $value["title"]); ?></th>
             </tr>
             </thead>
			
            <?php foreach($value["data"]  as $k=>$v): ?>
            	<tr>
            		<?php  switch($key):  case"a": break; ?>
                    	<?php case 'order_total': ?>
                        <?php case 'product_line_total': ?>
                        	<td><?php esc_html_e( ucwords( str_replace('_',' ', $v->meta_key))); ?></td>
                            <td><?php esc_html_e(  $v->meta_value); ?></td>     
                        <?php break;?>
                       <?php case 'order_status': ?>
                        	<td><?php esc_html_e(  ucwords( str_replace('-',' ',  str_replace('wc-',' ', $v->meta_key)  ))); ?></td>
                            <td><?php esc_html_e(  $v->meta_value); ?></td>     
                       <?php break;?> 
                     <?php default: ?>
                     	 	<td><?php esc_html_e(  ucwords($v->meta_key)); ?></td>
		 	                <td><?php esc_html_e( $v->meta_value); ?></td>     
                    <?php  endswitch; ?>
             	</tr>
             <?php endforeach; ?>
			<?php
			
			}
			?>
            </table>
            <?php
			}else{
				
			esc_html_e(  'No record found'  ,'nidsrfw');
			}
		
			 
			
			//$this->prettyPrint($new_data);
		 }
		 /*Handle all ajax request*/
		 function ajax_init(){
			$this->get_data_table(); 
			die;;
		 }
		 /*Get Query*/
		 function get_order_meta_query(){
		 	global $wpdb;
			
			$order_meta_key = $this->get_order_meta_key();
			$order_meta_key_string = "'" . implode ( "', '", $order_meta_key ) . "'";
			
			$start_date             =  sanitize_text_field(isset($_REQUEST["start_date"])?$_REQUEST["start_date"]:$this->get_today_date());
             $end_date               =  sanitize_text_field(isset($_REQUEST["end_date"])?$_REQUEST["end_date"]:$this->get_today_date());
			
			$query = '';
			$query .= "SELECT ROUND(SUM( postmeta.meta_value ),2) as meta_value, postmeta.meta_key FROM {$wpdb->prefix}posts as posts";
			
			$query .= " LEFT JOIN  {$wpdb->prefix}postmeta as postmeta ON postmeta.post_id=posts.ID"; 
			
			$query .= " WHERE 1 = 1";
			$query .= " AND posts.post_type ='shop_order'";
			
			$query .= " AND postmeta.meta_key  IN  ({$order_meta_key_string })";
			
			$query .= " AND date_format( posts.post_date, '%Y-%m-%d') BETWEEN  '{$start_date}' AND '{$end_date }'";	
			
			$query .= " AND posts.post_status NOT IN ('auto-draft','inherit')";
			
			$query .= " GROUP BY  postmeta.meta_key  ";
			
			
			//echo $query;
			$rows = $wpdb->get_results($query );
			
			//$this->prettyPrint($rows);
			return $rows;
			
		 }
		
		 /*Get order status query*/
		 function get_order_status_query(){
			 global $wpdb;
			
			$start_date             =  sanitize_text_field(isset($_REQUEST["start_date"])?$_REQUEST["start_date"]:$this->get_today_date());
             $end_date               =  sanitize_text_field(isset($_REQUEST["end_date"])?$_REQUEST["end_date"]:$this->get_today_date());
			
			$query = '';
			$query .= "SELECT posts.post_status as meta_key, ROUND(SUM( order_total.meta_value ),2) as meta_value FROM {$wpdb->prefix}posts as posts";
			
			$query .= " LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID"; 
			
			$query .= " WHERE 1 = 1";
			$query .= " AND posts.post_type ='shop_order'";
			
			$query .= " AND order_total.meta_key  IN  ('_order_total')";
			
			$query .= " AND date_format( posts.post_date, '%Y-%m-%d') BETWEEN  '{$start_date}' AND '{$end_date }'";	
				$query .= " AND posts.post_status NOT IN ('auto-draft','inherit')";
			$query .= " GROUP BY  posts.post_status   ";
			
			
			//echo $query;
			$rows = $wpdb->get_results($query );
			
			//$this->prettyPrint($rows);
			return $rows;
		 }
		 /*Product Line Total*/
		 function get_product_line_total(){
		 	 global $wpdb;
			
			$start_date             =  sanitize_text_field(isset($_REQUEST["start_date"])?$_REQUEST["start_date"]:$this->get_today_date());
             $end_date               =  sanitize_text_field(isset($_REQUEST["end_date"])?$_REQUEST["end_date"]:$this->get_today_date());
			
			$query = '';
				$query .= "SELECT ROUND(SUM( order_itemmeta.meta_value ),2) as meta_value, order_itemmeta.meta_key FROM {$wpdb->prefix}posts as posts";
			
			$query .= " LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as order_items ON order_items.order_id=posts.ID";
			$query .= " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as order_itemmeta ON order_itemmeta.order_item_id=order_items.order_item_id"; 
			
			$query .= " WHERE 1 = 1";
			$query .= " AND posts.post_type ='shop_order'";
			$query .= " AND order_items.order_item_type ='line_item'";
			
			$query .= " AND order_itemmeta.meta_key  IN  ('_line_total','_line_subtotal')";
			
			
			$query .= " AND date_format( posts.post_date, '%Y-%m-%d') BETWEEN  '{$start_date}' AND '{$end_date }'";	
				$query .= " AND posts.post_status NOT IN ('auto-draft','inherit')";
			$query .= " GROUP BY order_itemmeta.meta_key    ";
			
			
			//echo $query;
			$rows = $wpdb->get_results($query );
			
			//$this->prettyPrint($rows);
			return $rows;
		 }
		 function get_order_refund(){
		 	global $wpdb;
		
			$start_date             =  sanitize_text_field(isset($_REQUEST["start_date"])?$_REQUEST["start_date"]:$this->get_today_date());
            $end_date               =  sanitize_text_field(isset($_REQUEST["end_date"])?$_REQUEST["end_date"]:$this->get_today_date());
			
			$query = '';
			$query .= "SELECT 'refund' as meta_key, ROUND(SUM( order_total.meta_value ),2) as meta_value FROM {$wpdb->prefix}posts as posts";
			
			$query .= " LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID"; 
			
			$query .= " WHERE 1 = 1";
			$query .= " AND posts.post_type ='shop_order_refund'";
			
			$query .= " AND order_total.meta_key  IN  ('_order_total')";
			
			$query .= " AND date_format( posts.post_date, '%Y-%m-%d') BETWEEN  '{$start_date}' AND '{$end_date }'";	
				$query .= " AND posts.post_status NOT IN ('auto-draft','inherit')";
			$query .= " GROUP BY  posts.post_status   ";
			
			
		
			$rows = $wpdb->get_results($query );
			//$this->prettyPrint($rows);
			return $rows;
		 }
		 /*Get To date*/
		 function get_today_date() {

            return  date_i18n("Y-m-d");
         }
		 function get_dswc_price($wc_price){
			 $new_wc_price = 0;
			 if ($wc_price){
			 	 $new_wc_price  = wc_price($wc_price);
			 }
			 
			 return $new_wc_price;
		 }
		 /*Print array*/
		 function prettyPrint($a, $t='pre') {echo "<$t>".print_r($a,1)."</$t>";}
		 function print_init(){
		?>
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Print</title>
                <link rel='stylesheet' id='sales-report-style-css-bootstrap'  href='<?php echo  plugins_url( '../admin/css/lib/bootstrap.min.css', __FILE__ ); ?>' type='text/css' media='all' />
                <link rel='stylesheet' id='sales-report-style-css'  href='<?php echo  plugins_url( '../admin/css/nidsrfw-daily-sales-report.css', __FILE__ ); ?>' type='text/css' media='all' />
                
                </head>
                
                <body>
                 <div class="container-fluid" id="niwoosalesreport">
                    <?php 
                         $this->get_data_table(); 
                    ?>
                  <div class="print_hide" style="text-align:right; margin-top:15px"><input type="button" value="Back" onClick="window.history.go(-1)" class="btn btn-primary buttontrets rounded-0 shadow noprint"> <input type="button" class="btn btn-primary buttontrets rounded-0 shadow noprint" value="Print this page" onClick="window.print()">	</div>
                 </div>
                </body>
                </html>
        
            <?php
		 }
	}
	
}
?>