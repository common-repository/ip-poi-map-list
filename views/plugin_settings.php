<?php
if ( ! defined( 'ABSPATH' ) ) exit;
global $wpdb;

$settings_detail = $wpdb->get_results(
    "SELECT * FROM wp_ip_poi_map_settings where id like '1'"
);
?>
<form method="post" class="wrap" >
    <h1>Settings</h1>
    <div class="settingsContainer">
        <div class="settingsForm">
                     <p style="font-style: italic; color:#939393;">*NOTICE* You need an API Key to display the component on your site.</p>
            <div class="settingsRow">
                <div class="settingsText">
                    <label>Google API Key* :</label>
                </div>
                <div class="settingsInput">
                    <input type="text" class="settingsInnerInput" name="api_key" value="<?php echo esc_attr( $settings_detail[0]->api_key );?>" required>
                </div>
            </div>
            <div class="settingsRow">
                <div class="settingsText">
                    <label>Map Height (px) :</label>
                </div>
                <div class="settingsInput">
                    <input type="number" class="settingsInnerInput" name="map_height" value="<?php echo esc_attr($settings_detail[0]->map_height); ?>">
                </div>
            </div>
            <div class="settingsRow">
                <div class="settingsText">
                    <label>Main theme color (color name or hex value) :</label>
                </div>
                <div class="settingsInput">
                    <input type="text" class="settingsInnerInput" name="theme_color" value="<?php echo esc_attr($settings_detail[0]->theme_color);?>">
                </div>
            </div>
            <div class="settingsRow">
                <div class="settingsText">
                    <label>Default picture :</label>
                </div>
                <div class="settingsInput">
                    <input type="text" class="settingsInnerInput" name="default_picture" value="<?php echo esc_attr( $settings_detail[0]->default_picture);?>">
                </div>
            </div>
            <div class="settingsRow">
                <div class="settingsText">
                    <label>Map type :</label>
                </div>
                <div class="settingsInput">
                    <input type="radio" id="map" name="map_type" value="map" <?php if (isset($settings_detail[0]->map_type) && $settings_detail[0]->map_type=="map") echo "checked";?>>
                    <label for="map">Map only</label><br>
                    <input type="radio" id="list" name="map_type" value="list" <?php if (isset($settings_detail[0]->map_type) && $settings_detail[0]->map_type=="list") echo "checked";?>>
                    <label for="list">List and map</label><br>
                </div>
            </div>
        </div>

        <div class="settingsForm2">
            <p style="font-style: italic; color:#939393;">*NOTICE* Use this Shortcode on your site to use the Point of interest map list.</p>
            <div class="settingsRow">
                <div class="settingsText">
                    <p>Shortcode:</p>
                </div>
                <div class="settingsInput">
                    <input type="text" class="settingsInnerInput"  value="[POI_Map_list]">
                </div>
            </div>
            <div id="publishing-action">
                <span class="spinner"></span>
                <input name="original_publish" type="hidden" id="original_publish" value="Publish">
                <input type="submit" name="PublishPluginSettings" id="publish" class="button button-primary button-large" value="Publish">
            </div>
        </div>
    </div>
</form>
<?php
if ( current_user_can( 'manage_options' ) ) {
    if ($_POST['PublishPluginSettings']) {
        $wpdb->update(
            'wp_ip_poi_map_settings',
            array(
                "api_key" => sanitize_text_field($_POST['api_key']),
                "map_height" => sanitize_text_field($_POST['map_height']),
                "theme_color" => sanitize_text_field($_POST['theme_color']),
                "default_picture" => sanitize_text_field($_POST['default_picture']),
                "map_type" => sanitize_text_field($_POST['map_type']),
            ),
            array('ID' => 1)
        );
        echo "<meta http-equiv='refresh' content='0'>";
    };
}
?>
