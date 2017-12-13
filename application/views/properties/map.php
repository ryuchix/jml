<?php if ($record->address_location): ?>
    
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>

    <h3 id="loading">Loading...</h3>

    <div id="map"></div>

<script>

    function initMap() {

        var location = <?php echo $record->address_location; ?>;

        var map = new google.maps.Map(document.getElementById('map'), {

          zoom: 16,
          center: location

        });
        
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });

        $('#loading').remove();

    }

</script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqnjObX9xybABsjKQYnwEPn88sc7Yhh9I&callback=initMap"></script>

<?php else: ?>

    <h1>Address not available.</h1>

<?php endif ?>