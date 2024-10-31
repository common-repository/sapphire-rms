<?php
    
    class reservation_widget extends WP_Widget {
    
        // constructor
        function __construct() {
            parent::__construct(
                                'reservation_widget', // Base ID
                                __( 'Sapphire Reservation', 'text_domain' ),  // Name
                                array( 'description' => __( 'Provides the initial search form for car rental availability' ), ) // Args
                                ); 
        }
    
        // widget form creation
        public function form($instance) {
    
            // Check values
            if( $instance) {
                 $title = esc_attr($instance['title']);
                 $lblPickup = esc_attr($instance['lblPickup']);
                 $lblReturn = esc_attr($instance['lblReturn']);
                 $lblPickupLocation = esc_attr($instance['lblPickupLocation']);
                 $lblReturnLocation = esc_attr($instance['lblReturnLocation']);
                 $lblSubmit = esc_attr($instance['lblSubmit']);
            } else {
                 $title = 'Book Now';
                 $lblPickup = 'Pickup Date';
                 $lblReturn = 'Return Date';
                 $lblPickupLocation = 'Pickup Location';
                 $lblReturnLocation = 'Return Location';
                 $lblSubmit = 'Get Rates';
            }
?>
<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'reservation_widget'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('lblPickup'); ?>"><?php _e('Pickup Date Label:', 'reservation_widget'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('lblPickup'); ?>" name="<?php echo $this->get_field_name('lblPickup'); ?>" type="text" value="<?php echo $lblPickup; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('lblReturn'); ?>"><?php _e('Return Date Label:', 'reservation_widget'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('lblReturn'); ?>" name="<?php echo $this->get_field_name('lblReturn'); ?>" type="text" value="<?php echo $lblReturn; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('lblPickupLocation'); ?>"><?php _e('Pickup Location Label:', 'reservation_widget'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('lblPickupLocation'); ?>" name="<?php echo $this->get_field_name('lblPickupLocation'); ?>" type="text" value="<?php echo $lblPickupLocation; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('lblReturnLocation'); ?>"><?php _e('Return Location Label:', 'reservation_widget'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('lblReturnLocation'); ?>" name="<?php echo $this->get_field_name('lblReturnLocation'); ?>" type="text" value="<?php echo $lblReturnLocation; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('lblSubmit'); ?>"><?php _e('Button Label:', 'reservation_widget'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('lblSubmit'); ?>" name="<?php echo $this->get_field_name('lblSubmit'); ?>" type="text" value="<?php echo $lblSubmit; ?>" />
</p>
<?php
        }
    
        // widget update
        function update($new_instance, $old_instance) {
    
            $instance = $old_instance;
    
            // Fields
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['lblPickup'] = strip_tags($new_instance['lblPickup']);
            $instance['lblReturn'] = strip_tags($new_instance['lblReturn']);
            $instance['lblPickupLocation'] = strip_tags($new_instance['lblPickupLocation']);
            $instance['lblReturnLocation'] = strip_tags($new_instance['lblReturnLocation']);
            $instance['lblSubmit'] = strip_tags($new_instance['lblSubmit']);
    
            return $instance;
        }
    
        // display widget
        function widget($args, $instance) {
    
           extract( $args );
    
           // these are the widget options
           $title = apply_filters('widget_title', $instance['title']);
           $lblPickup = $instance['lblPickup'];
           $lblReturn = $instance['lblReturn'];
           $lblPickupLocation = $instance['lblPickupLocation'];
           $lblReturnLocation = $instance['lblReturnLocation'];
           $lblSubmit = $instance['lblSubmit'];
           echo $before_widget;

           // GET RESTFUL LOCATIONS
           $dataPickup = NULL;
           $dataReturn = NULL;
           $url = get_option('SapphireRMS_Options_url');
           $key = get_option('SapphireRMS_Options_key');
           if($key != NULL)
           {
                $api_url = $url . "/api/Locations/" . $key;
                $web_url = $url . "/web/reservations/";
                
                $jsonPickup = file_get_contents($api_url . "?AllowPickup=true");
                $dataPickup = json_decode($jsonPickup, TRUE);

                $jsonReturn = file_get_contents($api_url . "?AllowReturn=true");
                $dataReturn = json_decode($jsonReturn, TRUE);
           }
    
           // Display the widget
           echo '<div class="widget-text wp_widget_plugin_box">';
    
           // Check if title is set
           if ( $title ) {
              echo $before_title . $title . $after_title;
           }

           // CREATE FORM    
           echo '<form method="GET" action="' . $web_url . 'create/" target="_new">';
           echo '<input type="hidden" name="id" value="' . $key . '">';
           echo '<input type="hidden" name="go" value="1">';

           // PICKUP: LOCATION
           echo '<dl>';
           echo '<dt>' . $lblPickupLocation . '</dt>';
           echo '<dd>';
           echo '<select name="pid" class="form-control">';
           if($dataPickup != NULL)
           {
                foreach($dataPickup as $key => $value)
                    {
                        echo "<option value='" . $value["LocationID"] . "'>";
                        echo $value["LocationName"];
                        echo "</option>";
                    }
           }
           echo '</select>';  
           echo '</dd>';
           echo '</dl>';

           // RETURN: LOCATION
           echo '<dl>';
           echo '<dt>' . $lblReturnLocation . '</dt>';
           echo '<dd>';
           echo '<select name="rid" class="form-control">';
           if($dataReturn != NULL)
           {
                foreach($dataReturn as $key => $value)
                    {
                        echo "<option value='" . $value["LocationID"] . "'>";
                        echo $value["LocationName"];
                        echo "</option>";
                    }
           }
           echo '</select>';  
           echo '</dd>';
           echo '</dl>';

           // PICKUP: DATE TIME
           echo '<dl>';
           echo '<dt>' . $lblPickup . '</dt>';
           echo '<dd>';
           echo '<div class="form-group">';
           echo '   <div class="input-group date PickupDate" id="PickupDate">';
           echo '       <input type="text" class="form-control" name="pd" />';
           echo '       <span class="input-group-addon">';
           echo '           <span class="glyphicon glyphicon-calendar"></span>';
           echo '       </span>';
           echo '   </div>';
           echo '</div>';
           echo '<div class="form-group">';
           echo '   <div class="input-group date PickupTime" id="PickupTime">';
           echo '       <input type="text" class="form-control" name="pt" />';
           echo '       <span class="input-group-addon">';
           echo '           <span class="glyphicon glyphicon-time"></span>';
           echo '       </span>';
           echo '   </div>';
           echo '</div>';
           echo '</dd>';
           echo '</dl>';

           // RETURN: DATE TIME
           echo '<dl>';
           echo '<dt>' . $lblReturn . '</dt>';
           echo '<dd>';
           echo '<div class="form-group">';
           echo '   <div class="input-group date ReturnDate" id="ReturnDate">';
           echo '       <input type="text" class="form-control" name="rd" />';
           echo '       <span class="input-group-addon">';
           echo '           <span class="glyphicon glyphicon-calendar"></span>';
           echo '       </span>';
           echo '   </div>';
           echo '</div>';
           echo '<div class="form-group">';
           echo '   <div class="input-group date ReturnTime" id="ReturnTime">';
           echo '       <input type="text" class="form-control" name="rt" />';
           echo '       <span class="input-group-addon">';
           echo '           <span class="glyphicon glyphicon-time"></span>';
           echo '       </span>';
           echo '   </div>';
           echo '</div>';
           echo '</dd>';
           echo '</dl>';

           // BUTTON
           echo '<input type="submit" class="btn btn-primary form-control" value="' . $lblSubmit . '" />';
    
           echo '</form>';
    
           echo '</div>';
           echo $after_widget;
        }
    
    }
    
?>