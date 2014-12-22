<div class='opt_cl'>
	<span class='opt_head'>1. General</span>
	<span class='sp3'>
		<label for='cpm{{$index}}'>Label: </label>
		<input id='cpm{{$index}}' type='text' ng-model='el.cap1'>
	</span>
	<span class='sp3'>
		<label>Instructions: </label>
		<input type='text' ng-model='el.inst' class='inst_change'>
	</span>
	<span class='sp3'>
		<label class='label_check' style='margin-top: 23px'>
			<input type='checkbox' ng-model='el.default' ng-click='el.req=!el.req' ng-true-value='is_hidden' ng-false-value=''>
			<div class='label_div' style='background: #fff'>Hidden by Default</div>
		</label>
	</span>
	<br>
	<span class='sp1'>
		<label for='inline{{$index}}' class='label_radio ax' style='margin-bottom: 25px; margin-top: 18px'>
			<input type='radio' id='inline{{$index}}' ng-model='el.inline' value='large-12 column'>
			<div class='label_div' style='background: #fff'>
				<span class='layout_c1' style='width: 80px'></span>
			</div>
			<span class='layout_c1_text'>one column</span>
		</label>
		<label for='inline2{{$index}}' class='label_radio ax' style='margin-bottom: 25px; margin-top: 18px'>
		<input type='radio' id='inline2{{$index}}' ng-model='el.inline' value='large-6 column'>
			<div class='label_div' style='background: #fff'>
				<span class='layout_c1' style='width: 32px'></span>
				<span class='layout_c1' style='width: 32px; margin-left: 5px'></span>
			</div>
			<span class='layout_c1_text'>two column</span>
		</label>
	</span>
</div>

<div class='opt_cl'>
	<span class='opt_head'>2. Validation</span>
	<span class='sp1'>
		<label>Compulsory Field? <span style='color: #888'>(whether or not hidden by default)</span></label>
		<label for='req1{{$index}}' class='label_radio'>
			<input type='radio' id='req1{{$index}}' ng-model='el.req' value='1'>
			<div class='label_div' style='background: #fff'>Yes</div>
		</label>
		<label for='req2{{$index}}' class='label_radio'>
			<input type='radio' id='req2{{$index}}' ng-model='el.req' value='0'>
			<div class='label_div' style='background: #fff'>No</div> 
		</label>
	</span>
	<br>
	<span class='sp3'>
		<label>Validation: </label>
		<div class='select-cover'>
			<select ng-model='el.valid'>
				<option value=''></option>
				<option value='alphabets'>Alphabets Only</option>
				<option value='integers'>Integers Only</option>
				<option value='alpha'>Alpha-numeric Only</option>
				<option value='email'>Email</option>
				<option value='url'>URL</option>
			</select>
		</div>
	</span>
	<span class='sp3'>
		<label for='min{{$index}}'>Min Characters: </label>
		<input id='min{{$index}}' type='text' ng-model='el.min'>
	</span>
	<span class='sp3'>
		<label for='max{{$index}}'>Max Characters: </label>
		<input id='max{{$index}}' type='text' ng-model='el.max'>
	</span>
</div>
<div class='opt_cl'>
	<span class='opt_head'>3. Conditional Laws </span>
	<div ng-repeat='el2 in build[$index].CL' class='cl_div_cover'>
		<div compile='el2.CL_html'></div>
	</div>
	<button style='width: 100%; height: 40px; margin-top: 15px' class='add_btn fc-btn small' ng-click='addCL($index)'>
		<i class='formed-plus'></i>
	</button>
</div>
			
			
			
			
			