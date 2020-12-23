<?php $this->load->view( 'partials/header' ); ?>

<!-- <link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css"> -->
<div class="preloader-container" style="position: fixed;">
    <div class="preloader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Weekly Schedules</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'reports/' ); ?>"><i class="fa fa-user"></i> Schedule</a></li>
            <li><a href="<?php echo site_url( 'schedule/weekly' ); ?>"><i class="fa fa-user"></i> Weekly</a></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Job Visits</h3>
                        <div id="filterContainer" style="display: inline-block; float: right;">
                            <span id="categoryFilterContainer"></span>
                            <span id="crewFilterContainer"></span>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
$(function(){
    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        columnFormat: {
            week: 'ddd DD/MM',
        },
        defaultView: 'basicWeek',
        editable: false,
        droppable: false, // this allows things to be dropped onto the calendar
        dragRevertDuration: 0,
        eventLimit: false, // allow "more" link when too many events
        textEscape: false,
        viewRender: function(date, d) {
            
            $('.preloader-container').show();

            // console.log(d);
            /* setTimeout(() => {
                $(document).find('.fc-center h2').text('hello world');
            }, 1); */
            // axios.post('./weekly-visits', { 
            //     'start_date': date.start.format('YYYY-MM-DD'),
            //     'end_date': date.end.subtract(1, "days").format('YYYY-MM-DD')
            // }).then(function(data){
            //     // console.log(date, date.start.format('DD/MM/YYYY'), date.end.format('DD/MM/YYYY'));
            //     console.log(data.data);

            // })
        },
        eventRender: function(event, element) {
            var crews = '';
            var categoryId = event.job.category.id;
            if(event.crews.length > 0)
            {
                crews = '<ul class="crews-list">';
                $.each(event.crews, function(i, el){
                    crews += `<li class="crew-item" data-toggle="tooltip" data-category="${categoryId}" data-pk="${el.id}" title="${el.first_name} ${el.last_name}" style="background-color: ${el.system_color}">${el.first_name[0]}${el.last_name[0]}</li>`;
                });
                crews += `<ul>`;
            }
            var jobType = event.job.job_type === 2? '(R)': '(O)';


                element.css('background-color', event.job.category.color);


            element.find('.fc-title').text(event.job.property.address + ' ' + jobType);
            element.find('.fc-content')
                .append(`<span class="job-category">${event.job.category.type}</span>`)
                .append(`<span class="job-title">${event.job.job_title}</span>`)
                .append(`<span class="job-crews">${crews}</span>`);
        },
        events: function( start, end, timezone, callback ) {
            axios.post('./weekly-visits', {
                'start_date': start.format('YYYY-MM-DD'),
                'end_date': end.subtract(1, "days").format('YYYY-MM-DD')
            }).then(function(data){
                // console.log(date, date.start.format('DD/MM/YYYY'), date.end.format('DD/MM/YYYY'));

                addFilters(data.data);
                
                callback(data.data);
                $('.preloader-container').hide();
            })
        }
    });

    function addFilters(events)
    {
        let users = [];
        let categories = [];

        events.forEach(visit => {
            visit.crews.forEach(crew => users.push(crew))
            categories.push(visit.job.category);
        })
        
        let uniqueCrewIds = Array.from(new Set(users.map(user => user.id)))
        crewFilterOptions = uniqueCrewIds.map(id => { 
            let u = users.find(user => user.id === id);
            return { id:id, name: u.first_name + ' ' + u.last_name }
        });

        let crewSelectFilter = $('<select class="crewsLists"></select>');
        crewSelectFilter.append(`<option>Select Crew</option>`);
        crewFilterOptions.forEach(option => {
            crewSelectFilter.append(`<option data-id="${option.id}">${option.name}</option>`);
        });

        crewSelectFilter.on('change', function(e){
            let id = $(this).find('option:selected').data('id');
            let categoryId = $("select.categoriesLists").find('option:selected').data('id');
            let username = $(this).val();
            if(username == 'Select Crew')
            {
                $('.fc-event-container').css('opacity', 1);
                return;
            }
            $('.fc-event-container').css('opacity', 0.2)
                .removeClass('animated rubberBand');
            setTimeout(() => {
                if(categoryId)
                {
                    let = selector = '[data-pk="'+ id +'"][data-category="' + categoryId + '"]';
                }else{
                    let = selector = '[data-pk="' + id + '"]';
                }
                console.log(selector);
                $(selector).each(function(){
                    // $('[data-pk="'+ id +'"]').each(function(){
                    var $this = $(this);
                    $this.parents('.fc-event-container').css('opacity', 1)
                    .addClass('animated rubberBand');
                })
            }, 10);
        });

        
        let uniqueCategoriesId = Array.from(new Set(categories.map(category => category.id)))
        categoriesFilterOptions = uniqueCategoriesId.map(id => { 
            let cat = categories.find(category => category.id === id);
            return { id:id, name: cat.type }
        });

        let categoriesSelectFilter = $('<select class="categoriesLists"></select>');
        categoriesSelectFilter.append(`<option>Select Category</option>`);
        categoriesFilterOptions.forEach(option => {
            categoriesSelectFilter.append(`<option data-id="${option.id}">${option.name}</option>`);
        });

        categoriesSelectFilter.on('change', function(e){
            let selectedCrewId = $('select.crewsLists').find('option:selected').data('id');
            let id = $(this).find('option:selected').data('id');
            let categoryName = $(this).val();
            if(categoryName == 'Select Category')
            {
                $('.fc-event-container').css('opacity', 1);
                return;
            }
            $('.fc-event-container').css('opacity', 0.05)
                .removeClass('animated rubberBand');
            setTimeout(() => {
                if(selectedCrewId)
                {
                    let = selector = '[data-pk="'+ selectedCrewId +'"][data-category="' + id + '"]';
                }else{
                    let = selector = '[data-category="' + id + '"]';
                }
                $(selector).each(function(){
                    var $this = $(this);
                    $this.parents('.fc-event-container').css('opacity', 1)
                    .addClass('animated rubberBand');
                })
            }, 10);
        });
        
        console.log(categoriesSelectFilter);

        $('#categoryFilterContainer').html(categoriesSelectFilter);
        $('#crewFilterContainer').html(crewSelectFilter);
    }

    

});

</script> 