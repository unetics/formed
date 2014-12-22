<div class='opt_cl'>
	<span class='opt_head'>1. General</span>
	<span class='sp1'>
		<label for='pcpm{{$index}}'>Label: </label>
		<input id='pcpm{{$index}}' type='text' ng-model='el.cap1' >
	</span>
	<span class='sp1'>
		<label class='label_check' style='margin-top: 23px'>
			<input type='checkbox' ng-model='el.default' ng-true-value='is_hidden' ng-false-value=''>
			<div class='label_div' style='background: #fff'>Hidden by Default</div>
		</label>
	</span>
	<br>
	<span class='sp1'>
		<label for='inline{{$index}}' class='label_radio ax' style='margin-bottom: 25px; margin-top: 18px'>
		<input type='radio' id='inline{{$index}}' ng-model='el.inline' value='inline1'>

<div class='label_div' style='background: #fff'>
	<span class='layout_c1' style='width: 80px'></span>

</div>
	<span class='layout_c1_text'>one column</span> </label>
		<label for='inline2{{$index}}' class='label_radio ax' style='margin-bottom: 25px; margin-top: 18px'>
		<input type='radio' id='inline2{{$index}}' ng-model='el.inline' value='inline2'>
		
<div class='label_div' style='background: #fff'>
	<span class='layout_c1' style='width: 32px'></span>
	<span class='layout_c1' style='width: 32px; margin-left: 5px'></span>

</div>
	<span class='layout_c1_text'>two column</span> </label>
		<label for='inline3{{$index}}' class='label_radio ax' style='margin-bottom: 25px; margin-top: 18px'>
		<input type='radio' id='inline3{{$index}}' ng-model='el.inline' value='inline3'>
		
<div class='label_div' style='background: #fff'>
	<span class='layout_c1' style='width: 25px'></span>
	<span class='layout_c1' style='width: 25px; margin-left: 5px'></span>
	<span class='layout_c1' style='width: 25px; margin-left: 5px'></span>
</div>
	<span class='layout_c1_text'>three column</span> </label>
		<label for='inline4{{$index}}' class='label_radio ax' style='margin-bottom: 25px; margin-top: 18px'>
		<input type='radio' id='inline4{{$index}}' ng-model='el.inline' value='inline4'>
		
<div class='label_div' style='background: #fff'>
	<span class='layout_c1' style='width: 21px'></span>
	<span class='layout_c1' style='width: 21px; margin-left: 5px'></span>
	<span class='layout_c1' style='width: 21px; margin-left: 5px'></span>
	<span class='layout_c1' style='width: 21px; margin-left: 5px'></span>
</div>
	<span class='layout_c1_text'>four column</span> </label>
	</span>
</div>

<div class='opt_cl'>
	<span class='opt_head'>2. Items</span>
	<textarea rows='6' class='options_textarea' options-raw='' ng-model='el.options_raw'></textarea>
</div>
<div class='opt_cl'>
	<span class='opt_head'>3. Validation</span>
	<span class='sp1'>
		<label>Compulsory Field? <span style='color: #888'>(whether or not hidden by default)</span></label> 
		<label for='req1{{$index}}' class='label_radio'>
		<input type='radio' id='req1{{$index}}' ng-model='el.req' value='1'>
	
<div class='label_div' style='background: #fff'>Yes</div> </label>
	<label for='req2{{$index}}' class='label_radio'>
	<input type='radio' id='req2{{$index}}' ng-model='el.req' value='0'>
	
<div class='label_div' style='background: #fff'>No</div> </label></span></div>

<!--
<div class='opt_cl'>
	<span class='opt_head'>4. Conditional Laws </span>
	
<div ng-repeat='el2 in build[$index].CL' class='cl_div_cover'>
<div compile='el2.CL_html'></div></div>
	<button style='width: 100%; height: 40px; margin-top: 15px' class='add_btn fc-btn small' ng-click='addCL($index)'>
	<i class='formed-plus'></i>
	</button>
</div>
-->