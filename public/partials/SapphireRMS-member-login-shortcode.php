<?php
function SapphireRMS_URL_Member_shortcode_handler() {
    $url = get_option('SapphireRMS_Options_url');
    $key = get_option('SapphireRMS_Options_key');
    return $url . '/web/members/?id=' . $key;
}
?>
<?php
function SapphireRMS_member_login_shortcode_handler() {
  
    // GET LOCATIONS
    $data = NULL;
    $url = get_option('SapphireRMS_Options_url');
    $key = get_option('SapphireRMS_Options_key');
    if($key != NULL)
    {
        $api_url = $url . "/api/Locations/" . $key;
        $web_url = $url . "/web/members/";
        $json = file_get_contents($api_url);
        $data = json_decode($json, TRUE);               
    }

    // FORM
    echo '<div class="container">';
    echo '<form method="GET" action="' . $web_url . '" target="_new">';
    echo '<input type="hidden" name="id" value="' . $key . '">';
    echo '<input type="hidden" name="go" value="1">';

    echo '<div class="row">';

    // MEMBER ID
    echo '<div class="col-md-4">';
    echo '  <dl>';
    echo '      <dt>Member Email</dt>';
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
    echo '</div>';

    // PASSWORD
    echo '<div class="col-md-4">';
    echo '  <dl>';
    echo '      <dt>Password</dt>';
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
    echo '</div>';
    echo '</div>';

    // SUBMIT BUTTON  
    echo '<div class="row">';
    echo '<div class="col-md-4"><dl><dt>&nbsp;</dt><dd><input type="submit" class="btn btn-primary btn-block" /></dd></dl></div>';
    echo '<div class="col-md-4"><dl><dt>&nbsp;</dt><dd><input type="reset" class="btn btn-default btn-block" /></dd></dl></div>';
    echo '</div>';

    echo '</form>';
    echo '</div>';
}
?>