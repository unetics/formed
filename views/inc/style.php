<div id="collapseTwo" class="form_accordion accordion-body collapse">
	<div class='global_holder'>
		<label class='option_text'>Form Layout</label>
		<label class='label_radio'>
			<input type='radio' ng-model='con[0].flayout' value='horizontal'>
			<div class='label_div' style='background: #f3f3f3'>Horizontal</div>
		</label>
		<label class='label_radio'>
			<input type='radio' ng-model='con[0].flayout' value='vertical'>
			<div class='label_div' style='background: #f3f3f3'>Vertical</div>
		</label><br/>

		<label class='option_text' style='width: 150px; display: inline-block'> Field Alignment </label>

		<label class='label_radio'>
			<input type='radio' ng-model='con[0].field_align' value='left' name='field_align'>
			<div class='label_div' style='background: #f3f3f3'>Left</div>
		</label>

		<label class='label_radio'>
			<input type='radio' ng-model='con[0].field_align' value='center' name='field_align'>
			<div class='label_div' style='background: #f3f3f3'>Center</div>
		</label>

		<label class='label_radio'>
			<input type='radio' ng-model='con[0].field_align' value='right' name='field_align'>
			<div class='label_div' style='background: #f3f3f3'>Right</div>
		</label>


		<label class='option_text' style='width: 150px; display: inline-block'> Direction </label>

		<label class='label_radio'>
			<input type='radio' ng-model='con[0].direction' value='ltr' name='direction'>
			<div class='label_div' style='background: #f3f3f3'>Left to Right</div>
		</label>

		<label class='label_radio'>
			<input type='radio' ng-model='con[0].direction' value='rtl' name='direction'>
			<div class='label_div' style='background: #f3f3f3'>Right to Left</div>
		</label>

	</div>
	<div class='global_holder'>
		<label class='label_check'>
			<input type='checkbox' ng-model='con[0].show_star_validation'>
			<div class='label_div' style='background: #f3f3f3'>Don't Show <span class='show_1_sample'>*</span> for Required Fields</div>
		</label>
	</div>
</div>