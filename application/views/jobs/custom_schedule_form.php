<style>
    .carousel-inner .checkbox{
        display: inline-block;
        padding: 0 10px;
    }
</style>
<div class="col-sm-4">
    <div class="box box-primary" id="custom_schedule_container" style="display: none;">
        <div class="box-header with-border">
          <h3 class="box-title">Custom Schedule</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="form-group <?php echo form_error('data[frequency]')? 'has-error':''; ?>">
                <label for="frequency">Frequency:</label>
                <?php 
                $freq = ['Daily'=>'Daily','Weekly'=>'Weekly','Monthly'=>'Monthly','Yearly'=>'Yearly'];
                echo form_dropdown('data[frequency]', $freq, 
                        isset($_POST['data']['frequency'])? $_POST['data']['frequency']: $record->frequency
                        , 'class="dropdown_lists form-control" id="frequency" data-placeholder="Job Category"'); ?>
                <?php echo form_error('data[frequency]','<p class="error-msg">','</p>') ?>
            </div>

            <div id="myCarousel" class="carousel slide" data-rides="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators" style="display: none;">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <?php echo $fr = $this->input->post('data[frequency]'); ?>
                    <div class="item daily <?php echo isset($_POST['submit']) ? ($fr == 'Daily')? 'active':'':'active'; ?>">

                        <div class="input-group">
                            <div class="input-group-addon">Every </div>
                            <input type="number" class="form-control" name="every_no_day" value="<?php echo ($fr == 'Daily')? set_value('every_no_day', $record->every_no_day):''; ?>">
                            <div class="input-group-addon">Day(s)</div>
                        </div>

                        <hr>

                        <label>Summary: Days</label>
                    </div>

                    <div class="item Weekly <?php echo ($fr == 'Weekly')? 'active':'' ?>">

                        <div class="input-group">
                            <div class="input-group-addon">Every </div>
                            <input type="number" class="form-control" name="every_no_week">
                            <div class="input-group-addon">Week(s) on:</div>
                        </div>
                        <?php $days = [ 'monday'=>'Mon', 'tuesday'=>'Tue', 'wednesday'=>'Wed', 'thursday'=>'Thu', 'friday'=>'Fri', 'saturday'=>'Sat', 'sunday'=>'Sun' ];

                        foreach ($days as $day => $abb) {
                            echo "<div class='checkbox'>
                                <label><input type='checkbox' name='week_days[]' value='$day'>$abb</label>
                            </div>";
                        }

                         ?>


                        <hr>

                        <label>Summary: Weeks</label>
                    </div>

                    <div class="item Monthly <?php echo ($fr == 'Monthly')? 'active':'' ?>">

                        <div class="input-group">
                            <div class="input-group-addon">Every </div>
                            <input type="number" class="form-control" name="every_no_month">
                            <div class="input-group-addon">Month(s):</div>
                        </div>
                        <br>
                        <div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" 
                                    class="<?php echo ($this->input->post('dayorweek_of_month')=='Day of Month')? 'active':''; ?>">
                                    <a href="#day_of_month" aria-controls="day_of_month" role="tab" data-toggle="tab">
                                        Day of month
                                    </a>
                                </li>
                                <li role="presentation" class="<?php echo ($this->input->post('dayorweek_of_month')=='Day of Week')? 'active':''; ?>">
                                    <a href="#day_of_week" aria-controls="day_of_week" role="tab" data-toggle="tab">
                                        Day of week
                                    </a>
                                </li>
                            </ul>
                            <input type="hidden" name="dayorweek_of_month" id="day_or_week_of_month" value="<?php echo set_value('dayorweek_of_month','Day of Month') ?>">
                            <!-- Tab panes -->

                            <?php 
                                $selected_dates =  (($record->month_day_or_week=='Day of Month') && $record->selected_day_of_month)? 
                                                    explode(',', $record->selected_day_of_month):[];
                                                    
                                $selected_days = (($record->month_day_or_week=='Day of Week') && $record->selected_day_of_month)? 
                                                    unserialize($record->selected_day_of_month):[];
                             ?>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane <?php echo ($this->input->post('dayorweek_of_month')=='Day of Month')? 'active':''; ?>" id="day_of_month">

                                    <table class="table table-bordered text-center" id="dayOfMonth">
                                        <tr>
                                            <?php 
                                            $selected = $this->input->post('selected_date_of_month');

                                            for ($i=1; $i < 32; $i++) { 
                                                $selected_class = in_array($i, isset($selected)? $selected:$selected_dates)?' class="selected"':'';
                                                $checked = $selected_class?'checked':'';

                                                echo "<td $selected_class>
                                                    <input type='checkbox' name='selected_date_of_month[]' value='$i'
                                                        $checked/>
                                                    $i </td>";
                                                if( $i == 31 ) { echo "<td colspan='4'>
                                                        <input type='checkbox' name='selected_date_of_month[]' value='Last day of month'/>
                                                    Last Day</td>"; 
                                                }
                                                if (!($i%7)) { echo "</tr><tr>"; }
                                            } ?>
                                        </tr>
                                    </table>
                                    <p></p>
                                </div>
                                <div role="tabpanel" class="tab-pane <?php echo ($this->input->post('dayorweek_of_month')=='Day of Week')? 'active':''; ?>" id="day_of_week">

                                    <table class="table table-bordered text-center" id="dayOfMonth">
                                        <?php 
                                        $week = explode(',', '1st,2nd,3rd,4th');
                                        $selected = $this->input->post('selected_date_of_week');
                                        for ($i=0; $i < 4; $i++) { 
                                            echo '<tr>';
                                            echo "<td class='not'>".$week[$i]."</td>";
                                            foreach ($days as $day => $abb) {
                                                $selected_class = in_array($day, isset($selected[$week[$i]])?$selected[$week[$i]]:[]) || in_array($day, isset($selected_days[$week[$i]])?$selected_days[$week[$i]]:[])? 'class="selected"':'';
                                                $checked = $selected_class?'checked':'';
                                                echo "<td $selected_class>
                                                        <input type='checkbox' 
                                                        $checked
                                                        name='selected_date_of_week[".$week[$i]."][]' 
                                                        value='$day'/>".strtoupper($abb)."</td>";
                                            }
                                            echo '</tr>';
                                        } ?>
                                    </table>
                                    <p></p>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item Yearly <?php echo ($fr == 'Yearly')? 'active':'' ?>">
                        <div class="input-group">
                            <div class="input-group-addon">Every </div>
                            <input type="number" class="form-control">
                            <div class="input-group-addon">Year(s)</div>
                        </div>
                        <hr>
                        <label>Summary: Years</label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>