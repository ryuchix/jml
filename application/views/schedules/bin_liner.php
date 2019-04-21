<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper" id="scheduleBinLiner">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Bin Liner</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'reports/' ); ?>"><i class="fa fa-user"></i> Schedule</a></li>
            <li><a href="<?php echo site_url( 'schedule/bin-liner' ); ?>"><i class="fa fa-user"></i> Bin Liner</a></li>
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
                            <h3 class="box-title">Bin lIner</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="from_date">From Date:</label>
                                        <input type="date" required id="from_date" v-model="form.fromDate" class="form-control date">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="to_date">To Date:</label>
                                        <input type="date" required id="to_date" v-model="form.toDate" class="form-control date">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="client_type">Client Type:</label>
                                        <select v-model="form.clientType" id="client_type" class="form-control">
                                            <option v-for="type in clientTypes" :value="type.id">{{ type.type }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="status">Status:</label>
                                        <select v-model="form.status" id="status" class="form-control">
                                            <option value="1">Enable</option>
                                            <option value="0">Disable</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
                                            <td>{{ job.category.type }}</td>
                                            <td>{{ job.client.status ? 'Active' : 'Inactive' }}</td>
                                            <td>{{ job.instruction }}</td>
                                            <td>{{ job.frequency }} {{ job.every_no_day }}</td>
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

                                <div class="alert" style="background-color: #ccc" v-if="!jobs.length">
                                    <p align=center>No records found</p>
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
            </div>
        </div>
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>

    var app = new Vue({
        el: '#scheduleBinLiner',
        data:{
            form: {
                fromDate: '2019-04-08',
                toDate: '2019-04-25',
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
                axios.post("<?php echo site_url('schedules/bin-liner-filter'); ?>", this.form).then((data) => {
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
                    qty.forEach(q=> totalQty+=q);
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
                    total.forEach(q=> grandTotal+=q);
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
                    items.forEach(q => grandTotal+= q.pivot[property]);
                    return grandTotal;
                }
                else{
                    return '';
                }
            }
        }
    });

</script>