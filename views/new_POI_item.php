<?php
if ( ! defined( 'ABSPATH' ) ) exit;
global $wpdb;
$settings_detail = $wpdb->get_results(
    "SELECT * FROM wp_ip_poi_map_settings where id like '1'"
);

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
        <form method="post" class="wrap">
            <div style="flex-direction: row;align-items: center;display: flex;justify-content: space-between;">
                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
                <div id="publishing-action">
                    <span class="spinner"></span>
                    <input name="original_publish" type="hidden" id="original_publish" value="Publish">
                    <input type="submit" name="PublishNewItem" id="publish" class="button button-primary button-large" value="Publish">
                </div>
            </div>

            <div id="titlediv">
                <div id="titlewrap">
                    <label class="poiLabelText" id="title-prompt-text" for="title"></label>
                    <input class="poiFormInput" type="text" name="item_title" size="30" value="" id="title" spellcheck="true" placeholder="Add title" autocomplete="off" required>
                </div>
                <div class="inside">
                    <div id="edit-slug-box" class="hide-if-no-js">
                    </div>
                </div>
                <input type="hidden" id="samplepermalinknonce" name="samplepermalinknonce" value="05d7dd2b6d">
            </div>
            <div class="poiFormContainer">
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>Description :</p>
                    </div>
                    <div class="poiFormInput">
                        <input type="text" class="poiInnerInput" name="item_description" placeholder="Item description">
                    </div>
                </div>
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>Phone :</p>
                    </div>
                    <div class="poiFormInput">
                        <input type="text" class="poiInnerInput" name="item_phone" placeholder="" >
                    </div>
                </div>
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>Email :</p>
                    </div>
                    <div class="poiFormInput">
                        <input type="text" class="poiInnerInput" name="item_email" placeholder="">
                    </div>
                </div>
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>URL :</p>
                    </div>
                    <div class="poiFormInput">
                        <input type="text" class="poiInnerInput" name="item_url" placeholder="">
                    </div>
                </div>
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>Picture :</p>
                    </div>
                    <div class="poiFormInput">
                        <input type="text" class="poiInnerInput" name="item_picture" placeholder="Picture's URL">
                    </div>
                </div>
            </div>
            <div class="poiFormContainer">
                <div class="poiFormRow">
                    <div style="flex: 1"> </div>
                    <div class="poiMap" >
                        <div class="mapContainer">
                            <div id="POI-map"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <p style="margin-left: 8%; font-style: italic; color:#939393;">*NOTICE* Click on "Generate Location" to get your coordinates and set a marker on map before publishing.</p>
                </div>
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>Address* :</p>
                    </div>
                    <div class="poiFormInput">
                        <input id="address" type="text" class="poiInnerInput" name="item_address" required>
                    </div>
                </div>
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>Street Number :</p>
                    </div>
                    <div class="poiFormInput">
                        <input id="streetNumber" type="text" class="poiInnerInput" name="item_streetNumber">
                    </div>
                </div>
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>City* :</p>
                    </div>
                    <div class="poiFormInput">
                        <input id="city" type="text" class="poiInnerInput" name="item_city" required>
                    </div>
                </div>
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>ZipCode :</p>
                    </div>
                    <div class="poiFormInput">
                        <input id="zipCode" type="text" class="poiInnerInput" name="item_zipCode">
                    </div>
                </div>
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>Country* :</p>
                    </div>
                    <div class="poiFormInput">
                        <input id="country" type="text" class="poiInnerInput" name="item_country" required>
                    </div>
                </div>
                <p style="margin-left: 8%; font-style: italic; color:#939393;">*NOTICE* To generate your coordinates you need a premium API Key. Otherwise, you have to enter the coordinates by yourself.</p>
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>Latitude :</p>
                    </div>
                    <div class="poiFormInput">
                        <input id="latitude" type="text" class="poiInnerInput" name="item_latitude">
                    </div>
                </div>
                <div class="poiFormRow">
                    <div class="poiLabelText">
                        <p>Longtitude :</p>
                    </div>
                    <div class="poiFormInput">
                        <input id="longitude" type="text" class="poiInnerInput" name="item_longitude">
                    </div>
                </div>

        </form>

        </div>
        <div class="poiFormRow">
            <div class="poiFormInput">
                <input type="submit" name="Generate Location" id="generateLocation" class="button button-primary button-large" value="Generate Location">
            </div>
        </div>
<script>
    var geocoder;
    var map;
    var marker = "";
    function initMap() {
        map = new google.maps.Map(document.getElementById('POI-map'), {
            zoom: 8,
            center: {lat: -34.397, lng: 150.644}
        });
        geocoder = new google.maps.Geocoder();
        document.getElementById('generateLocation').addEventListener('click', function() {
            geocodeAddress(geocoder, map);
        });
    }
    function geocodeAddress(geocoder, map) {
        var address = document.getElementById('address').value;
        var streetNumber = document.getElementById('streetNumber').value;
        var city = document.getElementById('city').value;
        var zipCode = document.getElementById('zipCode').value;
        var country = document.getElementById('country').value;
        var fullAddress = streetNumber + ' ' + address + ', ' + city + ' ' + zipCode + ', ' + country;
        console.log(fullAddress);
        geocoder.geocode({'address': fullAddress}, function(results, status) {
            if (status === 'OK') {
                console.log(results[0].geometry.location.lat());
                map.setCenter(results[0].geometry.location);
                map.setZoom(18);
                if(marker)(
                    marker.setMap(null)
                );
                marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
                var newLat = results[0].geometry.location.lat();
                var newLng = results [0].geometry.location.lng();
                document.getElementById('latitude').value = newLat;
                document.getElementById('longitude').value = newLng;
            }
            else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $settings_detail[0]->api_key; ?>&callback=initMap">
</script>

<?php
global $wpdb;
if ( current_user_can( 'publish_posts' ) ) {
    if ($_POST['PublishNewItem']) {
        $wpdb->insert("wp_ip_poi_map_list", array(
            "title" => sanitize_text_field($_POST['item_title']),
            "description" => sanitize_text_field($_POST['item_description']),
            "phone" => sanitize_text_field($_POST['item_phone']),
            "itemPicture" => sanitize_text_field($_POST['item_picture']),
            "email" => sanitize_text_field($_POST['item_email']),
            "url" => sanitize_text_field($_POST['item_url']),
            "streetNumber" => sanitize_text_field($_POST['item_streetNumber']),
            "address" => sanitize_text_field($_POST['item_address']),
            "city" => sanitize_text_field($_POST['item_city']),
            "zipCode" => sanitize_text_field($_POST['item_zipCode']),
            "country" => sanitize_text_field($_POST['item_country']),
            "latitude" => sanitize_text_field($_POST['item_latitude']),
            "longitude" => sanitize_text_field($_POST['item_longitude']),
        ));
    };
}

?>
