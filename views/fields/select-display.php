<input type='hidden' class='name_holder' value='{{el.cap1}}'>
<span class='input_cover text_cover'>
	<div class='select-cover' >
		<select class='field_class form-control' do_what='{{el.LAW}}' name='{{el.cap1}}_"+type+"__{{el.req}}___field{{$index}}'>
			<option value="" disabled selected>{{el.cap1}}</option>
			<option ng-repeat='opt in el.options_final' value='{{opt.value}}'>{{opt.label}}</option>
		</select>
	</div>
	<span class='field{{$index}} valid_show'></span>
</span>