<?php
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
<style>
       
        
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
           
<div style="display:flex">
                <h3 style ="color:#504d4d;">Total record : <span class="trecord">0</span></h3> 

                <a href="<?php echo $_GET['_wp_http_referer']; ?>" style="margin-top:20px; margin-left:10px; display:block;" onclick="modyfi_data()" id="backtosearch"> modify search </a>
                </div>
<div  id="sendbox_section" style="margin-bottom: 1em;  display: flex;flex-direction: column;flex-wrap: wrap; display: block;">
                    <p class="ptomato">
                        <label>
                        SMS Alert Senderid:<br>
                        <select id="senderid_section" style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em;width: 50% !important;">
                          
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
                        <select id="route_section" style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em;width: 50% !important;">
                        
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
                        
                            
                    <select name="smsalert_templates" id="template_section" style= "color: inherit;font: inherit;margin: 0;margin-top: 0.5em;width: 50% !important;" onchange="return selecttemplate(this, '#wc_sms_alert_sms_order_message');">
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
                        <textarea name="message" id="wc_sms_alert_sms_order_message" style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em; width:50%;" rows="5" cols="40" placeholder="Your message. I'm afraid I still don't understand, sir. Maybe if we felt any human loss as keenly as we feel one of those close to us, human history would be far less bloody."></textarea>
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
        </div></form>
                <?php
                 $phone = '';
                 $count = '';
                  global $wpdb;
                   if ( ! empty( $id ) ) {
                    if ( is_array( $id ) ) {

                        foreach ( $id as $key => $ids ) {
                            if ($type == 'orders_data'){
                                $user_phone = get_post_meta( $ids, '_billing_phone', true );
                                $arr_phone[] =$user_phone;
                            }
                            elseif($type == 'users_data'){
                                $user_phone = get_user_meta( $ids, 'billing_phone', true ); 
						        $arr_phone[] =$user_phone;
                            } elseif($type == 'abondend_data'){

                                $table_name = $wpdb->prefix . SA_CART_TABLE_NAME;
                           
                                $results=$wpdb->get_results("SELECT * FROM $table_name WHERE id = $ids ", ARRAY_A );
            
                                $arr=$results[0]['phone'];
                                $arr_phone[] =$arr;
                            }
                            elseif($type == 'subscribe_data'){
                                
                                global $wpdb;
                                $sql = "SELECT  P.post_title, P.post_status,P.post_content, PM.meta_value FROM {$wpdb->prefix}posts P inner join {$wpdb->prefix}postmeta PM on P.ID = PM.post_id WHERE id = $ids";
                                $results = $wpdb->get_results( $sql, 'ARRAY_A');
            
                                $arr=$results[0]['post_title'];
                                $arr_phone[] =$arr;
                            }
                           
                            
                        }
                        $arr_phones =array_unique($arr_phone);
                        $string = rtrim(implode(',', $arr_phones), ',');
                        $count = count($arr_phone);
                      
                    }
                }
                   
                    
                    ?>

                <script>
                    function selecttemplate(e, t) { return jQuery(t).val(e.value), jQuery(t).trigger("change"), !1 }

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
                             
                               
                             }else{
                                $('#error_message').html(' <h3>Your message sending error!</h3>').show(); 
                                
                                
                             }
                            
                       
                        },
                        
                    });
                }



                var data_arr = '(<?php echo $count; ?>)';
               var arr_phone = '<?php echo $string; ?>';
               if (arr_phone!=''){        
                $('.trecord').text(data_arr);                
               
                }    
                </script>
    </div>