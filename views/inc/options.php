<div id="collapseOne" class="form_accordion accordion-body collapse">
							<div class="accordion-inner">


								<div class='accordion acl' id="accordion_fo">

<div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle collapsed">
												1. General
											</a>
										</div>

										<div id="form_options_one" class="accordion-body collapse">
											<div class="accordion-inner l2">

												<div class='global_holder'>

													<span class='settings_desc' style='font-size: 14px'>Submit values from fields hidden by Conditional Laws?</span>

													<label class='label_radio'>
														<input type='radio' ng-model='con[0].cl_hidden_fields' value='submit_hidden' name='cl_hidden_fields'>
														<div class='label_div' style='background: #f3f3f3'>
															Yes, submit all fields, whether hidden or visible
														</div>
													</label>

													<label class='label_radio'>
														<input type='radio' ng-model='con[0].cl_hidden_fields' value='no_submit_hidden' name='cl_hidden_fields'>
														<div class='label_div' style='background: #f3f3f3'>
															No
														</div>
													</label>
												</div>


												<div class='global_holder'>
													<span class='settings_desc' style='font-size: 14px; font-weight: bold'>No Conflict Mode</span>
													<span class='settings_desc' style='font-size: 13px'>If the checkbox, or multi-choice field(s) used by formed are having problems with your theme's styling, check <strong>yes</strong>. Else, ignore this.</span>
													<label class='label_radio'>
														<input type='radio' ng-model='con[0].check_no_conflict' value='check_no_conflict' name='check_no_conflict'><div class='label_div' style='background: #f3f3f3'>
														Yes</div>
													</label>
													<label class='label_radio'>
														<input type='radio' ng-model='con[0].check_no_conflict' value='check_conflict' name='check_no_conflict'><div class='label_div' style='background: #f3f3f3'>
														No</div>
													</label>
												</div>

												<div class='global_holder'>
													<span class='settings_desc' style='font-size: 14px;'>Use Number Spinning Effect for Math Results?</span>
													<label class='label_radio'>
														<input type='radio' ng-model='con[0].number_spin' value='spin' name='number_spin'><div class='label_div' style='background: #f3f3f3'>
														Yes</div>
													</label>
													<label class='label_radio'>
														<input type='radio' ng-model='con[0].number_spin' value='no_spin' name='number_spin'><div class='label_div' style='background: #f3f3f3'>
														No</div>
													</label>
												</div>																								

												<div class='global_holder'>
													<span class='settings_desc' style='font-size: 14px'>Allow multiple submissions from the same device?</span>
													<label class='label_radio'>
														<input type='radio' ng-model='con[0].allow_multi' value='allow_multi' name='allow_multi'><div class='label_div' style='background: #f3f3f3'>
														Yes</div>
													</label>
													<label class='label_radio'>
														<input type='radio' ng-model='con[0].allow_multi' value='no_allow_multi' name='allow_multi'><div class='label_div' style='background: #f3f3f3'>
														No</div>
													</label>
													<br>
													<div ng-class='"op_"+[con[0].allow_multi]'>
														<p>Error Message to Show<br><span class='settings_desc'>you can use HTML here</span></p>
														<textarea rows='4' ng-model='con[0].multi_error' style='width: 100%'></textarea>
													</div>
												</div>												

											</div>
										</div>
									</div>
<div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle collapsed">
												2. Email Notifications
											</a>
										</div>

										<div id="form_options_two" class="accordion-body collapse">
											<div class="accordion-inner l2">

												<div class='global_holder'>

													<div class='gh_head'>Email Sending Method&nbsp;&nbsp;<button class='fc-btn small' id='test_email'>Send Test Email</button></div>
													<div><div id='test_response'>
														<ol>
															<li>Save the form before sending a test email
															</li>
															<li>The test email(s) will be sent to the list of recipients added below</li>
														</ol>
													</div></div>

													<label class='label_radio circle-ticked'><input type='radio' ng-model='con[0].mail_type' value='mail' name='type_email'><strong><div class='label_div' style='background: #f3f3f3'>Use PHP Mail Function (default)</div></strong>
													</label>
													<br>
													<div class='mail_type_div {{con[0].mail_type}}1'>

														<span style='width: 30%; display: inline-block; text-align: right; margin-right: 5%'> Sender Name: </span><input type='text' ng-model='con[0].from_name'><i class='ttip formed-help-circled' title='You can use values from the form, using labels like [Name]'></i><br>

														<span style='width: 30%; display: inline-block; text-align: right; margin-right: 5%'> Sender Email: </span><input type='text' ng-model='con[0].from_email'><i class='ttip formed-help-circled' title='You can use values from the form, using labels like [Email]'></i>
														<br><br>
													</div>

													<label class='label_radio circle-ticked'><input type='radio' ng-model='con[0].mail_type' name='type_email' value='smtp'><strong><div class='label_div' style='background: #f3f3f3'>Use SMTP Authentication (try if the above doesn't work)</div></strong></label>
													<br>

													<div class='mail_type_div {{con[0].mail_type}}'>

														<label><span style='width: 30%; margin-top: 5px; display: inline-block; text-align: right; margin-right: 5%'> Sender Name: </span><input type='text' ng-model='con[0].smtp_name' placeholder='No Reply'></label><i class='ttip formed-help-circled' title='You can use values from the form, using labels like [Name]'></i><br>
														<label><span style='width: 30%; margin-top: 5px; display: inline-block; text-align: right; margin-right: 5%'> Username: </span><input type='text' ng-model='con[0].smtp_username' placeholder='noreply'></label><br>
														<label><span style='width: 30%; margin-top: 5px; display: inline-block; text-align: right; margin-right: 5%'> Email: </span><input type='text' ng-model='con[0].smtp_email' placeholder='noreply@pressedsites.com'></label><i class='ttip formed-help-circled' title='You can use values from the form, using labels like [Email]'></i><br>
														<label><span style='width: 30%; margin-top: 5px; display: inline-block; text-align: right; margin-right: 5%'> Password: </span><input type='password' ng-model='con[0].smtp_pass'></label><br>
														<label><span style='width: 30%; margin-top: 5px; display: inline-block; text-align: right; margin-right: 5%'> Host: </span><input type='text' ng-model='con[0].smtp_host' placeholder='mail.pressedsites.com'></label>

														<label class='label_radio' style='margin-left: 35%'><input type='checkbox' ng-model='con[0].if_ssl' name='if_ssl' ng-true-value='ssl' ng-false-value='false'><div class='label_div' style='background: #f3f3f3'>Use SSL</div></label>

														<label class='label_radio' style='margin-left: 15px'><input type='checkbox' ng-model='con[0].if_ssl' name='if_ssl' ng-true-value='tls' ng-false-value='false'><div class='label_div' style='background: #f3f3f3'>Use TLS</div></label><br>

														<label><span style='width: 30%; margin-top: 5px; display: inline-block; text-align: right; margin-right: 5%'> Port: </span><input type='text' ng-model='con[0].smtp_port' placeholder='465'></label><br>


													</div>		
												</div>


												<div class='global_holder'>
													<div class='gh_head'>Add Email Recipients</div>
													<span class='settings_desc'>When the form is successfully submitted, the following people will get an email notification. Separate multiple emails with commas</span>
													<ul class='rec_ul'>
														<textarea style='width: 100%' rows='3' ng-model='recipients'></textarea>
													</ul>
												</div>												

												<div class='global_holder'>

													<div class='gh_head'>Email Content</div>

													<label style='width: 30%; display: inline-block; text-align: right; margin-right: 5%'>Email Subject</label>
													<input type='text' style='width: 60%' ng-model='con[0].email_sub'>

													<label style='width: 30%; display: inline-block; text-align: right; margin-right: 5%'>Email Body</label>
													<textarea rows='7' style='width: 60%' ng-model='con[0].email_body'></textarea>
													<div style="margin-left: 35%; margin-top: 5px; font-size: 12px" class='desc'>Use the label [Form Content] to insert the form data in the email body.</div>

												</div>

											</div>
										</div>
									</div>
<div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle collapsed">
												3. Email AutoResponders
											</a>
										</div>

										<div id="form_options_three" class="accordion-body collapse">
											<div class="accordion-inner l2">

												<div class='global_holder'>
													<div class='gh_head'>
														AutoReply Email Settings
													</div>
													<span class='settings_desc'>You can send autoreplies to emails entered by the user when they fill up the form. You can enable autoreplies for any email form field, by checking the option <strong>Send AutoReply to this Email</strong> in the field options.</span>
													<br>


													<div style='display: inline-block; width: 48%'>
													<p>Sender Name<br>
													</p>
													<input ng-model='con[0].autoreply_name' style='width: 100%' type='text'>
													</div>

													<div style='display: inline-block; width: 48%; float: right'>
													<p>Sender Email<br>
													</p>
													<input ng-model='con[0].autoreply_email' style='width: 100%' type='text'>
													</div>
													<br>

													<p>Subject of Email<br>
													</p>
													<input ng-model='con[0].autoreply_s' style='width: 100%' type='text'>
													<br><br>

													<p>Body of Email<br>
														<span class='settings_desc'>you can use HTML here</span>
													</p>
													<textarea ng-model='con[0].autoreply' rows='7' style='width: 100%'>
													</textarea>

												</div>

											</div>
										</div>
									</div>
<div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle collapsed">
												4. Displaying the Form
											</a>
										</div>

										<div id="form_options_four" class="accordion-body collapse">
											<div class="accordion-inner l2">

												<div class='global_holder'>
													<div class='gh_head'>
														Other Methods
													</div>

													<strong>Shortcode</strong>
													<textarea onclick="select()" readonly="readonly" class="code code-inline" rows="1">[formed id='<?php echo $id; ?>']</textarea>
													<br><strong>Use in Themes, and Other Places</strong>
													<textarea onclick="select()" readonly="readonly" class="code code-inline" rows="1">&lt;?php formed(<?php echo $id; ?>); ?&gt;</textarea>

												</div>
											</div>
										</div>
									</div>
<div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle collapsed">
												5. Form Error Messages
											</a>
										</div>

										<div id="form_options_five" class="accordion-body collapse">
											<div class="accordion-inner l2">

												<div class='global_holder'>


													<label for='error_id_a' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Common Message</label>
													<input type='text' id='error_id_a' style='width: 60%' ng-model='con[0].error_gen'>
													<hr>

													<label for='error_id_1' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Incorrect File Upload Type</label>
													<input type='text' id='error_id_1' style='width: 60%' ng-model='con[0].error_ftype'>														
													<br>
													<label for='error_id_112' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Incorrect File Upload Size (min)</label>
													<input type='text' id='error_id_112' style='width: 60%' ng-model='con[0].error_ftype1'>														
													<br>
													<label for='error_id_113' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Incorrect File Upload Size (max)</label>
													<input type='text' id='error_id_113' style='width: 60%' ng-model='con[0].error_ftype2'>														
													<br>
													<label for='error_id_115' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Uploaded max number of files</label>
													<input type='text' id='error_id_115' style='width: 60%' ng-model='con[0].error_ftype3'>														
													<br>
													<label for='error_id_114' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Incorrect Email</label>
													<input type='text' id='error_id_114' style='width: 60%' ng-model='con[0].error_email'>
													<br>
													<label for='error_id_2' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Incorrect URL</label>
													<input type='text' id='error_id_2' style='width: 60%' ng-model='con[0].error_url'>
													<br>
													<label for='error_id_3' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Incorrect Captcha</label>
													<input type='text' id='error_id_3' style='width: 60%' ng-model='con[0].error_captcha'>
													<br>
													<label for='error_id_4' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Integers Only</label>
													<input type='text' id='error_id_4' style='width: 60%' ng-model='con[0].error_only_integers'>
													<br>
													<label for='error_id_5' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Compulsory Field</label>
													<input type='text' id='error_id_5' style='width: 60%' ng-model='con[0].error_required'>
													<br>
													<label for='error_id_6' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Min Characters</label>
													<input type='text' id='error_id_6' style='width: 60%' ng-model='con[0].error_min'>
													<br>
													<label for='error_id_7' style='width: 30%; display: inline-block; text-align: right; margin-right: 5%; font-size: 12px; margin-top: 6px'>Max Characters</label>
													<input type='text' id='error_id_7' style='width: 60%' ng-model='con[0].error_max'>
													<br>

												</div>
											</div>
										</div>
									</div>
<div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle collapsed">
												6. On Form Submission
											</a>
										</div>

										<div id="form_options_six" class="accordion-body collapse">
											<div class="accordion-inner l2">

												<div class='global_holder'>
													<div class='gh_head'>
														Form Sent Message
													</div>

													<span class='settings_desc'>you can use HTML here</span>
												</p>
												<textarea style='width:96%; margin: 0' rows='4' ng-model='con[0].success_msg'></textarea>
												<div compile='con[0].success_msg' class='nform_res_sample' style='white-space: pre-line'></div>
											</div>
											<div class='global_holder'>

												<div class='gh_head'>
													Form Could Not be Sent Message
												</div>														<span class='settings_desc'>you can use HTML here</span>
											</p>
											<textarea style='width:96%;  margin: 0' rows='4' ng-model='con[0].failed_msg'></textarea>
											<div compile='con[0].failed_msg' class='nform_res_sample' style='white-space: pre-line'></div>

										</div>
										<div class='global_holder'>
											<div class='gh_head'>
												Redirection
											</div>

											<p>URL<br>
												<span class='settings_desc'>redirects the user in case of a successful form submission<br>(disabled in the form builder mode)</span>
											</p>
											<input type='text' style='width: 96%' ng-model='con[0].redirect'>

										</div>
									</div>
								</div>
							</div>

							<?php
							if (function_exists('formed_add_builder'))
							{
								formed_add_builder();
							}

							?>

										<form id='export_form_form' name="myForm" action="<?php echo plugins_url('formed/php/export_form.php?id=').$_GET[id]; ?>" method="POST" target='_blank' style='width: 100%; margin: 0px; padding: 0px; display: inline-block'>

											<input type="hidden" id="export_build" name="build" value = "">
											<input type="hidden" id="export_option" name="options" value = "">
											<input type="hidden" id="export_con" name="con" value = "">
											<input type="hidden" id="export_rec" name="rec" value = "">
											<input type="hidden" id="export_dir" name="dir" value = "<?php echo plugins_url(); ?>">
											<input type="hidden" id="export_dir2" name="dir2" value = "<?php echo site_url(); ?>">

											<a id='export_form' export-link='<?php echo plugins_url('formed/php/export_form.php?id=').$_GET[id]; ?>' class='trans_btn' style='color: green; width: 100%' ng-click='export_form()'>
												Export Form
											</a>


										</form>


									</div>


								</div>
							</div>