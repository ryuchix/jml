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
                                    <table class="table table-striped table-bordered"  v-if="jobs.length">
                                        <thead>
                                            <tr>
                                                <th colspan=7>&nbsp;</th>
                                                <template v-for="key in Object.keys(weeks)">
                                                    <th :colspan="weeks[key].length * 2">{{ key }}</th>
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
                                                <td>{{ job.client.address_1 }}</td>
                                                <td>{{ job.client.address_suburb }}</td>
                                                <td>{{ job.client.type.name }}</td>
                                                <td>{{ day(job.start_date) }}</td>
                                                <td>{{ job.client.active ? 'Active' : 'Inactive' }}</td>
                                                <td>{{ job.job_title }}</td>
                                                <td>{{ job.every_no_day>0? job.every_no_day: '' }} {{ job.frequency }}</td>
                                                <template v-for="week in weeks">
                                                    <template v-for="day in week">
                                                        <td>{{ getNumberOfBins(job, day) }}</td>
                                                        <td>{{ getRevenue(job, day) }}</td>
                                                    </template>
                                                </template>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan=5>&nbsp;</th>
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
                                                <th colspan=5>&nbsp;</th>
                                                <th>Total Revenue</th>
                                                <th>&nbsp;</th>
                                                <template v-for="week in weeks">
                                                    <template v-for="day in week">
                                                        <th></th>
                                                        <th>{{ getTotalRevenue(day) }}</th>
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
                fromDate: '08/04/2019',
                toDate: '25/04/2019',
                status: 1,
                clientType: '',
            },
            clientTypes: [],
            jobs: [],
            weeks: [],
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
            },
            report(){
                this.jobs = [];
                this.isLoading = true;
                var modifiedData = this.form;
                modifiedData.fromDate = this.convertDate(this.form.fromDate);
                modifiedData.toDate = this.convertDate(this.form.toDate);

                console.log(modifiedData);
                axios.post("<?php echo site_url('schedules/bin-cleaning-filter'); ?>", modifiedData).then((data) => {
                    this.jobs = data.data.jobs;
                    this.weeks = data.data.weeks;
                    this.isLoading = false;
                })
            },
            getNumberOfBins(job, day){
                var date = this.makeDate(day);
                var currentVisits = job.visits.filter(v => v.date === date);
                var qty = currentVisits.map( v => v.items.map( i => i.pivot.qty));
                
                if(qty.length > 0)
                {
                    var totalQty = 0;
                    qty.forEach(q=> totalQty+=parseFloat(q));
                    return totalQty;
                }
                else{
                    return '';
                }
            },
            getRevenue(job, day){
                var date = this.makeDate(day);
                var currentVisits = job.visits.filter(v => v.date === date);
                var total = currentVisits.map( v => v.items.map( i => i.pivot.total));
                
                if(total.length > 0)
                {
                    var grandTotal = 0;
                    total.forEach(q=> grandTotal+= parseFloat(q));
                    return grandTotal;
                }
                else{
                    return '';
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
            convertDate(date){
                var d = date.split('/');
                return d[2] + '-' + d[1] + "-" + d['0'];
            }
        }
    });

</script>