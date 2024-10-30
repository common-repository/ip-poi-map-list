<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div style="margin-top: 30px; padding-right: 20px;">
    <h1 style="font-weight: normal">POI Map List Support Center</h1>
    <div style="height: auto; width:auto;background-color: white; border:1px solid lightgrey;border-radius: 5px;margin-top:50px;padding: 30px">
        <h3>About us</h3>
        <p style="text-align: justify;">
            POI map list is a WordPress plugin developed by <a href="https://instant-programming.com/">Instant-Programming</a> to geolocate and display points of interest (POI) on a map. It is a free and easy-to-use plugin made entirely by our team.
        </p>

        <h3 style="padding-top:30px">Plugin usage</h3>
        <p style="text-align: justify;">
            The first step to use the plugin is to enter a valid Google API key in the dedicated field on the Settings of the plugin. This API key is necessary for the plugin to work and to display the map and markers on your site. If you don't have a Google API key, you can get one for free (or buy a premium) by following the steps <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">proposed by Google</a>.<br>
            <br>Then, go to 'Add item' and add the places you want to display on the map by filling in the necessary fields marked with an * (Title, description, exact address). The add item page presents a map to locate the place and two necessary fields: 'Latitude' and 'Longitude'. If you have a Google API premium key, you will be able to get the exact coordinates of your location by clicking on the 'generate location' button. However, if you have a free Google API key, you will have to fill in the latitude and longitude manually.<br>
            <br>Once the previous steps have been done, you just have to use the short-code of the plugin indicated on the Settings page on your site to display the map and the POIs.
        </p>

        <h3 style="padding-top:30px">Visual features of the plugin</h3>
        <p style="text-align: justify;">
            The Settings page allows you to modify some visual characteristics of the plugin.
            <br>
            The plugin has a 100% width, which means that it will occupy the entire width of the parent. It has a height that can be modified as you wish (but with a minimum height of 400px). Markers and POI info. windows are black by default but can be modified to match the color of your theme, accepting HEX and rgba values or name following HTML color-names.<br>
            <br>If your items do not all have a picture, you can define a default picture that will appear for all items that do not have a picture. <br>
            <br> Finally, the plugin presents two different display modes presented by the screeshots below, one mode including the list and the map and another one just displaying the map. Some people will prefer the list mode because it allows you to display all your POIs on a list and filter the content with the search bar. Others will prefer the map only mode because it is more simplified and easy to use.
        </p>
    </div>
    <div style="display: flex; flex-direction: row; margin-top: 50px;">
        <div style="background-color: white; border: 1px solid lightgrey; border-radius: 5px; padding: 30px; flex: 1; margin-right: 5px;">
            <h3>Overview of the plugin with a list</h3>
            <img style="width: 100%;" src="<?php echo plugins_url( '../admin/images/Screenshot_3.png', __FILE__ ); ?>" />
        </div>
        <div style="background-color: white; border: 1px solid lightgrey; border-radius: 5px; padding: 30px; flex: 1; margin-left: 5px;">
            <h3>Overview of the plugin with the map only</h3>
            <img style="width: 100%;" src="<?php echo plugins_url( '../admin/images/Screenshot_4.png', __FILE__ ); ?>" />
        </div>
    </div>
</div>
<?php
?>