<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Clients Report</h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( 'reports/' ); ?>"><i class="fa fa-user"></i> Reports</a></li>
    
            <li><a href="<?php echo site_url( 'reports/client/filters' ); ?>"><i class="fa fa-user"></i> Clients Report</a></li>
    
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

                                        <label for="is_prospect">Client/Prospect:</label>

                                        <?php echo form_dropdown('client_or_prospect', array('All', 'Client', 'Prospect', 'Lead'), isset($_GET['client_or_prospect'])?$_GET['client_or_prospect']: 'All', 'class="form-control"'); ?>

                                        <?php echo form_error('client_or_prospect','<p class="error-msg">','</p>') ?>

                                    </div>

                                    <div class="form-group">

                                        <label for="id_label_single">Client Type:</label>

                                        <?php echo form_dropdown('client_type', $client_types, isset($_GET['client_type'])?$_GET['client_type']: 'All', 'class="client_type form-control" id="id_label_single"'); ?>

                                        <?php echo form_error('client_type','<p class="error-msg">','</p>') ?>

                                    </div>

                                    <div class="form-group">
                                        
                                        <div class="checkbox">
                                            
                                            <label>
                                                
                                                <input type="checkbox" value="1" <?php echo isset($_GET['is_active'])? 'checked':''; ?> name="is_active"> Is active?

                                            </label>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group <?php echo form_error('lead_type')? 'has-error':''; ?>">

                                        <label for="id_label_single">Lead Type:</label>

                                        <?php echo form_dropdown('lead_type', $lead_types, isset($_GET['lead_type'])?$_GET['lead_type']: 'All', 'class="is_parent_choose form-control" id="id_label_single"'); ?>

                                        <?php echo form_error('lead_type','<p class="error-msg">','</p>') ?>

                                    </div>
                            
                                    <div class="form-group">

                                        <label for="child_or_parent">Child / Parent:</label>

                                        <?php echo form_dropdown('child_or_parent', array('Both', 'Parent Only', 'Child Only'), isset($_GET['child_or_parent'])?$_GET['child_or_parent']: 'All', 'class="client_type form-control" id="id_label_single"') ?>

                                    </div>
                                    
                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">

                            <button type="submit" class="btn btn-primary">Submit</button>

                            <?php if (!empty($records)): ?>
                                
                                <a href="<?php echo isset($_SERVER['QUERY_STRING'])? current_url() . '?' . $_SERVER['QUERY_STRING']: current_url(); ?>&export=csv" class="btn btn-info">Export in CSV</a>
                                
                            <?php endif ?>

                        </div>

                    </div>

                </div>

            </form>

        </div>
        <!-- /.row -->

        <div class="row">

            <div class="col-sm-12">

                <div class="box box-primary">

                    <div class="box-header with-border">

                      <h3 class="box-title">Clients</h3>

                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client name</th>
                                    <th>Address</th>
                                    <th>Client Type</th>
                                    <th>Lead Type</th>
                                    <th>Is Parent</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php foreach($records as $row){ ?>

                            <tr>
                                <td><?php echo $row->id; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->address; ?></td>
                                <td><?php echo $row->client_type; ?></td>
                                <td><?php echo $row->lead_type; ?></td>
                                <td><i style="color: limegreen;" class="fa fa-<?php echo $row->is_parent ? 'circle': 'circle-o'; ?>"></i></td>
                            </tr>

                            <?php } ?>

                            </tbody>

                        </table>

                    </div>
                    <!-- /.box-body -->

                </div>

            </div>

        </div>
        <!-- /.row -->

    </section>

</div>

<?php $this->load->view( 'partials/footer' ); ?>

<script>
    
    $(function(){
        $('#filterForm').on('submit', function(e){
            // e.preventDefault();
            // $(this)[0].reset();
            // console.log($(this).serialize());
        });
    });

</script>