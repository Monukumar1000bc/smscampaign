<?php

function subscriber_page_smscampain()
{
    	$username = smsalert_get_option('smsalert_name', 'smsalert_gateway');
            $password = smsalert_get_option('smsalert_password', 'smsalert_gateway');
            $result    = SmsAlertcURLOTP::get_templates( $username, $password );
            $templates = (array)json_decode( $result, true );
            //   SmsAlertcURLOTP::sendsms($shortdata);
            $result = SmsAlertcURLOTP::get_senderids($username, $password);
            $arr = json_decode($result, true);
            $senderids = ($arr['description']);

            $credits = json_decode(SmsAlertcURLOTP::get_credits(), true);

            $cred = ($credits['description']['routes']);
			
				
        // senderid
       
				
        //templates 
				
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <style>
        .wp-core-ui select {
            width: 100px !important;
        }
        
        .ptomato {
            color: #504d4d;
            font-size: 1em;
            /* color: whitesmoke; */
            margin-bottom: 1em;
            margin-top: 0;
        }
        input[type="submit"]:hover {
            background-color: blue;
        }
    </style>
    
    <div class="container wp-core-ui" style=" min-width: 960px; height: 100%;margin: 0 auto;padding: 1.5em;background-color: #F0F0F1;font-size: 1rem;font-family: 'Lato'; ">
        <h1 style="font-size: 2em;color: #504d4d;font-weight: 400;text-align: left;margin-bottom: 0.5em;margin-top: 0;border-radius: 4px;padding: 10px;background: #F0F0F1;width: 100%;">SMS CAMPAIGN</h1>
        <!-- SEARCH DATA -->
        <div style=" display: flex;flex-direction: column;flex-wrap: wrap;">
            <div id="select_section" style="display: block;">
            <form action="" method="POST" id="reset"> 
           
            <p class="ptomato">
        <label>Select Event<br>
       
            <select  name="dogl_names[]" size="10" data-placeholder="Choose event..."  id="dogl_names" style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em;width: 100% !important;" multiple class="chosen-select">
               
            <option value="wc-processing">processing data</option>
                <option value="wc-pending">Pending </option>
                <option value="wc-on-hold">on-hold data</option>
                <option value="wc-cancelled">Cancelled data</option>
                <option value="wc-completed">Completed data</option>
                <option value="wc-refunded">Refunded </option>
                <option value="wc-failed">Failed </option>
             </select>
         </label>
                </p>
               
                <p class="ptomato">
                <!-- <input type="hidden" name="page" value="all-smscampain"> -->
               <button type="button" onclick="select_data()" id="btn" style=" display: inline-block;padding: 6px 10px;color: #ffff;font: inherit;background-color: #2271B1;border: 1px solid #F0F0F1;border-radius: 5px;cursor: pointer;transition: all 300ms ease;box-shadow: 0px 0px 0px 0px #2271b1eb;">SearchData</button>
                </p>
                </div>
                <div style="display:flex">
                <h3 style ="color:#504d4d;">Total record : <span class="trecord">0</span></h3> 

                <a href="#" style="margin-top:20px; margin-left:10px; display:none;" onclick="modyfi_data()" id="backtosearch"> modify search </a>
                </div>
          <div  id="sendbox_section" style="margin-bottom: 1em;  display: flex;flex-direction: column;flex-wrap: wrap; display: none;">
                    <p class="ptomato">
                        <label>
                        SMS Alert Senderid:<br>
                        <select id="senderid_section" style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em;width: 100% !important;">
                          
                   <?php
                        foreach ($senderids as $key => $senderid) {
                            $boards = $senderid['Senderid']['sender'];?>

                            <option value="<?php  echo $boards;?>"><?php  echo $boards;?></option>
                           
		            	<?php }?>
                        </select>
                    </label>
                    </p>
                     
                    <?php
                        foreach ($cred as $key => $creditroot) {
				          $creditrout = $creditroot['route'];
                        }
                          ?>
                    <?php 
                    if ($cred){?>
                    <p class="ptomato">
                        <label>
                        SMS Alert Route:<br>
                        <select id="route_section" style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em;width: 100% !important;">
                        
                        <?php
                        foreach ($cred as $key => $creditroot) {
				          $creditrout = $creditroot['route'];?>
				
                            <option value="<?php echo $creditrout;?>"><?php echo $creditrout;?></option>
                      <?php  }?>
                          
                        </select>
                    </label>
                    </p>
                        <?php
                    }?>
                    <p class="ptomato">
                        <label>
                        Templates:<br>
                        
                            
                    <select name="smsalert_templates" id="template_section" style="width:87%;color: inherit;font: inherit;margin: 0;margin-top: 0.5em;width: 100% !important;" onchange="return selecttemplate(this, '#wc_sms_alert_sms_order_message');">
                    <option value="" disabled selected>Select Template...</option>
                    <?php foreach ( $templates['description'] as $template ){
				?>
                  
                <option value="<?php echo esc_textarea( $template['Smstemplate']['template'] ); ?>"><?php echo esc_attr( $template['Smstemplate']['title'] ); ?></option>
				

			<?php	}?>

                   					
						</select>
                       
                    </label>
                    </p>

                    <p class="ptomato">
                        <label>
                        SMS Text:<br>
                        <textarea name="message" id="wc_sms_alert_sms_order_message" style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em; width:40%;" rows="5" cols="40" placeholder="Your message. I'm afraid I still don't understand, sir. Maybe if we felt any human loss as keenly as we feel one of those close to us, human history would be far less bloody."></textarea>
                    </label>
                    </p>
                    <p class="ptomato">
                        
                        <button type="button" id="send_sms"  onclick="sending_data()" style=" display: inline-block;padding: 6px 10px;color: #ffff;font: inherit;background-color: #2271B1;border: 1px solid #F0F0F1;border-radius: 5px;cursor: pointer;transition: all 300ms ease;box-shadow: 0px 0px 0px 0px #2271b1eb;">Send SMS</button>
                    </p>
                    <div id="success_message" style="width:100%; height:100%; display:none; ">
               
                </div>
                <div id="error_message" style="width:100%; height:100%; display:none; ">
                    
                 </div>
                   
                </div>
        </div>
                    </form>

                    <?php
                    $phone = '';
                    $count = '';
                    if (isset($_GET['phone'])){
                    $phone =trim(( $_GET['phone']));
                   
                    $arr_phone = explode(",","$phone");
                    
                    $count = count($arr_phone);
                    }
                    ?>
            <!-- /SEARCH DATA -->
            <!-- SENDBOX -->
           
            <script>
               
               
                $(".chosen-select").chosen();

                function select_data(){
                    var dogl_names = $('#dogl_names').val();
                    $('#btn').html('Please Wait..');
                    jQuery.ajax({
                        url: "http:\/\/localhost\/wordpress\/wp-admin\/admin-ajax.php",
                        type:'POST',
                        data:'action=smscampain_data&dogl_names='+dogl_names+'&searchdata=',
                          
			             success : function(response) {
                            $('.trecord').text(response);
                            $('#btn').html('SearchData');
                            $('#select_section').hide();
                            $('#backtosearch').show();
                            $('#sendbox_section').show();
                           
                        }
                    });
                }
                function sending_data(){
                    var senderid_section = $('#senderid_section').val();
                    var route_section = $('#route_section').val();
                    var template_section = $('#template_section').val();
                    var wc_sms_alert_sms_order_message = $('#wc_sms_alert_sms_order_message').val();
                    var dogl_names = $('#dogl_names').val();
                     $('#send_sms').html('Sending...');
                    
                    jQuery.ajax({
                        url: "http:\/\/localhost\/wordpress\/wp-admin\/admin-ajax.php",
                        type:'POST',
                        data:'action=smscampain_data&senderid_section='+senderid_section+'&route_section='+route_section+ '&template_section='+template_section+'&wc_sms_alert_sms_order_message='+wc_sms_alert_sms_order_message+'&dogl_names='+dogl_names+'&arr_phone='+arr_phone ,
			             success : function(response){
                            $('#send_sms').html('Send SMS');
                            debugger;
                             if(response==1)
                             {
                                $('#success_message').html(' <h3>Your message send successfully!</h3>').show();
                             
                                setTimeout(hideSection, 8000);
                                $('#backtosearch').hide(); 
                                $("#reset").trigger("reset");
                                $('.trecord').text(0);
                             }else{
                                $('#error_message').html(' <h3>Your message sending error!</h3>').show(); 
                                
                                setTimeout(hideSection, 8000);
                                $('#backtosearch').hide();
                                $("#reset").trigger("reset");
                                $('.trecord').text(0);
                             }
                            
                       
                        },
                        
                    });
                }
                function hideSection()
                {
                    $('#sendbox_section').hide(); 
                    $('#select_section').show();
                    $('#error_message').html('');
                    $('#success_message').html('');
                }
            function modyfi_data(){
             $('#select_section').show();
             $('#sendbox_section').hide();
             $('#backtosearch').hide();
            //  $("#reset").trigger("reset");
             $('.trecord').text(0);
            }

            
        // $(".chosen-select").each(function(){
        //      var thisOptionValue=$(this).val();
        // 
    
        var data_arr = '(<?php echo $count; ?>)';
               var arr_phone = '<?php echo $phone; ?>';
               if (arr_phone!=''){        
                $('.trecord').text(data_arr);                
                $('#select_section').hide();
                $('#backtosearch').show();
                $('#sendbox_section').show();
                }      
        

  
         </script>
         
    </div><?php
    
    
}


/**
 * Adds a sub menu page for all Smscampain.
 *
 * @return void
 */
function all_subscriber_admin_smscampain()
{
    add_submenu_page(null, 'All Smscampain', 'All Smscampain', 'manage_options', 'all-smscampain', 'subscriber_page_smscampain');
}

add_action('admin_menu', 'all_subscriber_admin_smscampain');
// sms campain function
?>