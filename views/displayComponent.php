<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function display_component()
{
    global $wpdb;
    $settings_detail = $wpdb->get_results(
        "SELECT * FROM wp_ip_poi_map_settings where id like '1'"
    );

    $all_items = $wpdb->get_results(
        "SELECT * FROM wp_ip_poi_map_list"
    );
    $items_array = array();

    if (count($all_items) > 0) {

        foreach ($all_items as $index => $listItem) {
            $items_array[] = array(
                "id"    => $listItem->id,
                "title" => $listItem->title,
                "description" => $listItem->description,
                "phone" => $listItem->phone,
                "url"=> $listItem->url,
                "itemPicture"=> $listItem->itemPicture,
                "streetNumber" => $listItem->streetNumber,
                "address"=> $listItem->address,
                "city" => $listItem->city,
                "zipCode"=> $listItem->zipCode,
                "country" => $listItem->country,
                "latitude"=> $listItem->latitude,
                "longitude" => $listItem->longitude,
            );
        }
    }
    wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=' . $settings_detail[0]->api_key . '&callback=initMap&language=en®ion=EU', false);
    wp_enqueue_script('googlemaps');
    //convert the PHP array into JSON format, so it works with javascript
    $json_array = json_encode($items_array);
    ?>
    <?php if($settings_detail[0]->map_type === 'map') : ?>
        <div class="poiMainContainer">
            <div class="poiListhidden" id="POI-list"></div>
            <div class="poiMap" >
                <div class="mapContainer">
                    <div id="POI-map"></div>
                </div>
            </div>
        </div>

    <?php else : ?>
        <svg class="spritesheet" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black">
            <symbol id="searchIcon" viewBox="0 0 24 24">
                <title>search</title>
                <path d="M0 0h24v24H0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
            </symbol>
        </svg>
        <div style="margin:15px 0!important; max-width: unset!important;">
            <label class="searchInputContainer">
                <input class="poiInput" type="text" id="poiSearch" placeholder='Filter your search' style="font-size:16px">
            </label>
        </div>

        <div class="poiMainContainer">
            <div class="poiList" id="POI-list"></div>
            <div class="poiMap" >
                <div class="mapContainer">
                    <div id="POI-map"></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <script>

        var listItemArray = <?php echo $json_array; ?>;

        if(listItemArray[0].latitude ===''){
            listItemArray[0].latitude= 0;
        }
        if(listItemArray[0].longitude ===''){
            listItemArray[0].longitude= 0;
        }

        var map;
        var markers = [];

        function initMap() {
            map = new google.maps.Map(document.getElementById('POI-map'), {
                zoom: 8,
                center: {lat: parseFloat(listItemArray[0].latitude), lng: parseFloat(listItemArray[0].longitude)}
            });
            setMarkers(map);
        }

        function setMarkers(map) {
            var infowindow = new google.maps.InfoWindow();

            var svgColor = "<?php echo $settings_detail[0]->theme_color; ?>";

            var svg = '<svg width="39.99999999999999" height="45" xmlns="http://www.w3.org/2000/svg">'+
                '<g><path stroke="rgba(0, 0, 0, 0.28)" fill="'+svgColor+'" id="svg_1" d="m20,1.30991a15.541792,15.541792 0 0 0 -15.541792,15.541792c0,15.880886 14.128902,26.152598 14.722316,26.576465a1.41289,1.41289 0 0 0 1.638953,0c0.593414,-0.423867 14.722316,-10.695579 14.722316,-26.576465a15.541792,15.541792 0 0 0 -15.541792,-15.541792zm0,22.606243a7.064451,7.064451 0 1 1 7.064451,-7.064451a7.064451,7.064451 0 0 1 -7.064451,7.064451z" class="cls-1"/>\n' +
                '<path id="svg_12" fill-opacity="null" stroke-opacity="null" stroke-width="1.5" stroke="#000" fill="none"/>\n' +
                '<path id="svg_14" fill-opacity="null" stroke-opacity="null" stroke-width="1.5" stroke="#000" fill="none"/>\n' +
                '</g>\n' +
                '</svg>';
            for (var i = 0; i < listItemArray.length; i++) {
                var listItem = listItemArray[i];
                var marker = new google.maps.Marker({
                    position: {lat: parseFloat(listItem.latitude), lng: parseFloat(listItem.longitude)},
                    map: map,
                    icon: { url: 'data:image/svg+xml;charset=UTF-8;base64,' + btoa(svg), scaledSize: new google.maps.Size(40, 40) },
                    title: listItem.title,
                    zIndex: 4,
                });

                function displayInfo(infoArray){
                    let toDisplay = '';
                    if(infoArray.address){
                        toDisplay = toDisplay+
                            '<div class="infoWindowRow" style="align-items: flex-start">'+
                            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="14px" height="14px">'+
                            '<path d="M0 0h24v24H0z" fill="none"/>'+
                            '<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>'+
                            '</svg>'+
                            '<p id="infoWindowBodyText" class="infoWindowBodyText">'+infoArray.streetNumber+ ' '+infoArray.address+', '+ infoArray.city+ ' '+ infoArray.zipCode+'</p>'+
                            '</div>'
                    }
                    if(infoArray.phone){
                        toDisplay = toDisplay +
                            '<div class="infoWindowRow">'+
                            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="14px" height="14px">' +
                            '<path d="M0 0h24v24H0z" fill="none"/>' +
                            '<path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>' +
                            '</svg>' +
                            '<p class="infoWindowBodyText">'+ infoArray.phone+ '</p>'+
                            '</div>'
                    }
                    if(infoArray.url){
                        toDisplay = toDisplay +
                            '<div class="infoWindowRow">'+
                            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="14px" height="14px">'+
                            '<path d="M0 0h24v24H0z" fill="none"/>'+
                            '<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95c-.32-1.25-.78-2.45-1.38-3.56 1.84.63 3.37 1.91 4.33 3.56zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2 0 .68.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56-1.84-.63-3.37-1.9-4.33-3.56zm2.95-8H5.08c.96-1.66 2.49-2.93 4.33-3.56C8.81 5.55 8.35 6.75 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2 0-.68.07-1.35.16-2h4.68c.09.65.16 1.32.16 2 0 .68-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95c-.96 1.65-2.49 2.93-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2 0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z"/>'+
                            '</svg>'+
                            '<a class="infoWindowBodyText" href="http://'+infoArray.url+'" target="_blank">'+infoArray.url+'</a>'+
                            '</div>'
                    }

                    return toDisplay
                }

                google.maps.event.addListener(marker, 'click', (function openWindow(marker, i) {
                    return function() {
                        infowindow.setContent(
                            '<div id="infoWindowContent" class="infoWindowItem">'+
                            '<div>'+
                            '<p id="windowTitle" class="infoWindowTitle">'+listItemArray[i].title+'</p>'+
                            '</div>'+
                            '<div class="infoWindowBodyContent">'+
                            displayInfo(listItemArray[i])+
                            '</div>'+
                            '</div>');
                        infowindow.open(map, marker);
                        map.setCenter(new google.maps.LatLng({lat: parseFloat(listItemArray[i].latitude), lng: parseFloat(listItemArray[i].longitude)}));
                    }
                })(marker, i));

                markers.push(marker);
            }

            google.maps.event.addListener(map, 'click', function() {
                infowindow.close();
            });
        }

        function displayListItemPicture(listItem){
            let pictureToDisplay = '';
            if(listItem.itemPicture){
                pictureToDisplay = pictureToDisplay+ '<img class="poiListItemImage" src=' + listItem.itemPicture + '>'
            }
            else{
                pictureToDisplay = pictureToDisplay+ '<img class="poiListItemImage" src="<?php echo $settings_detail[0]->default_picture; ?>">'
            }
            return pictureToDisplay
        }

        function displayListItemDescription(listItem){
            let descriptionToDisplay = '';
            if(listItem.description){
                descriptionToDisplay = descriptionToDisplay+ '<p class="poiListItemDescription">'+listItem.description+'</p>'
            }
            else{
                descriptionToDisplay = descriptionToDisplay+ '<p class="poiListItemDescription">'+listItem.streetNumber+ ' '+listItem.address+', '+ listItem.city+ ' '+ listItem.zipCode+'</p>'
            }
            return descriptionToDisplay
        }

        <?php if($settings_detail[0]->map_type === 'map') : ?>
        let listItems = listItemArray.map(
            (item)=>{
                return (
                    '<div class="poiListItemHidden"  data-id="'+item.id+'">' +
                    '<div class="poiListItemImageContainer">' +
                    displayListItemPicture(item)+
                    '</div>' +
                    '<div class="poiListItemContent">' +
                    '<p class="poiListItemTitle">'+item.title+'</p>' +
                    displayListItemDescription(item)+
                    '</div>'+
                    '</div>'
                )
            }).join('');

        <?php else : ?>
        let listItems = listItemArray.map(
            (item)=>{
                return (
                    '<div class="poiListItem"  data-id="'+item.id+'">' +
                    '<div class="poiListItemImageContainer">' +
                    displayListItemPicture(item)+
                    '</div>' +
                    '<div class="poiListItemContent">' +
                    '<p class="poiListItemTitle">'+item.title+'</p>' +
                    displayListItemDescription(item)+
                    '</div>'+
                    '</div>'
                )
            }).join('');

        <?php endif; ?>

        window.onload = function() {

            var themeColor = "<?php echo $settings_detail[0]->theme_color; ?>";
            var height = "<?php echo $settings_detail[0]->map_height; ?>px";

            //changing our basic background-color for the theme color
            var html = document.getElementsByTagName('html')[0];
            html.style.setProperty("--main-background-color", themeColor);
            html.style.setProperty("--main-height", height);

                //Display the listItems on the loading of the page
            document.getElementById("POI-list").innerHTML = listItems;

            //get the data from the Input component
            const searchField = document.querySelector('#poiSearch');

            //function when you write text in the input field
            searchField.addEventListener('input', (e) => {

                // if input field is empty, we display all the array
                if(e.target.value === '') {
                    document.getElementById("POI-list").innerHTML = listItems;
                    setListeners();
                    return;
                }

                // filter the listItemArray array
                const searchResults = listItemArray.filter(listItem => {
                    let { title, address , city, zipCode, description } = listItem;
                    let isSelected = title.toLowerCase().includes(e.target.value.toLowerCase()) || address.toLowerCase().includes(e.target.value.toLowerCase()) || city.toLowerCase().includes(e.target.value.toLowerCase()) || zipCode.toLowerCase().includes(e.target.value.toLowerCase()) || description.toLowerCase().includes(e.target.value.toLowerCase())
                    return isSelected;
                });

                // before displaying the search results, clear the search results div
                document.getElementById("POI-list").innerHTML = '';

                // display the titles of the listItemArray objects that include the text entered in input field
                document.getElementById("POI-list").innerHTML = searchResults.map(
                    (item)=>{
                        return (
                            '<div class="poiListItem"  data-id="'+item.id+'">' +
                            '<div class="poiListItemImageContainer">' +
                            displayListItemPicture(item)+
                            '</div>' +
                            '<div class="poiListItemContent">' +
                            '<p class="poiListItemTitle">'+item.title+'</p>' +
                            displayListItemDescription(item)+
                            '</div>'+
                            '</div>'
                        )
                    }).join('');
                setListeners()
            });

            function setListeners (){
                var elements = document.getElementsByClassName("poiListItem");
                Array.from(elements).forEach(function(element) {
                    element.addEventListener('click', myFunction);
                });
            }
            function myFunction() {
                var infowindow = new google.maps.InfoWindow();
                var POIID = this.getAttribute("data-id");
                let listItemIndex = listItemArray.findIndex(function (Item) { return Item.id === POIID});
                let POI = listItemArray[listItemIndex];
                map.setZoom(5);
                map.setCenter(new google.maps.LatLng({lat: parseFloat(POI.latitude), lng: parseFloat(POI.longitude)}));
                map.setZoom(12);
                infowindow.setContent(
                    '<div id="infoWindowContent">'+
                    '<div id="siteNotice">'+'</div>'+
                    '<p id="windowTitle" class="windowTitle">'+POI.title+'</p>'+
                    '<div>'+
                    '<p id="windowContent">'+POI.streetNumber+ ' '+POI.address+', '+ POI.city+ ' '+ POI.zipCode+'</p>'+
                    '</div>'+
                    '</div>');
                infowindow.open(map);
                onclick="myClick(0);";
                google.maps.event.trigger(markers[listItemIndex], 'click');
            }
            setListeners();
        };

    </script>

    <?php
}

add_shortcode('POI_Map_list', 'display_component');
?>