<div class='group_cover'>
	
	<a class='fc-btn large' style='margin: 10px' data-target="#new_form" data-toggle="fcmodal">Add Form</a>	
			
	<div id='existing_forms'>
		<div class='subs_wrapper'>
			<table style='' class='table' id='ext' cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th width='1%' style='text-align: center; width: 5px'>ID</th>
						<th width='29%'>Name of Form</th>
						<th width='29%'>Description</th>
						<th width='7%' style='text-align: center'>Views</th>
						<th width='10%' style='text-align: center'>Submissions</th>
						<th width='13%' style='text-align: center'>Date Added</th>
						<th width='5%' style='text-align: center'></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($myrows as $row) {
						?>
						<tr id='<?php echo $row->id; ?>'>
							<td class='row_click' style='text-align: center'><?php echo $row->id; ?></td>

							<td class='row_click'><a class='rand' href='admin.php?page=formed_admin&id=<?php echo $row->id; ?>'><?php echo $row->name; ?></a><input class="rand2" style="width: 110px; display:none; margin-right: 6px" type="text" value="<?php echo $row->name; ?>"><a class='btn edit_btn' title='Edit Form Name' id='edit_<?php echo $row->id; ?>'>edit name</a><a class='btn save_btn' id='edit_<?php echo $row->id; ?>'>save</a></td>

							<td class='row_click row_description'><a  class='rand'><?php echo $row->description; ?></a></td>
							<td class='row_click' style='text-align: center'><?php echo $row->views; ?></td>
							<td class='row_click' style='text-align: center'><?php echo $row->submits; ?></td>
							<td class='row_click'><?php echo $row->added; ?></td>
							<td style='text-align: center; border-right: 1px solid #eee'>

								<a class='delete-row btn-danger' data-loading='...' data-complete="<i class='formed-ok'></i>" data-reset="<i class='formed-trash'></i>" id='delete_<?php echo $row->id; ?>' title='Delete this form'><i class='formed-trash'></i>
								</a>

							</td>
						</tr>
						<?php } ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>