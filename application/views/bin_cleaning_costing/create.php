<?php $this->load->view( 'partials/header' ); ?>

<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">

<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        
        <h1>Bin Cleaning Costing<small><?php echo $costing->id? 'edit': 'new'; ?></small></h1>
        
        <ol class="breadcrumb">
        
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        
            <li><a href="<?php echo site_url( 'bin-cleaning-costing' ); ?>"><i class="fa fa-money"></i> Bin Cleaning Costing</a></li>
        
            <li class="active"><?php echo $costing->id? 'Edit': 'New'; ?></li>
        
        </ol>
    
    </section>
    
    <br>

    <!-- Main content -->
    <section class="content">
        
        <div class="row" id="form">

            <!-- form start -->
            <form role="form" @submit.prevent="save()" method="post" action="<?php echo site_url( "bin-cleaning-costing/" . ($costing->id? 'store': $costing->id . '/update') ); ?>">

                <div class="col-sm-8 col-sm-offset-2">

                    <div class="box box-primary">

                        <div class="box-header with-border">

                          <h3 class="box-title"><?php echo $costing->id? 'Edit': 'Add New'; ?> Bin Cleaning Costing</h3>

                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group" :class="{'has-error': form.errors.cost_title}">
                                <label for="cost-title">Cost Title</label>
                                <input type="text" class="form-control" id="cost-title" placeholder="Cost Title" v-model="form.cost_title">
                                <p class="error-msg" v-if="form.errors.cost_title" v-text="form.errors.cost_title"></p>
                            </div>

                            <div class="form-group" :class="{'has-error': form.errors.monthly_cost}">
                                <label for="monthly-cost">Montly Cost</label>
                                <input type="text" class="form-control" id="monthly-cost" placeholder="Monthly Cost" v-model="form.monthly_cost">
                                <p class="error-msg" v-if="form.errors.monthly_cost" v-text="form.errors.monthly_cost"></p>
                            </div>

                            <div class="form-group" :class="{'has-error': form.errors.daily_cost}">
                                <label for="daily-cost">Daily Cost</label>
                                <input type="text" class="form-control" id="daily-cost" placeholder="Daily Cost" v-model="daily_cost">
                                <p class="error-msg" v-if="form.errors.daily_cost" v-text="form.errors.daily_cost"></p>
                            </div>

                            <div class="form-group" :class="{'has-error': form.errors.notes}">
                                <label>Notes</label>
                                <textarea class="form-control" rows="3" v-model="form.notes" placeholder="Notes..."></textarea>
                                <p class="error-msg" v-if="form.errors.notes" v-text="form.errors.notes"></p>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit" disabled :disabled="isLoading">
                                Submit <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                            </button>
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
<script src="https://unpkg.com/vue-toasted"></script>

<script>
Vue.use(Toasted, {
    duration: 5000,
});
var app = new Vue({
    el: '#form',
    data: {
        form: {
            id: undefined,
            cost_title: '',
            monthly_cost: '',
            daily_cost: '',
            notes: '',
            errors: {}
        },
        isLoading: false
    },
    computed: {
        daily_cost(){
            if(!this.form.monthly_cost)
                return '';
            return (parseFloat(this.form.monthly_cost) / 260).toFixed(2);
        }
    },
    watch: {
        daily_cost(dailyCost){
            this.form.daily_cost = dailyCost;
        }
    },
    methods: {
        save(){
            axios.post('<?= site_url('bin-cleaning-costing/store'); ?>', this.form)
            .then((data) => {
                this.showAlert();
                this.form = {
                    cost_title: '',
                    monthly_cost: '',
                    daily_cost: '',
                    notes: '',
                    errors: {}
                };
            }).catch(error => {
                this.form.errors = error.response.data;
            });
        },

        showAlert()
        {
            this.$toasted.show('Costing is saved successfully!', {
                action : {
                    text : 'Go to List',
                    onClick : (e, toastObject) => {
                        window.location = '<?= site_url('bin-cleaning-costing'); ?>';
                    }
                },
                theme: 'outline'
            });
        }
    }
});

</script>