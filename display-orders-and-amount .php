<?php
/**
 * Plugin Name: Display Orders and Amount 
 * Description: Adds the [wc_order_count] OR [user_on_hold_total] OR [user-total-amount] OR [user_order_counts] (for only user) shortcode to display the total number of orders placed on your site.
 * Author: Sajid Hunxai
 * Author URI: http://www.fiverr.com/sajidhunxai
 * Version: 1.0.0
 *
 * GitHub Plugin URI: sajidhunxai/Display Orders and Amount 
 * GitHub Branch: master
 *
 * Copyright: (c) 2021-2022 Login Solution, Inc. (bc180402683@vu.edu.pk)
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package   Display Orders and Amount 
 * @author    Sajid Hunxai
 * @category  Admin
 * @copyright Copyright: (c) 2021-2022 Login Solution, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 *
 */


defined( 'ABSPATH' ) or exit;


/**
 * Plugin Description
 *
 * Adds a shortcode to display the total number of orders on your shop (defaults to completed orders)
 * The shortcode can accept the optional 'status' attribute to display the total number of orders with the included statuses.
 *
 * Use [wc_order_count status="completed,pending"] to display the total for completed and processing orders
 *
 */

function display_woocommerce_order_count( $atts, $content = null ) {

	$args = shortcode_atts( array(
		'status' => 'refunded',
		'date_created'=> $initial_date .'...'. $final_date,
	), $atts );

	$statuses    = array_map( 'trim', explode( ',', $args['status'] ) );
	$order_count = 0;
	$user_id = get_current_user_id(); 

	if($user_id ==! null){
	foreach ( $statuses as $status ) {


		if ( 0 !== strpos( $status, 'wc-' ) ) {
			$status = 'wc-' . $status;
		}

		$order_count += wp_count_posts( 'shop_order' )->$status;
	}
	}else{
		return $order_count = 0;
	}
	ob_start();

	echo number_format( $order_count );

	return ob_get_clean();
}
add_shortcode( 'wc_order_count', 'display_woocommerce_order_count' );


function get_user_orders_on_hold_total() {
    $total_amount = 0; // Initializing
	$initial_date = $_POST['datefrom'];
	$final_date = $_POST['dateto'];
	$user_id = get_current_user_id(); 
	if($user_id ==! null){
    // Get current user
    if( ($user = wp_get_current_user()) ==! null ){

        // Get 'on-hold' customer ORDERS
        $on_hold_orders = wc_get_orders( array(
            'limit' => -1,
            'customer_id' => $user->ID,
			'date_created'=> $initial_date .'...'. $final_date,
            'status' => 'on-hold',
        ) );
		

        foreach( $on_hold_orders as $order) {
            $total_amount += $order->get_total();
        }
     return $total_amount;
	}
	}else{
		return $total_amount= 0;
	}
   
}
add_shortcode('user_on_hold_total', 'get_user_orders_on_hold_total');
add_shortcode('user-total-amount', 'get_customer_total_order');
 function get_customer_total_order() {
	  $total_amount = 0; // Initializing
	$initial_date = $_POST['datefrom'];
	$final_date = $_POST['dateto'];
	
	$user_id = get_current_user_id(); 
	if($user_id ==! null){
    // Get current user
    if( ($user = wp_get_current_user()) ==! null ){

        // Get 'on-hold' customer ORDERS
        $on_hold_orders = wc_get_orders( array(
            'limit' => -1,
            'customer_id' => $user->ID,
			'date_created'=> $initial_date .'...'. $final_date,
            'status' => 'on-completed',
        ) );
		

        foreach( $on_hold_orders as $order) {
            $total_amount += $order->get_total();
        }
     return $total_amount;
	}
	}else{
		return $total_amount= 0;
	}
   
}
//order count
function get_order_count_for_user() {
	$user_id = get_current_user_id(); 

	$result = wc_get_customer_order_count( $user_id ); 

	return $result;

}
add_shortcode( 'user_order_counts', 'get_order_count_for_user' );
