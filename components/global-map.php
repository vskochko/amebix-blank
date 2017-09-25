    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUPkH8XAlVE39QDX5C-NZOqe-gciMfdA4"></script>
    <script type="text/javascript">
        (function ($) {

            function new_map($el) {
                // var
                var $markers = $el.find('.marker');
                // vars
                var args = {
                    zoom: 16,
                    center: new google.maps.LatLng(0, 0),
                     // @formatter:off
                styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
                // @formatter:on
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                // create map
                var map = new google.maps.Map($el[0], args);
                // add a markers reference
                map.markers = [];
                // add markers
                $markers.each(function () {
                    add_marker($(this), map);
                });
                // center map
                center_map(map);
                // return
                return map;
            }


            function add_marker($marker, map) {
                // var
                var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
                // create marker
                var iconBase = '<?php echo theme(); ?>/img/pin.png';
                var marker = new google.maps.Marker({
                    position: latlng,
                    icon: iconBase,
                    map: map
                });
                // add to array
                map.markers.push(marker);
                // if marker contains HTML, add it to an infoWindow
                if ($marker.html()) {
                    // create info window
                    var infowindow = new google.maps.InfoWindow({
                        content: $marker.html()
                    });
                    // show info window when marker is clicked
                    google.maps.event.addListener(marker, 'click', function () {
                        infowindow.open(map, marker);
                    });
                }
            }


            function center_map(map) {
                // vars
                var bounds = new google.maps.LatLngBounds();
                // loop through all markers and create bounds
                $.each(map.markers, function (i, marker) {
                    var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
                    bounds.extend(latlng);
                });
                // only 1 marker?
                if (map.markers.length == 1) {
                    // set center of map
                    map.setCenter(bounds.getCenter());
                    map.setZoom(16);
                }
                else {
                    // fit to bounds
                    map.fitBounds(bounds);
                }
            }


            var map = null;
            $(document).ready(function () {
                $('.acf-map').each(function () {
                    // create map
                    map = new_map($(this));
                });
            });
        })(jQuery);
    </script>
