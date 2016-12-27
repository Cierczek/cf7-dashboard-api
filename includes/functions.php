<?php
//------------------------------------------------------------------------------------
   //Function to Add JS File to Add Hidden Field
//------------------------------------------------------------------------------------
function add_hidden_field()
{
    // Register the script like this for a plugin:
    wp_register_script( 'add_hidden_field', plugins_url( '/add_hidden_field.js', __FILE__ ), array( 'jquery' ) );
    // or
    // Register the script like this for a theme:
    wp_register_script( 'add_hidden_field', get_template_directory_uri() . '/add_hidden_field.js', array( 'jquery' ) );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'add_hidden_field' );
}
add_action( 'wp_enqueue_scripts', 'add_hidden_field' );





//------------------------------------------------------------------------------------
   //Add Contact Form 7 - Dashboard API Menu
//------------------------------------------------------------------------------------


// Call dash_opti_page function to load plugin menu in dashboard
add_action( 'admin_menu', 'dash_opti_page' );

// Create WordPress admin menu
if( !function_exists("dash_opti_page") )
{
function dash_opti_page(){

  $page_title = 'Contact Form 7 - Dashboard API Menu';
  $menu_title = 'Dashboard API Menu';
  $capability = 'manage_options';
  $menu_slug  = 'dash-post-info';
  $function   = 'dash_opti_info_page';
  $icon_url   = 'dashicons-media-code';


  add_menu_page( $page_title,
                 $menu_title,
                 $capability,
                 $menu_slug,
                 $function,
                 $icon_url);

  // Call update_dash_opti_page function to update database
  add_action( 'admin_menu', 'update_dash_opti_page' );

}
}

// Create function to register plugin settings in the database
if( !function_exists("update_dash_opti_page") )
{
function update_dash_opti_page() {
  register_setting( 'extra_post_dash_opti_info_settings', 'contact_form_token' );
}
}

// Create WordPress plugin page
if( !function_exists("dash_opti_info_page") )
{
function dash_opti_info_page(){

?>
  
  <form method="post" action="options.php">
    <?php settings_fields( 'extra_post_dash_opti_info_settings' ); ?>
    <?php do_settings_sections( 'extra_post_dash_opti_info_settings' ); ?>
    <table class="form-table">
      <tr valign="top">
      <th scope="row">Token:</th>
      <td><input type="text" name="contact_form_token" value="<?php echo  contact_form_token(); ?>"/></td>
      </tr>
    </table>
  <?php submit_button(); ?>
  </form>
<?php
}
}

// Plugin logic for adding extra info to posts
if( !function_exists("contact_form_token") )
{
  function contact_form_token()
  {
       $token=get_option('contact_form_token',NULL);
    if(is_null($token)||empty($token)){
      $token=md5(uniqid(rand(), true));
      add_option('contact_form_token',$token);}

      return  $token;
  }
}

// Apply the contact_form_token function on our content  
add_filter('the_content', 'contact_form_token');



function add_token_to_footer() {
    echo "<script>var tokenLanding='".contact_form_token()."'</script>";
}
add_action( 'wp_footer', 'add_token_to_footer' );