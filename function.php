<?php  
    /* 
    Plugin Name: Formed
    Description: Premium WordPress form builder. Make amazing forms, incredibly fast.
    Version: 1.0.2
    GitHub Plugin URI: https://github.com/unetics/formed
	GitHub Branch:     master
    */
    if (!isset($_SESSION)) { session_start(); }
	
	$plugin_data = get_plugin_data( __FILE__ );
  	$plugin_version = $plugin_data['Version'];
    
    global $wpdb, $table_builder, $table_subs, $table_stats, $table_info, $is_multi, $fc_version, $formed_version;
    $table_builder = $wpdb->prefix . "formed_builder";
    $table_subs = $wpdb->prefix . "formed_submissions";
    $table_stats = $wpdb->prefix . "formed_stats";
    $table_info = $wpdb->prefix . "formed_info";
    $fc_version = 2.2;
    $formed_version = $plugin_version;

    $restricted = array('999999','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23');

    add_action('wp_ajax_formed_page', 'formed_page');
    add_action('wp_ajax_nopriv_formed_page', 'formed_page');
    add_action('wp_ajax_formed_update', 'formed_update');
    add_action('wp_ajax_nopriv_formed_update', 'formed_update');
    add_action('wp_ajax_formed_add', 'formed_add');
    add_action('wp_ajax_nopriv_formed_add', 'formed_add');
    add_action('wp_ajax_formed_import', 'formed_import');
    add_action('wp_ajax_nopriv_formed_import', 'formed_import');
    add_action('wp_ajax_formed_del', 'formed_del');
    add_action('wp_ajax_nopriv_formed_del', 'formed_del');
    add_action('wp_ajax_formed_submit', 'formed_submit');
    add_action('wp_ajax_nopriv_formed_submit', 'formed_submit');
    add_action('wp_ajax_formed_sub_upd', 'formed_sub_upd');
    add_action('wp_ajax_nopriv_formed_sub_upd', 'formed_sub_upd');
    add_action('wp_ajax_formed_name_update', 'formed_name_update');
    add_action('wp_ajax_nopriv_formed_name_update', 'formed_name_update');
    add_action('wp_ajax_formed_delete_file', 'formed_delete_file');
    add_action('wp_ajax_nopriv_formed_delete_file', 'formed_delete_file');
    add_action('wp_ajax_formed_chart', 'formed_chart');
    add_action('wp_ajax_nopriv_formed_chart', 'formed_chart');
    add_action('wp_ajax_formed_increment', 'formed_increment');
    add_action('wp_ajax_nopriv_formed_increment', 'formed_increment');
    add_action('wp_ajax_formed_increment2', 'formed_increment2');
    add_action('wp_ajax_nopriv_formed_increment2', 'formed_increment2');
    add_action('wp_ajax_formed_test_email', 'formed_test_email');
    add_action('wp_ajax_nopriv_formed_test_email', 'formed_test_email');
    add_action('wp_ajax_formed_verifyLicense', 'formed_verifyLicense');
    add_action('wp_ajax_nopriv_formed_verifyLicense', 'formed_verifyLicense');

function formed_parse_emails($string, $nos = 100)
{
        $emails = array();
        if(preg_match_all('/\s*"?([^><,"]+)"?\s*((?:<[^><,]+>)?)\s*/', $string, $matches, PREG_SET_ORDER) > 0)
        {
            $i = 0;
            foreach($matches as $m)
            {
                if ($i>=$nos){break;}
                if(! empty($m[2]))
                {
                    if (!filter_var(trim($m[2], '<>'), FILTER_VALIDATE_EMAIL)) {continue;}
                    $emails[trim($m[2], '<>')] = trim($m[1]);
                }
                else
                {
                    if (!filter_var($m[1], FILTER_VALIDATE_EMAIL)) {continue;}
                    $emails[$m[1]] = '';
                }
                $i++;
            }
        }
        return $emails;
    }

function formed_replace_comments($startPoint, $endPoint, $newText, $source) 
{
        $newString = preg_replace('#('.preg_quote($startPoint).')(.*)('.preg_quote($endPoint).')#si', '$1'.$source.'$3', $newText);
        return str_replace($endPoint, '', $newString);
    }

function formed_page()
{
        global $wpdb, $table_subs, $table_builder;
        $skip = (intval(max(1,$_POST['page']))-1)*10;
        if ( !is_user_logged_in()  )
        {
            exit;
        }
        if ( isset($_POST['search']) )
        {
            $search = '%'.addslashes($_POST['search']).'%';
            $mysub = $wpdb->get_results( "SELECT * FROM $table_subs WHERE content LIKE '$search' ORDER BY id DESC LIMIT $skip, 10", 'ARRAY_A' );
        }
        else
        {
            $mysub = $wpdb->get_results( "SELECT * FROM $table_subs ORDER BY id DESC LIMIT $skip, 10", 'ARRAY_A' );            
        }


        foreach ($mysub as $key=>$row)
        {
            $mess[$key] = '';
            $std  = "style='padding: 4px 8px 4px 0; margin: 0; vertical-align: top; width: 30%; display: inline-block'";
            $std2 = "style='padding: 4px 8px 4px 0; margin: 0; vertical-align: top; width: 60%; display: inline-block'";

            $new = json_decode($row['content'],1);
            $att = 1;


            foreach ($new as $value)
            {
                $value['value'] = htmlentities($value['value']);
                $value['value'] = str_replace("&lt;br /&gt;", "<br/>", $value['value']);                
                if ( !(empty($value['type'])) && !($value['type']=='captcha') && !($value['label']=='files') && !($value['label']=='divider') && !($value['label']=='location') )
                {
                    if ( ($value['type']=='radio' || $value['type']=='check' || $value['type']=='stars' || $value['type']=='smiley') && (empty($value['value'])) )
                    {
                        $mess[$key] .= "";
                    }
                    else
                    {
                        $mess[$key] .= "<li><span $std><strong>$value[label] </strong></span><span $std2>$value[value]</span></li>";
                    }
                }
                else if ($value['label']=='files') 
                {
                    $mess[$key] .= "<li><span $std><strong>Attachment($att) </strong></span><a href='$value[value]' target='_blank' $std2>$value[value]</a></li>";
                    $att ++;
                }
                else if ($value['label']=='divider') 
                {
                    $mess[$key] .= "<hr>$value[value]<hr>";
                }
                else if ($value['type']=='hidden' && $value['label']=='location') 
                {
                    $location = $value['value'];
                    $location_url = $value['value'];
                }
            }

            $name = $wpdb->get_results( "SELECT name FROM $table_builder WHERE id=".$row['form_id']." LIMIT 1", 'ARRAY_A' );
            $name = isset($name[0]['name']) ? $name[0]['name'] : 'deleted';            
            $mysub[$key]['name'] = $name;

            $message[$key] = 
            '<div class="fcmodal-header"><h1>'.$name.'</h1><a class="location_url" target="_blank" href="'.$location_url.'">'.$location.'</a></div><ul class="fcmodal-body" style="padding: 25px">
            '.$mess[$key].'
        </ul>';

        $mysub[$key]['content'] = $message[$key];
    }

    echo json_encode($mysub);
    die();
}

function formed_test_email()
{

    global $wpdb, $table_builder;
    error_reporting(0);
    $id = addslashes($_POST['id']);

    $qry = $wpdb->get_results( "SELECT * FROM $table_builder WHERE id = '$id'", 'ARRAY_A' );
    foreach ($qry as $row) {
        $con = stripslashes($row['con']);
        $rec = stripslashes($row['recipients']);
    }
    $con = json_decode($con, 1);
    $rec = formed_parse_emails($rec);
    if (sizeof($rec)==0)
    {
        echo "No email recipient added";
        die();
    }
    $sender_name = $con[0]['mail_type']=='smtp' ? $con[0]['smtp_name'] : $con[0]['from_name'];
    $sender_email = $con[0]['mail_type']=='smtp' ? $con[0]['smtp_email'] : $con[0]['from_email'];
    $email_subject = "Test Email from formed";
    $email_body = "Hey<br>This is a test email from formed. If you have received it, it means your email settings are working fine.";

    /* SwiftMailer Test */
    error_reporting(0);
    require_once('php/swift/lib/swift_required.php');

    if ($con[0]['smtp_port']=='')
    {
        $con[0]['smtp_port'] = $con[0]['if_ssl']=='tls' ? 587 : 465;
        $con[0]['smtp_port'] = $con[0]['if_ssl']=='false' || $con[0]['if_ssl']=='' ? 25 : $con[0]['smtp_port'];
    }

    if ($con[0]['mail_type']=='smtp')
    {
        if ($con[0]['if_ssl']=='ssl' || $con[0]['if_ssl']=='tls')
        {
            $transport = Swift_SmtpTransport::newInstance($con[0]['smtp_host'], $con[0]['smtp_port'], $con[0]['if_ssl'])
            ->setUsername($con[0]['smtp_username'])
            ->setPassword($con[0]['smtp_pass']);            
        }
        else
        {
            $transport = Swift_SmtpTransport::newInstance($con[0]['smtp_host'], $con[0]['smtp_port'])
            ->setUsername($con[0]['smtp_username'])
            ->setPassword($con[0]['smtp_pass']);            
        }
    }
    else
    {
        $transport = Swift_MailTransport::newInstance();
    }


    $sent = 0;
    foreach($rec as $emailTo => $nameTo)
    {
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance()
        ->setSubject($email_subject)
        ->setFrom(array($sender_email => $sender_name))
        ->setTo(array($emailTo => $nameTo))
        ->setBody($email_body, 'text/html');

        try
        {
            if ($mailer->send($message, $failures)) { $sent++; }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    echo "Sent $sent email(s)";
    die();
}

function formed_increment2()
{
    error_reporting(0);
    formed_increment($_POST['id']);
}

function formed_increment($id)
{
    error_reporting(0);
    global $wpdb, $table_stats, $table_builder, $table_info;

    if (!isset($id))
    {
        if (isset($_POST['id']))
        {
            $id = addslashes($_POST['id']);
        }
        else if (isset($_GET['id']))
        {
            $id = addslashes($_GET['id']);
        }
    }


    $wpdb->query( "UPDATE $table_builder SET
        views = views + 1
        WHERE id = '$id'" );


    $insert = $wpdb->insert( $table_stats, array( 
        'id' => $id
        ) );

    $date2 = date('Y-m-d');

    $temp1 = $wpdb->query( "SELECT * FROM $table_info WHERE time = '$date2' AND id = $id " );

    if ($temp1>=1)
    {
        $wpdb->query( "UPDATE $table_info SET views = views + 1 WHERE id = $id AND time = '$date2' " );
    }
    else
    {
        $temp2 = $wpdb->insert( $table_info, array( 'time' => $date2, 'views' => 1, 'submissions' => 0, 'id' => $id ) );
    }

}

function formed_chart()
{
    error_reporting(0);
    global $wpdb, $table_subs, $table_builder, $table_stats, $table_info;
    $_POST['id'] = addslashes($_POST['id']);

    $to = isset($_POST['to']) && !empty($_POST['to']) ? addslashes($_POST['to']) : date('Y/m/d', strtotime('now'));
    $from = isset($_POST['from']) && !empty($_POST['from']) ? addslashes($_POST['from']) : date('Y/m/d', strtotime('-30 days', strtotime($to)));
    
    $diff = strtotime($to) - strtotime($from);
    $diff = floor($diff/(60*60*24));

    $from = $diff > 90 ? date('Y/m/d', strtotime('-90 days', strtotime($to))) : $from;
    $from = $diff < 1 ? date('Y/m/d', strtotime('-1 days', strtotime($to))) : $from;

    $diff = $diff > 90 ? 90 : $diff;
    $diff = $diff < 1 ? 1 : $diff;

    if (ctype_digit($_POST['id']))
    {
        $subs = $wpdb->get_results( "SELECT * FROM $table_info WHERE id = $_POST[id] ORDER BY time", "ARRAY_A" );
    }
    else
    {
        $subs = $wpdb->get_results( "SELECT * FROM $table_info ORDER BY time", "ARRAY_A" );
    }

    foreach ($subs as $key => $value) 
    {
        if ($subs[$key]['time']==$subs[$key+1]['time'])
        {
            $subs[$key+1]['views'] = $subs[$key+1]['views']+$subs[$key]['views'];
            $subs[$key+1]['submissions'] = $subs[$key+1]['submissions']+$subs[$key]['submissions'];
            unset($subs[$key]);
        }
    }

    foreach ($subs as $key => $value)
    {
        $result[$value['time']] = array('views'=>$value['views'],'submissions'=>$value['submissions']);
    }

    $i = 0;
    $final = array();
    while ($i<=$diff)
    {
        $dateTemp0 = date("Y-m-d", strtotime('+'.$i.'day', strtotime($from)));
        $dateTemp1 = date("d M", strtotime('+'.$i.'day', strtotime($from)));
        $final[] = isset($result[$dateTemp0]) ? array('time'=>$dateTemp1,'views'=>$result[$dateTemp0]['views'],'submissions'=>$result[$dateTemp0]['submissions']) : array('time'=>$dateTemp1,'views'=>0,'submissions'=>0);
        $i++;
    }

    foreach ($final as $key => $value)
    {
        $dt = date_parse($final[$key]['time']);
        $diff_m = abs(($dt['month']-date('m'))*30);
        $diff_d = date('d')-$dt['day'];
        $month = date('Y-m-d');
        $diff = $diff_m+$diff_d;
        $final[$key]['time'] = date("d M", strtotime($final[$key]['time']));
        $views[] = array($final[$key]['time'], $final[$key]['views']);
        $submissions[] = array($final[$key]['time'], $final[$key]['submissions']);
    }

    $data['views'] = $views;
    $data['submissions'] = $submissions;

    echo json_encode($data);
    die();
}

function formed_delete_file()
{
    global $wpdb;
    error_reporting(0);

    if (isset($_POST['key']))
    {
        $key = explode('---', $_POST['key']);
        if (function_exists('is_multisite') && is_multisite())
        {
            $url = get_home_path().'wp-content/plugins/formed/file-upload/server/content/files/'.$wpdb->blogid.'/info.txt';
            $file_name = get_home_path().'wp-content/plugins/formed/file-upload/server/content/files/'.$wpdb->blogid.'/'.$_POST['key'];
        }
        else
        {
            $url = get_home_path().'wp-content/plugins/formed/file-upload/server/content/files/info.txt';
            $file_name = get_home_path().'wp-content/plugins/formed/file-upload/server/content/files/'.$_POST['key'];
        }
        $new = file_get_contents($url);
        $new = json_decode($new, 1);

        if (is_file($file_name))
        {
            unlink($file_name);
            unset($new[$key[0]]);
            file_put_contents($url, json_encode($new));            
            echo "Deleted";
        }
        else
        {
            echo "Not";
        }        
    }

    if (isset($_POST['name']))
    {
        $file_name = get_home_path().'wp-content/plugins/formed/file-upload/server/php/files/'.$_POST['name'];
        if (is_file($file_name))
        {
            unlink($file_name);
            echo "Deleted";
        }
        else
        {
            echo "Not";
        }
    }
    die();
}

function formed_sub_upd()
{
    error_reporting(0);

    global $wpdb, $table_subs, $table_builder;

    $id = addslashes($_POST['id']);
    $type = addslashes($_POST['type']);

    if ($type=='upd')
    {
        $wpdb->query( "UPDATE $table_subs SET
            seen = '1'
            WHERE id = '$id'" );
    }
    else if ($type=='del')
    {
        if ($wpdb->query( "DELETE FROM $table_subs WHERE id = '$id'" ))
        {    
            echo 'D';
        }
    }
    else if ($type=='read')
    {
        if ($wpdb->query( "UPDATE $table_subs SET seen = NULL WHERE id = '$id'" ))
        {    
            echo 'D';
        }
    }


    die();

}

function formed_name_update()
{
    error_reporting(0);

    global $wpdb, $table_subs, $table_builder, $restricted;

    $id = addslashes($_POST['id']);
    $name = addslashes($_POST['name']);

    $wpdb->query( "UPDATE $table_builder SET
        name = '$name'
        WHERE id = '$id'" );

    echo 'D';

    die();

}

function formed_submit()
{
    error_reporting(0);
    global $errors, $id;
    $conten = file_get_contents('php://input');
    $conten = explode('&', $conten);
    $nos = sizeof($conten);
    $title = $_POST['title'];
    $id = $_POST['id'];

    $i = 0;
    while ($i<$nos)
    {
        $cont = explode('=', $conten["$i"]);
        $content[$cont[0]]=$cont[1];
        $content_ex = explode('_',$cont[0]);
        if ( !($content_ex[0]=='id') && !($content_ex[0]=='action') )
        {
            $new[$i]['label'] = $content_ex[0];
            $new[$i]['value'] = urldecode($cont[1]);
            $new[$i]['type'] = $content_ex[1];
            $new[$i]['validation'] = $content_ex[2];
            $new[$i]['required'] = $content_ex[3];
            $new[$i]['min'] = $content_ex[4];
            $new[$i]['max'] = $content_ex[5];
            $new[$i]['tooltip'] = $content_ex[6];
            $new[$i]['custom'] = $content_ex[7];
            $new[$i]['custom2'] = $content_ex[8];
            $new[$i]['custom3'] = $content_ex[9];
            $new[$i]['custom4'] = $content_ex[10];
            $new[$i]['custom5'] = $content_ex[11];
        }
        $i++;
    }

    /* Get Form Options */
    global $wpdb, $table_subs, $table_builder, $table_info;

    $qry = $wpdb->get_results( "SELECT * FROM $table_builder WHERE id = '$id'", 'ARRAY_A' );
    foreach ($qry as $row) {
        $con = stripslashes($row['con']);
        $title = stripslashes($row['name']);
        $rec = stripslashes($row['recipients']);
    }

    $con = json_decode($con, 1);
    $rec = formed_parse_emails($rec);

    if (isset($_POST['emails']))
    {
        $rec = array_merge($rec, formed_parse_emails($_POST['emails']));
    }


	
    /* Apply filter to recipients before sending so it can be handle externally  */
    $rec = apply_filters('formed_presend_recipients', $rec, $id);

    /* Run the Validation Functions */
    $i = 0;

    $ar_inc = 1;
    while ($i<$nos)
    {
        if ($new[$i]['custom']=='autoreply')
            {$autoreply[$ar_inc]=$new[$i]['value']; $ar_inc++;}
        $new[$i]['custom3'] = 'zz'.$new[$i]['custom3'];

        if ($new[$i]['type']=='email' && $new[$i]['custom4']=='notif')
        {
            $rec[$new[$i]['value']] = '';
        }
        if ($new[$i]['type']=='email' && $new[$i]['custom5']=='notif')
        {
            $rec[$new[$i]['value']] = '';
        }
        if ($new[$i]['label']=='files')
        {
            $filePath = dirname(__FILE__).'/file-upload/server/content/files/'.substr($new[$i]['value'], strrpos($new[$i]['value'], '/')+1);
            if ((filesize($filePath)/1048576)<100)
            {
                $attachments[] = $filePath;
            }
        }


        /* Prepare List for MailChimp */
        if ($new[$i]['type']=='email' && (strpos($new[$i]['custom3'], 'm')==true) )
            { $mc_add[]=$new[$i]['value'];}

        /* Prepare List for AWeber */
        if ($new[$i]['type']=='email' && (strpos($new[$i]['custom3'], 'a')==true) )
            { $aw_add[]=$new[$i]['value'];}

        /* Prepare List for Campaign Monitor */
        if ($new[$i]['type']=='email' && (strpos($new[$i]['custom3'], 'c')==true) )
            { $campaign_add[]=$new[$i]['value'];}

        /* Prepare List for MyMail */
        if ($new[$i]['type']=='email' && $new[$i]['custom4']=='true')
        {
            $mm_add[]=$new[$i]['value'];
            $mm++;
        }

        /* Prepare List of Custom Variables for MC or MM */
        if ( $new[$i]['type']!='email' && isset($new[$i]['custom']) )
        {
            if (!empty($new[$i]['value']))
            {
                $custom_var[$new[$i]['custom']] = $new[$i]['value'];            
            }
        }




        if ($new[$i]['custom2']=='replyto')
            {$replyto = $new[$i]['value'];}

        if ($new[$i]['type']=='upload' && $new[$i]['value']=='0')
            {$new[$i]['value']=null;}



        formed_no_val($new[$i]['value'], $new[$i]['required'], $new[$i]['min'], $new[$i]['max'], $new[$i]['tooltip'], $con[0]);


        if (function_exists('formed_'.$new[$i]['validation']))
        {
            $fncall = 'formed_'.$new[$i]['validation'];
            $fncall($new[$i]['value'], $new[$i]['validation'], $new[$i]['required'], $new[$i]['min'], $new[$i]['max'], $new[$i]['tooltip'], $con[0]);
        }

        $i++;
    }


    if( sizeof($errors) )
    {
        if ($con[0]['error_gen']!=null)
        {
            $errors['errors'] = $con[0]['error_gen'];
        }
        else
        {
            $errors['errors'] = '';
        }
        $errors = json_encode($errors);
        echo $errors;
    }
    else
    {   

        global $wpdb, $table_subs, $table_builder;

        $qry = $wpdb->get_results( "SELECT * FROM $table_builder WHERE id = '$id'", 'ARRAY_A' );
        foreach ($qry as $row) {
            $con = stripslashes($row['con']);
        }
        $con = json_decode($con, 1);



        $sender_name = $con[0]['from_name'];
        $sender_email = $con[0]['from_email'];

        $success_sent = 0;

        /* Add to MailChimp */
        if (defined('formed_ADD'))
        {

            if ($con[0]['mc_double']=='true') {$con[0]['mc_double']=true;} else {$con[0]['mc_double']=false;}
            if ($con[0]['mc_welcome']=='true') {$con[0]['mc_welcome']=true;} else {$con[0]['mc_welcome']=false;}

            if ($con[0]['mc_list'] && isset($mc_add) && function_exists('mailchimp_fc'))
            {
                mailchimp_fc($mc_add, $custom_var, $con[0]['mc_list'], $con[0]['mc_double'], $con[0]['mc_welcome']);        
            }

            if ($con[0]['aw_list'] && isset($aw_add) && function_exists('aweber_fc'))
            {
                aweber_fc($aw_add, $custom_var, $con[0]['aw_list']);        
            }

            if ($con[0]['campaign_list'] && isset($campaign_add) && function_exists('campaign_fc'))
            {
                campaign_fc($campaign_add, $custom_var, $con[0]['campaign_list']);        
            }

        }


        /* Add to MyMail */
        if ( isset($con[0]['mm_list']) && defined('MYMAIL_VERSION'))
        {
            $template = 'notification.html';
            foreach ($mm_add as $mm_email)
            {
                mymail_subscribe($mm_email,$custom_var,$con[0]['mm_list'],NULL,true,NULL,$template);
            }
        }



        /* Make the Email */
        $label_style = "padding: 4px 8px 4px 0px; margin: 0; width: 180px; font-size: 13px; font-weight: bold";
        $value_style = "padding: 4px 8px 4px 0px; margin: 0; font-size: 13px";
        $divider_style = "padding: 10px 8px 4px 0px; margin: 0; font-size: 16px; font-weight: bold; border-bottom: 1px solid #ddd";

        $i=0;
        $att=1;

        $email_body = '';

        while ($i<$nos)
        {
            $new[$i]['value'] = nl2br($new[$i]['value']);

            if ($new[$i]['label']!='files')
            {
                $new[$i]['label'] = urldecode($new[$i]['label']);
                $new[$i]['value'] = $new[$i]['value'];                 
            }

            if ( !(empty($new[$i]['type'])) && !($new[$i]['type']=='captcha') && !($new[$i]['type']=='hidden') && !($new[$i]['label']=='files') && !($new[$i]['label']=='divider') && !($new[$i]['type']=='radio') && !($new[$i]['type']=='check')  && !($new[$i]['type']=='smiley') && !($new[$i]['type']=='stars') && !($new[$i]['type']=='matrix') )
            {
                $email_body .= "<tr><td style='$label_style'> ".$new[$i]['label']."</td><td style='$value_style'>".htmlentities($new[$i]['value'])."</td></tr>";
            }
            else if ( $new[$i]['label']=='files' )
            {
                $email_body .= "<tr><td style='$label_style'>Attachment($att)</td><td style='$value_style'><a href='".$new[$i]['value']."'>".$new[$i]['value']."</a></td></tr>";
                $att++;
            }
            else if ( $new[$i]['label']=='divider' )
            {
                $email_body .= "</table><table style='border: 0px; color: #333; width: 100%'><tr><td style='$divider_style'>".$new[$i]['value']."</td></tr></table><table>";
            }
            else if ( $new[$i]['type']=='hidden' && $new[$i]['label']=='location' )
            {
                $location = $new[$i]['value'];
            }
            else if ( $new[$i]['type']=='hidden' )
            {
                $email_body .= "<tr><td style='$label_style'> ".$new[$i]['label']."</td><td style='$value_style'>".$new[$i]['value']."</td></tr>";
            }
            else if (  $new[$i]['type']=='radio' || $new[$i]['type']=='check' || $new[$i]['type']=='smiley' || $new[$i]['type']=='stars' || $new[$i]['type']=='matrix' )
            {
                if ( $new[$i]['value']==true )
                {
                    $email_body .= "<tr><td style='$label_style'>".$new[$i]['label']."</td><td style='$value_style'> ".$new[$i]['value']."</td></tr>";
                }
            }

            $i++;
        }
        $email_body = "<table cellpadding='0' cellspacing='0' style='border: 0px; color: #333; width: 100%'>".$email_body."</table>";

        $con[0]['email_body'] = nl2br($con[0]['email_body']);
        if ( isset($con[0]['email_body']) && $con[0]['email_body']!='' )
        {
            $email_body = str_replace("[Form Content]", $email_body, $con[0]['email_body']);            
        }
        else
        {
            $email_body = "<h3 style='margin-bottom: 20px'>$title</h3>$email_body";
        }
        $email_body = str_replace("[Form Name]",$title,$email_body);
        $email_body = str_replace("[URL]",$location,$email_body);
        $email_body = str_replace("[form_name]",$title,$email_body);

        $subIDRow = $wpdb->get_results( "SELECT MAX(id) FROM $table_subs", ARRAY_A );
        $subID = intval($subIDRow[0]['MAX(id)'])+1;        

        $pattern = '/\[.*?\]/';
        preg_match_all($pattern, $con['0']['autoreply'], $matches);
        foreach ($new as $field)
        {
            foreach ($matches[0] as $match)
            {

                $match2 = str_replace('[','',$match);
                $match2 = str_replace(']','',$match2);
                if ($field['label']==$match2)
                {
                    $con['0']['autoreply'] = str_replace($match, $field['value'], $con['0']['autoreply']);
                }
            }
        }

        $pattern = '/\[.*?\]/';
        preg_match_all($pattern, $email_body, $matches);
        foreach ($new as $field)
        {
            foreach ($matches[0] as $match)
            {

                $match2 = str_replace('[','',$match);
                $match2 = str_replace(']','',$match2);
                if ($field['label']==$match2)
                {
                    $email_body = str_replace($match, $field['value'], $email_body);
                }
            }
        }        

        preg_match_all($pattern, $con['0']['autoreply_s'], $matches);
        foreach ($new as $field)
        {
            foreach ($matches[0] as $match)
            {

                $match2 = str_replace('[','',$match);
                $match2 = str_replace(']','',$match2);
                if ($field['label']==$match2)
                {
                    $con['0']['autoreply_s'] = str_replace($match, $field['value'], $con['0']['autoreply_s']);
                }
            }
        }

        preg_match_all($pattern, $con[0]['email_sub'], $matches);
        foreach ($new as $field)
        {
            foreach ($matches[0] as $match)
            {

                $match2 = str_replace('[','',$match);
                $match2 = str_replace(']','',$match2);
                if ($field['label']==$match2)
                {
                    $con[0]['email_sub'] = str_replace($match, $field['value'], $con[0]['email_sub']);
                }
            }
        }

        $sender_name = $con[0]['mail_type']=='smtp' ? $con[0]['smtp_name'] : $con[0]['from_name'];
        $sender_email = $con[0]['mail_type']=='smtp' ? $con[0]['smtp_email'] : $con[0]['from_email'];

        preg_match_all($pattern, $sender_name, $matches);
        foreach ($new as $field)
        {
            foreach ($matches[0] as $match)
            {

                $match2 = str_replace('[','',$match);
                $match2 = str_replace(']','',$match2);
                if ($field['label']==$match2)
                {
                    $sender_name = str_replace($match, $field['value'], $sender_name);
                }
            }
        }

        preg_match_all($pattern, $sender_email, $matches);
        foreach ($new as $field)
        {
            foreach ($matches[0] as $match)
            {

                $match2 = str_replace('[','',$match);
                $match2 = str_replace(']','',$match2);
                if ($field['label']==$match2)
                {
                    $sender_email = str_replace($match, $field['value'], $sender_email);
                }
            }
        }

        $sender_email = filter_var($sender_email, FILTER_VALIDATE_EMAIL) ? $sender_email : '';
        $autoreply_email = filter_var($con[0]['autoreply_email'], FILTER_VALIDATE_EMAIL) ? $con[0]['autoreply_email'] : $sender_email;
        $autoreply_name = $con[0]['autoreply_name'] ? $con[0]['autoreply_name'] : $sender_name;

        $con[0]['email_sub'] = str_replace("[form_name]",$title,$con[0]['email_sub']);
        $con[0]['autoreply_s'] = str_replace("[form_name]",$title,$con[0]['autoreply_s']);
        $con[0]['autoreply'] = str_replace("[form_name]",$title,$con[0]['autoreply']);

        $con[0]['email_sub'] = str_replace("[Form Name]",$title,$con[0]['email_sub']);
        $con[0]['autoreply_s'] = str_replace("[Form Name]",$title,$con[0]['autoreply_s']);
        $con[0]['autoreply'] = str_replace("[Form Name]",$title,$con[0]['autoreply']);

        $con[0]['email_sub'] = str_replace("[ID]",$subID,$con[0]['email_sub']);
        $con[0]['autoreply_s'] = str_replace("[ID]",$subID,$con[0]['autoreply_s']);
        $con[0]['autoreply'] = str_replace("[ID]",$subID,$con[0]['autoreply']);

        $con[0]['email_sub'] = str_replace("{{form_name}}",$title,$con[0]['email_sub']);
        $con[0]['autoreply_s'] = str_replace("{{form_name}}",$title,$con[0]['autoreply_s']);
        $con[0]['autoreply'] = str_replace("{{form_name}}",$title,$con[0]['autoreply']);

        $email_subject = $con[0]['email_sub'];


        /* SwiftMailer Test */
        require_once('php/swift/lib/swift_required.php');

        if ($con[0]['smtp_port']=='')
        {
            $con[0]['smtp_port'] = $con[0]['if_ssl']=='tls' ? 587 : 465;
            $con[0]['smtp_port'] = $con[0]['if_ssl']=='false' || $con[0]['if_ssl']=='' ? 25 : $con[0]['smtp_port'];
        }

        if ($con[0]['mail_type']=='smtp')
        {
            if ($con[0]['if_ssl']=='ssl' || $con[0]['if_ssl']=='tls')
            {
                $transport = Swift_SmtpTransport::newInstance($con[0]['smtp_host'], $con[0]['smtp_port'], $con[0]['if_ssl'])
                ->setUsername($con[0]['smtp_username'])
                ->setPassword($con[0]['smtp_pass']);            
            }
            else
            {
                $transport = Swift_SmtpTransport::newInstance($con[0]['smtp_host'], $con[0]['smtp_port'])
                ->setUsername($con[0]['smtp_username'])
                ->setPassword($con[0]['smtp_pass']);            
            }
        }
        else
        {
            $transport = Swift_MailTransport::newInstance();
        }

        if ($replyto==false) {$replyto = $sender_email;}

        $sent = 0;
        foreach($rec as $emailTo => $nameTo)
        {
            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance()
            ->setSubject($email_subject)
            ->setFrom(array($sender_email => $sender_name))
            ->setTo(array($emailTo => $nameTo))
            ->setBody($email_body, 'text/html')
            ;

            if (filter_var($replyto, FILTER_VALIDATE_EMAIL))
            {
                $message->setReplyTo(array($replyto));
            }
            if ( isset($attachments) && count($attachments)>0 )
            {
                foreach ($attachments as $value)
                {
                    $message->attach(Swift_Attachment::fromPath($value));
                }
            }

            try
            {
                if ($mailer->send($message, $failures)) { $sent++; }
            } catch (\Exception $e) {
                //echo $e->getMessage();
            }
        }

        if ($autoreply)
        {  
            foreach ($autoreply as $user_email)
            {
                if (empty($user_email)) continue;
                $mailer = Swift_Mailer::newInstance($transport);
                $message = Swift_Message::newInstance()
                ->setSubject($con['0']['autoreply_s'])
                ->setFrom(array($autoreply_email => $autoreply_name))
                ->setReplyTo(array($autoreply_email => $autoreply_name))
                ->setTo(array($user_email))
                ->setBody("<div style='white-space: pre-line'>".$con['0']['autoreply']."</div>", 'text/html')
                ;
                try
                {
                    $mailer->send($message, $failures);
                } catch (\Exception $e) {
                  //echo $e->getMessage();
                }
            }
        }



        $new_json = json_encode($new);

        global $wpdb, $table_subs, $table_builder, $table_info;


        $date = date('d M Y (H:i)');
        $date2 = date('Y-m-d');


        $temp1 = $wpdb->query( "SELECT * FROM $table_info WHERE time = '$date2' AND id = $id " );

        if ($temp1>=1)
        {
            $wpdb->query( "UPDATE $table_info SET submissions = submissions + 1 WHERE id = $id  AND time = '$date2' " );
        }
        else
        {
            $temp2 = $wpdb->insert( $table_info, array( 'time' => $date2, 'views' => 0, 'submissions' => 1, 'id' => $id ) );
        }

        $rows_affected = $wpdb->insert( $table_subs, array( 'content' => $new_json, 'seen' => NULL, 'added' => $date, 'form_id' => $id ) );

        $result['done'] = $rows_affected;


        /* Display Success Message if Form Submission Updated in DataBase */
        if($rows_affected)
        {
            if ( isset($_POST['multi']) && $_POST['multi']=='false' )
            {
                setcookie('fcwp',$_COOKIE['fcwp'].','.$id,time()+60*60*24*365,'/');
            }
            $error['sent']="true";
            $error['msg']="Message Sent";
            if ( (isset($con[0]['redirect'])) && !(empty($con[0]['redirect'])) )
            {
                $error['redirect']=$con[0]['redirect'];
            }


            $wpdb->query( "UPDATE $table_builder SET
                submits = submits + 1
                WHERE id = '$id'" );


            if (isset($con[0]['success_msg']))
            {
                $error['msg']=$con[0]['success_msg'];
            }

            echo json_encode($error);
        }
        else
        {
            $error['sent']="false";  
            $error['msg']="The message could not be sent";

            if (isset($con[0]['failed_msg']))
            {
                $error['msg']=$con[0]['failed_msg'];
            }

            echo json_encode($error);

        }

    }
    die();
}

function formed_email($value, $valid, $req, $min, $max, $tool, $con)
{
    error_reporting(0);
    global $errors;
    $a=0;

    if ( (!(empty($value))) && !(filter_var($value, FILTER_VALIDATE_EMAIL)) )
    {
        if (isset($con['error_email']))
        {
            $errors[$tool][$a] = $con['error_email'];
        }
        else
        {
            $errors[$tool][$a] = 'Incorrect email format.';
        }
        $a++;
    }

}

function formed_url($value, $valid, $req, $min, $max, $tool, $con)
{
    error_reporting(0);
    global $errors;
    $a=0;

    if ( (!(empty($value))) && !(filter_var($value, FILTER_VALIDATE_URL)) )
    {

        if (isset($con['error_url']))
        {
            $errors[$tool][$a] = $con['error_url'];
        }
        else
        {
            $errors[$tool][$a] = 'Incorrect URL format.';
        }
        $a++;
    }

}

function formed_captcha($value, $valid, $req, $min, $max, $tool, $con)
{
    global $errors;
    $a=0;
    $answers = array_filter($_SESSION["security_number_new"]);

    if (isset($answers))
    {
        $exists = in_array( strtoupper($value), $answers);
        if ( !($exists) )
        {
            if (isset($con['error_captcha']))
            {
                $errors[$tool][$a] = $con['error_captcha'];
            }
            else
            {
                $errors[$tool][$a] = "Incorrect Captcha";
            }
            $a++;
        }
    }
    else
    {
        if ( !(strtolower($_SESSION["security_number"])==strtolower($value)) )
        {
            if (isset($con["error_captcha"]))
            {
                $errors[$tool][$a] = $con["error_captcha"];
            }
            else
            {
                $errors[$tool][$a] = "Incorrect Captcha";
            }
            $a++;
        }

    }


}

function formed_integers($value, $valid, $req, $min, $max, $tool, $con)
{
    global $errors;
    $a=0;



    if ( (!(empty($value))) && !(is_numeric($value)) )
    {
        if (isset($con['error_only_integers']))
        {
            $errors[$tool][$a] = $con['error_only_integers'];
        }
        else
        {
            $errors[$tool][$a] = 'Only integers allowed';
        }
        $a++;
    }

}

function formed_no_val($value, $req, $min, $max, $tool, $con)
{
    global $errors;
    $a=0;

    if ( ( $req==1 || $req=='true' ) && empty($value) && $value!='0' )
    {
        if (isset($con['error_required']))
        {
            $errors[$tool][$a] = $con['error_required'];
        }
        else
        {
            $errors[$tool][$a] = 'This field is required';
        }
        $a++;
    }
    if ( (!(empty($min))) && (!(empty($value))) && (strlen($value)<$min) )
    {
        if (isset($con['error_min']))
        {
            if (strpbrk($con['error_min'],'[min_chars]'))
            {
                $con['error_min'] = explode("[min_chars]", $con['error_min'] );
                $errors[$tool][$a] = isset($con['error_min'][1]) ? $con['error_min'][0].$min.$con['error_min'][1] : $con['error_min'][0];
            }
            else
            {
                $errors[$tool][$a] = $con['error_min'];
            }
        }
        else
        {
            $errors[$tool][$a] = 'At least '.$min.' characters required';
        }
        $a++;
    }
    if ( (!(empty($max))) && (!(empty($value))) && (strlen($value)>$max) )
    {
        if (isset($con['error_max']))
        {
            if (strpbrk($con['error_max'],'[max_chars]'))
            {
                $con['error_max'] = explode("[max_chars]", $con['error_max'] );
                $errors[$tool][$a] =  isset($con['error_max'][1]) ? $con['error_max'][0].$max.$con['error_max'][1] : $con['error_max'][0];
            }
            else
            {
                $errors[$tool][$a] = $con['error_max'];
            }
        }
        else
        {
            $errors[$tool][$a] = 'At most '.$max.' characters allowed';
        }
        $a++;
    }

}

function formed_alphabets($value, $valid, $req, $min, $max, $tool, $con)
{
    global $errors;
    $a=0;

    if ( (!(empty($value))) && !(ctype_alpha(str_replace(' ', '', $value))) )
    {

        $errors[$tool][$a] = 'Only alphabets allowed';
        $a++;
    }

}

function formed_alpha($value, $valid, $req, $min, $max, $tool, $con)
{
    global $errors;
    $a=0;

    if ( (!(empty($value))) && !(ctype_alnum(str_replace(' ', '', $value))) )
    {
        $errors[$tool][$a] = 'Only alphabets and numbers allowed';
        $a++;
    }

}

function formed_update() 
{


    global $wpdb, $table_subs, $table_builder, $restricted;

    $id = addslashes($_POST['id']);
    $html = addslashes($_POST['content']);
    $build = addslashes($_POST['build']);
    $option = addslashes($_POST['option']);
    $con = addslashes($_POST['con']);
    $recipients = addslashes($_POST['rec']);

    if ( isset($_POST['key']) && $_POST['key']=='false' )
    {
        $html = formed_replace_comments('');
    }

    $wpdb->query( "UPDATE $table_builder SET
        build = '$build',
        options = '$option',
        con = '$con',
        recipients = '$recipients',
        html = '$html'
        WHERE id = '$id'" );
    $wpdb->show_errors();

    die();
}

function formed_add() 
{

    global $wpdb, $table_subs, $table_builder, $restricted;
    error_reporting(0);

    $_POST['name'] = addslashes($_POST['name']);
    $_POST['desc'] = addslashes($_POST['desc']);

    if (empty($_POST['name']))
    {
        $result2['Error'] = 'Name is required';
        echo json_encode($result2);
        die();
    }
    if (strlen($_POST['name'])<2)
    {
        $result2['Error'] = 'Name is too short';
        echo json_encode($result2);
        die();
    }
    if (strlen($_POST['name'])>90)
    {
        $result2['Error'] = 'Name is too long';
        echo json_encode($result2);
        die();
    }
    if (strlen($_POST['desc'])>500)
    {
        $result2['Error'] = 'Description is too long';
        echo json_encode($result2);
        die();
    }
    if ( (!(empty($_POST['desc']))) && strlen($_POST['desc'])<3)
    {
        $result2['Error'] = 'Description is too short';
        echo json_encode($result2);
        die();
    }

    $dt = date('d M Y (H:i)');
    $_POST['name'] = addslashes($_POST['name']);
    $_POST['desc'] = addslashes($_POST['desc']);


    if ($_POST['type_form']=='duplicate')
    {
        $dup = $_POST['duplicate'];

        $dup_id = $wpdb->get_results( "SELECT * FROM $table_builder WHERE id = $dup ", "ARRAY_A" );
        $rows_affected = $wpdb->insert( $table_builder, array( 
            'name' => $_POST['name'], 
            'description' => $_POST['desc'], 
            'html' => $dup_id[0]['html'], 
            'build' => $dup_id[0]['build'], 
            'options' => $dup_id[0]['options'], 
            'con' => $dup_id[0]['con'], 
            'recipients' => $dup_id[0]['recipients'], 
            'added' => $dt 
            ) );

        $result['done'] = $rows_affected;
    }
    else if ($_POST['type_form']=='import')
    {

        if (empty($_POST['import_form']))
        {
            $result2['Error'] = 'Upload a form to be imported';
            echo json_encode($result2);
            die();
        }
        $temp = $_POST['import_form'];
        error_reporting(0);

        $_POST['import_form'] = str_replace(' ', '%20', $_POST['import_form']);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, plugins_url('formed/file-upload/server/content/files/'.$_POST['import_form']));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($data, 1);

        if ($data['dir2'])
        {
            $data = str_replace($data['dir2'], site_url(), $data);
        }
        $data = str_replace($data['dir'], plugins_url(), $data);

        if (empty($data))
        {
            $result2['Error'] = 'Import failed';
            echo json_encode($result2);
            unlink(__DIR__.'/file-upload/server/content/files/'.$_POST['import_form']);
            die();
        }

        $rows_affected = $wpdb->insert( $table_builder, array( 
            'name' => $_POST['name'], 
            'description' => $_POST['desc'], 
            'html' => $data['html'], 
            'build' => $data['build'], 
            'options' => $data['options'], 
            'con' => $data['con'], 
            'recipients' => $data['recipients'], 
            'added' => $dt 
            ) );

        unlink(__DIR__.'/file-upload/server/content/files/'.$_POST['import_form']);

    }
    else
    {
        $rows_affected = $wpdb->insert( $table_builder, array( 'name' => $_POST['name'], 'description' => $_POST['desc'], 'added' => $dt ) );
        $result['done'] = $rows_affected;
    }


    if($rows_affected)
    {
        $wpdb->query( "SELECT MAX(id) FROM $table_builder", "ARRAY_A" );
        $result2['Added']= $wpdb->insert_id;
        echo json_encode($result2);
    }

    die();
}

function formed_del() 
{
    global $wpdb, $table_subs, $table_builder, $table_info, $restricted;
    $id = addslashes($_POST['id']);

    if ($wpdb->query( "DELETE FROM $table_builder WHERE id = '$id'" ))
    {
        if ($wpdb->query( "DELETE FROM $table_info WHERE id = '$id'" ))
        {
            echo "Deleted";
        }
        else
        {
            echo "Deleted";
        }
    }

    die();
}

function checkTables()
{
    global $wpdb, $table_subs, $table_builder, $table_stats, $table_info, $fc_mse, $is_multi;

    if ( isset($fc_mse) && $fc_mse==true || $is_multi==false )
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        if($wpdb->get_var("SHOW TABLES LIKE '$table_builder'") != $table_builder)
        {
            $sql = "CREATE TABLE $table_builder (id mediumint(9) NOT NULL AUTO_INCREMENT,name tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,description tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,html MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,build MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,options MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,con MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,recipients text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,added text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,views INT NOT NULL DEFAULT '0',submits INT NOT NULL DEFAULT '0',UNIQUE KEY id (id)) CHARACTER SET utf8 COLLATE utf8_general_ci"; dbDelta($sql);
        }

        if($wpdb->get_var("SHOW TABLES LIKE '$table_subs'") != $table_subs)
        {
            $sql = "CREATE TABLE $table_subs (id mediumint(9) NOT NULL AUTO_INCREMENT,content text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,seen tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,form_id tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,added text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,UNIQUE KEY id (id)) CHARACTER SET utf8 COLLATE utf8_general_ci";
            dbDelta($sql);
        }

        if($wpdb->get_var("SHOW TABLES LIKE '$table_stats'") != $table_stats)
        {
            $sql = "CREATE TABLE $table_stats (`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,`id` INT NOT NULL) CHARACTER SET utf8 COLLATE utf8_general_ci";
            dbDelta($sql);
        }

        if($wpdb->get_var("SHOW TABLES LIKE '$table_info'") != $table_info)
        {
            $sql = "CREATE TABLE $table_info (`time` TEXT NULL,`id` INT NULL,`views` INT NULL,`submissions` INT NULL) CHARACTER SET utf8 COLLATE utf8_general_ci";
            dbDelta($sql);
        }
    }
}
checkTables();

function formed_activate()
{
    error_reporting(0);
    global $wpdb, $table_subs, $table_builder, $table_stats, $table_info;
    checkTables();
}

register_activation_hook( __FILE__, 'formed_activate' );

function formeds_register_scripts()
{
    global $fc_version;
    wp_enqueue_script('jquery');

    wp_enqueue_script('fc_combined_js', plugins_url( 'js/combined-js.js', __FILE__ ) ,array(),$fc_version);

    wp_enqueue_script('formedjs', plugins_url( 'js/form.js?v=2', __FILE__ ), array('jquery','jquery-ui-core','jquery-ui-mouse', 'jquery-ui-widget', 'jquery-ui-sortable', 'jquery-ui-slider'),$fc_version);
    wp_localize_script('formedjs', 'formedJS', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'server' => plugins_url('/formed/file-upload/server/content/upload.php'), 'locale' => plugins_url('/formed/libraries/datepicker/js/locales/'), 'other' => plugins_url('/formed') ) );
    wp_enqueue_script('formedjs2', plugins_url( 'js/form_only.js', __FILE__ ),array(),$fc_version);
    wp_enqueue_script('upload-1', plugins_url( 'libraries/upload/jquery.fileupload.min.js', __FILE__ ),array(),$fc_version);
    wp_enqueue_script('upload-2', plugins_url( 'libraries/upload/jquery.iframe-transport.min.js', __FILE__ ),array(),$fc_version);
}

include('inc/widget.php');

add_shortcode( 'formed', 'add_formed' );

function add_formed( $atts, $content = null )
{

    extract( shortcode_atts( array(
        'id' => '1',
        'type' => '',
        'emails' => '',
        'bind' => '',
        'opened' => '0',
        'class' => 'fc-btn',
        'background' => '#48e',
        'text_color' => ''
        ), $atts ) );

    $un = substr(rand(),0,5);
    $uniq = "fc".$un."_".$id;

    formeds_register_scripts();

    global $wpdb, $table_subs, $table_builder, $table_stats, $ppage;
    $finalHTML = '';    
    
    $myrows = $wpdb->get_results( "SELECT con,html FROM $table_builder WHERE id=$id" );

    if (!is_user_logged_in() || $ppage!=true)
    {
        if ( isset($config[0]['allow_multi']) && $config[0]['allow_multi']=='no_allow_multi' )
        {
            $allIDS = explode(',',$_COOKIE['fcwp']);
            foreach ($allIDS as $thisID)
            {
                if ($thisID==$id)
                {
                    return $config[0]['multi_error'];
                    die();
                }
            }
        }
    }

    foreach ($myrows as $row)
    {
        $config = json_decode(stripslashes($row->con), true);
        $css = $config[0]['custom_css'];
    }
    foreach ($myrows as $row)
    {
        $form_html = stripslashes($row->html);
    }
    if ($form_html=='')
    {
        return '';
    }

    $defaultFonts = array('A','', 'Helvetica Neue, Arial', 'Helvetica, Arial', 'Courier New', 'Georgia', 'Book Antiqua, Palatino Linotype', 'Geneva, Tahoma', 'Times New Roman', 'Trebuchet MS');
    if (array_search($config[0]['formfamily'], $defaultFonts)==false)
    {
        $finalHTML .= "<script>window.GoogleFont = '".$config[0]['formfamily']."';</script>";
    }

    $form_html = formed_replace_comments("<!--STARTID-->", "<!--ENDID-->", $form_html, $un);
    $form_html = formed_replace_comments("STARTID", "ENDID", $form_html, $un);
    $finalHTML .= "<style>.nform { behavior: url('".plugins_url('formed/libraries')."/pie/PIE.htc'); } </style>";
    $finalHTML .= "<input type='hidden' class='form_un' value='".$un."'>";
    $finalHTML .= $bind == '' ? '' : "<input type='hidden' data-bindWhat='".$bind."' data-bindTo='#fc-".$uniq."' class='hidden_fc_variables'>";


    $wpdb->query( "UPDATE $table_builder SET views = views + 1 WHERE id = '$id'" );
    $insert = $wpdb->insert( $table_stats, array('id'=>$id) );
    formed_increment($id);
    $finalHTML .= "<style>$css</style><input type='hidden' id='emails_fc$un' value='$emails'>$form_html";
    return $finalHTML;

}

function formed( $id='1', $type='', $opened='0', $text='', $class='', $background='#eee', $text_color='#333' )
{
    echo do_shortcode("[formed id='$id' type='$type' opened='$opened' class='$class' background='$background' text_color='$text_color']".$text."[/formed]");
}

add_action( 'admin_menu', 'formed_menu' );
function formed_menu()
{
	global $wpdb;
	$table_subs = $wpdb->prefix . "formed_submissions";
	$wpdb->get_results( "SELECT * FROM wp_formed_submissions WHERE seen <> '1'" );
	$unread =($wpdb->num_rows);
	
    $page = add_menu_page( 'Formed - Form Builder', 'Forms', 'edit_dashboard', 'formed_admin', 'formed_menu_options', 'dashicons-feedback','31.21' );   
    $alert_title = esc_attr( sprintf( '%d plugin warnings', $unread ) );
    $menu_label = sprintf( __( 'Inbox %s' ), "<span class='update-plugins count-$alert_count' title='$alert_title'><span class='update-count'>$unread</span></span>" );
    add_submenu_page( 'formed_admin', 'Formed - Inboxs',  $menu_label, 'edit_posts', 'formed_admin_inbox', 'formed_menu_inbox' ); 
}

function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function noWhite($name)
{ 
	if( ini_get('allow_url_fopen') ) {   // lucky me my server allows file_get_contents ...
		$file = file_get_contents(plugins_url('/formed/views/fields/'.$name.'.php'));
	}else{
		$file = url_get_contents(plugins_url('/formed/views/fields/'.$name.'.php'));
	} 
	$processed = preg_replace('/\s\s+/', ' ', $file);
	return $processed;
}

add_action( 'admin_enqueue_scripts', 'formed_admin_assets' ); 
function formed_admin_assets($hook)
{
    global $fc_version;
    if ( $hook == $hook/* 'toplevel_page_formed_admin' */ )
    {

        /* Common Assets */
        /* Mother */
        wp_enqueue_script('jquery');    
        /* Libraries and Extensions */
        wp_enqueue_script('jquery-ui-core' );
        wp_enqueue_script('jquery-ui-widget' );
        wp_enqueue_script('jquery-ui-draggable' );
        wp_enqueue_script('jquery-ui-sortable' );
        wp_enqueue_script('jquery-ui-slider' );
        wp_enqueue_script('bs-modal-js', plugins_url( 'js/fcmodal.js', __FILE__ ));
        wp_enqueue_script('datepicker-js', plugins_url( 'libraries/datepicker/js/bootstrap-datepicker.js', __FILE__ ));
        wp_enqueue_script( 'upload-1', plugins_url( 'libraries/upload/jquery.fileupload.min.js', __FILE__ ), array('jquery-ui-widget'));
        wp_enqueue_script( 'upload-2', plugins_url( 'libraries/upload/jquery.iframe-transport.min.js', __FILE__ ), array('jquery-ui-widget'));
        wp_enqueue_script('jquery-ui-widget');
//         wp_enqueue_style( 'fc-fontello', plugins_url( 'css/fontello/css/formed.css', __FILE__ ));
        wp_enqueue_script('time_js', plugins_url( 'libraries/timepicker/js/timepicker.min.js', __FILE__ )); 
        wp_enqueue_script( 'jquery-colorpicker-s', plugins_url( 'libraries/colorpicker/spectrum.js', __FILE__ ));        
        wp_enqueue_style( 'colorpicker_css', plugins_url( 'libraries/colorpicker/spectrum.css', __FILE__ ));        
        /* Custom Work */
        wp_enqueue_style('fc-admin-style', plugins_url( 'css/admin-style.css', __FILE__ ),array(),$fc_version);  
        wp_enqueue_style('fc-common-style', plugins_url( 'css/common.css', __FILE__ ),array(),$fc_version);


        if ( isset($_GET['id']) )
        {

            global $wpdb, $table_builder;
            $id = addslashes($_GET['id']);
            $qry = $wpdb->get_results( "SELECT * FROM $table_builder WHERE id = '$id'" );
            foreach ($qry as $row)
            {
                $build = stripcslashes($row->build);
                $options = stripcslashes($row->options);
                $con = stripcslashes($row->con);
                $rec = stripcslashes($row->recipients);
            }

            wp_enqueue_style( 'formed_forms_css', plugins_url( 'css/editor_form.css', __FILE__ ), array(), $formed_version);
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('my-upload');
            wp_enqueue_style('thickbox');
            wp_deregister_script('angularjs');
            wp_register_script( 'angularjs', plugins_url( 'js/angular.min.js', __FILE__ ));
            wp_enqueue_script('angularjs');
            wp_register_script( 'angularjs-2', plugins_url( 'js/angular-sanitize.min.js', __FILE__ ));
            wp_enqueue_script('angularjs-2');
            wp_enqueue_script( 'angular-ui-js', plugins_url( 'js/angular-ui.js', __FILE__ ));        
            wp_enqueue_script( 'json.jq', plugins_url( 'js/jquery.json.js', __FILE__ ));
            wp_enqueue_script( 'webfont', plugins_url( 'js/webfont.js', __FILE__ ));
            wp_enqueue_script( 'deflate1', plugins_url( 'js/deflate/easydeflate.js', __FILE__ ));
            wp_enqueue_script( 'deflate2', plugins_url( 'js/deflate/deflateinflate.min.js', __FILE__ ));
            wp_enqueue_script( 'deflate3', plugins_url( 'js/deflate/typedarrays.js', __FILE__ ));
            wp_enqueue_script( 'deflate4', plugins_url( 'js/deflate/json3.min.js', __FILE__ ));
            wp_enqueue_script( 'deflate5', plugins_url( 'js/deflate/es5-shim.min.js', __FILE__ ));
            wp_enqueue_script( 'deflate6', plugins_url( 'js/deflate/base64.js', __FILE__ ));
			
			$textDisplay = noWhite('text-display');
			$textOptions = noWhite('text-options');
			
			$paraDisplay = noWhite('para-display');
			$paraOptions = noWhite('para-options');	
					
			$emailDisplay = noWhite('email-display');
			$emailOptions = noWhite('email-options');	
			
			$selectDisplay = noWhite('select-display');
			$selectOptions = noWhite('select-options');	
				
			$submitDisplay = noWhite('submit-display');
			$submitOptions = noWhite('submit-options');		
			
			$checkDisplay = noWhite('check-display');
			$checkOptions = noWhite('check-options');	

			$radioDisplay = noWhite('radio-display');
			$radioOptions = noWhite('radio-options');				
			
            /* Our Own Stuff */
            $ul = plugins_url();
            wp_enqueue_script( 'editor-js', plugins_url( 'js/editor.js', __FILE__ ),array(),$fc_version);
            wp_localize_script( 'editor-js', 'J', array( 
                        					'B' => $build, 
                        					'O' => $options, 
                        					'C' => $con, 
                        					'R' => $rec, 
                        					'I' => $ul, 
                        					'ide' => $id,  
                        					'countries' => plugins_url('/formed/data/countries.json'),  
                        					'states' => plugins_url('/formed/data/states.json'),  
                        					'languages' => plugins_url('/formed/data/languages.json'),
                        					'my' => $filey                       					
                        					  ) );
                        					  
             wp_localize_script( 'editor-js', 'inp', array( 
                        					'textDisplay' => $textDisplay, 
                        					'textOptions' => $textOptions, 
                        					'paraDisplay' => $paraDisplay, 
                        					'paraOptions' => $paraOptions, 
                        					'emailDisplay' => $emailDisplay, 
                        					'emailOptions' => $emailOptions,  
                        					'selectDisplay' => $selectDisplay, 
                        					'selectOptions' => $selectOptions,                        					                                             											'submitDisplay' => $submitDisplay, 
                        					'submitOptions' => $submitOptions,      					
											'checkDisplay' => $checkDisplay, 
                        					'checkOptions' => $checkOptions,
											'radioDisplay' => $radioDisplay, 
                        					'radioOptions' => $radioOptions, 
                        					                        					  ) );                       					  

            wp_enqueue_script( 'formedjs', plugins_url( 'js/form.js', __FILE__ ),array(),$fc_version);
            wp_localize_script( 'formedjs', 'formedJS', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'server' => plugins_url('/formed/file-upload/server/content/'), 'locale' => plugins_url('/formed/libraries/datepicker/js/locales/'), 'other' => plugins_url('/formed') ) );

            wp_enqueue_script( 'formed-build-js', plugins_url( 'js/build.js', __FILE__ ),array(),$fc_version);
            wp_localize_script( 'formed-build-js', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

        }
        else
        {
            wp_enqueue_script('datatables', plugins_url( 'libraries/datatables.js', __FILE__ ));
            wp_deregister_script('jquery-ui-datepicker');

            /* Our Own Stuff */
            wp_enqueue_script('form-index-js', plugins_url( 'js/form-index.js', __FILE__ ),array(),$fc_version);
            wp_localize_script('form-index-js', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

        }

    }
}


function formed_menu_inbox()
{
	$to_include='views/inbox.php';  
    require($to_include); 
}

function formed_menu_options()
{
    if (isset($_GET['id']))
    {
        $url = plugins_url();
        $to_include = 'views/builder.php';
        add_action( 'admin_enqueue_scripts', 'formed_admin_assets' );        
    }
    else
    {
        $to_include='views/admin-page.php';
        add_action( 'admin_enqueue_scripts', 'formed_admin_assets' );        
    }
    require($to_include);
}
