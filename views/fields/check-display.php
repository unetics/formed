<input type='hidden' class='name_holder' value='{{el.cap1}}'>
{{el.cap1}}
<div class='checkbox' ng-repeat='opt in el.options_final' for='check"+inx+"{{$index}}'>
	<label class='label_check' ng-class='el.tick_type' style='height: 20px; width: 0px'>
		<input  class='field_class_checkbox' do_what='{{el.LAW}}' type='checkbox' class='label_check' value='{{opt.value}}' id='check"+inx
		+"{{$index}}' name='{{el.cap1}}_"+type+"__{{el.req}}___field{{$parent.$index}}'>
		{{opt.label}}
	</label>
	<span class='field{{$index}} valid_show'></span>
</div>