<?php
    
    class partner_login_widget extends WP_Widget {
    
        // constructor
        function __construct() {
            parent::__construct(
                                'partner_login_widget', // Base ID
                                __( 'Sapphire Partner Login', 'text_domain' ),  // Name
                                array( 'description' => __( 'Provides partners with login to their portal' ), ) // Args
                                ); 
        }
    
        // widget form creation
        public function form($instance) {
    
            // Check values
            if( $instance) {
                 $SapphireRMS_Partner_Login_Widget_Title = esc_attr($instance['SapphireRMS_Partner_Login_Widget_Title']);
                 $SapphireRMS_Partner_Login_Widget_lblUser = esc_attr($instance['SapphireRMS_Partner_Login_Widget_lblUser']);
                 $SapphireRMS_Partner_Login_Widget_lblPass = esc_attr($instance['SapphireRMS_Partner_Login_Widget_lblPass']);
                 $SapphireRMS_Partner_Login_Widget_lblSubmit = esc_attr($instance['SapphireRMS_Partner_Login_Widget_lblSubmit']);
            } else {
                 $SapphireRMS_Partner_Login_Widget_Title = 'Partner Login';
                 $SapphireRMS_Partner_Login_Widget_lblUser = 'Partner ID';
                 $SapphireRMS_Partner_Login_Widget_lblPass = 'Password';
                 $SapphireRMS_Partner_Login_Widget_lblSubmit = 'Login';
            }
?>
<p>
    <label for="<?php echo $this->get_field_id('SapphireRMS_Partner_Login_Widget_Title'); ?>"><?php _e('Partner Login', 'partner_login_widget'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('SapphireRMS_Partner_Login_Widget_Title'); ?>" name="<?php echo $this->get_field_name('SapphireRMS_Partner_Login_Widget_Title'); ?>" type="text" value="<?php echo $SapphireRMS_Partner_Login_Widget_Title; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('SapphireRMS_Partner_Login_Widget_lblUser'); ?>"><?php _e('Partner ID:', 'partner_login_widget'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('SapphireRMS_Partner_Login_Widget_lblUser'); ?>" name="<?php echo $this->get_field_name('SapphireRMS_Partner_Login_Widget_lblUser'); ?>" type="text" value="<?php echo $SapphireRMS_Partner_Login_Widget_lblUser; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('SapphireRMS_Partner_Login_Widget_lblPass'); ?>"><?php _e('Password:', 'partner_login_widget'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('SapphireRMS_Partner_Login_Widget_lblPass'); ?>" name="<?php echo $this->get_field_name('SapphireRMS_Partner_Login_Widget_lblPass'); ?>" type="text" value="<?php echo $SapphireRMS_Partner_Login_Widget_lblPass; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('SapphireRMS_Partner_Login_Widget_lblSubmit'); ?>"><?php _e('Login:', 'partner_login_widget'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('SapphireRMS_Partner_Login_Widget_lblSubmit'); ?>" name="<?php echo $this->get_field_name('SapphireRMS_Partner_Login_Widget_lblSubmit'); ?>" type="text" value="<?php echo $SapphireRMS_Partner_Login_Widget_lblSubmit; ?>" />
</p>
<?php
        }
    
        // widget update
        function update($new_instance, $old_instance) {
    
            $instance = $old_instance;
    
            // Fields
            $instance['SapphireRMS_Partner_Login_Widget_Title'] = strip_tags($new_instance['SapphireRMS_Partner_Login_Widget_Title']);
            $instance['SapphireRMS_Partner_Login_Widget_lblUser'] = strip_tags($new_instance['SapphireRMS_Partner_Login_Widget_lblUser']);
            $instance['SapphireRMS_Partner_Login_Widget_lblPass'] = strip_tags($new_instance['SapphireRMS_Partner_Login_Widget_lblPass']);
            $instance['SapphireRMS_Partner_Login_Widget_lblSubmit'] = strip_tags($new_instance['SapphireRMS_Partner_Login_Widget_lblSubmit']);
    
            return $instance;
        }
    
        // display widget
        function widget($args, $instance) {
    
           extract( $args );
    
           // these are the widget options
           $SapphireRMS_Partner_Login_Widget_Title = apply_filters('widget_title', $instance['SapphireRMS_Partner_Login_Widget_Title']);
           $SapphireRMS_Partner_Login_Widget_lblUser = $instance['SapphireRMS_Partner_Login_Widget_lblUser'];
           $SapphireRMS_Partner_Login_Widget_lblPass = $instance['SapphireRMS_Partner_Login_Widget_lblPass'];
           $SapphireRMS_Partner_Login_Widget_lblSubmit = $instance['SapphireRMS_Partner_Login_Widget_lblSubmit'];
           echo $before_widget;

           // GET RESTFUL LOCATIONS
           $data = NULL;
           $url = get_option('SapphireRMS_Options_url');
           $key = get_option('SapphireRMS_Options_key');
           if($key != NULL)
           {
                $api_url = $url . "/api/Locations/" . $key;
                $web_url = $url . "/web/partners/";
                $json = file_get_contents($api_url);
                $data = json_decode($json, TRUE);               
           }
    
           // Display the widget
           echo '<div class="widget-text wp_widget_plugin_box">';
    
           // Check if title is set
           if ( $SapphireRMS_Partner_Login_Widget_Title ) {
              echo $before_title . $SapphireRMS_Partner_Login_Widget_Title . $after_title;
           }

           // CREATE FORM    
           echo '<form method="GET" action="' . $web_url . '" target="_new">';
           echo '<input type="hidden" name="id" value="' . $key . '">';
           echo '<input type="hidden" name="go" value="1">';

           // partner ID
            echo '  <dl>';
            echo '  <dt>' . $SapphireRMS_Partner_Login_Widget_lblUser . '</dt>';
            echo '      <dd>';
            echo '          <div class="form-group">';
            echo '              <div class="input-group">';
            echo '                  <span class="input-group-addon">';
            echo '                      <span class="glyphicon glyphicon-info-sign"></span>';
            echo '                  </span>';
            echo '                  <input type="text" class="form-control" name="mid" />';
            echo '              </div>';
            echo '          </div>';
            echo '      </dd>';
            echo '  </dl>';

            // PASSWORD
            echo '  <dl>';
            echo '  <dt>' . $SapphireRMS_Partner_Login_Widget_lblPass . '</dt>';
            echo '      <dd>';
            echo '          <div class="form-group">';
            echo '              <div class="input-group">';
            echo '                  <span class="input-group-addon">';
            echo '                      <span class="glyphicon glyphicon-lock"></span>';
            echo '                  </span>';
            echo '                  <input type="password" class="form-control" name="pass" />';
            echo '              </div>';
            echo '          </div>';
            echo '      </dd>';
            echo '  </dl>';

           // BUTTON
           echo '<input type="submit" class="btn btn-primary btn-block" value="' . $SapphireRMS_Partner_Login_Widget_lblSubmit . '" />';
    
           echo '</form>';
    
           echo '</div>';
           echo $after_widget;
        }
    
    }
    
?>