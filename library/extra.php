<?php
/**
 * Extra helper functions for WordPress
 */

// IS THIS YOU, THE DEV
// very specific is_admin check to test stuff without letting anybody see it, but you
/*
function is_this_tom() {
  $current_user = wp_get_current_user();
    // echo 'Username: ' . $current_user->user_login . '<br />';
    // echo 'User email: ' . $current_user->user_email . '<br />';
    // echo 'User first name: ' . $current_user->user_firstname . '<br />';
    // echo 'User last name: ' . $current_user->user_lastname . '<br />';
    // echo 'User display name: ' . $current_user->display_name . '<br />';
    // echo 'User ID: ' . $current_user->ID . '<br />';
  if( 'tomhermans@gmail.com' === $current_user->user_email) {
    return true;
  }
}
*/

// Move Yoast to bottom
function yoasttobottom() {
  return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');


// allow svg upload
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


// Remove empty P tags
// https://wordpress.org/plugins/remove-empty-p/
add_filter( 'the_content', 'remove_empty_p', 20, 1 );
function remove_empty_p( $content ){
  // clean up p tags around block elements
  $content = preg_replace( array(
    '#<p>\s*<(div|aside|section|article|header|footer)#',
    '#</(div|aside|section|article|header|footer)>\s*</p>#',
    '#</(div|aside|section|article|header|footer)>\s*<br ?/?>#',
    '#<(div|aside|section|article|header|footer)(.*?)>\s*</p>#',
    '#<p>\s*</(div|aside|section|article|header|footer)#',
  ), array(
    '<$1',
    '</$1>',
    '</$1>',
    '<$1$2>',
    '</$1',
  ), $content );

  return preg_replace('#<p>(\s|&nbsp;)*+(<br\s*/*>)*(\s|&nbsp;)*</p>#i', '', $content);
}



// ADD CPT TO SEARCH RESULTS
// put the cpt identifier names in the array, separated by commas
/*
function filter_search($query) {
    if ($query->is_search) {
  $query->set('post_type', array('post', 'name_of_cpt'));
    };
    return $query;
};
add_filter('pre_get_posts', 'filter_search');
*/


// SHARE VIA MAIL
/*
function th_share_via_mail($a, $t) {
  $msg = $a;
  if (empty($msg)) { $msg = 'YOUR_SITE_NAME : '; }
  if (!empty($t)) { $t = $t . ' '; }
  $subject = strip_tags($msg . get_the_title() ); // . ' - ' . get_bloginfo('name') );
  $intro = get_the_excerpt( );
  $link = urlencode(get_permalink());

  $r = '<li><a class="dashicons dashicons-email" target="_blank" href="mailto:?subject='. $subject .'&body='.$intro . '%0D%0A%0D%0A Lees hier verder : ' . $link .'"></a></li>';

  return $r;
}
*/


// MAKE WIDGETS WORK WITH SHORTCODES
/*
add_filter('widget_text', 'do_shortcode');
*/


// RWD VIDEO
// Automatically add FitVids to oembed YouTube videos
/*
function video_filter( $output, $data, $url ) {
  $return = '<div class="responsive-wrapper">'.$output.'</div>';
  return $return;
}
add_filter( 'embed_oembed_html', 'video_filter', 10, 3);
*/

// SIMPLE GET FEAT IMG URL
/*
function featuredimg($post_id) {
  if(is_single( )) {
    $post_thumbnail_id = get_post_thumbnail_id($post_id);
    $post_thumbnail_url = wp_get_attachment_image_src( $post_thumbnail_id, 'medium', true);

    $url = $post_thumbnail_url[0];
  }
  if(empty($url)) {
    $url = 'nosuchthing';
  }
  return $url;
}
*/


// WORDPRESS GET POST IMAGES AND THE_POST_THUMBNAIL CAPTION
// http://stereointeractive.com/blog/2010/02/12/wordpress-get-post-images-and-the_post_thumbnail-caption/
/*
function th_thumbnail_caption($html, $post_id, $post_thumbnail_id, $size, $attr) {
  $attachment = get_post($post_thumbnail_id);
  // post_title => image title
  // post_excerpt => image caption
  // post_content => image description
  if ($attachment->post_excerpt || $attachment->post_content) {
    $html .= '<p class="thumbcaption">';
    if ($attachment->post_excerpt) {
      $html .= '<span class="captitle">'.$attachment->post_excerpt.'</span> ';
    }
    $html .= $attachment->post_content.'</p>';
  }
  return $html;
}
add_action('post_thumbnail_html', 'th_thumbnail_caption', null, 5);
*/


// EXTRA USER FIELDS, DEFINE BELOW WHICH ONES
// Add extra fields to User Profile
/*
function my_show_extra_profile_fields( $user ) { ?>
  <h3>Extra profile information</h3>
  <fieldset>
    <legend>Optional information</legend>
    <table class="form-table wpuf-table">
      <tr>
        <th><label for="city">City</label></th>
        <td>
          <input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" />
          <span class="description">Please enter your city.</span>
        </td>
      </tr>
      <tr>
        <th><label for="country">Country</label></th>
        <td>
          <input type="text" name="country" id="country" value="<?php echo esc_attr( get_the_author_meta( 'country', $user->ID ) ); ?>" class="regular-text" />
          <span class="description">Please enter your country</span>
        </td>
      </tr>
    </table>
  </fieldset>

<?php }

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
function my_save_extra_profile_fields( $user_id ) {
  if ( !current_user_can( 'edit_user', $user_id ) )
    return false;
  // Copy and paste this line for additional fields. Make sure to change 'country' to the field ID.
  update_user_meta( $user_id, 'city', $_POST['city'] );
  update_user_meta( $user_id, 'country', $_POST['country'] );
  // update_user_meta( $user_id, 'gender', $_POST['gender'] );
}
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );
*/


// Allow iframe tags
// function to initialise the iframe elements - http://digitizor.com/2011/01/14/add-insert-iframe-wordpress/
/*
function add_iframe($initArray) {
  $initArray['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
  return $initArray;
}
*/


// SPLIT CONTENT
// split content at the more tag and return an array
/*
function split_content() {
  global $more;
  $more = true;
  $content = preg_split('/<span id="more-\d+"><\/span>/i', get_the_content('more'));
  // // first content section in column1
  // $ret = '<div id="column1" class="column1">'. array_shift($content). '</div>';
  // // remaining content sections in column2
  // if (!empty($content)) $ret .= '<div id="column2" class="column2">'. implode($content). '</div>';
  // return apply_filters('the_content', $ret);
  return $content;
}
*/

