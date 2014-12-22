function save_form(build, option, con, rec)
{
  window.saving = true;
  jQuery('#save_form_btn').html(jQuery('#save_form_btn').attr('data-loading'));

  var key = 'true';
  if (jQuery('#no-key').length)
  {
    var key = 'false';
  }

  var build = jQuery.toJSON(build);
  build = deflate(build);
  build = encodeURIComponent(build);

  var option = jQuery.toJSON(option);
  option = deflate(option);
  option = encodeURIComponent(option);

  var rec = jQuery.toJSON(rec);
  rec = encodeURIComponent(rec);

  var con = jQuery.toJSON(con);
  con = encodeURIComponent(con);

  var html = encodeURIComponent(jQuery('.html_here').html());
  var id = jQuery('.form_id').attr('val');

  if (build.length+option.length+con.length+rec.length == window.content_len && window.falseClick==true)
  {
    jQuery('#save_form_btn').html(jQuery('#save_form_btn').attr('data-normal'));
    window.saving = false;
    window.falseClick = false;
    return false;
  }
  window.falseClick = false;

  jQuery.ajax({
    url: ajaxurl,
    type: "POST",
    data: 'action=formed_update&content='+html+'&build='+build+'&option='+option+'&con='+con+'&rec='+rec+'&id='+id+'&key='+key,
    success: function (response) {
      jQuery('#save_form_btn').html(jQuery('#save_form_btn').attr('data-normal'));
      window.saving = false;
      window.content_len = build.length+option.length+con.length+rec.length;
    },
    error: function (response) {
      jQuery('#save_form_btn').html(jQuery('#save_form_btn').attr('data-error'));
      window.saving = false;
    }
  });

}

setTimeout(function(){
  if (jQuery('.ff_c_t').length) { setInterval(function(){jq_functions();},1500); setInterval(function(){tooltipSet();},10000); }
},1000);

function export_form(build, option, con, rec)
{
  var build = jQuery.toJSON(build);
  var option = jQuery.toJSON(option);
  var con = jQuery.toJSON(con);
  var rec = jQuery.toJSON(rec);

  jQuery('#export_build').val(build);
  jQuery('#export_option').val(option);
  jQuery('#export_con').val(con);
  jQuery('#export_rec').val(rec);

  jQuery('#export_form_form').submit();
}


function builder_interval()
{
  /* Fix Height of Captcha Image */
  jQuery('.c_image').each(function(){
    var he = jQuery(this).next('input').outerHeight();
    he = parseInt(he);
    jQuery(this).css({'height':he+'px'});
  });
}


// Trigger a Click on 'SAVE' button
var save_formed = function save_formed()
{
  window.falseClick = true;
  jQuery('#save_form_btn').trigger('click');
}





jQuery(document).ready(function () {

  jQuery('body').addClass('has-js');
  jQuery('body').on('click','.fileupload-input',function(event){
    event.preventDefault();
  });

  jQuery('#lp-button').click(function(event){
    event.preventDefault();
    myWindow = window.open(jQuery(this).attr('href'), 'myWindow');
    myWindow.focus();    
  });

  jQuery('body').on('input','.slider_update',function(){
    add_sliders();
  });

  jQuery('.font-change').trigger('change');
  setTimeout(function(){
    jQuery('.font-change').trigger('change');
  },1000);

  jQuery('.font-change').change(function(){
    if(jQuery(this.options[this.selectedIndex]).closest('optgroup').prop('label')=='Defaults')
    {
      return false;
    }
    WebFont.load({
      google: { families: [this.value] }
    });
  });

  jQuery('.font-change').each(function(){
    if(jQuery(this.options[this.selectedIndex]).closest('optgroup').prop('label')=='Defaults' || this.value.indexOf('undefined')!=-1)
    {
      return false;
    }
    WebFont.load({
      google: { families: [this.value] }
    });
  });  

  jQuery('body').on('click','.form-theme-bg > button',function(){
    setTimeout(function(){
      jQuery('#image_location_2').trigger('input');
    },100);
  });

  jQuery('.btn-toggle').click(function(event){
    event.preventDefault();
    var mainID = jQuery(this).attr('href');
    jQuery(this).parent().find('.fc-btn.medium.btn-toggle.active').each(function(){
      var id = jQuery(this).attr('href');
      if (id!=mainID && jQuery(id).hasClass('active'))
      {
        jQuery(id).slideUp();
        jQuery(id).removeClass('active');
        jQuery(this).removeClass('active');
      }
    });
    var mainID = jQuery(this).attr('href');
    if (jQuery(mainID).hasClass('active'))
    {
      jQuery(mainID).slideUp();
      jQuery(mainID).removeClass('active');
      jQuery(this).removeClass('active');
    }
    else
    {
      jQuery(mainID).slideDown();
      jQuery(mainID).addClass('active');      
      jQuery(this).addClass('active');
    }
  });

  jQuery('.dropdown-toggle').click(function(event){
    event.preventDefault();    
    jQuery(this).parent().find('.dropdown-menu').show();
  });

  jQuery(document).mouseup(function (e)
  {
    var container = jQuery(".dropdown-menu");
    container.hide();
  });  

  jQuery('.accordion-heading').click(function(event){
    event.preventDefault();
    var thisHTML = jQuery(this).html();
    jQuery(this).parent().parent().find('.accordion-group').each(function(){

    var result = jQuery(this).find('.accordion-body');
    var head = jQuery(this).find('.accordion-heading');
    if (result.hasClass('active') && head.html()!=thisHTML)
    {
      result.slideUp();
      result.removeClass('active');
      head.removeClass('active');
    }

    });
    result = jQuery(this).parent().find('.accordion-body');
    if (result.hasClass('active'))
    {
      result.slideUp();
      result.removeClass('active');
      jQuery(this).removeClass('active');
    }
    else
    {
      result.slideDown();
      result.addClass('active');      
      jQuery(this).addClass('active');
    }
  });  


  jQuery('.min-btn').removeAttr('disabled');

  setTimeout("add_field_call()", 500);
  
  setInterval(function(){builder_interval();},5000);


  jQuery('#stab').click(function(){

    if (jQuery('.fc_pagination .active').length==0)
    {
      jQuery('#fc-page-1').trigger('click');
    }

  })


  jQuery('.btn-toggle').click(function(){
    if (jQuery(this).hasClass('active'))
    {
      jQuery(this).removeClass('active');
    }
    else 
    {
      jQuery(this).addClass('active');
    }
  });




 }); // End of Document Ready





// declare a new module, and inject the $compileProvider
angular.module('compile', [], function($compileProvider) {


  // configure new 'compile' directive by passing a directive
  // factory function. The factory function injects the '$compile'
  $compileProvider.directive('compile', function($compile) {
    // directive factory creates a link function
    return function(scope, element, attrs) {
      scope.$watch(
        function(scope) {
           // watch the 'compile' expression for changes
           return scope.$eval(attrs.compile);
         },
         function(value) {
          // when the 'compile' expression changes
          // assign it into the current DOM
          element.html(value);

          // compile the new DOM and link it to the current
          // scope.
          // NOTE: we only compile .childNodes so that
          // we don't get into infinite loop compiling ourselves
          $compile(element.contents())(scope);
        }
        );
    };
  });

  $compileProvider.directive('scale', function() {
    return {
      restrict: 'A',
      scope: true,
      link: function(scope, element, attrs) {
        element.addClass('anim');
        var abc = setTimeout(function(){
          element.removeClass('anim')},1000);
      }
    };
  });


  $compileProvider.directive('optionsRaw', function() {
    return {
      require: 'ngModel',
      link: function($scope, $element, $attrs, ngModelCtrl) {
        $scope.$watch($attrs.ngModel, function(){
          if (ngModelCtrl.$viewValue)
          {
            var temp = ngModelCtrl.$viewValue.replace('(empty)','\n').split('\n');
            $scope.el.options_final=[];
            for (x in temp)
            {
              if (temp[x]=='' && temp[x-1]==''){continue;}
              if(temp[x].indexOf('==')!=-1)
              {
                values = temp[x].split('==');
                $scope.el.options_final.push({
                  value:  values[0],
                  label:  values[1]
                });                
              }
              else
              {
                $scope.el.options_final.push({
                  value:  temp[x],
                  label:  temp[x]
                });                
              }
            }         
          }
        });
      }
    }
  });

  $compileProvider.directive('tooltip', function () {
    return {
      restrict:'A',
      link: function(scope, element, attrs)
      {
        $(element)
        .attr('title',scope.$eval(attrs.tooltip))
        .tooltip({placement: "right"});
      }
    }
  });
});





 // Angular JS Function
 function bob_the_builder($scope, $http)
 {

  $scope.selectedDate = "Aladdin";


  var sortableEle;
  var sortableEle2;
  var slideris;



  $scope.dragStart = function(e, ui) {
    ui.item.data('start', ui.item.index());
  }
  $scope.dragEnd = function(e, ui) {
    var start = ui.item.data('start'),
    end = ui.item.index();
    $scope.build.splice(end, 0, 
      $scope.build.splice(start, 1)[0]);
    $scope.$apply();
  }


  sortableEle = jQuery('.form_ul').sortable({
    placeholder: "sort_placeholder", // css for placeholder style
    delay: 100,
    distance: 20,
    start: $scope.dragStart,
    update: $scope.dragEnd
  });

  sortableEle2 = jQuery('.options_ul').sortable({
    placeholder: "sort_placeholder", // css for placeholder style
    start: $scope.dragStart,
    update: $scope.dragEnd
  });

  if (!(J.B))
  {
    $scope.build = [];
    $scope.is_new = true;
  }
  else 
  {
    var temp_b = inflate(J.B);
    if (temp_b==null)
    {
      $scope.build = jQuery.evalJSON(J.B);
    }
    else
    {
      temp_b = temp_b.replace(/place='{{el.cap1}}'/g,"placeholder='{{el.cap1}}' has_p='{{con[0].placeholder}}'");
      $scope.build = jQuery.evalJSON(temp_b);
    }
  }

  $scope.build.le = $scope.build.length;

  var i = 0;
  $scope.build.captcha = 0;
  while (i<$scope.build.le)
  {
    if($scope.build[i].captcha==1)
    {
      $scope.build.captcha = 1;
    }
    i = i + 1;
  }

  var i = 0;
  $scope.build.upload = 0;
  while (i<$scope.build.le)
  {
    if($scope.build[i].upload==1)
    {
      $scope.build.upload = 1;
    }
    i = i + 1;
  }

  if (!(J.O))
  {
    $scope.option = [];
  }
  else 
  {
    var temp_o = inflate(J.O);
    if (temp_o==null)
    {
      $scope.option = jQuery.evalJSON(J.O);
    }
    else
    {
      $scope.option = jQuery.evalJSON(temp_o);
    }
  }

  if (!(J.R))
  {
    $scope.recipients = [];
  }
  else 
  {
    $scope.recipients = jQuery.evalJSON(J.R);
  }

  if (J.C!=null)
  {
    J.C = J.C.replace('"color: red"',"'color: red'"); 
  }
  if (!(J.C))
  {
    $scope.con = [];
  }
  else 
  {
    $scope.con = jQuery.evalJSON(J.C);
  }


  slideris = jQuery( ".con_slider" ).slider({
    min: 0,
    max: 100,
    slide: function( event, ui ) {
      var id_is = jQuery(this).attr('id');
      jQuery( "#"+id_is+"_v" ).val( ui.value );
      jQuery( "#"+id_is+"_v" ).trigger( 'input');
    }
  });

  if($scope.stext==undefined)
  {
    $scope.stext = 'Submit';
  }
  if($scope.form_title==undefined)
  {
    $scope.form_title = 'Form Title';
  }
  if($scope.ft_px==undefined)
  {
    $scope.ft_px = 32;
  }
  if($scope.sfs==undefined)
  {
    $scope.sfs = 14;
  }
  if($scope.lp==undefined)
  {
    $scope.lp = '0px';
  }
  if($scope.bp==undefined)
  {
    $scope.bp = '20px';
  }
  if($scope.tp==undefined)
  {
    $scope.tp = '15px';
  }
  if($scope.theme==undefined)
  {
    $scope.theme = 'none';
  }
  if($scope.spad1==undefined)
  {
    $scope.spad1 = '8px';
  }
  if($scope.spad2==undefined)
  {
    $scope.spad2 = '14px';
  }
  if($scope.spad2==undefined)
  {
    $scope.spad2 = '14px';
  }
  if($scope.sbold==undefined)
  {
    $scope.sbold = 'normal';
  }
  if($scope.tbold==undefined)
  {
    $scope.tbold = 'normal';
  }
  if($scope.ftalign==undefined)
  {
    $scope.ftalign = 'left';
  }
  if($scope.sub_th==undefined)
  {
    $scope.sub_th = 'boots';
  }
  if($scope.email_sub==undefined)
  {
    $scope.email_sub = 'New Form Submission for [Form Name]';
  }
  if($scope.email_body==undefined)
  {
    $scope.email_body = '<strong>[Form Name]</strong>\n\n[URL]\n[Form Content]';
  }
  if($scope.number_spin==undefined)
  {
    $scope.number_spin = 'spin';
  }
  if($scope.allow_multi==undefined)
  {
    $scope.allow_multi = 'allow_multi';
  }    
  if($scope.check_no_conflict==undefined)
  {
    $scope.check_no_conflict = 'check_conflict';
  }    
  if($scope.multi_error==undefined)
  {
    $scope.multi_error = '<center>You cannot submit the form twice!</center>';
  }    
  if($scope.error_gen==undefined)
  {
    $scope.error_gen = 'Please correct the errors and try again';
  }
  if($scope.error_email==undefined)
  {
    $scope.error_email = 'Incorrect email format';
  }
  if($scope.error_url==undefined)
  {
    $scope.error_url = 'Incorrect URL format';
  }
  if($scope.error_ftype==undefined)
  {
    $scope.error_ftype = 'Incorrect file type';
  }
  if($scope.error_captcha==undefined)
  {
    $scope.error_captcha = 'Incorrect captcha';
  }
  if($scope.error_only_integers==undefined)
  {
    $scope.error_only_integers = 'Only integers';
  }
  if($scope.error_required==undefined)
  {
    $scope.error_required = 'This field is required';
  }
  if($scope.error_min==undefined)
  {
    $scope.error_min = 'At least [min_chars] characters required';
  }
  if($scope.error_max==undefined)
  {
    $scope.error_max = 'Maximum [max_chars] characters allowed';
  }
  if($scope.ruser==undefined)
  {
    $scope.ruser = '';
  }
  if($scope.form_sent==undefined)
  {
    $scope.form_sent = 'Your message was sent. We will get back to you asap!';
  }
  if($scope.form_not_sent==undefined)
  {
    $scope.form_not_sent = '<span>Looks like there was an error. Sorry.</span>';
  }
  if($scope.autoreply==undefined)
  {
    $scope.autoreply = 'Hey,\n\nThis is just a confirmation message. We have received you reply and will get back to you soon.';
  }
  if($scope.autoreply_s==undefined)
  {
    $scope.autoreply_s = 'Just Confirming';
  }
  if($scope.formpage==undefined)
  {
    $scope.formpage = 'false';
  }
  if($scope.mail_type==undefined)
  {
    $scope.mail_type = 'mail';
  }
  if($scope.flayout==undefined)
  {
    $scope.flayout = 'horizontal';
  }
  if($scope.success_msg==undefined)
  {
    $scope.success_msg = 'Message Sent';
  }
  if($scope.failed_msg==undefined)
  {
    $scope.failed_msg = 'Message Could Not Be Sent';
  }
  if($scope.direction==undefined)
  {
    $scope.direction = 'ltr';
  }
  if($scope.cl_hidden_fields==undefined)
  {
    $scope.cl_hidden_fields = 'no_submit_hidden';
  }
  if($scope.user_save_form==undefined)
  {
    $scope.user_save_form = 'no_save_form';
  }
  if($scope.field_align==undefined)
  {
    $scope.field_align = 'left';
  }


  if($scope.con.length==0)
  {
    $scope.con.push({
      stext:$scope.stext,
      form_title:$scope.form_title,
      ft_px:$scope.ft_px,
      sfs:$scope.sfs,
      lp:$scope.lp,
      bp:$scope.bp,
      tp:$scope.tp,
      spad1:$scope.spad1,
      spad2:$scope.spad2,
      sbold:$scope.sbold,
      tbold:$scope.tbold,
      ftalign:$scope.ftalign,
      sub_th:$scope.sub_th,
      email_sub:$scope.email_sub,
      email_body:$scope.email_body,
      allow_multi:$scope.allow_multi,
      number_spin:$scope.number_spin,
      check_no_conflict:$scope.check_no_conflict,
      multi_error:$scope.multi_error,
      error_gen:$scope.error_gen,
      error_email:$scope.error_email,
      error_url:$scope.error_url,
      error_captcha:$scope.error_captcha,
      error_ftype:$scope.error_ftype,
      error_only_integers:$scope.error_only_integers,
      error_required:$scope.error_required,
      error_min:$scope.error_min,
      error_max:$scope.error_max,
      ruser:$scope.ruser,
      form_sent:$scope.form_sent,
      form_not_sent:$scope.form_not_sent,
      autoreply:$scope.autoreply,
      autoreply_s:$scope.autoreply_s,
      formpage:$scope.formpage,
      mail_type:$scope.mail_type,
      success_msg:$scope.success_msg,
      failed_msg:$scope.failed_msg,
      flayout:$scope.flayout,
      direction:$scope.direction,
      field_align:$scope.field_align,
      cl_hidden_fields:$scope.cl_hidden_fields,
      user_save_form:$scope.user_save_form,
      theme:$scope.theme
    });
}



if (typeof $scope.recipients=='object')
{
  $scope.tempRecipients = '';
  for (var sub in $scope.recipients)
  {
    $scope.tempRecipients = $scope.tempRecipients+$scope.recipients[sub].val+', ';
  }
  $scope.recipients = $scope.tempRecipients;
}


$scope.addCL = function ($index)
{
  $scope.build[$index].CL.push({
    CL_html:"<span class='sp1 cl_cover'><div style='width: 233px'><label>if this element</label><div class='select-cover'><select ng-model='el2.law' ng-change='el.LAW[$index].law=el2.law' style='width: 110px'><option value='='>equals</option><option value='>'>is greater than</option><option value='<'>is less than</option></select></div><input type='text' ng-model='el2.equals' ng-change='el.LAW[$index].equals=el2.equals' style='width: 100px'></div><div style='width: 88px'><label>then</label><div class='select-cover'><select ng-model='el2.doit' ng-change='el.LAW[$index].doit=el2.doit' style='width: 84px' class='cl_do_what'><option value=''></option><option value='show'>Show</option><option value='hide'>Hide</option><option value='redirect'>Redirect</option><option value='emails'>Email To</option></select></div></div><div style='width: 130px; display: none' class='cl_show' ng-class='[el2.doit]'><label>element(s)</label><input ng-model='el2.to' ng-change='el.LAW[$index].to=el2.to' style='width: 130px' type='text' placeholder='2,4,5'></div><div style='width: 130px; display: none' class='cl_emails' ng-class='[el2.doit]'><label>emails</label><input type='text' ng-model='el2.emails' ng-change='el.LAW[$index].emails=el2.emails' placeholder='a@b.com,b@c.com'></div><div style='width: 130px; display: none' ng-class='[el2.doit]' class='cl_redirect'><label>URL</label><input type='text' ng-model='el2.redirect' ng-change='el.LAW[$index].redirect=el2.redirect' placeholder='URL'></div><button class='btn btn-danger cl_del' title='Delete' ng-click='remCL($index, $parent.$index)'>×</button></span>"
  });
$scope.build[$index].LAW.push({
  equals:"",
  do:"",
  to:"",
  emails:"",
  redirect:""
});
}
$scope.remCL = function ($index, $parent_index)
{
  $scope.build[$parent_index].CL.splice($index, 1);
  $scope.build[$parent_index].LAW.splice($index, 1);
}

$scope.remOpt = function ($index, series)
{
  $scope.option[series].Drop.splice($index, 1);
}
$scope.addOpt = function (series, type)
{

  if (type=='matrix')
  {
    $scope.option[series].Drop.push({
      val:"Timeliness"
    });
  }
  else if(type=='smiley')
  {
    alert('Cannot add more options here!');
  }
  else if(type=='pre-countries')
  {
    $http({method: 'GET', url: J.countries }).
    success(function(data, status, headers, config) 
    {
      for (var i in data)
      {
        $scope.option[series].Drop.push({
          val: data[i].Item
        });
      }
    }).
    error(function(data, status, headers, config) 
    {
      alert('Error');
    });
  }
  else if(type=='pre-states')
  {
    $http({method: 'GET', url: J.states }).
    success(function(data, status, headers, config) 
    {
      for (var i in data)
      {
        $scope.option[series].Drop.push({
          val: data[i].Item
        });
      }
    }).
    error(function(data, status, headers, config) 
    {
      alert('Error');
    });
  }
  else if(type=='pre-lang')
  {
    $http({method: 'GET', url: J.languages }).
    success(function(data, status, headers, config) 
    {
      for (var i in data)
      {
        $scope.option[series].Drop.push({
          val: data[i].Item
        });
      }
    }).
    error(function(data, status, headers, config) 
    {
      alert('Error');
    });
  }
  else
  {
    $scope.option[series].Drop.push({
      val:"Option",
      smin:"10",
      smax:"100"
    });
  }  
  setTimeout("add_sliders()", 300);
}

$scope.addOptNew = function ($index, type)
{

  if(type=='pre-countries')
  {
    $http({method: 'GET', url: J.countries.replace('.json','_new.json') }).
    success(function(data, status, headers, config) 
    {
      $scope.build[$index].options_raw = data;
    }).
    error(function(data, status, headers, config) 
    {
      alert('Error');
    });
  }
  else if(type=='pre-states')
  {
    $http({method: 'GET', url: J.states.replace('.json','_new.json') }).
    success(function(data, status, headers, config) 
    {
      $scope.build[$index].options_raw = data;
    }).
    error(function(data, status, headers, config) 
    {
      alert('Error');
    });
  }
  else if(type=='pre-lang')
  {
    $http({method: 'GET', url: J.languages.replace('.json','_new.json') }).
    success(function(data, status, headers, config) 
    {
      $scope.build[$index].options_raw = data;
    }).
    error(function(data, status, headers, config) 
    {
      alert('Error');
    });
  }
}

$scope.remEl = function($index) {

  if($scope.build[$index].captcha==1)
  {
    $scope.build.captcha = 0;
  }

  if($scope.build[$index].upload==1)
  {
    $scope.build.upload = 0;
  }

  jq_click_before($index);
  $scope.build.splice($index, 1);
  $scope.build.le = $scope.build.length;
}
$scope.save = function()
{
  save_form($scope.build, $scope.option, $scope.con, $scope.recipients);
}
$scope.export_form = function()
{
  export_form($scope.build, $scope.option, $scope.con, $scope.recipients);
}

/* console.log(J); */

$scope.addEl = function (type) {
  var inx = $scope.build.length;
  var inx2 = $scope.option.length;
  var inx = Math.max(inx,inx2);
  var random = "_"+Math.floor((Math.random() * 100) + 1)+"_";

  if (type=='text')
  {
    $scope.el_f = inp.textDisplay;
 $scope.el_b = "<span class='id_hold'>{{$index}}{{el.uniq}}</span><span class='id_text'>One-line Text Input <span class='head_label'>{{el.cap1}}</span></span>";
    $scope.el_b2 = inp.textOptions;
    $scope.captcha = 0;
    $scope.upload = 0;
  }
  if (type=='email')
  {       
    $scope.el_f = inp.emailDisplay;
    $scope.el_b = "<span class='id_hold'>{{$index}}</span><span class='id_text'>Email Input <span class='head_label'>{{el.cap1}}</span></span>";
    $scope.el_b2 = inp.emailOptions;
    $scope.captcha = 0;
    $scope.upload = 0;
  }


  if (type=='para')
  {       
    $scope.el_f = inp.paraDisplay;
    $scope.el_b = "<span class='id_hold'>{{$index}}</span><span class='id_text'>Paragraph Text Input <span class='head_label'>{{el.cap1}}</span></span>";
    $scope.el_b2 = inp.paraOptions;
    $scope.captcha = 0;
    $scope.upload = 0;
  }

  if (type=='dropdown')
  {
    $scope.el_f = inp.selectDisplay;
    $scope.el_b = "<span class='id_hold'>{{$index}}</span><span class='id_text'>Select Box <span class='head_label'>{{el.cap1}}</span></span>";
    $scope.el_b2 = inp.selectOptions;
    $scope.captcha = 0;
    $scope.upload = 0;
  }
  if (type=='check')
  {
    $scope.el_f = inp.checkDisplay;
    $scope.el_b = "<span class='id_hold'>{{$index}}</span><span class='id_text'>CheckBox Group <span class='head_label'>{{el.cap1}}</span></span>";
    $scope.el_b2 = inp.checkOptions;
    $scope.captcha = 0;
    $scope.upload = 0;
  }
  if (type=='radio')
  {
    $scope.el_f = inp.radioDisplay;
    $scope.el_b = "<span class='id_hold'>{{$index}}</span><span class='id_text'>Radio Group <span class='head_label'>{{el.cap1}}</span></span>";
    $scope.el_b2 = inp.radioOptions;
    $scope.captcha = 0;
    $scope.upload = 0;
  }
  if (type=='submit')
  {
    $scope.el_f = inp.submitDisplay;
    $scope.el_b = "<span class='id_hold'>{{$index}}</span><span class='id_text'>Submit Button <span class='head_label'>{{el.cap1}}</span></span></div>";
    $scope.el_b2 = inp.submitOptions;
    $scope.captcha = 0;
    $scope.upload = 0;
  }

  $scope.build.splice($scope.build.length, 0, {
    el_f:$scope.el_f,
    el_b:$scope.el_b,
    el_b2:$scope.el_b2,
    captcha:$scope.captcha,
    upload:$scope.upload,
    CL: [],
    LAW: []
  });


  var inx = $scope.build.length-1;

  $scope.build.le = $scope.build.length;
  var temp_length = $scope.build.le-1;

  add_field_call();


  setTimeout("add_sliders()", 200);
  setTimeout("add_upload()", 200);
  setTimeout("setupLabel()", 200);
  setTimeout("update_date()", 200);

    // Specifics
    switch (type)
    {

      case 'text':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Name';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'full name';
      }
      if($scope.build[inx].inline==undefined)
      {
        $scope.build[inx].inline = 'large-12 column';
      }
      break;

      case 'password':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Password';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'shhh';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '80%';
      }
      break;

      case 'email':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Email';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'a valid email address';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '80%';
      }
      break;

      case 'para':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Comments';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'something more';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '80%';
      }
      if($scope.build[inx].row==undefined)
      {
        $scope.build[inx].row = '3';
      }
      break;

      case 'dropdown':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Country';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'select your country';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '80%';
      }
      if($scope.build[inx].options_raw==undefined)
      {
        $scope.build[inx].options_raw = '(empty)\nOption A\nOption B';
      }      
      break;

      case 'check':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Food';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'you like';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '100%';
      }
      if($scope.build[inx].tick_type==undefined)
      {
        $scope.build[inx].tick_type = 'default';
      }
      if($scope.build[inx].options_raw==undefined)
      {
        $scope.build[inx].options_raw = '10==Pizza\n8==Cheese Burger\n4==Bottled Water';        
      }      
      break;

      case 'radio':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Eggs';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'to order';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '35%';
      }
      if($scope.build[inx].tick_type==undefined)
      {
        $scope.build[inx].tick_type = 'default';
      }
      if($scope.build[inx].options_raw==undefined)
      {
        $scope.build[inx].options_raw = '12==One Dozen\n24==2 Dozens';
      }
      break;

      case 'stars':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Service';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'rate our service';
      }
      break;

      case 'smiley':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Food';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'how good was the food?';
      }
      break;

      case 'thumbs':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Like it?';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'be frank!';
      }
      if($scope.build[inx].lines==undefined)
      {
        $scope.build[inx].lines = 'lines';
      }
      break;

      case 'matrix2':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Ratings';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'how good was the food?';
      }
      if($scope.build[inx].matrix1==undefined)
      {
        $scope.build[inx].matrix1 = 'Poor';
      }
      if($scope.build[inx].matrix2==undefined)
      {
        $scope.build[inx].matrix2 = 'Decent';
      }
      if($scope.build[inx].tick_type==undefined)
      {
        $scope.build[inx].tick_type = 'default';
      }

      case 'matrix3':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Ratings';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'how good was the food?';
      }
      if($scope.build[inx].matrix1==undefined)
      {
        $scope.build[inx].matrix1 = 'Poor';
      }
      if($scope.build[inx].matrix2==undefined)
      {
        $scope.build[inx].matrix2 = 'Decent';
      }
      if($scope.build[inx].matrix3==undefined)
      {
        $scope.build[inx].matrix3 = 'Decent';
      }
      if($scope.build[inx].tick_type==undefined)
      {
        $scope.build[inx].tick_type = 'default';
      }

      case 'matrix4':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Ratings';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'how good was the food?';
      }
      if($scope.build[inx].matrix1==undefined)
      {
        $scope.build[inx].matrix1 = 'Poor';
      }
      if($scope.build[inx].matrix2==undefined)
      {
        $scope.build[inx].matrix2 = 'Decent';
      }
      if($scope.build[inx].matrix3==undefined)
      {
        $scope.build[inx].matrix3 = 'Good';
      }
      if($scope.build[inx].matrix4==undefined)
      {
        $scope.build[inx].matrix4 = 'Excellent';
      }
      if($scope.build[inx].tick_type==undefined)
      {
        $scope.build[inx].tick_type = 'default';
      }

      case 'matrix5':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Ratings';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'how good was the food?';
      }
      if($scope.build[inx].matrix1==undefined)
      {
        $scope.build[inx].matrix1 = 'Poor';
      }
      if($scope.build[inx].matrix2==undefined)
      {
        $scope.build[inx].matrix2 = 'Decent';
      }
      if($scope.build[inx].matrix3==undefined)
      {
        $scope.build[inx].matrix3 = 'Good';
      }
      if($scope.build[inx].matrix4==undefined)
      {
        $scope.build[inx].matrix4 = 'Excellent';
      }
      if($scope.build[inx].matrix5==undefined)
      {
        $scope.build[inx].matrix5 = 'Godlike';
      }
      if($scope.build[inx].tick_type==undefined)
      {
        $scope.build[inx].tick_type = 'default';
      }

      break;

      case 'date':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Date';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'make a booking';
      }
      if($scope.build[inx].date==undefined)
      {
        $scope.build[inx].date = 'mdy';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '80%';
      }
      if($scope.build[inx].dmy==undefined)
      {
        $scope.build[inx].dmy = 'mm-dd-yyyy';
      }
      if($scope.build[inx].lang==undefined)
      {
        $scope.build[inx].lang = 'en';
      }
      break;

      case 'time12': case 'time24':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Time';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = "let's meet";
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '80%';
      }
      break;

      case 'slider':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Slider';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'drag it';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '80%';
      }
      if($scope.build[inx].slider_min==undefined)
      {
        $scope.build[inx].slider_min = 0;
      }
      if($scope.build[inx].slider_max==undefined)
      {
        $scope.build[inx].slider_max = 100;
      }
      if($scope.build[inx].slider_step==undefined)
      {
        $scope.build[inx].slider_step = 5;
      }
      break;

      case 'slider-range':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Budget';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'show me the money';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '80%';
      }
      if($scope.build[inx].slider_min==undefined)
      {
        $scope.build[inx].slider_min = 0;
      }
      if($scope.build[inx].slider_max==undefined)
      {
        $scope.build[inx].slider_max = 100;
      }
      if($scope.build[inx].slider_step==undefined)
      {
        $scope.build[inx].slider_step = 5;
      }      
      break;

      case 'divider':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Group';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '30%';
      }
      if($scope.build[inx].divwid==undefined)
      {
        $scope.build[inx].divwid = '1px';
      }
      if($scope.build[inx].divtop==undefined)
      {
        $scope.build[inx].divtop = '-10px';
      }
      if($scope.build[inx].divlef==undefined)
      {
        $scope.build[inx].divlef = '50px';
      }
      if($scope.build[inx].divfs==undefined)
      {
        $scope.build[inx].divfs = '14px';
      }
      if($scope.build[inx].divfc==undefined)
      {
        $scope.build[inx].divfc = '#666';
      }
      if($scope.build[inx].divspa==undefined)
      {
        $scope.build[inx].divspa = '20px';
      }
      if($scope.build[inx].divspa_divider_top==undefined)
      {
        $scope.build[inx].divspa_divider_top = '20px';
      }
      if($scope.build[inx].divspa_divider_bottom==undefined)
      {
        $scope.build[inx].divspa_divider_bottom = '10px';
      }
      if($scope.build[inx].divcol==undefined)
      {
        $scope.build[inx].divcol = '#CCC';
      }

      break;

      case 'custom':
      if($scope.build[inx].customText==undefined)
      {
        $scope.build[inx].customText = 'You can use this to write comments in the form.<br><em><strong>You can even use HTML!</strong></em>';
      }
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = '';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '40%';
      }
      if($scope.build[inx].divspa==undefined)
      {
        $scope.build[inx].divspa = '20px';
      }
      if($scope.build[inx].divfs==undefined)
      {
        $scope.build[inx].divfs = '14px';
      }
      if($scope.build[inx].divfc==undefined)
      {
        $scope.build[inx].divfc = '#666';
      }

      break;

      case 'upload':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Files';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'upload files here';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '80%';
      }
      if($scope.build[inx].uploadtext==undefined)
      {
        $scope.build[inx].uploadtext = 'Upload';
      }
      break;

      case 'captcha':
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Captcha';
      }
      if($scope.build[inx].cap2==undefined)
      {
        $scope.build[inx].cap2 = 'copy the words';
      }
      if($scope.build[inx].wid==undefined)
      {
        $scope.build[inx].wid = '80%';
      }
      if($scope.build[inx].cap_st==undefined)
      {
        $scope.build[inx].cap_st = 'one';
      }
      if($scope.build[inx].cap_stf==undefined)
      {
        $scope.build[inx].cap_stf = 'font';
      }
      if($scope.build[inx].cap_type==undefined)
      {
        $scope.build[inx].cap_type = 'text';
      }
      break;

      case 'hidden':
      if($scope.build[inx].li_class==undefined)
      {
        $scope.build[inx].li_class = 'hidden_li';
      }
      break;

      case 'image':
      if($scope.build[inx].li_class==undefined)
      {
        $scope.build[inx].li_class = 'hidden_li';
      }
      if($scope.build[inx].image==undefined)
      {
        $scope.build[inx].image = 'http://placehold.it/100x50&text=image';
      }
      break;

      case 'submit':
      if($scope.build[inx].sub_th==undefined)
      {
        $scope.build[inx].sub_th = 'boots';
      }
      if($scope.build[inx].sco==undefined)
      {
        $scope.build[inx].sco = '#ddd';
      }
      if($scope.build[inx].sfs==undefined)
      {
        $scope.build[inx].sfs = 15;
      }
      if($scope.build[inx].spad1==undefined)
      {
        $scope.build[inx].spad1 = '42px';
      }
      if($scope.build[inx].spad2==undefined)
      {
        $scope.build[inx].spad2 = '100px';
      }
      if($scope.build[inx].curve==undefined)
      {
        $scope.build[inx].curve = 4;
      }
      if($scope.build[inx].sbold==undefined)
      {
        $scope.build[inx].sbold = 'normal';
      }
      if($scope.build[inx].cap1==undefined)
      {
        $scope.build[inx].cap1 = 'Submit';
      }
      break;

    }



    // Default for All Field Types

    if($scope.build[inx].req==undefined)
    {
      $scope.build[inx].req = '0';
    }
    if($scope.build[inx].inline==undefined)
    {
      $scope.build[inx].inline = 'large-12 column';
    }

    if($scope.build[inx].cs==undefined)
    {
      $scope.build[inx].cs = 'fixed';
    }

    if($scope.build[inx].min==undefined)
    {
      $scope.build[inx].min = '0';
    }
    if($scope.build[inx].max==undefined)
    {
      $scope.build[inx].max = '300';
    }



    $scope.build.le = $scope.build.length;
    setTimeout("add_field_call()", 500);



  };

  if ($scope.is_new)
  {
    $scope.addEl('submit');
  }

  setTimeout("add_field_call()", 500);

}



function add_field_call()
{

  if (jQuery('.cpicker').length)
  {
    jQuery('.cpicker').spectrum({
      showInput: true,
      showAlpha: true,
      clickoutFiresChange: true,
      preferredFormat: 'rgb',
      showButtons: false,
      change: function(color){
        jQuery(this).trigger('input');
      },
      move: function(color){
        jQuery(this).trigger('input');
      }
    }); 
  }

  jQuery( ".image_cap_cover" ).draggable({ 
    containment: ".nform",
    scroll: false,
    drag: function(event, ui) {
      var id = jQuery(this).attr('id');
      jQuery("#"+id+"l").val(ui.position.left+'px');
      jQuery("#"+id+"t").val(ui.position.top+'px');

      jQuery("#"+id+"l").trigger('input');
      jQuery("#"+id+"t").trigger('input');
    }
  });


  if (jQuery('.cpicker2').length)
  {
    jQuery('.cpicker2').spectrum({
      showInput: true,
      showAlpha: true,
      clickoutFiresChange: true,
      preferredFormat: 'rgb',
      showButtons: false,
      change: function(color){
        jQuery(this).trigger('input');
      },
      move: function(color){
        jQuery(this).trigger('input');
      }
    });
  }

}

