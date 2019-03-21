    <h3 id="loading">Loading...</h3>

    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <?php 
            $pos = 0;
            foreach ($images as $image): ?>
                <li data-target="#carousel-example-generic" data-slide-to="<?php echo $pos; ?>" <?php echo !($pos)?'class="active"':''; ?>></li>
                <?php $pos++; ?>
            <?php endforeach ?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php 
            $pos = 0;
            foreach ($images as $image): ?>
                <div class="item <?php echo !($pos)?'active':''; ?>">
                    <img src="<?php echo base_url('uploads/gallery/'.$image->image); ?>" alt="record->name">
                    <div class="carousel-caption">
                        <h2><?php echo $image->title; ?></h2>
                        <p><?php echo $image->description; ?></p>
                    </div>
                </div>
                <?php $pos++; ?>
            <?php endforeach ?>
        </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <?php if($record->source == 'app'): ?>
    <h3>Description:</h3>
    <p> <?= $record->description; ?> </p>
    <?php endif; ?>

<script>

    $('#loading').remove();

</script>