<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            
            <li class="header">MAIN NAVIGATION</li>
            <?php if (has_access('quotes')) { /* ?>
                
            <li class="treeview <?php set_active_menu('quote', $active_menu); ?>">

                <a href="#"><i class="fa fa-file-text-o"></i> <span>Quotes</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_quote', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'quote/save' ); ?>"><i class="fa fa-circle-o"></i> Add Quote</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_quote', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'quote/' ); ?>"><i class="fa fa-circle-o"></i> View Quotes</a>
                    </li>

                    <li class="<?php echo set_sub_menu('sales_forcast', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'quote/forcast' ); ?>"><i class="fa fa-circle-o"></i> Sales Forecast</a>
                    </li>

                </ul>

            </li>
           
            <?php */ } // end if quotes access
             if (has_access('memos')) { ?>

            <li class="treeview <?php set_active_menu('memo', $active_menu); ?>">

                <a href="#"><i class="fa fa-file-text-o"></i> <span>Memos</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_memo', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'memo/save' ); ?>"><i class="fa fa-circle-o"></i> Add Memo</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_memo', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'memo/' ); ?>"><i class="fa fa-circle-o"></i> View Memos</a>
                    </li>

                </ul>

            </li>
           
            <?php } // end if memos access
             if (has_access('jobs')) { /* ?>
            
            <li class="treeview <?php set_active_menu('jobs', $active_menu); ?>">

                <a href="#"><i class="fa fa-tint"></i> <span>Jobs</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_job', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'jobs/save' ); ?>"><i class="fa fa-circle-o"></i> Add Job</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_jobs', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'jobs/' ); ?>"><i class="fa fa-circle-o"></i> View Jobs</a>
                    </li>

                </ul>

            </li>
           
            <?php */ } // end if jobs access

             if (has_access('daily_runs')) { /* ?>
            
            <li>
                <a href="<?php echo site_url('dailyrun'); ?>"> <i class="fa fa-trash"></i> <span>Daily Run</span></i></a>
            </li>
           
            <?php */ } // end if daily_runs access
             if (has_access('vehicles')) { ?>
             
            <li class="treeview <?php set_active_menu('vehicle', $active_menu); ?>">
                
                <a href="#"><i class="fa fa-car"></i> <span>Vehicles</span></i> <i class="fa fa-angle-left pull-right"></i></a>
                
                <ul class="treeview-menu">
                
                    <li><a href="<?php echo site_url('vehicle/save'); ?>"><i class="fa fa-circle-o"></i> Add Vehicle</a></li>
                
                    <li><a href="<?php echo site_url('vehicle/'); ?>"><i class="fa fa-circle-o"></i> View Vehicles</a></li>

                </ul>
            
            </li>
           
            <?php } // end if vehicles access
             if (has_access('equipments')) { ?>
             
            <li class="treeview <?php set_active_menu('equipments', $active_menu); ?>">

                <a href="#"><i class="fa fa-tags"></i> <span>Equipments</span></i> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">

                    <li class="<?php set_sub_menu('add_equipment', $sub_menu); ?>"><a href="<?php echo site_url('equipments/save'); ?>"><i class="fa fa-circle-o"></i> Add Equipment</a></li>

                    <li class="<?php set_sub_menu('view_equipment', $sub_menu); ?>"><a href="<?php echo site_url('equipments'); ?>"><i class="fa fa-circle-o"></i> View Equipments</a></li>

                    <li class="<?php set_sub_menu('view_equipment_type', $sub_menu); ?>"><a href="<?php echo site_url('equipment_types'); ?>"><i class="fa fa-circle-o"></i> View Equipment Types</a></li>

                </ul>
            </li>
           
            <?php } // end if equipments access
             if (has_access('issues')) { /* ?>

            <li class="treeview <?php set_active_menu('complaints', $active_menu); ?>">

                <a href="#"><i class="fa fa-bug"></i> <span>Issues/Complaints</span></i> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">

                    <li class="<?php set_sub_menu('add_complain', $sub_menu); ?>"><a href="<?php echo site_url('complaints/save'); ?>"><i class="fa fa-circle-o"></i> New Issue/Complaints</a></li>

                    <li class="<?php set_sub_menu('view_complain', $sub_menu); ?>"><a href="<?php echo site_url('complaints'); ?>"><i class="fa fa-circle-o"></i> View Issue/Complaints</a></li>

                </ul>
            </li>
           
            <?php */ } // end if issues access
             if (has_access('services')) { /* ?>

            <li class="treeview <?php set_active_menu('services', $active_menu); ?>">

                <a href="<?php echo site_url('services'); ?>"><i class="fa fa-file-pdf-o"></i> <span>Services</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">

                    <li class="<?php set_sub_menu('add_service', $sub_menu); ?>"><a href="<?php echo site_url('services/save'); ?>"><i class="fa fa-circle-o"></i> Add Service</a></li>

                    <li class="<?php set_sub_menu('active_service_list', $sub_menu); ?>">
                        <a href="<?php echo site_url('services'); ?>"><i class="fa fa-circle-o"></i> View Services</a>
                    </li>
                </ul>
            </li>
           
            <?php */ } // end if services access
             if (has_access('users')) { ?>

            <li class="treeview <?php set_active_menu('users', $active_menu); ?>">
                <a href="#"><i class="fa fa-users"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">

                    <li class="<?php echo set_sub_menu('add_user', $sub_menu); ?>">
                        <a href="<?php echo site_url('users/save'); ?>"><i class="fa fa-circle-o"></i> Add User</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_user', $sub_menu); ?>">
                        <a href="<?php echo site_url('users'); ?>"><i class="fa fa-circle-o"></i> View Users</a>
                    </li>

                </ul>
            </li>

            <?php } // end if users access
            if (has_access('client_types')) { /* ?>

            <li class="treeview <?php set_active_menu('client_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-language"></i> <span>Client Types</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">

                    <li class="<?php echo set_sub_menu('add_client_types', $sub_menu) ?>">
                        <a href="<?php echo site_url( 'client_type/add' ); ?>"><i class="fa fa-circle-o"></i> Add Client Type</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_client_type', $sub_menu) ?>">
                        <a href="<?php echo site_url( 'client_type/' ); ?>"><i class="fa fa-circle-o"></i> View Client Types</a>
                    </li>

                </ul>
            </li>

            <?php */ } // end if client_types access
            if(has_access('clients')) { /* ?>

            <li class="treeview <?php set_active_menu('client', $active_menu); ?>">

                <a href="#"><i class="fa fa-user"></i> <span>Clients</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    <li class="<?php echo set_sub_menu('add_client', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'client/save' );?>"><i class="fa fa-circle-o"></i> Add Client/Prospect</a>
                    </li>
                    <li class="<?php echo set_sub_menu('active_client_lists', $sub_menu); ?>">
                        <a href="<?php echo site_url('client/'); ?>"><i class="fa fa-circle-o"></i> View Clients/Prospects</a>
                    </li>
                </ul>
            </li>

            <?php */ } // end if clients access
            if (has_access('properties')) { /* ?>

            <li class="treeview <?php set_active_menu('property', $active_menu); ?>">

                <a href="#"><i class="fa fa-home"></i> <span>Properties</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_property', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'property/save' ); ?>"><i class="fa fa-circle-o"></i> Add Property</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_property', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'property/' ); ?>"><i class="fa fa-circle-o"></i> View Properties</a>
                    </li>

                </ul>
            </li>

            <?php */ } // end if properties access
            if(has_access('bin_types')) { /* ?>

            <li class="treeview <?php set_active_menu('bin_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-trash"></i> <span>Bin Types</span> <i class="fa fa-angle-left pull-right"></i></a>
                
                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_bin_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'bin_type/save' );?>"><i class="fa fa-circle-o"></i> Add Bin</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_types', $sub_menu); ?>">
                        <a href="<?php echo site_url('bin_type/'); ?>"><i class="fa fa-circle-o"></i> View Bin Types</a>
                    </li>

                </ul>
            </li>

            <?php */ } // end if bin_types access
            if(has_access('document_types')) { /* ?>

            <li class="treeview <?php set_active_menu('document_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-file-text"></i> <span>Document Types</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_document_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'document_type/save' ); ?>"><i class="fa fa-circle-o"></i> Add Document Type</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_document_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'document_type/' ); ?>"><i class="fa fa-circle-o"></i> View Document Types</a>
                    </li>

                </ul>
            </li>

            <?php */ } // end if document_types access
            if(has_access('gallery_types')) { ?>

            <li class="treeview <?php set_active_menu('gallery_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-image"></i> <span>Gallery Types</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_gallery_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'gallery_type/save' ); ?>"><i class="fa fa-circle-o"></i> Add Gallery Type</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_document_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'gallery_type/' ); ?>"><i class="fa fa-circle-o"></i> View Gallery Types</a>
                    </li>

                </ul>
            </li>

            <?php } // end if gallery_types access
            if(has_access('key_types')) { ?>

            <li class="treeview <?php set_active_menu('key_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-key"></i> <span>Key Types</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_key_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'key_type/save' ); ?>"><i class="fa fa-circle-o"></i> Add Key Type</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_key_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'key_type/' ); ?>"><i class="fa fa-circle-o"></i> View Key Types</a>
                    </li>

                </ul>
            </li>

            <?php } // end if key_types access
            if(has_access('lead_types')) { /* ?>

            <li class="treeview <?php set_active_menu('lead_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-tasks"></i> <span>Lead Types</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_lead_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'lead_type/save' ); ?>"><i class="fa fa-circle-o"></i> Add Lead Type</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_lead_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'lead_type/' ); ?>"><i class="fa fa-circle-o"></i> View Lead Types</a>
                    </li>

                </ul>
            </li>

            <?php */ } // end if lead_types access 
            if(has_access('suppliers')) { /* ?>

            <li class="treeview <?php set_active_menu('supplier', $active_menu); ?>">

                <a href="#"><i class="fa fa-ship"></i> <span>Suppliers</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_supplier', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'supplier/save' ); ?>"><i class="fa fa-circle-o"></i> Add Supplier</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_supplier', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'supplier/' ); ?>"><i class="fa fa-circle-o"></i> View Suppliers</a>
                    </li>

                </ul>
            </li>

            <?php */ } // end if suppliers access
            if(has_access('consumables')||has_access('consumables_request')) { /* ?>

            <li class="treeview <?php set_active_menu('consumable', $active_menu); ?>">

                <a href="#"><i class="fa fa-hourglass-half"></i> <span>Consumables</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    <?php if(has_access('consumables')): ?>
                    <li class="<?php echo set_sub_menu('add_consumable', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'consumable/save' ); ?>"><i class="fa fa-circle-o"></i> Add Consumable</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_consumable', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'consumable/' ); ?>"><i class="fa fa-circle-o"></i> View Consumables</a>
                    </li>
                    <?php endif; ?>
                    <?php if(has_access('consumables_request')): ?>
                    <li class="<?php echo set_sub_menu('add_consumable_request', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'consumable_request/' ); ?>"><i class="fa fa-circle-o"></i> Consumable Request</a>
                    </li>
                    <?php endif; ?>
                    
                </ul>
            </li>

            <?php */ } // end if consumables access 
            if(has_access('councils')) { /* ?>

            <li class="treeview <?php set_active_menu('council', $active_menu); ?>">

                <a href="#"><i class="fa fa-hourglass-half"></i> <span>Councils</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_council', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'council/save' ); ?>"><i class="fa fa-circle-o"></i> Add Council</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_council', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'council/' ); ?>"><i class="fa fa-circle-o"></i> View Councils</a>
                    </li>

                </ul>

            </li>

            <?php */ } // end if councils access
            if(has_access('bin_liners_management')) { /* ?>

            <li class="treeview <?php set_active_menu('bin_liner', $active_menu); ?>">

                <a href="#"><i class="fa fa-filter"></i> <span>Bin Liners Management</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_bin_liner_settings', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'bin_liner/' ); ?>"><i class="fa fa-circle-o"></i> Settings</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_bin_liner', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'bin_liner/record_list' ); ?>"><i class="fa fa-circle-o"></i> View Bin Liners</a>
                    </li>

                </ul>

            </li>

            <?php */ } // end if bin_liners_managements access
            
            if(has_access('bin_liners_management')) { ?>

            <li class="treeview <?php set_active_menu('daily_balance', $active_menu); ?>">

                <a href="#"><i class="fa fa-balance-scale"></i> <span>Daily Balance</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <li class="<?php echo set_sub_menu('add_daily_balance', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'daily_balances/save' ); ?>"><i class="fa fa-circle-o"></i> Add new balance</a>
                    </li>

                    <li class="<?php echo set_sub_menu('view_daily_balance', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'daily_balances' ); ?>"><i class="fa fa-circle-o"></i> View Balances</a>
                    </li>

                </ul>

            </li>

            <?php } // end if bin_liners_managements access
            if(has_access('reports')) { ?>

            <li>
                <a href="<?php echo site_url('reports'); ?>"><i class="fa fa-file-pdf-o"></i> <span>Reports</span></i></a>
            </li>

            <?php } // end if reports access ?>

        </ul>

  </section>
  <!-- /.sidebar -->
</aside>