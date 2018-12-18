<div class="row">

  <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
                <h3><?php echo $count_properties; ?></h3>
                <p>Properties</p>
          </div>
            <div class="icon">
                <i class="ion ion-home"></i>
            </div>
            <a href="<?php echo site_url( 'property/' ); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

	<div class="col-lg-3 col-xs-6">
      	<!-- small box -->
      	<div class="small-box bg-red">
        	<div class="inner">
              	<h3><?php echo $count_complaints; ?></h3>
              	<p>Issues/Complaints</p>
        	</div>
            <div class="icon">
              	<i class="ion ion-bug"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      	</div>
    </div>
	<div class="col-lg-3 col-xs-6">
      	<!-- small box -->
      	<div class="small-box bg-green">
        	<div class="inner">
              	<h3><?php echo $count_quotes; ?></h3>
              	<p>Quotes</p>
        	</div>
            <div class="icon">
              	<i class="ion ion-filing"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      	</div>
    </div>

	<?php if (false): ?>
	<div class="col-lg-3 col-xs-6">
      	<!-- small box -->
      	<div class="small-box bg-aqua">
        	<div class="inner">
              	<h3><?php echo $count_pending_quotes; ?></h3>
              	<p>Pending Quotes</p>
        	</div>
            <div class="icon">
              	<i class="ion ion-quote"></i>
            </div>
            <a href="<?php echo site_url( 'quote/' ); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      	</div>
    </div>
	<?php endif ?>
    <?php if(false): ?>
	<div class="col-lg-3 col-xs-6">
      	<!-- small box -->
      	<div class="small-box sk bg-aqua">
        	<div class="inner">
              	<h3><?php // echo $count_all_vehicle; ?></h3>
              	<p>Vehicles</p>
        	</div>
            <div class="icon">
              	<i class="ion ion-model-s"></i>
            </div>
            <a href="<?php echo site_url( 'vehicle/' ); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      	</div>
    </div>
    <?php endif ?>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box sk bg-red">
            <div class="inner">
                <h3><span class="temperature"></span> °C</h3>
                <p>Weather</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-cloud-outline"><!-- <img src="" alt="status" id="thumbnail" /> --></i>
            </div>
            <a href="#" class="small-box-footer" id="showForecast">More info <i class="fa fa-arrow-circle-down"></i></a>
        </div>
    </div>

</div>

<div class="row" id="weather">

	<div class="col-sm-12">

		<div id="display" class="box box-danger">

			<div class="row">
				
			    <div id="top" class="col-sm-4">

			      	<div class="location"></div>

			      	<div class="time"></div>

			      	<div class="status"></div>

			    </div>

			    <div id="left-information" class="col-sm-4">

			      	<img src="" alt="status" class="thumbnail" id="thumbnail" />

			      	<div class="temperature"></div>

			      	<div class="unit">°C</div>

			    </div>

			    <div id="right-information" class="col-sm-4">

			      	<span></span><br/>

			      	<span></span><br/>

			      	<span>km/h</span>

			    </div>

			</div>

	    	<div id="forecast">

	      		<ul class="upcoming-forecast">
	        		
	      		</ul>

	    	</div>

		</div>

	</div>

</div>