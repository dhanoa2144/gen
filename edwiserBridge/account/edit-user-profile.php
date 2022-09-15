<?php
global $current_user, $wp_roles;

$username    = $current_user->user_login;
$first_name  = getArrValue($_POST, "first_name", $current_user->first_name);
$last_name   = getArrValue($_POST, "last_name", $current_user->last_name);
$nickname    = getArrValue($_POST, "nickname", $current_user->nickname);
$email       = getArrValue($_POST, "email", $current_user->user_email);
$description = getArrValue($_POST, "description", $current_user->description);
$city        = getArrValue($_POST, "city", $current_user->city);
$country     = getArrValue($_POST, "country", $current_user->country);
?>

<section class="eb-user-info eb-edit-user-wrapper">
    <h4 class="eb-user-info-h4"><?php _e('Edit Account Details', 'eb-textdomain'); ?></h4>    
    <?php
    if (!is_user_logged_in()) {
        ?>
        <p class="eb-warning"><?php _e('You must be logged in to edit your profile.', 'eb-textdomain'); ?></p>
        <?php
    } else {
        if (isset($_SESSION['eb_msgs_' . $current_user->ID])) {
            echo $_SESSION['eb_msgs_' . $current_user->ID];
            unset($_SESSION['eb_msgs_' . $current_user->ID]);
        }
        ?>
        <form method="post" id="eb-update-profile" action="#<?php // echo esc_url(add_query_arg('eb_action', 'edit-profile', get_permalink())); ?>">
            <fieldset>
                <legend><?php _e('Account Details', 'eb-textdomain'); ?></legend>

                <div class="row mt-3">
                    <label class="col-12">Name<span class="required">*</span></label>
                    <div class="col-6">
                        <input class="text-input col" name="first_name" type="text" id="first_name" value="<?php echo $first_name; ?>" />
                        <label class="hint" for="first-name"><?php _e('First Name', 'eb-textdomain'); ?></label>
                    </div>
                    <div class="col-6">
                        <input class="text-input col" name="last_name" type="text" id="last_name" value="<?php echo $last_name; ?>" />
                        <label class="hint" for="last-name"><?php _e('Last Name', 'eb-textdomain'); ?></label>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <label for="nickname"><?php _e('Nick Name', 'eb-textdomain'); ?></label>
                        <input class="text-input col-12" name="nickname" type="text" id="nickname" value="<?php echo $nickname; ?>" />
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <label for="wdm_company"><?php _e('Company Name', 'eb-textdomain'); ?></label>
                        <input class="text-input col-12" name="wdm_company" type="text" id="wdm_company" value="<?php echo $current_user->wdm_company;; ?>" />
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <label for="email"><?php _e('E-mail', 'eb-textdomain'); ?><span class="required">*</span></label>
                        <input class="text-input col-12" name="email" type="email" id="email" value="<?php echo $email; ?>" required />
                    </div>
                </div>
                <?php

                do_action('eb_user_account_show_account_details_fields', $current_user);

                /**
                 * This will add the list of the countrys in the dropdown.
                 */
                wp_enqueue_script('edwiserbridge-edit-user-profile');
                ?>
                <div class="row mt-3 country">
                    <div class="col-12">
                        <label for="country"><?php _e('Country', 'eb-textdomain'); ?></label>
                        <select class="col-12" name="country" id="country"></select>
                        <input name="eb-selected-country" type="hidden" id="eb-selected-country" value="<?php echo $country; ?>" />
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label for="city"><?php _e('City', 'eb-textdomain'); ?></label>
                        <input class="text-input col-12" name="city" type="text" id="city" value="<?php echo $city; ?>" />
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label for="description"><?php _e('Biographical Information', 'eb-textdomain') ?></label>
                        <textarea class="col-12" name="description" id="description" rows="3" cols="50"><?php echo $description; ?></textarea>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend><?php _e('Password Change', 'eb-textdomain'); ?></legend>
                <div class="row mt-3">
                    <div class="col-12">
                        <label for="eb_curr_psw"><?php _e('Current Password', 'eb-textdomain'); ?> <span class="eb-small"><?php _e('(Keep blank to leave unchanged)', 'eb-textdomain'); ?></span></label>
                        <input class="text-input col-12" name="curr_psw" type="password" id="eb_curr_psw" />                
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label for="eb_new_psw"><?php _e('New Password', 'eb-textdomain'); ?> <span class="eb-small"><?php _e('(Keep blank to leave unchanged)', 'eb-textdomain'); ?></span></label>
                        <input class="text-input col-12" name="new_psw" type="password" id="eb_new_psw" />
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label for="eb_confirm_psw"><?php _e('Confirm Password', 'eb-textdomain'); ?></label>
                        <input class="text-input col-12" name="confirm_psw" type="password" id="eb_confirm_psw" />
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <p class="eb-small">
                    <?php _e('Note: All fields will be updated on Moodle as well as on WordPress site.', 'eb-textdomain'); ?>
                </p>
                <p class="eb-profile-form-submit">
                    <?php //echo $referer;   ?>
                    <input name="updateuser" type="submit" id="updateuser" class="btn btn-primary" value="<?php _e('Save Changes', 'eb-textdomain'); ?>" />
                    <?php wp_nonce_field('eb-update-user') ?>
                    <input name="action" type="hidden" id="action" value="eb-update-user" />
                </p>
            </fieldset>
        </form>
    <?php } ?>
</section>
