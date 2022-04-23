<?php
function data_phone()
{
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
    return $shortdata;
}

function subscriber_page_smscampain()
{

?>
    <style>
        .wp-core-ui select {
            width: 100px !important;
        }
        
        .ptomato {
            color: tomato;
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
        <h1 style="font-size: 2em;color: whitesmoke;font-weight: 400;text-align: center;margin-bottom: 0.5em;margin-top: 0;border-radius: 4px;padding: 10px;background: rgb(248, 107, 82);width: 100%;">SMSCAMPAIGN</h1>
        <!-- SEARCH DATA -->
        <div style=" display: flex;flex-direction: column;flex-wrap: wrap;">
            <form>

                <p class="ptomato">
                    <label>
                        Select Event<br>
                <select style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em;width: 100% !important;">
                <option value="" disabled selected>Slect Data...</option>
                <option value="shop_order">All Customer </option>
                <option value="wc-processing">processing data</option>
                <option value="wc-on-hold">on-hold data</option>
                <option value="wc-cancelled">Cancelled data</option>
                <option value="wc-complete">Completed data</option>
                        </select>
                    </label>
                </p>
                <p class="ptomato">
                    <input type="submit" name="submit" value="Search data" style=" display: inline-block;padding: 8px 12px;color: white;background-color: tomato;border: 0;border-radius: 5px;cursor: pointer;transition: all 300ms ease;">
                </p>

            </form>
        </div>
            <!-- /SEARCH DATA -->
            <!-- SENDBOX -->
            <form>
                <div style="margin-bottom: 1em;  display: flex;flex-direction: column;flex-wrap: wrap;">
                    <p class="ptomato">
                        <label>
                        SMS Alert Senderid:<br>
                        <select style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em;width: 100% !important;">
                            <option value="" disabled selected>Select...</option>
                            <option>This is option 1</option>
                            <option>This is option 2</option>
                            <option>This is option 3</option>
                        </select>
                    </label>
                    </p>
                    <p class="ptomato">
                        <label>
                        SMS Alert Route:<br>
                        <select style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em;width: 100% !important;">
                            <option value="" disabled selected>Select...</option>
                            <option>This is option 1</option>
                            <option>This is option 2</option>
                            <option>This is option 3</option>
                        </select>
                    </label>
                    </p>
                    <p class="ptomato">
                        <label>
                        Templates:<br>
                        <select style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em;width: 100% !important;">
                            <option value="" disabled selected>Select...</option>
                            <option>This is option 1</option>
                            <option>This is option 2</option>
                            <option>This is option 3</option>
                        </select>
                    </label>
                    </p>

                    <p class="ptomato">
                        <label>
                        SMS Text:<br>
                        <textarea style=" color: inherit;font: inherit;margin: 0;margin-top: 0.5em; width:40%;" rows="5" cols="40" placeholder="Your message. I'm afraid I still don't understand, sir. Maybe if we felt any human loss as keenly as we feel one of those close to us, human history would be far less bloody."></textarea>
                    </label>
                    </p>
                    <p class="ptomato">
                        <input type="submit" name="submit" value="Send SMS" style=" display: inline-block;
            padding: 6px 10px;color: white;font: inherit;background-color: tomato;border: 0;border-radius: 5px;cursor: pointer;transition: all 300ms ease;">
                    </p>
                </div>
            </form>
            <!-- /SENDBOX -->
         

    <?php
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