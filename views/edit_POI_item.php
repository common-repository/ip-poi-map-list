<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$id = isset($_GET['id']) ? intval($_GET['id']) : "";

global $wpdb;

$settings_detail = $wpdb->get_results(
    "SELECT * FROM wp_ip_poi_map_settings where id like '1'"
);

$item_detail = $wpdb->get_results(
    "SELECT * FROM wp_ip_poi_map_list WHERE id like '%$id%'"
);
add_action ( 'admin_enqueue_scripts', function () {
    if (is_admin ())
        wp_enqueue_media ();
} );

?>

<form method="post" class="wrap">
    <div style="flex-direction: row;align-items: center;display: flex;justify-content: space-between;">
        <h1>List Item</h1>
        <div id="publishing-action">
            <span class="spinner"></span>
            <input name="original_publish" type="hidden" id="original_publish" value="Publish">
            <input type="submit" name="PublishNewItem" id="publish" class="button button-primary button-large" value="Publish">
        </div>
    </div>

    <div id="titlediv">
        <div id="titlewrap">
            <label class="poiLabelText" id="title-prompt-text" for="title"></label>
            <input class="poiFormInput" required type="text" name="item_title" size="30" id="title" spellcheck="true" placeholder="Add title" autocomplete="off" value="<?php
            if(empty($item_detail[0]->title)) {
                echo sanitize_text_field($_POST["item_title"]);
            }
            else {
                echo $item_detail[0]->title;
            };
            ?>"">
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
                <label>Description:</label>
            </div>
            <div class="poiFormInput">
                <input type="text" class="poiInnerInput" name="item_description" value="<?php
                if(empty($item_detail[0]->description)) {
                    echo sanitize_text_field($_POST["item_description"]);
                }
                else {
                    echo $item_detail[0]->description;
                };
                ?>"">
            </div>
        </div>
        <div class="poiFormRow">
            <div class="poiLabelText">
                <label>Phone:</label>
            </div>
            <div class="poiFormInput">
                <input type="text" class="poiInnerInput" name="item_phone" value="<?php
                if(empty($item_detail[0]->phone)) {
                    echo sanitize_text_field($_POST["item_phone"]);
                }
                else {
                    echo $item_detail[0]->phone;
                };
                ?>"">
            </div>
        </div>
        <div class="poiFormRow">
            <div class="poiLabelText">
                <label>Email:</label>
            </div>
            <div class="poiFormInput">
                <input type="text" class="poiInnerInput" name="item_email" value="<?php
                if(empty($item_detail[0]->email)) {
                    echo sanitize_text_field($_POST["item_email"]);
                }
                else {
                    echo $item_detail[0]->email;
                };
                ?>"">
            </div>
        </div>
        <div class="poiFormRow">
            <div class="poiLabelText">
                <label>URL:</label>
            </div>
            <div class="poiFormInput">
                <input type="text" class="poiInnerInput" name="item_url" value="<?php
                if(empty($item_detail[0]->url)) {
                    echo sanitize_text_field($_POST["item_url"]);
                }
                else {
                    echo $item_detail[0]->url;
                };
                ?>"">
            </div>
        </div>
        <div class="poiFormRow">
            <div class="poiLabelText">
                <label>Picture</label>
            </div>
            <div class="poiFormInput">
                <input type="text" class="poiInnerInput" name="item_picture" value="<?php
                if(empty($item_detail[0]->itemPicture)) {
                    echo sanitize_text_field($_POST["item_picture"]);
                }
                else {
                    echo $item_detail[0]->itemPicture;
                };
                ?>"">
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
        <div >
        <p style="margin-left: 8%; font-style: italic; color:#939393;">*NOTICE* Every time you enter a new address, click on "Generate Location" to get your coordinates and set a marker on map.</p>
        </div>
        <div class="poiFormRow">
            <div class="poiLabelText">
                <label>Address* :</label>
            </div>
            <div class="poiFormInput">
                <input id="address" required type="text" class="poiInnerInput" name="item_address" value="<?php
                if(empty($item_detail[0]->address)) {
                    echo sanitize_text_field($_POST["item_address"]);
                }
                else {
                    echo $item_detail[0]->address;
                };
                ?>"">
            </div>
        </div>
        <div class="poiFormRow">
            <div class="poiLabelText">
                <label>Street Number :</label>
            </div>
            <div class="poiFormInput">
                <input id="streetNumber" type="text" class="poiInnerInput" name="item_streetNumber" value="<?php
                if(empty($item_detail[0]->streetNumber)) {
                    echo sanitize_text_field($_POST["item_streetNumber"]);
                }
                else {
                    echo $item_detail[0]->streetNumber;
                };
                ?>"">
            </div>
        </div>
        <div class="poiFormRow">
            <div class="poiLabelText">
                <label>City* :</label>
            </div>
            <div class="poiFormInput">
                <input id="city" required type="text" class="poiInnerInput" name="item_city" value="<?php
                if(empty($item_detail[0]->city)) {
                    echo sanitize_text_field($_POST["item_city"]);
                }
                else {
                    echo $item_detail[0]->city;
                };
                ?>"">
            </div>
        </div>
        <div class="poiFormRow">
            <div class="poiLabelText">
                <label>ZipCode:</label>
            </div>
            <div class="poiFormInput">
                <input id="zipCode" type="text" class="poiInnerInput" name="item_zipCode" value="<?php
                if(empty($item_detail[0]->zipCode)) {
                    echo sanitize_text_field($_POST["item_zipCode"]);
                }
                else {
                    echo $item_detail[0]->zipCode;
                };
                ?>"">
            </div>
        </div>
        <div class="poiFormRow">
            <div class="poiLabelText">
                <label>Country* :</label>
            </div>
            <div class="poiFormInput">
                <input id="country" required type="text" class="poiInnerInput" name="item_country" value="<?php
                if(empty($item_detail[0]->country)) {
                    echo sanitize_text_field($_POST["item_country"]);
                }
                else {
                    echo $item_detail[0]->country;
                };
                ?>"">
            </div>
        </div>
        <p style="margin-left: 8%; font-style: italic; color:#939393;">*NOTICE* To generate your coordinates you need a premium API Key. Otherwise, you have to enter the coordinates by yourself.</p>
        <div class="poiFormRow">
            <div class="poiLabelText">
                <label>Latitude:</label>
            </div>
            <div class="poiFormInput">
                <input id="latitude" type="text" class="poiInnerInput" name="item_latitude" value="<?php
                if(empty($item_detail[0]->latitude)) {
                    echo sanitize_text_field($_POST["item_latitude"]);
                }
                else {
                    echo $item_detail[0]->latitude;
                };
                ?>"">
            </div>
        </div>

        <div class="poiFormRow">
            <div class="poiLabelText">
                <label>Longtitude:</label>
            </div>
            <div class="poiFormInput">
                <input id="longitude" type="text" class="poiInnerInput" name="item_longitude" value="<?php
                if(empty($item_detail[0]->longitude)) {
                    echo sanitize_text_field($_POST["item_longitude"]);
                }
                else {
                    echo $item_detail[0]->longitude;
                };
                ?>"">
            </div>
        </div>
    </div>
</form>
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
    jQuery(document).ready(function() {
        var $ = jQuery;
        if ($('.set_custom_images').length > 0) {
            if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
                $('.set_custom_images').on('click', function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var id = button.prev();
                    wp.media.editor.send.attachment = function(props, attachment) {
                        id.val(attachment.id);
                    };
                    wp.media.editor.open(button);
                    return false;
                });
            }
        }
    });
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $settings_detail[0]->api_key; ?>&callback=initMap">
</script>

<?php


if ( current_user_can( 'edit_others_posts' ) ) {
    if (($_POST['PublishNewItem'])) {
        $wpdb->update(
            'wp_ip_poi_map_list',
            array(
                "title" => sanitize_text_field($_POST['item_title']),
                "description" => sanitize_text_field($_POST['item_description']),
                "phone" => sanitize_text_field($_POST['item_phone']),
                "email" => sanitize_text_field($_POST['item_email']),
                "url" => sanitize_text_field($_POST['item_url']),
                "itemPicture" => sanitize_text_field($_POST['item_picture']),
                "streetNumber" => sanitize_text_field($_POST['item_streetNumber']),
                "address" => sanitize_text_field($_POST['item_address']),
                "city" => sanitize_text_field($_POST['item_city']),
                "zipCode" => sanitize_text_field($_POST['item_zipCode']),
                "country" => sanitize_text_field($_POST['item_country']),
                "latitude" => sanitize_text_field($_POST['item_latitude']),
                "longitude" => sanitize_text_field($_POST['item_longitude']),
            ),
            array('ID' => $id)
        );
        echo "<meta http-equiv='refresh' content='0'>";
    };
}
?>
