<?php $this->load->view( 'partials/header' ); ?>
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">

<style>
    .widget-user-desc a {
        color: white;
        text-decoration: underline;
    }
    .form-group.delRow {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-group.delRow .deleteRow {
        background-color: red;
        display: block;
        line-height: 30px;
        width: 30px;
        text-align: center;
        color: white;
        border-radius: 3px;
        margin-left: 5px;
        opacity: 0.3;
        transition: all ease-in-out 0.2s;
        display: none;
        cursor: pointer;
    }

    tr:hover .form-group.delRow .deleteRow {
        opacity: 1;
    }
    .form-group.delRow .deleteRow.active {
        transform: scale(2);
        opacity: 1;
        transition: all cubic-bezier(0.68, -0.55, 0.27, 1.55) 0.2s;
    }
</style>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $address; ?></h4>
            </div>
            <div class="modal-body">
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>&nbsp;</h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-trash"></i> Jobs</a></li>
    
            <li class="active">view</li>
    
        </ol>
    
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">

            <div class="col-sm-12">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active" style="height: auto;">
                        
                        <h3 class="widget-user-username">
                            <?php echo $client; ?>
                        </h3>

                        <h5 class="widget-user-desc">
                            <?php echo anchor(site_url("property/map/$record->property_id"),'<i class="fa fa-map-marker"> </i> '. $address, ' data-remote="false" data-toggle="modal" data-target="#myModal" class=""')?>
                        </h5>
                        
                        <h5 class="widget-user-desc">
                            Job # <?php echo $record->id; ?> - <?php echo get_job_types($record->job_type); ?>
                        </h5>
                        
                        <h5 class="widget-user-desc">
                            <a href="<?php echo site_url("jobs/save/{$record->id}") ?>">
                                <?php echo $record->job_title . ' - ' . JobCategory::find($record->job_category)->type; ?>
                                &nbsp;&nbsp;&nbsp;<i class="fa fa-edit"></i>
                            </a>
                        </h5>
                        
                        <?php if($record->job_type == 2): ?>

                        <h5 class="widget-user-desc">
                            Last for: <?php echo $record->duration . ' ' . $record->duration_schedule; ?>
                        </h5>

                        <?php endif;?>
                        
                        <h5 class="widget-user-desc">
                            Contact: <?php echo "$contact->contact_name $contact->surname 
                                (<i class='fa fa-phone'> </i> $contact->phone <i class='fa fa-envelope'> </i> $contact->email)"; ?>
                        </h5>

                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo count($visits); ?></h5>
                                    <a href="#tab_2-2" data-toggle="tab" aria-expanded="true">
                                        <span class="description-text">VISITS</span>
                                    </a>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo count($crew_users); ?></h5>
                                    <a href="#tab_2-1" data-toggle="tab" aria-expanded="false">
                                        <span class="description-text">CREW USERS</span>
                                    </a>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo count($line_items); ?></h5>
                                    <a href="#tab_2-3" data-toggle="tab" aria-expanded="false">
                                        <span class="description-text">LINE ITEMS</span>
                                    </a>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo count($notes); ?></h5>
                                    <a href="#tab_2-4" data-toggle="tab" aria-expanded="false">
                                        <span class="description-text">Notes</span>
                                    </a>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                      <!-- /.row -->
                    </div>
                </div>
                <!-- /.widget-user -->
            </div>

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-body">

                        <div class="nav-tabs-custom">

                            <div class="tab-content">

                                <div class="tab-pane <?php echo $show_note?'':'active'; ?>" id="tab_2-2">

                                    <?php $this->load->view("$class_name/job_visits_table", array('records'=>$visits)); ?>
                                    
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_2-1">

                                    <?php $this->load->view("$class_name/crew_user_table", array('records'=>$crew_users)); ?>
                                    
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_2-3">

                                    <?php $this->load->view("$class_name/job_line_items_table", array('records'=>$line_items)); ?>
                                    
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane <?php echo $show_note?'active':''; ?>" id="tab_2-4">

                                    <?php $this->load->view("$class_name/note_form", array('records'=>$notes)); ?>
                                    
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


<?php $this->load->view( 'partials/footer' ); ?>

<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>

<script>

$(function () {

    $('#VisitDateInput').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    $('.edit_note').on('click', function (e) {
        var $this = $(this),
            note = $this.parents('.timeline-item').find('.note-text').text(),
            url = $('#editModal').find('form').attr('action'),
            note_id = $this.data('note-id'),
            actionUrl = url.substring( 0, url.lastIndexOf('/') )+'/'+note_id;
        
        $('#editModal').find('form').attr('action', actionUrl );
        // console.log(actionUrl);

        $('#editNote').text(note);
    });

    $('.reactivate').on('click', function (e) {
        if (!confirm("do you really want to Reactivate this Bin type?")) { e.preventDefault(); }
    });

    $('a .badge').on('click', function(event) {
        $that = $(this);
        event.preventDefault();
        if (confirm('do you want do delete attachment?')) {
            var url = '<?php echo site_url( "jobs/delete_attachment" ); ?>';
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {'file_id': $(this).data('file_id')},
            })
            .done(function(data) {
                console.log(data);
                if (data.status) {
                    $that.parents('.list-group-item').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }
            });
            
        }
    });

    $("#myModal").on("show.bs.modal", function(e) {
        var $link = $(e.relatedTarget);
        // $('#myModalLabel').text( $link.parents('tr').find('td:eq(0)').text() + ' Location Map' );
        $(this).find(".modal-body").load($link.attr("href"));
    });

    $('[name="visit_id"]').on('change', function() {
        $(this).parent('form').submit();
    });

    // $('#editVisitModal').on('show.bs.modal', function(e){
    //     var visitId = $(e.relatedTarget).data('vpk');
    // });

    var JobVisit = {
        modal: "#editVisitModal",
        visitId: 0,
        titleInput: '',
        date: '',
        userText: '',
        users: [],
        services: [],
        itemRowNumber: 0,
        init: function() {
            $(this.modal).on('show.bs.modal', this.loadVisitForm);
            $('#saveBtn').on('click', this.save);
            this.loadServices();
            $('#addItem').on('click', this.addItemRow);
            $('#deleteItem').on('click', this.showDeleteBtns);
            $('#lineItemTable').on('change', 'tr td select', this.serviceSelected);
        },
        loadVisitForm: e => {
            // get clicked anchor
            var $anchor     = $(e.relatedTarget);
            var $row        = $anchor.parents('tr'); // get current table row

            this.visitId    = $anchor.data('vpk'); // get row visit id
            this.titleInput = $row.find('td:first'); // extract title from first table cell
            this.date       = $row.find('td:eq(1)'); // extract date from second table call
            this.userText   = $row.find('td:eq(2)'); // extra users name from third cell
            this.users      = this.userText.text().trim().split(','); // split by , from users name string

            // setting edit form value
            $('#VisitTitleInput').val(this.titleInput.text().trim());
            $('#VisitDateInput').val(this.date.text().trim());

            // uncheck all checkboxes so that we can check the box again with current selected rows
            $(".crew-users input").prop('checked', false);
            // loop through users array and check them by default.
            for(var i = 0; i < this.users.length; i++)
            {
                var userId = $(".crew-users:contains('" + this.users[i] + "')")
                                .find('input').val();
                $(".crew-users input[value="+ userId +"]").prop('checked', true);
            }
            JobVisit.populateItems();
        },
        populateItems: () => {
            $.ajax({
                url: `<?php echo site_url('jobs/visits/${this.visitId}/items'); ?>`,
                success: (data) => {
                    var row = ``;
                    for(var i = 0; i < data.length; i++){
                        row += JobVisit.getRowTemplate(data[i]);
                    };
                    $('#lineItemTable tbody').html(row);

                    $('#lineItemTable tbody').on('click', '.deleteRow', JobVisit.rowDeleteClickHandler)
                }
            });
        },
        save: () => {
            var lineItems = {};
            $('#lineItemTable tbody tr').each(function(e){
                var service_id = $(this).find('select:first').val();
                var quantity = $(this).find('input:first').val();
                var rate = $(this).find('input:eq(1)').val();
                var desc = $(this).find('textarea').val();
                if(!service_id || !quantity || !rate)
                {
                    alert('Please provide valid data.');
                    return;
                }
                lineItems[service_id] = { unit_cost: rate, service_id: service_id, qty: quantity, total: rate*quantity, description: desc };
                // lineItems.push(syncData);
            });
            var title = $('#VisitTitleInput').val();
            var date = $('#VisitDateInput').val();
            var users = [];
            $('.crew-users input:checked').each((idx, el) => {
                users.push( $(el).val() );
            });

            $.ajax({
                url: `<?php echo site_url('jobs/visits/${this.visitId}/edit'); ?>`,
                method: 'POST',
                data: {
                    title : title,
                    date: date,
                    users: users,
                    lineItems: lineItems,
                    regenerate: $('#regenerate_visit').prop('checked'),
                    job_id: <?php echo $record->id; ?>
                },
                success: (data) => {
                    // update the updated data into table without refreshing the page.
                    this.titleInput.text(data.title);
                    var date = data.date.split('-');
                    var $dateHtml = `<form action="<?php echo site_url('jobs/close_visit'); ?>" method="post">
                                        <input type="checkbox" name="visit_id" value="${data.id}">
                                        ${date[2]}/${date[1]}/${date[0]}
                                    </form>`;
                    this.date.html($dateHtml);

                    $('[data-dismiss="modal"]').trigger('click');
                }
            });
        },
        loadServices: () => {
            $.ajax({
                url: '<?php echo site_url("services/get_list"); ?>',
                success: (data) => {
                    this.services = data;
                    JobVisit.services = data;
                }
            });
        },
        addItemRow: () => {
            var tr = JobVisit.getRowTemplate();
            $('#lineItemTable tbody').append(tr);
        },
        showDeleteBtns: () => {
            $('#lineItemTable tbody .deleteRow').show('slow');
        },
        getRowTemplate: (data) => {
            var i = this.itemRowNumber++;
            var row = `<tr>
                        <td>
                            <div class="form-group">
                                <select name="line_items[0][service_id]" class="dropdown_lists serviceDD form-control select2-hidden-accessible" data-placeholder="Choose Service" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>`;
                                    for(var j=0; j < this.services.length; j++)
                                        row += `<option value="${this.services[j].id}" ${data && this.services[j].id == data.pivot.service_id? 'selected': ''}>${this.services[j].name}</option>`;
                        row += `</select>
                                <textarea class="form-control" rows="2" placeholder="Description...">${data? data.pivot.description: ''}</textarea>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control itemQty" name="line_items[${i}][qty]" placeholder="Quantity" value="${data? data.pivot.qty: ''}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control itemCost" name="line_items[${i}][unit_cost]" placeholder="Unit Cost" value="${data? data.pivot.unit_cost: ''}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group delRow">
                                <input type="text" readonly class="form-control" name="line_items[${i}][total]" placeholder="Total" value="$${data? data.pivot.total: ''}">
                                <span class="deleteRow"><i class="fa fa-trash"></i></span>
                            </div>
                        </td>
                    </tr>`;
            return row;
        },
        serviceSelected: function(e) {
            var service_id = $(this).val();
            var service = JobVisit.services.filter(item => item.id == service_id).shift();
            $(this).next().val(service.description);
            console.log(service);
            $(this).parents('tr').find('input:eq(1)').val(service.rate);
        },
        rowDeleteClickHandler: function(e) {
            if($(this).hasClass('active'))
            {
                $(this).parents('tr').fadeOut('slow', function(){
                    $(this).remove();
                });
            }
            else{
                $(this).addClass('active');
            }
        }
    };

    JobVisit.init();

});

</script>