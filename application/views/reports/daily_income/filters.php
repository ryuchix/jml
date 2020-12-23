<?php $this->load->view( 'partials/header' ); ?>
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">

<style>
@media (min-width: 992px){
    .modal-lg {
        width: 1280px;
    }
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Daily Income Report</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'reports/' ); ?>"><i class="fa fa-user"></i> Reports</a></li>
            <li><a href="<?php echo site_url( 'reports/daily-income/filters' ); ?>"><i class="fa fa-user"></i> Daily Income Report</a></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content" id="dailyCostingReport">
        <div class="row">
            <!-- form start -->
            <form role="form" @submit.prevent="report" id="filterForm" autocomplete="off">
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
                                        <label for="from_date">From Date:</label>
                                        <date-picker ref="fromDate" v-model="form.fromDate" required :config="{format: 'DD/MM/YYYY'}" class="form-control"></date-picker>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="to_date">To Date:</label>
                                        <date-picker ref="toDate" v-model="form.toDate" required :config="{format: 'DD/MM/YYYY'}" class="form-control"></date-picker>                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" :disabled="isLoading">
                                Submit
                                <i class="fa fa-spinner fa-spin" v-if="isLoading"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Daily Income</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="alert" style="background-color: #ccc" v-if="!jobs.length">
                                <p align="center" v-if="!isLoading">No records found</p>
                                <p align="center" v-if="isLoading">Processing...</p>
                            </div>

                            <div class="table-responsive" v-if="jobs.length">

                                <table class="table table-bordered table-striped">
                                
                                    <thead>
                                        <tr>
                                            <th>Property Address</th>
                                            <th>Client Name</th>
                                            <th>Category</th>
                                            <th>Job Title</th>
                                            <template v-for="date in dates">
                                                <th v-text="date"></th>
                                            </template>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(job,jobIndex) in jobs">
                                            <td v-text="job.property"></td>
                                            <td v-text="job.client"></td>
                                            <td v-text="job.category"></td>
                                            <td v-text="job.title"></td>
                                            <template v-for="amount in job.amounts">
                                                <td align="right" v-text="`\$${amount.toFixed(2)}`"></td>
                                            </template>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Total</th>
                                            <template v-for="date in db_dates">
                                                <th style="text-align:right" v-text="`\$${dateSum[date].toFixed(2)}`"></th>
                                            </template>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </form>
        </div>
        <!-- /.row -->
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

<!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script> -->
<!-- <script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script> -->
<script>
    
    var app = new Vue({
        el: '#dailyCostingReport',
        data:{
            form: {
                fromDate: "",
                toDate: "",
            },
            isLoading: false,
            jobs: [],
            dates: [],
            db_dates: [],
            dateSum: {}
        },
        mounted(){
            this.init();
        },
        methods: {
            init()
            {
                
            },
            report(){
                this.jobs = [];
                this.dateSum = {};
                this.isLoading = true;
                axios.post("<?php echo site_url('reports/daily-income'); ?>", this.form)
                .then((data) => {
                    this.jobs = data.data.jobs;
                    this.dates = data.data.dates;
                    this.db_dates = data.data.db_dates;

                    this.jobs.forEach(job => {
                        Object.keys(job.amounts).forEach( date => {
                            if(this.dateSum[date] == undefined)
                                this.dateSum[date] = 0;
                            this.dateSum[date] += job.amounts[date];
                        })
                    })

                    this.isLoading = false;
                })
            }
        }
    });

</script>