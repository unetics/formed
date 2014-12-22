<div class="form-group">
	<label for="exampleInputEmail1">{{el.cap1}} <span class='show_{{el.req}}'>*</span></label>
	<input type="email" id="exampleInputEmail1" placeholder='{{el.cap1}}' name='{{el.cap1}}_"+type+"_{{el.valid}}_{{el.req}}_{{el.min}}_{{el.max}}_field{{$index}}' class='field_class form-control' do_what='{{el.LAW}}'>
	<span class='field{{$index}} valid_show'></span>
</div>

