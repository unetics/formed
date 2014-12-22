<?php

if (function_exists('is_multisite') && is_multisite())
{
	$url = plugins_url("formed/file-upload/server/content/files/".$wpdb->blogid."/info.txt");					
}
else
{
	$url = plugins_url("formed/file-upload/server/content/files/info.txt");					
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$read = curl_exec($ch);
curl_close($ch);
$read = json_decode($read, 1);

$dir = get_home_path().'wp-content/plugins/formed/file-upload/server/php/files/';
$otherFiles = scandir($dir);
$extra=array();
$i = 1;
foreach ($otherFiles as $key => $value)
{
	if(substr($value, 0,1)=='.')continue;
	if($value=='info.txt')continue;
	if($value=='thumbnail')continue;
	$extra[$i]['name'] = $value;
	$extra[$i]['url'] = plugins_url("formed/file-upload/server/php/files/").$value;
	$i++;
}
unset($i);

?>

<div class='group_cover'>

	<span class='stat' style='border: none'>
		<span class='unr_msg' id='unr_ind'><?php echo sizeof($read['files'])?>
		</span> files&nbsp;&nbsp;
	</span>

	<div id='files_c' >
		<div class='subs_wrapper'>

			<table cellpadding='0' cellspacing='0' style='' class='table' id='files_manager_table'>
				<thead>
					<tr>
						<th width="20%">Name</th>
						<th width="10%">Size</th>
						<th width="59%">Url</th>
						<th width="6%">Delete</th>
					</tr>
				</thead>
				<?php
				foreach ($read as $key => $value) 
				{
					$value = json_decode($value,1);
					?>
					<tr>
						<td><?php echo $value['name']; ?></td>
						<td><?php echo round(($value['size']/1024),2); ?> KB</td>
						<td><a href='<?php echo $value['full-url']; ?>' target='_blank'><?php echo $value['full-url']; ?></a></td>
						<td><a class='btn-danger delete_from_manager' style='width: 38px' data-loading='...' data-key='<?php echo $value['new_name']; ?>' data-complete='<i class="formed-ok"></i>' id='del_fm_<?php echo $key ?>'><i class='formed-trash'></i></a></td>
					</tr>
					<?php } ?>

					<?php
					foreach ($extra as $key => $value) 
					{
						?>
						<tr>
							<td><?php echo $value['name']; ?></td>
							<td>?? KB</td>
							<td><a href='<?php echo $value['url']; ?>' target='_blank'><?php echo $value['url']; ?></a></td>
							<td><a class='btn-danger delete_from_manager' style='width: 38px' data-loading='...' data-name='<?php echo $value['name']; ?>' data-complete='<i class="formed-ok"></i>' id='del_fm_<?php echo $key ?>'><i class='formed-trash'></i></a></td>
						</tr>
						<?php } ?>									

					</table>
				</div>
			</div>
		</div>