<?php
	require_once 'anet_php_sdk/AuthorizeNet.php'; // Path to AuthorizeNet.php
	include '../../../../wp-load.php';
	$text_widgets = get_option( 'widget_authorizesim' );
	$first = true;
	foreach ( $text_widgets as $widget => $value) {
		$loginID = $value['loginID'];
		$transactionKey = $value['transactionKey'];
		if ($first) {
			echo AuthorizeNetSIM_Form::getFingerprint(
			$loginID,
			$transactionKey,
			$_POST['amount'],
			$_POST['sequence'],
			$_POST['time']
			);
		}
	}
?>