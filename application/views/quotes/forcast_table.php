<div class="table-responsive">
<table id="example" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Quote No.</th>
            <th>Client/Property</th>
            <th>Service</th>
            <?php foreach ($months as $month): ?>
                <th><?php  echo $month; ?></th>
            <?php 
                $total = array();
                if( !array_key_exists($month, $total) ){
                    $total[$month] = array();
                }
            ?>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <?php if ($row->file): ?>
        <td><?php echo anchor(base_url('uploads/quotes/'.$row->file), $row->quote_no, 'download="'.$row->file.'"'); ?></td>
        <?php else: ?>
        <td><?php echo $row->quote_no; ?></td>
        <?php endif; ?>
        <td><?php echo anchor(site_url( "quote/save/$row->id" ), $row->client.'<br>'.$row->address); ?></td>
        <td><?php echo $row->service; ?></td>
        <?php foreach ($months as $month): ?>
            <td>
                <?php if ($row->month==$month): ?>
                    $<?php echo $row->amount; $total[$month][] = $row->amount; ?>
                <?php else: ?>
                    -
                <?php endif ?>
            </td>
        <?php endforeach;?>
    </tr>
    </tbody>
    <?php } ?>
    <tfoot>
        <tr>
            <th colspan="3" align="right">Total</th>
            <?php   $grand_total = 0;
                foreach ($months as $month): ?>
                <th>
                <?php if (isset($total[$month]) && $t = array_sum($total[$month])): ?>
                <?php echo "$".$t; $grand_total += $t; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
                </th>
            <?php endforeach ?>
        </tr>
        <tr>
            <th colspan="3" align="right">Grand Total</th>
            <th colspan="12">
                $<?php echo $grand_total; ?>
            </th>
        </tr>
    </tfoot>
</table>


</div>