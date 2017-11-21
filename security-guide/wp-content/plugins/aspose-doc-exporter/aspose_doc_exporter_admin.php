<?php

/**
 * Create the admin menu for this plugin
 * @param no-param
 * @return no-return
 */
function AsposeDocExporterAdminMenu() {
    add_options_page('Aspose Doc Exporter', __('Aspose Doc Exporter', 'aspose-doc-exporter'), 'activate_plugins', 'AsposeDocExporterAdminMenu', 'AsposeDocExporterAdminContent');
}

add_action('admin_menu', 'AsposeDocExporterAdminMenu');

/**
 * Pluing settings page
 * @param no-param
 * @return no-return
 */
function AsposeDocExporterAdminContent() {

    // Creating the admin configuration interface
    ?>
    <div class="wrap">
    <h2><?php echo __('Aspose Doc Exporter Options', 'aspose-doc-exporter');?></h2>
    <br class="clear" />

    <div class="metabox-holder has-right-sidebar" id="poststuff">
    <div class="inner-sidebar" id="side-info-column">
        <div class="meta-box-sortables ui-sortable" id="side-sortables">
            <div id="AsposeDocExporterOptions" class="postbox">
                <div title="Click to toggle" class="handlediv"><br /></div>
                <h3 class="hndle"><?php echo __('Support / Manual', 'aspose-doc-exporter'); ?></h3>
                <div class="inside">
                    <p style="margin:15px 0px;"><?php echo __('For any suggestion / query / issue / requirement, please feel free to drop an email to', 'aspose-doc-exporter'); ?> <a href="/cdn-cgi/l/email-protection#87eae6f5ece2f3f7ebe6e4e2c7e6f4f7e8f4e2a9e4e8eab8f4f2e5ede2e4f3bac6f4f7e8f4e2a7c3e8e4a7c2fff7e8f5f3e2f5">marketplace@aspose.com</a>.</p>
                    <p style="margin:15px 0px;"><?php echo __('Get the', 'aspose-doc-exporter'); ?> <a href="http://www.aspose.com/docs/display/wordscloud/Aspose+Doc+Exporter" target="_blank"><?php echo __('Manual here', 'aspose-doc-exporter'); ?></a>.</p>

                </div>
            </div>

            <div id="AsposeDocExporterOptions" class="postbox">
                <div title="Click to toggle" class="handlediv"><br /></div>
                <h3 class="hndle"><?php echo __('Review', 'aspose-doc-exporter'); ?></h3>
                <div class="inside">
                    <p style="margin:15px 0px;">
                        <?php echo __('Please feel free to add your reviews on', 'aspose-doc-exporter'); ?> <a href="http://wordpress.org/support/view/plugin-reviews/aspose-doc-exporter" target="_blank"><?php echo __('Wordpress', 'aspose-doc-exporter');?></a>.</p>
                    </p>

                </div>
            </div>
        </div>
    </div>

    <div id="post-body">
        <div id="post-body-content">
            <div id="WtiLikePostOptions" class="postbox">
                <h3><?php echo __('Configuration / Settings', 'aspose-doc-exporter'); ?></h3>

                <div class="inside">
                    <form method="post" action="options.php">
                        <?php settings_fields('aspose_doc_exporter_options'); ?>
                        <table class="form-table">



                            <tr valign="top">
                                <td colspan="2">
                                    <p> If you don't have an account with Aspose Cloud, <a target="_blank" href="https://cloud.aspose.com/SignUp?src=total-api"> Click here </a> to Sign Up.</p>
                                </td>

                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e('App SID', 'aspose-doc-exporter'); ?></label></th>
                                <td>
                                    <input type="text" size="40" name="aspose_doc_exporter_app_sid" id="aspose_doc_exporter_app_sid" value="<?php echo get_option('aspose_doc_exporter_app_sid'); ?>" />
                                    <span class="description"><?php _e('Aspose for Cloud App sID.', 'aspose-doc-exporter');?></span>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e('App key', 'aspose-doc-exporter'); ?></label></th>
                                <td>
                                    <input type="text" size="40" name="aspose_doc_exporter_app_key" id="aspose_doc_exporter_app_key" value="<?php echo get_option('aspose_doc_exporter_app_key'); ?>" />
                                    <span class="description"><?php _e('Aspose for Cloud App Key.', 'aspose-doc-exporter');?></span>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e('Show Post Date', 'aspose-doc-exporter'); ?></label></th>
                                <td>
                                    <input type="checkbox" name="aspose_doc_exporter_post_date" id="aspose_doc_exporter_post_date" value="yes" <?php echo ((get_option('aspose_doc_exporter_post_date') == 'yes') ? 'checked="checked"' : '') ?> >

                                    <span class="description"><?php _e('Enable if you want to show post date.', 'aspose-doc-exporter');?></span>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e('Show Post Author', 'aspose-doc-exporter'); ?></label></th>
                                <td>
                                    <input type="checkbox" name="aspose_doc_exporter_post_author" id="aspose_doc_exporter_post_author" value="yes" <?php echo ((get_option('aspose_doc_exporter_post_author') == 'yes') ? 'checked="checked"' : '') ?> >

                                    <span class="description"><?php _e('Enable if you want to show author of the post.', 'aspose-doc-exporter');?></span>
                                </td>
                            </tr>


                             <tr valign="top">
                                <th scope="row"><label><?php _e('Disable Other Filters on Post Content', 'aspose-doc-exporter'); ?></label></th>
                                <td>
                                    <input type="checkbox" name="aspose_doc_exporter_post_content_filters" id="aspose_doc_exporter_post_content_filters" value="no" <?php echo ((get_option('aspose_doc_exporter_post_content_filters') == 'no') ? 'checked="checked"' : '') ?> >

                                    <span class="description"><?php _e('Enable if you donot want to apply other plugins filters on post content.', 'aspose-doc-exporter');?></span>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e('Export Post Comments', 'aspose-doc-exporter'); ?></label></th>

                                <td>
                                    <input type="checkbox" name="aspose_doc_exporter_post_comments" id="aspose_doc_exporter_post_comments" value="yes" <?php echo ((get_option('aspose_doc_exporter_post_comments') == 'yes') ? 'checked="checked"' : '') ?> >

                                    <span class="description"><?php _e('Enable if you want to export post comments as well.', 'aspose-doc-exporter');?></span>
                                </td>
                            </tr>



                            <tr valign="top">
                                <th scope="row"><label><?php _e('Label for Comments', 'aspose-doc-exporter'); ?></label></th>
                                <td>
                                    <input type="text" size="40" name="aspose_doc_exporter_comments_text" id="aspose_doc_exporter_comments_text" value="<?php echo get_option('aspose_doc_exporter_comments_text'); ?>" />

                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e('Export Posts File Type', 'aspose-doc-exporter'); ?></label></th>

                                <td>
                                    <select name="aspose_doc_exporter_file_type" id="aspose_doc_exporter_file_type">
                                        <option value="docx" <?php echo ((get_option('aspose_doc_exporter_file_type') == 'docx') ? 'selected="selected"' : ''); ?>>DOCX</option>
                                        <option value="doc" <?php echo ((get_option('aspose_doc_exporter_file_type') == 'doc') ? 'selected="selected"' : ''); ?>>DOC</option>
                                        <option value="odt" <?php echo ((get_option('aspose_doc_exporter_file_type') == 'odt') ? 'selected="selected"' : ''); ?>>ODT</option>
                                        <option value="dot" <?php echo ((get_option('aspose_doc_exporter_file_type') == 'dot') ? 'selected="selected"' : ''); ?>>DOT</option>
                                        <option value="dotx" <?php echo ((get_option('aspose_doc_exporter_file_type') == 'dotx') ? 'selected="selected"' : ''); ?>>DOTX</option>
                                        <option value="rtf" <?php echo ((get_option('aspose_doc_exporter_file_type') == 'rtf') ? 'selected="selected"' : ''); ?>>RTF</option>
                                        <option value="txt" <?php echo ((get_option('aspose_doc_exporter_file_type') == 'txt') ? 'selected="selected"' : ''); ?>>TXT</option>
                                    </select>

                                    <span class="description"><?php _e('Select Exported File Format.', 'aspose-doc-exporter');?></span>
                                </td>
                            </tr>




                            <tr valign="top">
                                <th scope="row"></th>
                                <td>
                                    <input class="button-primary" type="submit" name="Save" value="<?php _e('Save Options', 'aspose-doc-exporter'); ?>" />
                                    <input class="button-secondary" type="reset" name="Reset" value="<?php _e('Reset', 'aspose-doc-exporter'); ?>" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}

add_action( 'admin_footer',  'aspose_doc_exporter_add_export_option' );
function aspose_doc_exporter_add_export_option() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            jQuery('<option>').val('aspose_export_doc').text('<?php echo('Aspose Export to File')?>').appendTo("select[name='action']");
            jQuery('<option>').val('aspose_export_doc').text('<?php echo('Aspose Export to File')?>').appendTo("select[name='action2']");
        });
    </script>

<?php
}

add_action('load-edit.php','aspose_doc_exporter_bulk_action');

function aspose_doc_exporter_bulk_action(){

    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['path'] . '/';

    $html_file = $upload_path . 'outpuut.html';
    $doc_file = $upload_path . 'outpuut.doc';

    @unlink($html_file);
    @unlink($doc_file);

    global $typenow;
    $post_type = $typenow;

    // get the action
    $wp_list_table = _get_list_table('WP_Posts_List_Table');  // depending on your resource type this could be WP_Users_List_Table, WP_Comments_List_Table, etc
    $action = $wp_list_table->current_action();

    $allowed_actions = array("aspose_export_doc");

    if(!in_array($action, $allowed_actions)) return;

    // security check
    check_admin_referer('bulk-posts');

    // make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
    if(isset($_REQUEST['post'])) {
        $post_ids = array_map('intval', $_REQUEST['post']);
    }

    if(empty($post_ids)) return;

    // this is based on wp-admin/edit.php
    $sendback = remove_query_arg( array('exported', 'untrashed', 'deleted', 'ids','file_name'), wp_get_referer() );

    if ( ! $sendback )
        $sendback = admin_url( "edit.php?post_type=$post_type" );

    $pagenum = $wp_list_table->get_pagenum();

    $sendback = add_query_arg( 'paged', $pagenum, $sendback );

    switch($action) {
        case 'aspose_export_doc':

            $exported = count($post_ids);

            $post_contents = aspose_doc_exporter_array_builder($post_ids);

            if ( is_array($post_contents) && count($post_contents) > 0 ) {
                $file_name = aspose_doc_exporter_array_to_html($post_contents);
                
                include_once('asposeDocConverter.php');
            } else {
                wp_die( __('Error exporting post.') );
            }

            global $html_filename;
            $file_type = get_option('aspose_doc_exporter_file_type');
            if(isset($file_type) && !empty($file_type)){
                $file_type = $file_type;
            } else {
                $file_type = 'docx';
            }

            $file_name = str_replace('.htm','.'.$file_type,$html_filename);

            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['path'] . '/';

            $file_name = $upload_path . $file_name;

            $file_details = pathinfo($file_name);

            if($file_details['extension'] == $file_type) {
                header ("Content-type: octet/stream");

                header ("Content-disposition: attachment; filename=".basename($file_name).";");

                header("Content-Length: ".filesize($file_name));

                readfile($file_name);
                exit;

            } else {
                echo "Invalid File!";
            }

            $sendback = add_query_arg( array('exported' => $exported, 'ids' => join(',', $post_ids), 'file_name' => $file_name ), $sendback );

            break;

        default:
            return;
    }



    $sendback = remove_query_arg( array('action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status',  'post', 'bulk_edit', 'post_view'), $sendback );

    wp_redirect($sendback);
    exit();
}

function aspose_doc_exporter_array_builder($post_ids) {

    foreach($post_ids as $post_id) {

        $post_data = get_post($post_id);

        $post_title = $post_data->post_title;
        $post_content = '';

        if(get_option('aspose_doc_exporter_post_date') == 'yes') {
            $post_content .= 'Published Date : ' . get_the_date( '', $post_id ) . '<br />' ;
        }

        if(get_option('aspose_doc_exporter_post_author') == 'yes') {
            $post_content .= 'Author : ' . get_the_author_meta( 'user_nicename' , $post_data->post_author ) . '<br />' ;
        }

        if(get_option('aspose_doc_exporter_post_content_filters') == 'no') {
            $post_content .= $post_data->post_content ;
        } else {
            $post_content .= apply_filters('the_content',$post_data->post_content) ;
        }

        //$post_content = $post_data->post_content;

        if(get_option('aspose_doc_exporter_post_comments') == 'yes') {

            if( get_option('aspose_doc_exporter_comments_text') !='' ) {
                $post_content .= ' <br /> <h3> '. get_option('aspose_doc_exporter_comments_text') .' </h3>';
            } else {
                $post_content .= ' <br /> <h3> Comments </h3>';
            }

            $defaults = array('post_id' => $post_id, 'status' => 'approve');
            $post_comments = get_comments($defaults);

            foreach($post_comments as $comment) :
                $post_content .= ' <strong>  ' . $comment->comment_author . ' </strong> <br />' . $comment->comment_content . '<br />';
            endforeach;
        }


        $post_contents[$post_title . ' ' . microtime()] = $post_content;
    }


    if(is_array($post_contents)) {
        return $post_contents;
    } else {
        return false;
    }

}

function aspose_doc_exporter_array_to_html($post_contents){
    global $html_filename;
    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['path'] . '/';
    $html_filename = 'output_'.time().'.htm';

    $output_string = <<<EOD
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body> 
EOD;

    foreach($post_contents as $key => $value) {

        $key = preg_replace('/[0-9\.\s]+$/','',$key);
    	//$value = iconv("UTF-8", "ASCII//TRANSLIT", $value);
        $output_string .= <<<EOD
        <h1> {$key} </h1>
        <p> {$value} </p>
        <hr />
EOD;
    }

    $output_string .= <<<EOD
</body>
</html>
EOD;

    @unlink($upload_path . $html_filename);    
    file_put_contents($upload_path . $html_filename,$output_string);

    return $upload_path . $html_filename;
}

