<?php

/**

 * Plugin Name: Authorize.net SIM

 * Version: 1.0

 * Author: <a href="http://www.jamesnorthard.com">James Northard</a>

 * Author URI: http://www.jamesnorthard.com

 * Description: Displays form for Authorize.net Server Intergration Method (SIM). An Authorize.net account (Login ID and Transaction Key) is required.

 **/
 

// Initialize jQuery if it is not already loaded
function add_jQuery_libraries() {
 
    // Registering Scripts
     wp_register_script('google-hosted-jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js', false);
     wp_register_script('jquery-validation-plugin', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js', array('google-hosted-jquery'));

    // Enqueueing Scripts to the head section
	if (!is_admin()) {
		wp_enqueue_script('google-hosted-jquery');
		wp_enqueue_script('jquery-validation-plugin');
	}
}

add_action( 'wp_enqueue_scripts', 'add_jQuery_libraries' );

// Authorization Requirements



// Register the widget with Wordpress
add_action( 'widgets_init', 'AuthorizeSIM' );


function AuthorizeSIM() {

	register_widget( 'AuthorizeSIM' );

}



class AuthorizeSIM extends WP_Widget {



function AuthorizeSIM() {



	$widget_ops = array(

		'classname' => 'AuthorizeSIM',

		'description' => __('Display Authorize.net SIM widget', 'authorizesim')

	);



	$this->WP_Widget( 'AuthorizeSIM', __('Authorize SIM', 'authorizesim'), $widget_ops );

	

}





//	Outputs the options form on admin

function form( $instance ) {

	$defaults = array(

		'formurl' => 'https://secure.authorize.net/gateway/transact.dll',

		'loginID' => '',

		'transactionKey' => '',

		'title' => 'Make a Payment',

		'x_customer_id' => 'Customer ID',

		'x_customer_id_check' => 'true',

		'x_invoice_num' => 'Invoice #',

		'x_invoice_num_check' => 'true',

		'x_description' => 'Description',

		'x_description_check' => 'true',

		'x_test_request' => 'false',

		'x_button_title' => 'Submit'

	);

	$instance = wp_parse_args( (array) $instance, $defaults );

	$x_test_request = isset( $instance['x_test_request'] ) ? $instance['x_test_request'] : 'true'; ?>



	<p>

		<label for="<?php echo $this->get_field_id( 'formurl' ); ?>"><?php _e('Authorize.net Form URL:', 'authorizesim') ?></label>

		<input class="widefat" id="<?php echo $this->get_field_id( 'formurl' ); ?>" name="<?php echo $this->get_field_name( 'formurl' ); ?>" value="<?php echo $instance['formurl']; ?>" />

	</p>

    

    <p>

		<label for="<?php echo $this->get_field_id( 'loginID' ); ?>"><?php _e('Login ID:', 'authorizesim') ?></label>

		<input class="widefat" id="<?php echo $this->get_field_id( 'loginID' ); ?>" name="<?php echo $this->get_field_name( 'loginID' ); ?>" value="<?php echo $instance['loginID']; ?>" />

	</p>

    

    <p>

		<label for="<?php echo $this->get_field_id( 'transactionKey' ); ?>"><?php _e('Transaction Key:', 'authorizesim') ?></label>

		<input class="widefat" id="<?php echo $this->get_field_id( 'transactionKey' ); ?>" name="<?php echo $this->get_field_name( 'transactionKey' ); ?>" value="<?php echo $instance['transactionKey']; ?>" />

	</p>

    

	<p>

		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'authorizesim') ?></label>

		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />

	</p>

	

	<p>

		<label for="<?php echo $this->get_field_id( 'x_customer_id' ); ?>"><?php _e('Customer ID Title:', 'authorizesim') ?></label>

		<input class="widefat" id="<?php echo $this->get_field_id( 'x_customer_id' ); ?>" name="<?php echo $this->get_field_name( 'x_customer_id' ); ?>" value="<?php echo $instance['x_customer_id']; ?>" />

        <p align="right">Display Customer ID: <input type="checkbox" value="true" id="<?php echo $this->get_field_id( 'x_customer_id_check' ); ?>" name="<?php echo $this->get_field_name( 'x_customer_id_check' ); ?>" <?php  if( $instance['x_customer_id_check']=="true") { echo "checked"; } ?>></p>

	</p>

    

    <p>

		<label for="<?php echo $this->get_field_id( 'x_invoice_num' ); ?>"><?php _e('Invoice # Title:', 'authorizesim') ?></label>

		<input class="widefat" id="<?php echo $this->get_field_id( 'x_invoice_num' ); ?>" name="<?php echo $this->get_field_name( 'x_invoice_num' ); ?>" value="<?php echo $instance['x_invoice_num']; ?>" />

        <p align="right">Display Invoice #: <input type="checkbox" value="true" id="<?php echo $this->get_field_id( 'x_invoice_num_check' ); ?>" name="<?php echo $this->get_field_name( 'x_invoice_num_check' ); ?>" <?php  if( $instance['x_invoice_num_check']=="true") { echo "checked"; } ?>></p>

	</p>

    

    <p>

		<label for="<?php echo $this->get_field_id( 'x_description' ); ?>"><?php _e('Descripion Title:', 'authorizesim') ?></label>

		<input class="widefat" id="<?php echo $this->get_field_id( 'x_description' ); ?>" name="<?php echo $this->get_field_name( 'x_description' ); ?>" value="<?php echo $instance['x_description']; ?>" />

        <p align="right">Display Invoice #: <input type="checkbox" value="true" id="<?php echo $this->get_field_id( 'x_description_check' ); ?>" name="<?php echo $this->get_field_name( 'x_description_check' ); ?>" <?php  if( $instance['x_description_check']=="true") { echo "checked"; } ?>></p>

	</p>

    

    <p>

		<label for="<?php echo $this->get_field_id( 'x_test_request' ); ?>"><?php _e('Test Request:', 'authorizesim') ?></label>

        <select id="<?php echo $this->get_field_id( 'x_test_request' ); ?>" name="<?php echo $this->get_field_name( 'x_test_request' ); ?>"><option value="true" <?php selected($x_test_request,'true');?>>true</option><option value="false" <?php selected($x_test_request,'false');?>>false</option></select>

	</p>



    <p>

		<label for="<?php echo $this->get_field_id( 'x_button_title' ); ?>"><?php _e('Submit Button Title:', 'authorizesim') ?></label>

		<input class="widefat" id="<?php echo $this->get_field_id( 'x_button_title' ); ?>" name="<?php echo $this->get_field_name( 'x_button_title' ); ?>" value="<?php echo $instance['x_button_title']; ?>" />

	</p>



	<?php

	}



//	Processes widget options to be saved

	

function update( $new_instance, $old_instance ) {

	$instance = $old_instance;



	$instance['title'] = strip_tags( $new_instance['title'] );

	$instance['formurl'] = strip_tags( $new_instance['formurl'] );

	$instance['loginID'] = strip_tags( $new_instance['loginID'] );

	$instance['transactionKey'] = strip_tags( $new_instance['transactionKey'] );

	$instance['x_customer_id'] = strip_tags( $new_instance['x_customer_id'] );

	$instance['x_customer_id_check'] = strip_tags( $new_instance['x_customer_id_check'] );

	$instance['x_invoice_num'] = stripslashes( $new_instance['x_invoice_num']);

	$instance['x_invoice_num_check'] = strip_tags( $new_instance['x_invoice_num_check'] );

	$instance['x_description'] = strip_tags( $new_instance['x_description'] );

	$instance['x_description_check'] = strip_tags( $new_instance['x_description_check'] );

	$instance['x_test_request'] = strip_tags( $new_instance['x_test_request'] );

	$instance['x_button_title'] = stripslashes( $new_instance['x_button_title']);



	return $instance;

}



//	Outputs the content of the widget

	

function widget( $args, $instance ) {

	extract( $args );

	$title = $instance['title'];

	$formurl = $instance['formurl'];

	$loginID = $instance['loginID'];

	$transactionKey = $instance['transactionKey'];

	$x_customer_id = $instance['x_customer_id'];

	$x_customer_id_check = $instance['x_customer_id_check'];

	$x_invoice_num = $instance['x_invoice_num'];

	$x_invoice_num_check = $instance['x_invoice_num_check'];

	$x_description = $instance['x_description'];

	$x_description_check = $instance['x_description_check'];

	$x_test_request = $instance['x_test_request'];

	$x_button_title = $instance['x_button_title'];

	$invoice	= date(YmdHis);

	$x_fp_sequence	= rand(1, 1000);

	$x_fp_timestamp	= time();



	echo $before_widget;

	echo '<h3>' . $title . '</h3>';

	echo '<table cellspacing="5">';

	echo '<form method="post" id="authorizesim" action="' . $formurl . '">';

	echo '<input type="hidden" name="x_login" value="' . $loginID . '" />';

	echo '<input type="hidden" name="transactionKey" value="' . $transactionKey . '" />';

	echo '<tr><td>First Name:&nbsp;</td><td><input type="text" name="x_first_name" required  id="x_first_name" value="" /></td></tr>';

	echo '<tr><td>Last Name:&nbsp;</td><td><input type="text" name="x_last_name" required id="x_last_name" value="" /></td></tr>';
	
	echo '<tr><td>Amount:&nbsp;</td><td><input type="text" class="amount" name="x_amount" required id="x_amount" value="" /></td></tr>';

	if   ($x_description_check ==="true")  {echo '<tr><td>' . $x_description . ':&nbsp;</td><td><input type="text" name="x_description" value="" /></td></tr>';}

	if   ($x_customer_id_check ==="true")  {echo '<tr><td>' . $x_customer_id . ':&nbsp;</td><td><input type="text" name="x_cust_id" value="" /></td></tr>';}

	if   ($x_invoice_num_check ==="true")  {echo '<tr><td>' . $x_invoice_num . ':&nbsp;</td><td><input type="text" name="x_invoice_num" value="" /></td></tr>';}
	
	echo '<tr style="display:none;" id="agreement"><td colspan="2"><input type="checkbox" id="agree" required name="agree" /> <div id="display" style="display:inline;"></div></td></tr>';

	echo '<input type="hidden" name="x_fp_sequence" value="' . $x_fp_sequence . '" />';

	echo '<input type="hidden" name="x_fp_timestamp" value="' . $x_fp_timestamp . '" />';

	echo '<input type="hidden" name="x_fp_hash" value="' . $fingerprint . '" />';

	echo '<input type="hidden" name="x_test_request" value="' . $x_test_request . '" />';

	echo '<input type="hidden" name="x_show_form" value="PAYMENT_FORM" />';

	echo '<tr><td colspan="2" align="center" style="text-align:center !important;"><input type="submit" name="submit" value="' . $x_button_title . '" /></td></tr>';

	echo '</form>';

	echo '</table>';

	echo $after_widget;

	
	/*$text_widgets = get_option( 'widget_authorizesim' );
	//echo var_dump($text_widgets);
	
	foreach ( $text_widgets as $widget => $value) {
		$loginID = $value['loginID'];
		$transactionKey = $value['transactionKey'];
		echo $loginID;
		echo $transactionKey;
		}*/
	
	
	//$no_exists_value = get_option( 'widget_authorizesim' );
	//print_r( $no_exists_value )['2']['loginID'];
	//echo $no_exists_valuep['2']['loginID'];
	//echo $no_exists_value;
	
    echo "<script type=\"text/javascript\">
		function update(){
			jQuery('#display')
				.text('I, ' + jQuery('#x_first_name').val() + jQuery('#x_last_name').val() + ', authorize a charge to my banking account for the amount of $' + jQuery('#x_amount').val() + '.');
			}
		jQuery('#x_amount').keyup(update);
		jQuery('#x_amount').keyup(
			function()
				{
					jQuery('#agreement').show();
				}
			);

        jQuery(document).ready(function() {

                loginID = jQuery('[name=x_login]').val(),

				transactionKey = jQuery('[name=transactionKey]').val(),

				fingerprint = jQuery('[name=x_fp_hash]'),

                timestamp = jQuery('[name=x_fp_timestamp]').val(),

                sequence = jQuery('[name=x_fp_sequence]').val();

            

            // This is the function that loads the Authorize.net fingerprint

            var getFingerprint = function() {

            	total = jQuery('[name=x_amount]').val();

				

                // Get a new fingerprint

                jQuery.post(

                    '".plugins_url( 'inc/fingerprint.php' , __FILE__ )."',

                    {

                        'api_login_id': loginID,

						'transaction_key': transactionKey,

						'amount': total,

                        'time': timestamp,

                        'sequence': sequence

                    },

                    function(data) {

                        // Use the returned value to update the form

                        fingerprint.val(data);

                    }

                );

            }

            

            // Update the fingerprint when an option is selected/deselected

            jQuery('.amount').blur(getFingerprint);
			jQuery('#authorizesim').validate();
			
        });

    </script>";

	}

}



/*******SHORTCODE*******/

function authorize_func( $atts ) {

	extract( shortcode_atts( array(

		'formurl' => 'https://secure.authorize.net/gateway/transact.dll',

		'loginid' => 'Login ID',

		'transactionkey' => 'Transaction Key',

		'title' => 'Make a Payment',

		'customer_id' => 'Customer ID',
		
		'show_customer_id' => 'Y',

		'invoice_num' => 'Invoice #',
		
		'show_invoice_num' => 'Y',

		'description' => 'Description',
		
		'show_description' => 'Y',

		'test_request' => 'false',

		'button_title' => 'Submit'

	), $atts ) );

	$x_fp_sequence	= rand(1, 1000);

	$x_fp_timestamp	= time();
	
	if ($show_description == 'N') {$show_description = 'style=\'display:none;\'';} else {$show_description = 'style=\'display:table-row;\'';}
	if ($show_invoice_num == 'N') {$show_invoice_num = 'style=\'display:none;\'';} else {$show_invoice_num = 'style=\'display:table-row;\'';}
	if ($show_customer_id == 'N') {$show_customer_id = 'style=\'display:none;\'';} else {$show_customer_id = 'style=\'display:table-row;\'';}

	return "

		<h3>{$title}</h3>

		<table cellspacing='5'>

			<form method='post' id='authorizesim' action='{$formurl}'>

				<input type='hidden' name='x_login' value='{$loginid}' />

				<input type='hidden' name='transactionKey' value='{$transactionkey}' />

				<tr><td>First Name:&nbsp;</td><td><input type='text' name='x_first_name' required id='x_first_name' value='' /></td></tr>

				<tr><td>Last Name:&nbsp;</td><td><input type='text' name='x_last_name' required id='x_last_name' value='' /></td></tr>

				<tr><td>Amount:&nbsp;</td><td><input type='text' class='amount' name='x_amount' required id='x_amount' value='' /></td></tr>

				<tr {$show_description}><td>{$description}:&nbsp;</td><td><input type='text' name='x_description' value='' /></td></tr>

				<tr {$show_customer_id}><td>{$customer_id} :&nbsp;</td><td><input type='text' name='x_cust_id' value='' /></td></tr>

				<tr {$show_invoice_num}><td>{$invoice_num} :&nbsp;</td><td><input type='text' name='x_invoice_num' value='' /></td></tr>
				
				<tr style='display:none;' id='agreement'><td colspan='2'><input type='checkbox' id='agree' required name='agree' /> <div id='display' style='display:inline;'></div></td></tr>

				<input type='hidden' name='x_fp_sequence' value='".$x_fp_sequence."' />

				<input type='hidden' name='x_fp_timestamp' value='".$x_fp_timestamp."' />

				<input type='hidden' name='x_fp_hash' value='' />

				<input type='hidden' name='x_test_request' value='{$test_request}' />

				<input type='hidden' name='x_show_form' value='PAYMENT_FORM' />

				<tr><td colspan='2' align='center' style='text-align:center !important;'><input type='submit' name='submit' value='{$button_title}' /></td></tr>

			</form>

		</table>

		<script type=\"text/javascript\">
		function update(){
			jQuery('#display')
				.text('I, ' + jQuery('#x_first_name').val() + jQuery('#x_last_name').val() + ', authorize a charge to my banking account for the amount of $' + jQuery('#x_amount').val() + '.');
			}
		jQuery('#x_amount').keyup(update);
		jQuery('#x_amount').keyup(
			function()
				{
					jQuery('#agreement').show();
				}
			);

        jQuery(document).ready(function() {
			
                loginID = jQuery('[name=x_login]').val(),

				transactionKey = jQuery('[name=transactionKey]').val(),

				fingerprint = jQuery('[name=x_fp_hash]'),

                timestamp = jQuery('[name=x_fp_timestamp]').val(),

                sequence = jQuery('[name=x_fp_sequence]').val();

            

            // This is the function that loads the Authorize.net fingerprint

            var getFingerprint = function() {

            	total = jQuery('[name=x_amount]').val();

				

                // Get a new fingerprint

                jQuery.post(

                    '".plugins_url( 'inc/fingerprint.php' , __FILE__ )."',

                    {

                        'api_login_id': loginID,

						'transaction_key': transactionKey,

						'amount': total,

                        'time': timestamp,

                        'sequence': sequence

                    },

                    function(data) {

                        // Use the returned value to update the form

                        fingerprint.val(data);

                    }

                );

            }

            

            // Update the fingerprint when an option is selected/deselected

            jQuery('.amount').blur(getFingerprint);
			
			jQuery('#authorizesim').validate();
        });

       </script>

	";

}

add_shortcode( 'authorize', 'authorize_func' );

?>