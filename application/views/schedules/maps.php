<?php $this->load->view( 'partials/header' ); ?>
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">

<style>
@media (min-width: 992px){
    .modal-lg {
        width: 1280px;
    }
}
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Schedule Maps</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'reports/' ); ?>"><i class="fa fa-user"></i> Schedule</a></li>
            <li><a href="<?php echo site_url( 'schedule/list' ); ?>"><i class="fa fa-user"></i> List</a></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" id="filterForm" action="" autocomplete="off">
                <div class="col-sm-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Criteria</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="id_label_single">Date:</label>
                                        <input type="text" name="date" class="form-control date" value="<?php echo isset($_GET['date'])? $_GET['date']: date('d/m/Y'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group <?php echo form_error('size')? 'has-error':''; ?>">
                                        <label for="id_label_single">Staff members:</label>
                                        <?php echo form_dropdown('staff', ['All'] + $users->toArray(), isset($_GET['staff'])?$_GET['staff']: 'All', 'class="is_parent_choose form-control" id="id_label_single"'); ?>
                                        <?php echo form_error('size','<p class="error-msg">','</p>') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.row -->
        
        <div class="row">
            <?php if($visits->isEmpty()): ?>
                <div class="col-sm-12">
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <h2 align="center">No visit found!</h2>
                        </div>
                    </div>
                </div>
            <?php else: ?>
            
            <div class="col-sm-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Jobs</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12" style="min-height: 450px">

                                <ul class="list-group" id="visitsLists">
                                    <!-- Populate via javascript based on map marker -->
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Maps</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="map" style="min-height: 450px;"></div>
                    </div>
                </div>
            </div>

            <?php endif; ?>

        </div>
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>

<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>

<script>

    $(function () {

        $('.date').datetimepicker({
             format: 'DD/MM/YYYY'
        });

    });

</script> 

<script>

<?php if(!$visits->isEmpty()): ?>

function getContentAddress(location)
{
    return `<div id="content">
                <div id="siteNotice">
                </div>
                <h1 id="firstHeading" class="firstHeading">${location[2].toUpperCase()}</h1>
                <div id="bodyContent">
                    <p><b>Address</b>: ${location[0]}</p>
                </div>
            </div>`;
}

function initMap() {
    var center = <?php echo $visits->get(0)->job->property->getOriginal('address_location') ?>;

    /* var locations = [
        [
            'Philz Coffee<br> 801 S Hope St A, Los Angeles, CA 90017<br><a href="https://goo.gl/maps/L8ETMBt7cRA2">Get Directions</a>',
            34.046438, 
            -118.259653
        ],
        [
            'Philz Coffee<br>525 Santa Monica Blvd, Santa Monica, CA 90401<br><a href="https://goo.gl/maps/PY1abQhuW9C2">Get Directions</a>', 
            34.017951, 
            -118.493567
        ],
        [
            'Philz Coffee<br>146 South Lake Avenue #106, At Shoppers Lane, Pasadena, CA 91101<br><a href="https://goo.gl/maps/eUmyNuMyYNN2">Get Directions</a>',
            34.143073,
            -118.132040
        ],
        [
            'Philz Coffee<br>21016 Pacific Coast Hwy, Huntington Beach, CA 92648<br><a href="https://goo.gl/maps/Cp2TZoeGCXw">Get Directions</a>',
            33.655199, -117.998640
        ],
        [
            'Philz Coffee<br>252 S Brand Blvd, Glendale, CA 91204<br><a href="https://goo.gl/maps/WDr2ef3ccVz">Get Directions</a>', 
            34.142823, -118.254569
        ]
    ]; */



    <?php 
        $locations = 'var locations = [';
        $counter = 0;
        foreach ($visits as $visit) 
        {
            $users = '<ul class=\"crews-list crews-list-dark\">';
            foreach($visit->crews as $user):
                $users .= '<li class=\"crew-item\" data-toggle=\"tooltip\" title=\"' . $user->first_name . ' ' . $user->last_name . '\" style=\"background-color: ' . $user->system_color . ';\">' . $user->first_name[0] . $user->last_name[0] . '</li>';
            endforeach;
            $users .= '</ul>';

            $jobType = $visit->job->job_type == JOB_TYPE_RECURRING? "(R)": "(O)";
            $counter++;
            // ["{address} {job_type}<br>","{category}<br>", "{job_title}<br>", "{users}<br>", lat, lng],
            $locations .= sprintf('["%s %s<br>","%s<br>", "%s<br>", "%s", %s, %s]%s', 
                                    $visit->job->property->full_address,
                                    $jobType, 
                                    $visit->job->category->type, 
                                    $visit->job->job_title, 
                                    $visit->crews->count()>0 ? $users: '', 
                                    $visit->job->property->address_location->lat, 
                                    $visit->job->property->address_location->lng,
                                    count($visits) !== $counter ? ',':''
                                );
        }
        $locations .= ']';
        echo $locations;
    ?>

    var bounds = new google.maps.LatLngBounds();
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: center
    });
    var infowindow =  new google.maps.InfoWindow({});
    var markers =  [];
    var marker, count;
    for (count = 0; count < locations.length; count++) {
        var location = locations[count];
        console.log(location[4], location[5]);
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(location[4], location[5]),
            map: map,
            title: location[0].replace('<br>', '')
        });
        bounds.extend({ lat: location[4], lng: location[5]});

        markers.push(marker);

        google.maps.event.addListener(marker, 'click', (function (marker, count) {
            return function () {
                infowindow.setContent(getContentAddress(locations[count]));
                infowindow.open(map, marker);
            }
        })(marker, count));

        $hold = $(`<li class="list-group-item" data-idx="${count}">${location[0]}${location[1]}${location[2]}${location[3]}</li>`)
        .hover(function(){
            var index = $(this).data('idx');
            var CurrentMarker = markers[index];
            CurrentMarker.setAnimation(google.maps.Animation.WOBBLE);
            infowindow.setContent(getContentAddress(locations[index]));
            infowindow.open(map, CurrentMarker);
        }).mouseleave(function(){
            infowindow.close();
            var index = $(this).data('idx');
            var CurrentMarker = markers[index];
            CurrentMarker.setAnimation(null);
        })

        $('#visitsLists').append($hold)
    }
    
    map.fitBounds(bounds);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqnjObX9xybABsjKQYnwEPn88sc7Yhh9I&callback=initMap"></script>

<?php endif; ?>