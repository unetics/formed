<input type='hidden' class='name_holder' value='{{el.cap1}}'>
{{el.cap1}}
	<div class='new_ldiv' ng-style='{color: el.ocolor,  }' ng-repeat='opt in el.options_final' for='radio"+inx+random+"{{$index}}'>
		<label class='radio' ng-class='el.tick_type' style="display: inline-block;">
			<input type='radio' class='field_class_checkbox' do_what='{{el.LAW}}' value='{{opt.value}}' id='radio"+inx+random+"{{$index}}' name='{{el.cap1}}_"+type+"__{{el.req}}___field{{$parent.$index}}'>
			{{opt.label}}
		</label>
	</div>
	<span class='field{{$index}} valid_show'></span>
</span>