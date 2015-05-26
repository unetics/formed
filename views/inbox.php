<?php
global $wpdb, $fc_mse;

$table_builder = $wpdb->prefix . "formed_builder";
$table_subs = $wpdb->prefix . "formed_submissions";

$today_is = date('d M Y ');
$month_is = date('M Y ');

$myrows = $wpdb->get_results( "SELECT id,name,description,added,views,submits FROM $table_builder ORDER BY id" );	

$totalSubAll = $wpdb->get_results( "SELECT COUNT(*) FROM $table_subs", 'ARRAY_A' );
$totalSubAllToday = $wpdb->get_results( "SELECT COUNT(*) FROM $table_subs WHERE added LIKE '$today_is%' ", 'ARRAY_A' );
$totalSubAllMonth = $wpdb->get_results( "SELECT COUNT(*) FROM $table_subs WHERE added LIKE '%$month_is%' ", 'ARRAY_A' );
$totalSubSeen = $wpdb->get_results( "SELECT COUNT(*) FROM $table_subs WHERE seen='1'", 'ARRAY_A' );

$totalSubAll = intval($totalSubAll[0]['COUNT(*)']);
$totalSubAllToday = intval($totalSubAllToday[0]['COUNT(*)']);
$totalSubAllMonth = intval($totalSubAllMonth[0]['COUNT(*)']);
$totalSubSeen = intval($totalSubSeen[0]['COUNT(*)']);

$mysub = $wpdb->get_results( "SELECT * FROM $table_subs ORDER BY id LIMIT 0,10", 'ARRAY_A' );
$mysubr = $wpdb->get_results( "SELECT * FROM $table_subs WHERE seen='1'", 'ARRAY_A' );
?>

<div class="ffcover_add fc-common">
	<?php 
		include_once('inc/new_form_modal.php');
	
	$saw['today'] = 0;
	$saw['month'] = 0;

	foreach ($mysub as $key => $row) 
	{

		$dt = date_parse($row['added']);
		$date = date_parse(date('d M Y (H:m)'));

		if ($dt['month']==$date['month'] && $dt['day']==$date['day'] && $dt['year']==$date['year'])
		{
			$saw['today']++;
		}
		if ($dt['month']==$date['month'] && $dt['year']==$date['year'])
		{
			$saw['month']++;
		}
	} 
?>

	<div class="tab-content">
		<?php
		include_once('inc/submissions_tab.php');
		?>
	</div>
</div><!-- End of Cover -->

<?php include_once('inc/submissions_modal.php'); ?>
