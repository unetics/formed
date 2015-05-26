<div class='group_cover'>
	<div style='border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 10px'>
		<span class='stat'>
			<span class='unr_msg' id='unr_ind'><?php echo $totalSubAll-$totalSubSeen; ?>
			</span> unread&nbsp;&nbsp;
			<span class='tot_msg' id='tot_ind'><?php echo $totalSubAll; ?>
			</span> total	
		</span>
		<span class='stat'>
			<span class='unr_msg'><?php echo $totalSubAllToday; ?>
			</span> new today&nbsp;&nbsp;
			<span class='tot_msg'><?php echo $totalSubAllMonth; ?>
			</span> new this month
		</span>

		<span style='display: inline-block'>
			<strong>Export Submissions for </strong>
			<select id='export_select' style='height: 33px; min-width: 140px'>
				<option value='0'>All Forms</option>
				<?php foreach ($myrows as $row) { ?>
				<option value='<?php echo $row->id; ?>'><?php echo $row->name; ?></option>
				<?php } ?>
			</select>
			<a target='_blank' id='export_url' href='<?php echo plugins_url('/formed/php/export.php?id=0'); ?>' class='fc-btn'>export</a>					
		</span>
	</div>

	<div id='subs_c' >

		<div class='fc_pagination'>

			<?php

			$pages = ceil($totalSubAll / 10);
			$i = 1;

			while ($i<=$pages)
			{
				echo "<span class='page' id='fc-page-$i'>$i</span>" ;
				$i++;
			}

			?>

		</div>

		<table style='' class='table' id='subs' cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th width="10%" title='Click to sort'>ID</th>
					<th width="10%" title='Click to sort'>Read</th>
					<th width="20%" title='Click to sort'>Date</th>
					<th width="30%" title='Click to sort'>Form Name</th>
					<th width="20%" title='Click to sort'>Message</th>
					<th width="10%" title='Click to sort'>Options</th>
				</tr>
			</thead>
			<tbody>				
				<?php
					foreach ($mysub as $sub) {
						echo('<tr>');
					echo('<td>'.$sub['id'].'</td>');
					echo('<td>'.$sub['seen'].'</td>');
					echo('<td>'.$sub['added'].'</td>');
					echo('<td>'.$sub['form_id'].'</td>');
					echo('<td>'.$sub['content'].'</td>');
					echo('<td>delete</td>');
					echo('</tr>');
					
					}
					?>
			</tbody>
		</table>
	</div>
</div>
