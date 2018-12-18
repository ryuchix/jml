<table class="table table-bordered table striped">
    
    <thead>
        
        <tr>

            <th>Name</th>

            <th colspan="2">
                Url

                <div class="btn-group-sm pull-right">
                    
                    <button type="button" class="btn btn-primary" id="addRow">
                        <i class="fa fa-plus"></i>
                    </button>

                    <button type="button" class="btn btn-danger" id="deleteRow">
                        <i class="fa fa-trash"></i>
                    </button>

                </div>
            </th>

        </tr>

    </thead>
    
    <tbody>

        <?php if (empty($links)): ?>
        
            <!-- <tr>

                <td>

                    <input type="text" class="form-control" name="links[0][name]" placeholder="Name">

                </td>

                <td>

                    <input type="text" class="form-control" name="links[0][url]" placeholder="URL">

                </td>

            </tr> -->
            
        <?php endif ?>

        <?php if (!empty($links) && !isset($_POST['submit']) ): ?>

            <?php foreach ($links as $index => $link): ?>
        
                <tr>

                    <td>
                        <input type="hidden" name="links[<?php echo $index; ?>][pk]" value="<?php echo $link->id; ?>">
                        
                        <input type="text" class="form-control" name="links[<?php echo $index?>][name]" value="<?php echo $link->name; ?>" placeholder="Name">
                        
                        <?php echo form_error("links[$index][name]",'<p class="error-msg">','</p>'); ?>
                        
                    </td>

                    <td>

                        <input type="text" class="form-control" name="links[<?php echo $index?>][url]"  value="<?php echo $link->url; ?>" placeholder="URL">
                        
                        <?php echo form_error("links[$index][url]",'<p class="error-msg">','</p>'); ?>

                    </td>

                    <td>

                        <a href="<?php echo generate_url($link->url); ?>" target="_blank" class="fa fa-external-link"></a>

                    </td>

                </tr>
                
            <?php endforeach ?>
            
        <?php endif ?>

        <?php if ( isset($_POST['submit']) ): ?>

            <?php foreach ($this->input->post('links') as $index => $link): ?>
        
                <tr>

                    <td>
                        
                        <div class="form-group <?php echo form_error("links[$index][name]")? 'has-error':''; ?>">
                        
                            <input type="hidden" name="links[<?php echo $index; ?>][pk]" value="<?php echo $this->input->post('links')[$index]['pk']; ?>">
                            
                            <input type="text" class="form-control" name="links[<?php echo $index ?>][name]" value="<?php echo $this->input->post('links')[$index]['name']; ?>" placeholder="Name">
                            
                            <?php echo form_error("links[$index][name]",'<p class="error-msg">','</p>'); ?>
                        
                        </div>

                    </td>

                    <td>

                        <div class="form-group <?php echo form_error("links[$index][url]")? 'has-error':''; ?>">
                        
                            <input type="text" class="form-control" name="links[<?php echo $index ?>][url]"  value="<?php echo $this->input->post('links')[$index]['url']; ?>" placeholder="URL">
                            
                            <?php echo form_error("links[$index][url]",'<p class="error-msg">','</p>'); ?>

                        </div>

                    </td>

                    <td>

                        <?php if( !form_error("links[$index][url]",'<p class="error-msg">','</p>') ): ?>


                        <a href="<?php echo generate_url($this->input->post('links')[$index]['url']); ?>" target="_blank" class="fa fa-external-link"></a>

                        <?php endif; ?>

                    </td>

                </tr>
                
            <?php endforeach ?>
            
        <?php endif ?>

    </tbody>

</table>
