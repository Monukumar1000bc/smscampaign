<?php


function subscriber_page_smscampain()
{
global $shortdata;
?>
    <h2 style="text-align: center;">SMS CAMPAIGN</h2>
    <hr style="border:2px solid lightgray">

    <?php
    if (empty($_GET['dogl-names'])) { ?>
        <form action="" method="GET" for="dogl-names">

            <select name="dogl-names">
                <option value="">All Customer</option>
                <option value="wc-processing">processing data</option>
                <option value="wc-on-hold">on-hold data</option>
                <option value="wc-cancelled">Cancelled data</option>
                <option value="wc-complete">Completed data</option>
            </select>
            <input type="hidden" name="page" value="all-smscampain">
            <input type="submit" name="submit" value="Search data">

        </form>

    <?php
    }

    if (!empty($_REQUEST['submit']) && $_REQUEST['submit'] == 'Search data') {

        if (!empty($_GET['dogl-names'])) {
            $selected = $_GET['dogl-names'];


            $args = array(
                'status' => array($selected),
            );
        } else {
            $args = array();
        }


        $orders = wc_get_orders($args);

        $temp_array = array();
        foreach ($orders as $key => $order) {
            $phone = $order->get_billing_phone();
            $temp_array[] = $phone;
        }

        $shortdata = (array_unique($temp_array));
        //print_r($shortdata);
        $shortcountdata = count($shortdata);
        echo '<h2 >Total record : ' . $shortcountdata . '</h2>'; ?>
        <a href='admin.php?page=all-smscampain&action=all-smscampain'> modify search </a>

    <?php
        // =====================================
    }
    ?>

    <form action="admin.php?page=all-smscampain" method="POST">
        <br>
        <div>

            <?php

            $username = smsalert_get_option('smsalert_name', 'smsalert_gateway');
            $password = smsalert_get_option('smsalert_password', 'smsalert_gateway');
            //   SmsAlertcURLOTP::sendsms($shortdata);
            $result = SmsAlertcURLOTP::get_senderids($username, $password);
            $arr = json_decode($result, true);
            $senderids = ($arr['description']);

            $credits = json_decode(SmsAlertcURLOTP::get_credits(), true);

            $cred = ($credits['description']['routes']);
            ?>
            <div>
                <br><select>
                    <?php
                    foreach ($cred as $key => $creditroot) {
                        $creditrout = $creditroot['route'];
                    ?>

                        <option value=""> <?php echo $creditrout; ?></option>
                    <?php
                    }

                    ?>

                </select>
            </div>
            <div>
                <br><select>
                    <?php
                    foreach ($senderids as $key => $senderid) {
                        $boards = $senderid['Senderid']['sender'];

                    ?>

                        <option value="<?php echo $boards; ?>"> <?php echo $boards; ?></option>
                    <?php
                    }

                    ?>

                </select>
                    </div>
            <select name="temp">
                <option value="temp">slect templates</option>
                <option value=" ">aslike</option>	
            </select> <br>
            <textarea name="message" id="message" placeholder="Enter your message here"></textarea>
        </div>
        <input type="hidden" name="dogl-names" value="<?php echo $selected ;?>">

        <input type="submit" name="submit" value="send_sms">
    </form>
<?php

    if (!empty($_REQUEST['submit']) && ($_REQUEST['submit']) == 'send_sms') {





        $datas = array();
        foreach($shortdata as $newval) {
            $datas[] = array('number' => $newval, 'sms_body' => $_GET['message']);
        }
        print_r($datas);
        exit();
        $respo    = SmsAlertcURLOTP::send_sms_xml($datas);
        $response_arr = json_decode($respo, true);
    }
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