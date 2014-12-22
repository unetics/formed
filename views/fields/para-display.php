<input type='hidden' class='name_holder' value='{{el.cap1}}'>
  <label>
  	<span class='cap_cover {{con[0].cap_width}}'><span class='cap1 '>{{el.cap1}}<span class='show_{{el.req}}'>*</span></span>
	<span class='cap2 ' ng-bind='el.cap2'>enter your full name</span></span><span class='input_cover text_cover'>
  </label>
	<textarea rows='{{el.row}}' name='{{el.cap1}}_"+type+"__{{el.req}}_{{el.min}}_{{el.max}}_field{{$index}}_{{el.mail_field}}' class='field_class form-control' do_what='{{el.LAW}}' placeholder="{{el.cap1}}"></textarea>
	<span class='q_cover'>
	<span class='inst ttip' data-original-title='{{el.inst}}'><i class='formed-help-circled'></i></span></span><span class='field{{$index}} valid_show'></span></span>
