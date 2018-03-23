<?php $this->load->view( 'partials/header' ); ?>

<!-- Morris charts -->
<link rel="stylesheet" href="<?php echo site_url( 'assets/plugins/morris/morris.css' ); ?>">

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Daily Balances</h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li class="active">Daily Balances</li>
    
        </ol>
    
    </section>

    <!-- Main content -->
    <section class="content">

        
        <div class="row">
            
            <div class="col-sm-12">
                
                <div class="box box-info">

                    <div class="box-header with-border">

                      <h3 class="box-title">Progress</h3>

                      <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>

                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>

                      </div>

                    </div>

                    <div class="box-body chart-responsive">

                      <div class="chart" id="line-chart" style="height: 300px;"></div>

                    </div>
                    <!-- /.box-body -->

                </div>
                <!-- /.box -->

            </div>
            <!-- .col-sm-12 -->

        </div>
        <!-- .row -->

        <div class="row">

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-body">

                        <?php $this->load->view("daily_balances/table"); ?>
                                    
                    </div>
                    <!-- /.box-body -->

                </div>
                <!-- /.box -->

            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->

    </section>

</div>

<?php $this->load->view( 'partials/footer' ); ?>


<!-- Morris charts -->
<script src="<?php echo site_url( 'assets/plugins/raphael/raphael.min.js' ); ?>"></script>
<script src="<?php echo site_url( 'assets/plugins/morris/morris.min.js' ); ?>"></script>

<script>

    $(function () {
        
        $.ajax({
            url: '<?php echo site_url( 'daily_balances/get_progress' ) ?>',
        }).done(function(data) {
            
            var line = new Morris.Line({
                element: 'line-chart',
                resize: true,
                data: data,
                xkey: 'y',
                ykeys: ['item1'],
                labels: ['Balance'],
                lineColors: ['#3c8dbc'],
                hideHover: 'auto',
                parseTime: false,
                preUnits: "$",
            });

        }).fail(function() {
            console.log("error fetching daily balance progress data");
        });
    });

</script>