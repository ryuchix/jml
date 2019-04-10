<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Client <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( 'client/' ); ?>"><i class="fa fa-life-ring"></i> Client</a></li>
    
            <li class="active">List</li>
    
        </ol>
    
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-body">

                        <div class="nav-tabs-custom">

                            <ul class="nav nav-tabs pull-right">

                                <li class="<?php echo $inactive_list; ?>"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true">Inactive Clients</a></li>

                                <li class="<?php echo $active_list; ?>"><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Active Clients</a></li>

                                <li class="<?php echo $inactive_prospect_list; ?>"><a href="#tab_3-3" data-toggle="tab" aria-expanded="false">Inactive Prospects</a></li>

                                <li class="<?php echo $active_prospect_list; ?>"><a href="#tab_4-4" data-toggle="tab" aria-expanded="false">Active Prospects</a>

                                <li class="<?php echo $inactive_prospect_list; ?>"><a href="#tab_5-5" data-toggle="tab" aria-expanded="false">Inactive Leads</a></li>

                                <li class="<?php echo $active_prospect_list; ?>"><a href="#tab_6-6" data-toggle="tab" aria-expanded="false">Active Leads</a>
                                </li>
                                
                                <?php if ($controller->hasAccess('add-client')): ?>
                                <li class="pull-left header">
                                    <a href="<?php echo site_url( "client/save" ); ?>" style="display: inline;">
                                        <i class="fa fa-plus"></i>
                                    </a> Clients List
                                </li>
                                <?php endif; ?>
                                  
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane <?php echo $inactive_list; ?>" id="tab_1-1">

                                    <?php $this->load->view('clients/client_table', array('records'=>$inactive_records)); ?>
                                    
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane <?php echo $active_list; ?>" id="tab_2-2">

                                    <?php $this->load->view('clients/client_table', array('records'=>$records)); ?>

                                </div><!-- /.tab-pane -->

                                <div class="tab-pane <?php echo $inactive_prospect_list; ?>" id="tab_3-3">

                                    <?php $this->load->view('clients/client_table', array('records'=>$inactive_prospect_records)); ?>

                                </div><!-- /.tab-pane -->

                                <div class="tab-pane <?php echo $active_prospect_list; ?>" id="tab_4-4">

                                    <?php $this->load->view('clients/client_table', array('records'=>$prospect_records)); ?>
                                    
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane <?php echo $inactive_lead_list; ?>" id="tab_5-5">

                                    <?php $this->load->view('clients/client_table', array('records'=>$inactive_lead_records)); ?>

                                </div><!-- /.tab-pane -->

                                <div class="tab-pane <?php echo $active_lead_list; ?>" id="tab_6-6">

                                    <?php $this->load->view('clients/client_table', array('records'=>$lead_records)); ?>
                                    
                                </div><!-- /.tab-pane -->

                            </div><!-- /.tab-content -->

                        </div>

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

<!-- Link trigger modal -->

<!-- Default bootstrap modal example -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<form action="<?php echo base_url('client/change-password') ?>" class="modal fade" id="changeUsername">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Change Username/Password</h4>
            </div>
            <div class="modal-body">
                

                <input type="hidden" name="client_id" id="client_id" value="">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="closeFormModal" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</form>


<?php $this->load->view( 'partials/footer' ); ?>

<script>

    $('.disable').on('click', function (e) {
        if (!confirm("do you really want to disable this client?")) { e.preventDefault(); }
    });

    $('.reactivate').on('click', function (e) {
        if (!confirm("do you really want to Reactivate this client?")) { e.preventDefault(); }
    });

    $('.not').on('click', function (e) {
        e.preventDefault();
        alert('Not implemented yet.');
    });

    $("#myModal").on("show.bs.modal", function(e) {
        var $link = $(e.relatedTarget);
        $('#myModalLabel').text( $link.parents('tr').find('td:eq(0)').text() + ' Location Map' );
        $(this).find(".modal-body").load($link.attr("href"));
    });

    $('#changeUsername').on('show.bs.modal', function(e) {

        var clientId = $(e.relatedTarget).data('client');

        $('#client_id').val(clientId);

        $.ajax({
            url: '<?php echo site_url('clients-credentails') ?>',
            type: 'POST',
            dataType: 'json',
            data: { client_id: clientId },
        })
        .done(function(data) {
            $('#username').val(data.username);
        })
        .fail(function(a, b, c) {
            console.log(a);
        });

    }).on('submit', function(e) {
        
        e.preventDefault();

        $('.has-error').removeClass('has-error');

        $.ajax({
            url: '<?php echo site_url('client/change-password'); ?>',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
        })
        .done(function(data) {
            toastr.options = {
                'closeButton': true,
                'debug': false,
                'progressBar': true,
                'positionClass': 'toast-bottom-right',
                'onclick': null,
                'showDuration': 400,
                'hideDuration': 1000,
                'timeOut': 5000,
                'extendedTimeOut': 1000,
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut'
            };
            toastr.success(data.message, 'Success');
            $('#changeUsername input').val('');
            $('#closeFormModal').trigger('click');
        })
        .fail(function(error) {
            var fields = error.responseJSON;
            for (var name in fields) 
            {
                $('[name=' + name + ']').parent().addClass('has-error');

                if (fields.hasOwnProperty(name)) {
                    console.log(name + " -> " + fields[name]);
                }
            }
        })
        
    });;

</script>