<?php 
global $wpdb;
$table_builder = $wpdb->prefix . "formed_builder";
$table_subs = $wpdb->prefix . "formed_submissions";

if (defined('MYMAIL_VERSION'))
{
	?>
	<style>	.mymail_email{display: block;}</style>
	<?php
}
else
{
	?>
	<style> .mymail_email { display: none !important; }</style>
	<?php
}

global $wpdb;
$id = addslashes($_GET['id']);

$qry = $wpdb->get_results( "SELECT * FROM $table_builder WHERE id = '$id'" );
if(count($qry)==0){echo "<h3>Invalid Form ID</h3>"; die();}

foreach ($qry as $row) {
	$build = stripcslashes($row->build);
	$options = stripcslashes($row->options);
	$con = stripcslashes($row->con);
	$rec = stripcslashes($row->recipients);
}
$conf = json_decode($con);

/////////////////// JavaScripts //////////////////////

?>
<script language="JavaScript">
	jQuery(document).ready(function() {

		var formfield;
		var formfield_url;

		jQuery('.cpicker').spectrum({
			showInput: true,
			showAlpha: true,
			clickoutFiresChange: true,
			preferredFormat: 'rgb',
			showButtons: false,
			change: function(color){
				jQuery(this).trigger('input');
			},
			move: function(color){
				jQuery(this).trigger('input');
			}
		});

		jQuery('.custom_css_text').keyup(function()
		{
			var abc = jQuery(this).val();
			jQuery('.custom_css_show').text('<style>'+abc+'</style>');
		})

		window.old_tb_remove = window.tb_remove;
		window.tb_remove = function() {
			window.old_tb_remove();
			formfield=null;
		};


		window.original_send_to_editor = window.send_to_editor;
		window.send_to_editor = function(html){
			if (formfield) {
				fileurl = jQuery('img',html).attr('src');
				jQuery(formfield).val(fileurl);
				jQuery(formfield).trigger('input');
				tb_remove();
			} else if (formfield_url) {
				fileurl = "url("+jQuery('img',html).attr('src')+")";
				jQuery(formfield_url).val(fileurl);
				jQuery(formfield_url).trigger('input');
				tb_remove();
			}
			else {
				window.original_send_to_editor(html);
			}
		};

	});
</script>

<div ng-app="compile" ng-controller="bob_the_builder" class="ffcover fc-common has-js">


	<table class='ff_c_t' cellspacing="0" cellpadding="0">
		<tr>
			<td style='width: 580px'>
				<div class="main_builder">
					<div class='build_affix' data-spy="affix" data-offset-top="0"><!-- Start of affixed Part -->

						<div class='head_holder'>
							<a class='button-primary' href='?page=formed_admin' style='width: 100px'>
								<i class='formed-left-open'></i>Dashboard
							</a>
							<a data-normal="Save" data-loading="Saving.." data-error='Retry' class='button-primary' ng-click='save()' id='save_form_btn' >Save</a>
							<a class="button-primary btn-toggle" data-toggle="collapse" href="#collapseOne">Options</a>
							<a class="button-primary btn-toggle" data-toggle="collapse" href="#collapseTwo">Styling</a>
						</div>

<?php include('inc/options.php');?>
<?php include('inc/style.php');?>
<?php include('inc/add_items.php');?>
<?php include('inc/item_editor.php');?>

							</div><!-- End of affixed Part -->
						</div><!-- End of Left Part -->
					</td>
					<td style='vertical-align: top'>
						<div class="preview_form">
	

	
 	
							<?php
							$form_uniq = "fcSTARTID".substr(rand(),0,5)."ENDID_$id";
							$rand2 = "anchor_".substr(rand(),0,5);
							?>
							
							<div class='html_here'>

							<?php $form_id = "123$id"; ?>
							<form id='<?php echo $form_uniq; ?>' class="a_<?php echo $form_id; ?> nform {{con[0].cl_hidden_fields}} {{con[0].direction}} {{con[0].theme}} {{con[0].number_spin}} {{con[0].check_no_conflict}} {{con[0].allow_multi}}star_{{con[0].show_star_validation}} {{con[0].flayout}} fc-common">
							<input type='hidden' class='form_id' val='<?php echo $id; ?>' ng-model='con[0].form_main_id'>
							<input type='hidden' class='getlocation' val='' name='location_hidden__0_0_1000_'>
							<a id='<?php echo $rand2; ?>_anchor'></a>
							<a href='#<?php echo $rand2; ?>_anchor' class='anchor_trigger'></a>
							<ul class='form_ul {{con[0].theme}}' id='form_ul'><li ng-repeat="el in build" id='fe_{{$index}}_<?php echo $form_id; ?>' class='nform_li' ng-class='[el.default, "fe_"+$index, "required-"+el.req]' scale><div class="clearfix" compile="el.el_f" ng-style='{marginBottom: el.divspa, marginTop: el.divspa}'></div><span class='element_id'>{{$index}}</span></ul><div id='fe_submit' class='form_submit'><div class='res_div'><span class='nform_res'></span></div><span style='text-align: center; display: inline; padding-top: 8px; padding-bottom: 4px'><!--START--><!--END--></span></div><input type='text' name='name' id='waspnet' value=''></form>
						</div>
					</div><!-- End of Right Part -->
				</td>
			</tr>
		</table>
	</div><!-- End of Cover -->