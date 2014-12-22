<div class='opt_cl'>
	<span class='opt_head'>1. General</span>
	<span class='sp1'>
		<label for='sconfig9'>Text</label>
		<input id='sconfig9' type='text' ng-model='el.cap1'>
	</span>
	<span class='sp1'>
		<label class='label_check' style='margin-top: 23px'>
			<input type='checkbox' ng-model='el.default' ng-true-value='is_hidden' ng-false-value=''>
			<div class='label_div' style='background: #fff'>Hidden by Default</div>
		</label>
	</span>
</div>

<div class='opt_cl'>
	<span class='opt_head'>2. Styling</span>
	<span class='sp1'>
		<label>Style: </label>
			<select ng-model='el.style'>
				<option value='primary'>Primary</option>
				<option value='secondary'>Secondary</option>
				<option value='ghost'>Ghost</option>
				<option value='simple'>Simple</option>
			</select>
	</span>
	<span class='sp1'>
		<label>Align: </label>
			<select ng-model='el.align'>
				<option value='center'>Center</option>
				<option value='left'>Left</option>
				<option value='right'>Right</option>
				<option value='block'>Block</option>
			</select>
	</span>
</div>