<?php $this->load->view( 'partials/header' ); ?>
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">

<style>
    table.table td:nth-child(1)  {
        min-width: 150px;
    }
    table.table td:nth-child(2)  {
        min-width: 100px;
    }
    table.table td:nth-child(6)  {
        min-width: 150px;
    }

    table.table td:nth-child(n+8)  {
        min-width: 50px;
    }

    table.table th {
        text-align: center;
    }

    /* Table Column Freez */
    #table tr th:nth-child(1),
    #table tr td:nth-child(1),
    #table tr th:nth-child(2),
    #table tr td:nth-child(2),
    #table tr th:nth-child(3),
    #table tr td:nth-child(3),
    #table tr th:nth-child(4),
    #table tr td:nth-child(4),
    #table tr th:nth-child(5),
    #table tr td:nth-child(5),
    #table tr th:nth-child(6),
    #table tr td:nth-child(6),
    #table tr th:nth-child(7),
    #table tr td:nth-child(7){
        position: absolute;
        display: block;
        top: auto;
        word-break: break-word;
        box-sizing: border-box;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-top: -1px;
    }

    #table tr td:nth-child(1),
    #table tr td:nth-child(2),
    #table tr td:nth-child(3),
    #table tr td:nth-child(4),
    #table tr td:nth-child(5),
    #table tr td:nth-child(6),
    #table tr td:nth-child(7){
        margin-top: 0px;
    }

    #table tr th:nth-child(1),
    #table tr th:nth-child(2),
    #table tr th:nth-child(3),
    #table tr th:nth-child(4),
    #table tr th:nth-child(5),
    #table tr th:nth-child(6),
    #table tr th:nth-child(7){
        height: 40px;
    }

    #table tr th:nth-child(1),
    #table tr td:nth-child(1){
        width: 152px;
        min-width: auto;
    }
    #table tr th:nth-child(2),
    #table tr td:nth-child(2){
        width: 102px;
    }
    #table tr th:nth-child(3),
    #table tr td:nth-child(3){
        width: 84px;
    }
    #table tr th:nth-child(4),
    #table tr td:nth-child(4){
        width: 87px;
    }
    #table tr th:nth-child(5),
    #table tr td:nth-child(5){
        width: 58px;
    }
    #table tr th:nth-child(6),
    #table tr td:nth-child(6){
        width: 152px;
    }
    #table tr th:nth-child(7),
    #table tr td:nth-child(7){
        width: 67px;
    /*     border-right: 0; */
    }
    #table tr th:nth-child(8),
    #table tr td:nth-child(8){
        border-left: 0;
    }

    #table tr:nth-child(1) > th{
        border-top: 1px solid #f4f4f4;
    }

    #table.table-bordered{
        border-left: 0px;
    }

    #table tr:nth-child(2n+1) th,
    #table tr:nth-child(2n+1) > td {
        background: #f9f9f9 !important;
    }
    #table tr th:nth-child(10n+7), 
    #table tr td:nth-child(10n+7)
    {
        border-right-color: #000 !important;
    }

    #table thead tr:first-child th:nth-child(1n+7)
    {
        border-right-color: #000 !important;
    }

</style>

<div class="content-wrapper" id="scheduleBinLiner">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Bin Cleaning</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'reports/' ); ?>"><i class="fa fa-user"></i> Schedule</a></li>
            <li><a href="<?php echo site_url( 'schedule/bin-cleaning' ); ?>"><i class="fa fa-user"></i> Bin Cleaning</a></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <form role="form" @submit.prevent="report" autocomplete="off">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Bin Cleaning</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="from_date">From Date:</label>
                                        <!-- <input type="text" required id="from_date" v-model="form.fromDate" class="form-control date"> -->
                                        <date-picker ref="fromDate" v-model="form.fromDate" required :config="{format: 'DD/MM/YYYY'}" class="form-control" value=""></date-picker>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="to_date">To Date:</label>
                                        <!-- <input type="text" required id="to_date" v-model="form.toDate" class="form-control date"> -->
                                        <date-picker ref="toDate" v-model="form.toDate" required :config="{format: 'DD/MM/YYYY'}" class="form-control" value=""></date-picker>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="client_type">Client Type:</label>
                                        <select v-model="form.clientType" id="client_type" class="form-control">
                                            <option value="">All</option>
                                            <option v-for="type in clientTypes" :value="type.id">{{ type.type }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="status">Status:</label>
                                        <select v-model="form.status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="allClients">
                                        <input type="checkbox" id="allClients" value="1" v-model="form.withEmpty" id="allClients">
                                            All Clients
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="suburb">Suburb:</label>
                                        <select v-model="form.suburb" id="suburb" class="form-control">
                                            <option value="">All</option>
                                            <option v-for="suburb in suburbs" :value="suburb.address_suburb" v-text="suburb.address_suburb"></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">
                                Submit
                                <i class="fa fa-spinner fa-spin" v-if="isLoading"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Clients</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered"  v-if="jobs.length" id="table">
                                        <thead>
                                            <tr>
                                                <th style="border-right-color: #f9f9f9;">&nbsp;</th>
                                                <th style="border-right-color: #f9f9f9;">&nbsp;</th>
                                                <th style="border-right-color: #f9f9f9;">&nbsp;</th>
                                                <th style="border-right-color: #f9f9f9;">&nbsp;</th>
                                                <th style="border-right-color: #f9f9f9;">&nbsp;</th>
                                                <th style="border-right-color: #f9f9f9;">&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <template v-for="key in Object.keys(weeks)">
                                                    <th v-if="weeks[key].length > 0" :colspan="weeks[key].length * 2">{{ key }}</th>
                                                </template>
                                            </tr>
                                            <tr>
                                                <th>Clients</th>
                                                <th>Suburb</th>
                                                <th>Type</th>
                                                <th>Day</th>
                                                <th>Status</th>
                                                <th>Notes</th>
                                                <th>Freq</th>
                                                <template v-for="week in weeks">
                                                    <template v-for="day in week">
                                                        <th>{{ day[13] }}</th>
                                                        <th>R</th>
                                                    </template>
                                                </template>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="job in jobs">
                                                <!-- <td>{{ job.client.name }}</td> -->
                                                <td data-toggle="tooltip" data-container="body" :title="job.client.address_1">{{ job.client.address_1 }}</td>
                                                <td data-toggle="tooltip" data-container="body" :title="job.client.address_suburb">{{ job.client.address_suburb }}</td>
                                                <td data-toggle="tooltip" data-container="body" :title="job.client.type.name">{{ job.client.type.name }}</td>
                                                <td data-toggle="tooltip" data-container="body" :title="day(job.start_date)">{{ day(job.start_date) }}</td>
                                                <td data-toggle="tooltip" data-container="body" :title="job.client.active ? 'Active' : 'Inactive'">{{ job.client.active ? 'Active' : 'Inactive' }}</td>
                                                <td data-toggle="tooltip" data-container="body" :title="job.job_title">{{ job.job_title }}</td>
                                                <td data-toggle="tooltip" data-container="body" :title="job.every_no_day>0? job.every_no_day + job.frequency: job.frequency">{{ job.every_no_day>0? job.every_no_day: '' }} {{ job.frequency }}</td>
                                                <template v-for="week in weeks">
                                                    <template v-for="day in week">
                                                        <td align="center" v-html="getNumberOfBins(job, day)"></td>
                                                        <td align="center" v-html="getRevenue(job, day)"></td>
                                                    </template>
                                                </template>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>Total Bins</th>
                                                <th>&nbsp;</th>
                                                <template v-for="week in weeks">
                                                    <template v-for="day in week">
                                                        <th>{{ getTotalBins(day) }}</th>
                                                        <th></th>
                                                    </template>
                                                </template>
                                            </tr>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>Total Revenue</th>
                                                <th>&nbsp;</th>
                                                <template v-for="week in weeks">
                                                    <template v-for="day in week">
                                                        <th></th>
                                                        <th>{{ getTotalRevenue(day) }}</th>
                                                    </template>
                                                </template>
                                            </tr>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <template v-for="week in weeks">
                                                    <template v-for="day in week">
                                                        <th>{{ day[13] }}</th>
                                                        <th>C</th>
                                                    </template>
                                                </template>
                                            </tr>
                                            <tr v-for="item in costs">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td><strong>{{ item.cost_title }}</strong></td>
                                                <td>&nbsp;</td>
                                                <template v-for="week in weeks">
                                                    <template v-for="day in week">
                                                        <td>&nbsp;</td>
                                                        <td>{{ parseFloat(item.daily_cost) }}</td>
                                                    </template>
                                                </template>
                                            </tr>
                                            <tr v-for="item in costs">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>Total Cost</td>
                                                <td>&nbsp;</td>
                                                <template v-for="week in weeks">
                                                    <template v-for="day in week">
                                                        <td>&nbsp;</td>
                                                        <td><strong>{{ totalCost() }}</strong></td>
                                                    </template>
                                                </template>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="alert" style="background-color: #ccc" v-if="!jobs.length">
                                    <p align=center>No records found</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <!-- <div class="box-footer">
                        <button type="submit" class="btn btn-primary">
                            Submit
                            <i class="fa fa-spinner fa-spin" v-if="isLoading"></i>
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/moment@2.22"></script>

<!-- Date-picker itself -->
<script src="https://cdn.jsdelivr.net/npm/pc-bootstrap4-datetimepicker@4.17/build/js/bootstrap-datetimepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/pc-bootstrap4-datetimepicker@4.17/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
 
<script src="https://cdn.jsdelivr.net/npm/vue-bootstrap-datetimepicker@5"></script>
<script>
  // Initialize as global component
  Vue.component('date-picker', VueBootstrapDatetimePicker);
</script> 
<!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script> -->


<script>

    $(function () {

        $('.date').datetimepicker({
             format: 'DD/MM/YYYY'
        }).on('change', function (ev) {
            alert('changed');
        });

    });

    var app = new Vue({
        el: '#scheduleBinLiner',
        data:{
            form: {
                fromDate: '',
                toDate: '',
                status: 1,
                clientType: '',
                withEmpty: 1,
                suburb: ''
            },
            clientTypes: [],
            suburbs: [],
            jobs: [],
            weeks: [],
            costs: [],
            isLoading: false
        },
        mounted(){
            this.init();
        },
        methods: {
            init()
            {
                axios.get("<?php echo site_url('client_type/get_client_types'); ?>").then((data) => {
                    this.clientTypes = data.data;
                });

                axios.get("<?php echo site_url('client/suburbs'); ?>").then((data) => {
                    this.suburbs = data.data;
                });

                
            },
            report(){
                this.jobs = [];
                this.isLoading = true;
                axios.post("<?php echo site_url('schedules/bin-cleaning-filter'); ?>", this.form).then((data) => {
                    this.jobs = data.data.jobs;
                    this.weeks = data.data.weeks;
                    this.costs = data.data.costs;
                    setTimeout(() => {
                        this.adjustColumnPositions();
                        this.isLoading = false;
                    }, 500);
                })
            },
            getNumberOfBins(job, day){
                var date = this.makeDate(day);
                var currentVisits = job.visits.find(v => v.date === date);
                var qty = 0;
                
                if( currentVisits && currentVisits.items )
                {
                    var totalQty = 0;
                    currentVisits.items.forEach(q=> totalQty += parseFloat(q.pivot.qty));
                    return totalQty;
                }
                else{
                    return '&nbsp;';
                }
            },
            getRevenue(job, day){
                var date = this.makeDate(day);
                var currentVisits = job.visits.find(v => v.date === date);
                var qty = 0;
                
                if( currentVisits && currentVisits.items )
                {
                    var totalQty = 0;
                    currentVisits.items.forEach(q=> totalQty += parseFloat(q.pivot.total));
                    return '$' + totalQty;
                }
                else{
                    return '&nbsp;';
                }
            },
            getTotalRevenue(day){
                var date = this.makeDate(day);
                var amount = this.getTotalByDateAndProperty(date, 'total');
                return amount? `$${amount}`: '';
            },
            getTotalBins(day){
                var date = this.makeDate(day);
                return this.getTotalByDateAndProperty(date, 'qty');
            },
            makeDate(day){
                var date = day.split(' - ');
                date = date[0].split('/');
                return `${date[2]}-${date[1]}-${date[0]}`;
            },
            getTotalByDateAndProperty(date, property)
            {
                var items = [];
                var visits = this.jobs.map(j => j.visits.find(v => v.date === date));
                visits.forEach(visit => {
                    if(visit === undefined) { return; }
                    visit.items.forEach(item => items.push(item));
                });

                if(items.length > 0)
                {
                    var grandTotal = 0;
                    items.forEach(q => grandTotal += parseFloat(q.pivot[property]));
                    return grandTotal;
                }
                else{
                    return '';
                }
            },
            day(date) {
                var a = new Date(date);
                var weekdays = new Array(7);
                weekdays[0] = "Sunday";
                weekdays[1] = "Monday";
                weekdays[2] = "Tuesday";
                weekdays[3] = "Wednesday";
                weekdays[4] = "Thursday";
                weekdays[5] = "Friday";
                weekdays[6] = "Saturday";
                return weekdays[a.getDay()];
            },
            totalCost(){
                var cost = 0;
                this.costs.forEach(item => cost += parseFloat(item.daily_cost));
                return cost;
            },
            adjustColumnPositions(){
                var width = {
                    firstColWidth: 152, 
                    secondColWidth: 102, 
                    thirdColWidth: 84, 
                    fourthColWidth: 87, 
                    fifthColWidth: 58,
                    sixthColWidth: 152,
                    SeventhColWidth: 67
                };

                var columns = Object.keys(width);

                $("#table tr").each(function(columnIndex, col){

                    $(col).find('td, th').each(function(cellIndex, cell){

                        if(cellIndex < 7)
                        {
                            if(width[columns[cellIndex]] <= 0)
                                width[columns[cellIndex]] = $(cell).width();
                            // $(cell).width(width[columns[cellIndex]]);
                            $(cell).css('left', getLeftPosition(cellIndex));
                        }

                    });

                });

                $('.table-responsive').css('margin-left', getContainerMarginLeft());

                function getLeftPosition(index)
                {
                    var left = 0;
                    for(var i = 0; i < index; i++)
                        left += width[columns[i]];
                    return left + 18;
                }

                function getContainerMarginLeft()
                {
                    var ml = 0;
                    columns.forEach(c => ml += width[c]);
                    return ml;
                }
            }
        }
    });

</script>