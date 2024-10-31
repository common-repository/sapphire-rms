<?php
function SapphireRMS_URL_Reservation_shortcode_handler() {
    $url = get_option('SapphireRMS_Options_url');
    $key = get_option('SapphireRMS_Options_key');
    return $url . '/web/reservations/create/?id=' . $key;
}
?>
<?php
function SapphireRMS_reservation_shortcode_handler($atts) {
  
    // PARAMETERS
    extract(shortcode_atts(array(
        'large' => ""
    ), $atts));

    // GET LOCATIONS
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
    
    // FORM
    echo '<form method="GET" action="' . $web_url . 'create/" target="_new">';
    echo '<input type="hidden" name="id" value="' . $key . '">';
    echo '<input type="hidden" name="go" value="1">';

    echo '<div class="row">';
        
    // PICKUP
    echo '<div class="col-md-4">';
    echo '  <dl>';
    echo '      <dt>Pickup Location</dt>';
    echo '      <dd>';
    echo '          <select name="pid" class="form-control' . ($large == "true" ? ' input-lg' : '') . '">';
    
    if($dataPickup != NULL)
    {
        foreach($dataPickup as $ddlPickup => $value)
            {
                echo "<option value='" . $value["LocationID"] . "'>";
                echo $value["LocationName"];
                echo "</option>";
            }
    }

    echo '          </select>';  
    echo '      </dd>';
    echo '  </dl>';
    echo '  <dl>';
    echo '      <dt>Return Location</dt>';
    echo '      <dd>';
    echo '          <select name="rid" class="form-control' . ($large == "true" ? ' input-lg' : '') . '">';
        
    if($dataReturn != NULL)
    {
        foreach($dataReturn as $ddlReturn => $value)
            {
                echo "<option value='" . $value["LocationID"] . "'>";
                echo $value["LocationName"];
                echo "</option>";
            }
    }

    echo '          </select>';  
    echo '      </dd>';
    echo '  </dl>';
    echo '</div>';
        
    // PICKUP: DATETIME
    echo '<div class="col-md-3">';
    echo '  <dl>';
    echo '      <dt>Pickup Date</dt>';
    echo '      <dd>';
    echo '          <div class="form-group">';
    echo '              <div class="input-group date PickupDate" id="PickupDate">';
    echo '                  <input type="text" name="pd" class="form-control' . ($large == "true" ? ' input-lg' : '') . '"/>';
    echo '                  <span class="input-group-addon">';
    echo '                      <span class="glyphicon glyphicon-calendar"></span>';
    echo '                  </span>';
    echo '              </div>';
    echo '          </div>';
    echo '      </dd>';
    echo '  </dl>';
    echo '  <dl>';
    echo '      <dt>Return Date</dt>';
    echo '      <dd>';
    echo '          <div class="form-group">';
    echo '              <div class="input-group date ReturnDate" id="ReturnDate">';
    echo '                  <input type="text" name="rd" class="form-control' . ($large == "true" ? ' input-lg' : '') . '"/>';
    echo '                  <span class="input-group-addon">';
    echo '                      <span class="glyphicon glyphicon-calendar"></span>';
    echo '                  </span>';
    echo '              </div>';
    echo '          </div>';
    echo '      </dd>';
    echo '  </dl>';
    echo '</div>';

    // PICKUP: DATETIME
    echo '<div class="col-md-2">';
    echo '  <dl>';
    echo '      <dt>Pickup Time</dt>';
    echo '      <dd>';
    echo '          <div class="form-group">';
    echo '              <div class="input-group date PickupTime" id="PickupTime">';
    echo '                  <input type="text" name="pt" class="form-control' . ($large == "true" ? ' input-lg' : '') . '"/>';
    echo '                  <span class="input-group-addon">';
    echo '                      <span class="glyphicon glyphicon-time"></span>';
    echo '                  </span>';
    echo '              </div>';
    echo '          </div>';
    echo '      </dd>';
    echo '  </dl>';
    echo '  <dl>';
    echo '      <dt>Return Time</dt>';
    echo '      <dd>';
    echo '          <div class="form-group">';
    echo '              <div class="input-group date ReturnTime" id="ReturnTime">';
    echo '                  <input type="text" name="rt" class="form-control' . ($large == "true" ? ' input-lg' : '') . '"/>';
    echo '                  <span class="input-group-addon">';
    echo '                      <span class="glyphicon glyphicon-time"></span>';
    echo '                  </span>';
    echo '              </div>';
    echo '          </div>';
    echo '      </dd>';
    echo '  </dl>';
    echo '</div>';

    // SUBMIT BUTTON  
    echo '<div class="row">';
    echo '<div class="col-md-3">';
    echo '<dl><dt>&nbsp;</dt><dd><button type="submit" class="btn btn-primary btn-block' . ($large == "true" ? ' btn-lg' : '') . '">Get Rates</button></dd></dl>';
    echo '<dl><dt>&nbsp;</dt><dd><a class="btn btn-default btn-block' . ($large == "true" ? ' btn-lg' : '') . '" href="' . $web_url . 'lookup/?id=' . $key . '" target="_new">Lookup Existing</a></dd></dl>';
    echo '</div>';
    echo '</div>';

    echo '</form>';

}
?>
<?php
function SapphireRMS_reservation_lookup_shortcode_handler() {
  
    // GET LOCATIONS
    $data = NULL;
    $url = get_option('SapphireRMS_Options_url');
    $key = get_option('SapphireRMS_Options_key');
    if($key != NULL)
    {
        $api_url = $url . "/api/Locations/" . $key;
        $web_url = $url . "/web/reservations/";
        $json = file_get_contents($api_url);
        $data = json_decode($json, TRUE);               
    }

    // FORM
    echo '<form method="GET" action="' . $web_url . 'lookup/" target="_new">';
    echo '<div class="container-fluid">';
    echo '<input type="hidden" name="id" value="' . $key . '">';
    echo '<input type="hidden" name="go" value="1">';

    echo '<div class="row">';
    echo '<div class="col-md-12">';

    // CONFIRMATION NUMBER
    echo '  <dl>';
    echo '      <dt>Confirmation Number</dt>';
    echo '      <dd>';
    echo '          <div class="input-group">';
    echo '              <span class="input-group-addon"><span class="glyphicon glyphicon-info-sign"></span></span>';
    echo '              <input type="text" class="form-control" name="bid" />';
    echo '          </div>';
    echo '      </dd>';
    echo '  </dl>';

    // LAST NAME
    echo '  <dl>';
    echo '      <dt>Last Name</dt>';
    echo '      <dd>';
    echo '          <div class="input-group">';
    echo '              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
    echo '              <input type="text" class="form-control" name="ln" />';
    echo '          </div>';
    echo '      </dd>';
    echo '  </dl>';

    // SUBMIT BUTTON  
    echo '<dl><dt>&nbsp;</dt><dd><input type="submit" class="btn btn-primary form-control"/></dd></dl>';

    echo '</div>';    

    echo '</div>';
    echo '</div>';
    echo '</form>';
}
?>