 <footer class="main-footer">
    
    <div class="pull-right hidden-xs">
    
        <b>Version</b> <?php echo $this->config->item('site_info')['version'];?>
    
    </div>
    
    <strong>Copyright &copy; <?php echo date('Y'); ?><a href="http://www.thebinexperts.com.au"> <?php echo $this->config->item('site_info')['company_name'];?></a>.</strong> All rights reserved.
</footer>


</div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo site_url(); ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo site_url(); ?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo site_url(); ?>/assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo site_url(); ?>/assets/dist/js/app.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo site_url(); ?>/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="<?php echo site_url(); ?>/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo site_url(); ?>/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="<?php echo site_url(); ?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="<?php echo site_url(); ?>/assets/plugins/chartjs/Chart.min.js"></script>
    
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo site_url(); ?>/assets/dist/js/demo.js"></script>
   <!-- DataTables -->
    <script src="<?php echo site_url(); ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo site_url(); ?>/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo site_url(); ?>/assets/plugins/toastr/toastr.js"></script>
  
    <!-- page script -->
    <script>

    $(function () {

        if( $('#firstDateSort').size() )
        {
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                
                "extract-date-pre": function(value) 
                {
                    var date = value.split('/');
                    return Date.parse(date[2] + '/' + date[1] + '/' + date[0]);
                }, 
                
                "extract-date-asc": function(a, b) 
                {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },
                
                "extract-date-desc": function(a, b) 
                {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }

            });

            var dateSorter = {
                
                columnDefs: [
                    {
                        type: 'extract-date',
                        targets: [0]
                    }
                ],

                "order": [ [ 0, "desc" ] ]

            };

            $("#firstDateSort").DataTable(dateSorter);

        }


        $("#example1, #example2").DataTable({
            "order" : [ [ 0, "desc" ] ]
        });

        // $('#example2').DataTable({
        //   "pageLength": 10, 
        //   "paging": true,
        //   "lengthChange": false,
        //   "searching": false,
        //   "ordering": true,
        //   "info": true,
        //   "autoWidth": false
        // });

    });
    
    </script>

    <?php echo get_flash_message(); ?>
  
  </body>
</html>