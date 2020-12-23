<?php if (isset($_POST['submit'])): ?>
    <?php foreach ($this->input->post('line_items[]') as $key => $item): ?>
<tr>
<td>
    <div class="form-group <?php echo form_error("line_items[$key][service_id]")? 'has-error':''; ?>">                    
        <?php echo form_dropdown("line_items[$key][service_id]", $services, 
                                                    $this->input->post("line_items[$key][service_id]")
                                                    , 'class="dropdown_lists serviceDD form-control" data-placeholder="Choose Service"'); ?>
        <textarea class="form-control" rows="2" name="line_items[<?php echo $key ?>][description]" placeholder="Description..."><?php echo set_value("line_items[$key][description]"); ?></textarea>
        <?php echo form_error("line_items[$key][service_id]",'<p class="error-msg">','</p>') ?>
    </div>
</td>
<td>
    <div class="form-group <?php echo form_error("line_items[$key][qty]")? 'has-error':''; ?>">
        <input type="text" class="form-control itemQty" name="line_items[<?php echo $key ?>][qty]" placeholder="Quantity" value="<?php echo set_value("line_items[$key][qty]", ''); ?>">
        <?php echo form_error("line_items[$key][qty]",'<p class="error-msg">','</p>'); ?>
    </div>
</td>
<td>
    <div class="form-group <?php echo form_error("line_items[$key][unit_cost]")? 'has-error':''; ?>">
        <input type="text" class="form-control itemCost" name="line_items[<?php echo $key ?>][unit_cost]" placeholder="Unit Cost" value="<?php echo set_value("line_items[$key][unit_cost]", ''); ?>">
        <?php echo form_error("line_items[$key][unit_cost]",'<p class="error-msg">','</p>'); ?>
    </div>
</td>
<td>
    <div class="form-group delRow <?php echo form_error("line_items[$key][total]")? 'has-error':''; ?>">
        <input type="text" class="form-control" name="line_items[<?php echo $key ?>][total]" placeholder="Total" value="<?php echo set_value("line_items[$key][total]", ''); ?>">
        <?php echo form_error("line_items[$key][total]",'<p class="error-msg">','</p>'); ?>
        <span class="deleteRow"><i class="fa fa-trash"></i></span>
    </div>
</td>
</tr>
    <?php endforeach ?>
<?php else: ?>
    <?php if ($record->id): ?>
        <!-- line_items -->
    <?php $key = -1; foreach ($line_items as $k => $item): $key++;     ?>
    <tr>
    <td>
        <div class="form-group">
            <?php echo form_dropdown("line_items[$key][service_id]", $services, 
                                                        $item->service_id
                                                        , 'class="dropdown_lists serviceDD form-control" data-placeholder="Choose Service"'); ?>
            <textarea class="form-control" rows="2" name="line_items[<?php echo $key ?>][description]" placeholder="Description..."><?php echo $item->description; ?></textarea>
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="text" class="form-control itemQty" name="line_items[<?php echo $key ?>][qty]" placeholder="Quantity" value="<?php echo $item->qty ?>">
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="text" class="form-control itemCost" name="line_items[<?php echo $key ?>][unit_cost]" placeholder="Unit Cost" value="<?php echo $item->unit_cost ?>">
        </div>
    </td>
    <td>
        <div class="form-group delRow">
            <input type="text" class="form-control" name="line_items[<?php echo $key ?>][total]" placeholder="Total" value="$<?php echo $item->total ?>">
            <span class="deleteRow"><i class="fa fa-trash"></i></span>
        </div>
    </td>
    </tr>
        <?php endforeach ?>

    <?php else: ?>
    <tr>
    <td>
        <div class="form-group <?php echo form_error('line_items[0][service_id]')? 'has-error':''; ?>">                    
            <?php echo form_dropdown('line_items[0][service_id]', $services, 
                                                        $this->input->post('line_items[0][service_id]')
                                                        , 'class="dropdown_lists serviceDD form-control" data-placeholder="Choose Service"'); ?>
            <textarea class="form-control" rows="2" name="line_items[0][description]" placeholder="Description..."><?php echo set_value('line_items[0][description]'); ?></textarea>
            <?php echo form_error('line_items[0][service_id]','<p class="error-msg">','</p>') ?>
        </div>
    </td>
    <td>
        <div class="form-group <?php echo form_error('line_items[0][qty]')? 'has-error':''; ?>">
            <input type="text" class="form-control itemQty" name="line_items[0][qty]" placeholder="Quantity" value="<?php echo set_value('line_items[0][qty]', ''); ?>">
            <?php echo form_error('line_items[0][qty]','<p class="error-msg">','</p>'); ?>
        </div>
    </td>
    <td>
        <div class="form-group <?php echo form_error('line_items[0][unit_cost]')? 'has-error':''; ?>">
            <input type="text" class="form-control itemCost" name="line_items[0][unit_cost]" placeholder="Unit Cost" value="<?php echo set_value('line_items[0][unit_cost]', ''); ?>">
            <?php echo form_error('line_items[0][unit_cost]','<p class="error-msg">','</p>'); ?>
        </div>
    </td>
    <td>
        <div class="form-group delRow <?php echo form_error('line_items[0][total]')? 'has-error':''; ?>">
            <input type="text" class="form-control" name="line_items[0][total]" placeholder="Total" value="<?php echo set_value('line_items[0][total]', ''); ?>">
            <?php echo form_error('line_items[0][total]','<p class="error-msg">','</p>'); ?>
            <span class="deleteRow"><i class="fa fa-trash"></i></span>
        </div>
    </td>
    </tr>
    <?php endif ?>
<?php endif; ?>
