<div class="fcmodal fcfade" id="new_form" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="fcmodal-dialog">
			<form class="fcmodal-content" id='new_form' style='width: 640px; top: 20%'>
				<div class="fcclose">×</div>	
				<div class="fcmodal-header">
					Add Form
				</div>
				<div class="fcmodal-body">
						<label>
							<input type='radio' value='new' checked name='type_form'>New Form
						</label>
						<hr>
						<label>
							<input type='radio' value='duplicate' name='type_form' id='rand_aa'>Duplicate
						</label>
						<select name='duplicate' style='min-width: 200px' id='rand_a'>
							<?php foreach ($myrows as $row)
							{
								?>
								<option value='<?php echo $row->id; ?>'><?php echo $row->name; ?></option>
								<?php
							}
							?>
						</select>
						<hr>

					<div style='position: relative'>
						<label>
							<input type='radio' value='import' name='type_form' id='rand_b'>Import
						</label>
							<input id='import' type="file" name="files[]" data-url="<?php echo plugins_url('formed/file-upload/server/content/upload.php'); ?>">
							<span id='fu-label'><i class='formed-upload'></i>Upload Template</span>
						<input type='hidden' id='import_form' name='import_form' val=''>

					</div>
				</div>
				<hr>
				<div class='fcmodal-body'>
					<input name='name' id='new_name' type='text' autofocus placeholder='Form Name'>
					<br>
					<textarea name='desc' id='new_desc' rows='4' placeholder='Description'></textarea>
				</div>
				<div class="fcmodal-footer">
					<span class='response_ajax'></span>
					<button type="submit" id='submit_new_btn' class="fc-btn"><i class='icon-plus icon-white'></i> Add Form</button>
				</div>
			</form>
		</div>
	</div>