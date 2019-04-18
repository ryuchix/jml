<!-- Left side column. contains the logo and sidebar -->

<aside class="main-sidebar">

    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            
            <li class="header">MAIN NAVIGATION</li>
            <?php if ( $controller->hasAccess( [ 'add-quote', 'edit-quote', 'view-quote', 'view-forecast' ] ) ) : ?>
                
            <li class="treeview <?php set_active_menu('quote', $active_menu); ?>">

                <a href="#"><i class="fa fa-file-text-o"></i> <span>Quotes</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ( $controller->hasAccess( 'add-quote' ) ) : ?>
                    <li class="<?php echo set_sub_menu('add_quote', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'quote/save' ); ?>"><i class="fa fa-circle-o"></i> Add Quote</a>
                    </li>
                    <?php endif; ?>

                    <?php if ( $controller->hasAccess( 'view-quote' ) ) : ?>
                    <li class="<?php echo set_sub_menu('view_quote', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'quote/' ); ?>"><i class="fa fa-circle-o"></i> View Quotes</a>
                    </li>
                    <?php endif; ?>

                    <?php if ( $controller->hasAccess( 'view-forecast' ) ) : ?>
                    <li class="<?php echo set_sub_menu('sales_forcast', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'quote/forcast' ); ?>"><i class="fa fa-circle-o"></i> Sales Forecast</a>
                    </li>
                    <?php endif; ?>

                </ul>

            </li>

            <?php endif; // end if quotes access

            if ( $controller->hasAccess( ['add-file', 'view-file'] ) ): ?>

            <li class="treeview <?php set_active_menu('file', $active_menu); ?>">

                <a href="#"><i class="fa fa-file-text-o"></i> <span>Files</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-file')) : ?>
                    <li class="<?php echo set_sub_menu('add_file', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'files/save' ); ?>"><i class="fa fa-circle-o"></i> Add File</a>
                    </li>
                    <?php endif; ?>

                    <?php if ($controller->hasAccess('view-memo')) : ?>
                    <li class="<?php echo set_sub_menu('view-memo', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'files/' ); ?>"><i class="fa fa-circle-o"></i> View Memo</a>
                    </li>
                    <?php endif; ?>

                    <?php if ($controller->hasAccess('view-staff-file')) : ?>
                    <li class="<?php echo set_sub_menu('view-staff-file', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'files/?type=staff file' ); ?>"><i class="fa fa-circle-o"></i> View Files</a>
                    </li>
                    <?php endif; ?>

                    <?php if ($controller->hasAccess('view-tutorial')) : ?>
                    <li class="<?php echo set_sub_menu('view-tutorial', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'files/?type=tutorial' ); ?>"><i class="fa fa-circle-o"></i> View Tutorials</a>
                    </li>
                    <?php endif; ?>

                </ul>

            </li>
            <?php endif; ?>

            <?php if ($controller->hasAccess(['add-job', 'view-job'])) : ?>
            
            <li class="treeview <?php set_active_menu('jobs', $active_menu); ?>">

                <a href="#"><i class="fa fa-tint"></i> <span>Jobs</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-job')): ?>
                    <li class="<?php echo set_sub_menu('add_job', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'jobs/save' ); ?>"><i class="fa fa-circle-o"></i> Add Job</a>
                    </li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('view-job')): ?>
                    <li class="<?php echo set_sub_menu('view_jobs', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'jobs/' ); ?>"><i class="fa fa-circle-o"></i> View Jobs</a>
                    </li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('add-job-category')): ?>
                    <li class="<?php echo set_sub_menu('add_job_category', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'job_categories/save' ); ?>"><i class="fa fa-circle-o"></i> Add Job Category</a>
                    </li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('view-job-categories')): ?>
                    <li class="<?php echo set_sub_menu('view_job_categories', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'job_categories/' ); ?>"><i class="fa fa-circle-o"></i> View Job Categories</a>
                    </li>
                    <?php endif ?>

                </ul>

            </li>
           
            <?php endif; // end if jobs access ?>

            <?php if ($controller->hasAccess(['view-weekly', 'view-map', 'view-schedule-list'])) : ?>
            
            <li class="treeview <?php set_active_menu('schedule', $active_menu); ?>">

                <a href="#"><i class="fa fa-clock-o"></i> <span>Schedule</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('view-weekly')): ?>
                    <li class="<?php echo set_sub_menu('add_weekly', $sub_menu); ?>">
                        <a href="<?php echo site_url('schedules/weekly'); ?>"><i class="fa fa-circle-o"></i> Weekly</a>
                    </li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('view-map')): ?>
                    <li class="<?php echo set_sub_menu('view_map', $sub_menu); ?>">
                        <a href="<?php echo site_url('schedules/map'); ?>"><i class="fa fa-circle-o"></i> Map</a>
                    </li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('view-schedule-list')): ?>
                    <li class="<?php echo set_sub_menu('view_list', $sub_menu); ?>">
                        <a href="<?php echo site_url('schedules/list'); ?>"><i class="fa fa-circle-o"></i> List</a>
                    </li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('view-schedule-bin-liner')): ?>
                    <li class="<?php echo set_sub_menu('view_list', $sub_menu); ?>">
                        <a href="<?php echo site_url('schedules/list'); ?>"><i class="fa fa-circle-o"></i>Bin Liner</a>
                    </li>
                    <?php endif ?>

                </ul>

            </li>
           
            <?php endif; // end if Schedule Access ?>

            <?php if ($controller->hasAccess(['add-task', 'view-task'])) : ?>
            
            <li class="treeview <?php set_active_menu('tasks', $active_menu); ?>">

                <a href="#"><i class="fa fa-tasks"></i> <span>Tasks</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-task')): ?>
                    <li class="<?php echo set_sub_menu('add_task', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'tasks/create' ); ?>"><i class="fa fa-circle-o"></i> Add Task</a>
                    </li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('view-task')): ?>
                    <li class="<?php echo set_sub_menu('view_tasks', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'tasks/' ); ?>"><i class="fa fa-circle-o"></i> View Tasks</a>
                    </li>
                    <?php endif ?>

                </ul>

            </li>

            <?php endif; // end if jobs access
            
            if (true) : ?>
            
            <!-- <li>
                <a href="<?php echo site_url('dailyrun'); ?>"> <i class="fa fa-trash"></i> <span>Daily Run</span></i></a>
            </li> -->
           
            <?php endif; // end if daily_runs access

            if ($controller->hasAccess('add-vehicle') || $controller->hasAccess('view-vehicle')) : ?>
             
            <li class="treeview <?php set_active_menu('vehicle', $active_menu); ?>">
                
                <a href="#"><i class="fa fa-car"></i> <span>Vehicles</span></i> <i class="fa fa-angle-left pull-right"></i></a>
                
                <ul class="treeview-menu">
                
                    <?php if ($controller->hasAccess('add-vehicle')) : ?>
                    <li><a href="<?php echo site_url('vehicle/save'); ?>"><i class="fa fa-circle-o"></i> Add Vehicle</a></li>
                    <?php endif; ?>
                    <?php if ($controller->hasAccess('add-vehicle') || $controller->hasAccess('view-vehicle')) : ?>
                    <li><a href="<?php echo site_url('vehicle/'); ?>"><i class="fa fa-circle-o"></i> View Vehicles</a></li>
                    <?php endif; ?>
                </ul>
            
            </li>
           
            <?php endif; // end if vehicles access

             if ($controller->hasAccess('add-equipment') || $controller->hasAccess('view-equipment') || $controller->hasAccess('view-equipment-type')) : ?>
             
            <li class="treeview <?php set_active_menu('equipments', $active_menu); ?>">

                <a href="#"><i class="fa fa-tags"></i> <span>Equipments</span></i> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">

                    <?php if ($controller->hasAccess('add-equipment')) : ?>
                    <li class="<?php set_sub_menu('add_equipment', $sub_menu); ?>"><a href="<?php echo site_url('equipments/save'); ?>"><i class="fa fa-circle-o"></i> Add Equipment</a></li>
                    <?php endif; ?>

                    <?php if ($controller->hasAccess('view-equipment')) : ?>
                    <li class="<?php set_sub_menu('view_equipment', $sub_menu); ?>"><a href="<?php echo site_url('equipments'); ?>"><i class="fa fa-circle-o"></i> View Equipments</a></li>
                    <?php endif; ?>

                    <?php if ($controller->hasAccess('view-equipment-type')) : ?>
                    <li class="<?php set_sub_menu('view_equipment_type', $sub_menu); ?>"><a href="<?php echo site_url('equipment_types'); ?>"><i class="fa fa-circle-o"></i> View Equipment Types</a></li>
                    <?php endif; ?>

                </ul>
            </li>
            <?php endif; // end if equipments access
            
            if ( $controller->hasAccess(['add-complaint', 'view-complaint']) ) : ?>

            <li class="treeview <?php set_active_menu('complaints', $active_menu); ?>">

                <a href="#"><i class="fa fa-bug"></i> <span>Issues/Complaints</span></i> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-complaint')): ?>
                    <li class="<?php set_sub_menu('add_complain', $sub_menu); ?>">
                        <a href="<?php echo site_url('complaints/save'); ?>">
                            <i class="fa fa-circle-o"></i> New Issue/Complaints
                        </a>
                    </li>
                    <?php endif; ?>
                        
                    <?php if ($controller->hasAccess('view-complaint')): ?>
                    <li class="<?php set_sub_menu('view_complain', $sub_menu); ?>">
                        <a href="<?php echo site_url('complaints'); ?>">
                            <i class="fa fa-circle-o"></i> View Issue/Complaints
                        </a>
                    </li>
                    <?php endif; ?>

                </ul>
                        
            </li>

            <?php endif; // end if issues access

            if ( $controller->hasAccess(['add-service', 'view-service']) ) : ?>

            <li class="treeview <?php set_active_menu('services', $active_menu); ?>">

                <a href="<?php echo site_url('services'); ?>">
                    <i class="fa fa-file-pdf-o"></i> 
                    <span>Services</span> 
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <?php if ($controller->hasAccess('add-service')): ?>
                    <li class="<?php set_sub_menu('add_service', $sub_menu); ?>">
                        <a href="<?php echo site_url('services/save'); ?>">
                            <i class="fa fa-circle-o"></i> Add Service
                        </a>
                    </li>
                    <?php endif ?>

                    <?php if ($controller->hasAccess('view-service')): ?>
                    <li class="<?php set_sub_menu('active_service_list', $sub_menu); ?>">
                        <a href="<?php echo site_url('services'); ?>"><i class="fa fa-circle-o"></i> View Services</a>
                    </li>
                    <?php endif ?>

                </ul>
            </li>
           
            <?php endif; // end if services access

            if ($controller->hasAccess(['add-user', 'view-user', 'add-role', 'view-role'])) : ?>

            <li class="treeview <?php set_active_menu('users', $active_menu); ?>">
                <a href="#"><i class="fa fa-users"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    <?php if ($controller->hasAccess('add-user')) { ?>
                    <li class="<?php echo set_sub_menu('add_user', $sub_menu); ?>">
                        <a href="<?php echo site_url('users/save'); ?>"><i class="fa fa-circle-o"></i> Add User</a>
                    </li>
                    <?php } ?>

                    <?php if ($controller->hasAccess('view-user')) { ?>
                    <li class="<?php echo set_sub_menu('view_user', $sub_menu); ?>">
                        <a href="<?php echo site_url('users'); ?>"><i class="fa fa-circle-o"></i> View Users</a>
                    </li>
                    <?php } ?>

                    <?php if ($controller->hasAccess('add-role')) { ?>
                    <li class="<?php echo set_sub_menu('add_role', $sub_menu); ?>">
                        <a href="<?php echo site_url('roles/save'); ?>"><i class="fa fa-circle-o"></i> Add Role</a>
                    </li>
                    <?php } ?>

                    <?php if ($controller->hasAccess('view-role')) { ?>
                    <li class="<?php echo set_sub_menu('view_roles', $sub_menu); ?>">
                        <a href="<?php echo site_url('roles'); ?>"><i class="fa fa-circle-o"></i> View Roles</a>
                    </li>
                    <?php } ?>

                </ul>
            </li>

            <?php endif; // end if users access

            if ($controller->hasAccess(['add-client-type', 'view-client-type'])) : ?>

            <li class="treeview <?php set_active_menu('client_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-language"></i> <span>Client Types</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if( $controller->hasAccess('add-client-type') ): ?>
                    <li class="<?php echo set_sub_menu('add_client_types', $sub_menu) ?>">
                        <a href="<?php echo site_url( 'client_type/add' ); ?>"><i class="fa fa-circle-o"></i> Add Client Type</a>
                    </li>
                    <?php endif;?>

                    <?php if( $controller->hasAccess('view-client-type') ): ?>
                    <li class="<?php echo set_sub_menu('view_client_type', $sub_menu) ?>">
                        <a href="<?php echo site_url( 'client_type/' ); ?>"><i class="fa fa-circle-o"></i> View Client Types</a>
                    </li>
                    <?php endif;?>

                </ul>
            </li>

            <?php endif; // end if client_types access

            if($controller->hasAccess(['add-client', 'view-client'])) : ?>

            <li class="treeview <?php set_active_menu('client', $active_menu); ?>">

                <a href="#"><i class="fa fa-user"></i> <span>Clients</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    <?php if ($controller->hasAccess('add-client')): ?>
                    <li class="<?php echo set_sub_menu('add_client', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'client/save' );?>"><i class="fa fa-circle-o"></i> Add Client/Prospect/Lead</a>
                    </li>
                    <?php endif ?>
                    <?php if ($controller->hasAccess('view-client')): ?>
                    <li class="<?php echo set_sub_menu('active_client_lists', $sub_menu); ?>">
                        <a href="<?php echo site_url('client/'); ?>"><i class="fa fa-circle-o"></i> View Client/Prospect/Lead</a>
                    </li>
                    <?php endif ?>
                </ul>
            </li>

            <?php endif; // end if clients access

            if ( $controller->hasAccess(['add-property', 'view-property']) ) : ?>

            <li class="treeview <?php set_active_menu('property', $active_menu); ?>">

                <a href="#"><i class="fa fa-home"></i> <span>Properties</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    <?php if ($controller->hasAccess('add-property')): ?>
                    <li class="<?php echo set_sub_menu('add_property', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'property/save' ); ?>"><i class="fa fa-circle-o"></i> Add Property</a>
                    </li>
                    <?php endif ?>
                        
                    <?php if ($controller->hasAccess('view-property')): ?>
                    <li class="<?php echo set_sub_menu('view_property', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'property/' ); ?>"><i class="fa fa-circle-o"></i> View Properties</a>
                    </li>
                    <?php endif ?>

                </ul>
            </li>

            <?php endif; // end if properties access

            if( $controller->hasAccess( ['add-bin-type', 'edit-bin-type'] ) ): ?>

            <li class="treeview <?php set_active_menu('bin_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-trash"></i> <span>Bin Types</span> <i class="fa fa-angle-left pull-right"></i></a>
                
                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-bin-type')): ?>
                    <li class="<?php echo set_sub_menu('add_bin_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'bin_type/save' );?>"><i class="fa fa-circle-o"></i> Add Bin</a>
                    </li>
                    <?php endif; ?>
                        
                    <?php if ($controller->hasAccess('view-bin-type')): ?>
                    <li class="<?php echo set_sub_menu('view_types', $sub_menu); ?>">
                        <a href="<?php echo site_url('bin_type/'); ?>"><i class="fa fa-circle-o"></i> View Bin Types</a>
                    </li>
                    <?php endif; ?>

                </ul>
            </li>

            <?php endif; // end if bin_types access

            if($controller->hasAccess(['add-document-type', 'view-document-type'])) : ?>

            <li class="treeview <?php set_active_menu('document_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-file-text"></i> <span>Document Types</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-document-type')): ?>
                    <li class="<?php echo set_sub_menu('add_document_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'document_type/save' ); ?>"><i class="fa fa-circle-o"></i> Add Document Type</a>
                    </li>
                    <?php endif ?>
                        
                    <?php if ($controller->hasAccess('view-document-type')): ?>
                    <li class="<?php echo set_sub_menu('view_document_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'document_type/' ); ?>"><i class="fa fa-circle-o"></i> View Document Types</a>
                    </li>
                    <?php endif ?>

                </ul>
            </li>

            <?php endif; // end if document_types access

            if($controller->hasAccess(['add-gallery-type', 'edit-gallery-type'])) : ?>

            <li class="treeview <?php set_active_menu('gallery_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-image"></i> <span>Gallery Types</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-gallery-type')): ?>
                    <li class="<?php echo set_sub_menu('add_gallery_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'gallery_type/save' ); ?>"><i class="fa fa-circle-o"></i> Add Gallery Type</a>
                    </li>
                    <?php endif ?>
                        
                    <?php if ($controller->hasAccess('view-gallery-type')): ?>
                    <li class="<?php echo set_sub_menu('view_document_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'gallery_type/' ); ?>"><i class="fa fa-circle-o"></i> View Gallery Types</a>
                    </li>
                    <?php endif ?>

                </ul>

            </li>

            <?php endif; // end if gallery_types access

            if($controller->hasAccess(['add-key-type', 'view-key-type'])) : ?>

            <li class="treeview <?php set_active_menu('key_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-key"></i> <span>Key Types</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-key-type')): ?>
                    <li class="<?php echo set_sub_menu('add_key_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'key_type/save' ); ?>"><i class="fa fa-circle-o"></i> Add Key Type</a>
                    </li>
                    <?php endif ?>
                        
                    <?php if ($controller->hasAccess('view-key-type')): ?>
                    <li class="<?php echo set_sub_menu('view_key_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'key_type/' ); ?>"><i class="fa fa-circle-o"></i> View Key Types</a>
                    </li>
                    <?php endif ?>
                        
                </ul>

            </li>

            <?php endif; // end if key_types access

            if($controller->hasAccess(['add-lead-type', 'view-lead-type'])) : ?>

            <li class="treeview <?php set_active_menu('lead_type', $active_menu); ?>">

                <a href="#"><i class="fa fa-tasks"></i> <span>Lead Types</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-lead-type')): ?>
                    <li class="<?php echo set_sub_menu('add_lead_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'lead_type/save' ); ?>"><i class="fa fa-circle-o"></i> Add Lead Type</a>
                    </li>
                    <?php endif ?>
                        
                    <?php if ($controller->hasAccess('view-lead-type')): ?>
                    <li class="<?php echo set_sub_menu('view_lead_type', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'lead_type/' ); ?>"><i class="fa fa-circle-o"></i> View Lead Types</a>
                    </li>
                    <?php endif ?>
                        
                </ul>

            </li>

            <?php endif; // end if lead_types access

            if($controller->hasAccess(['add-supplier', 'view-supplier'])) : ?>

            <li class="treeview <?php set_active_menu('supplier', $active_menu); ?>">

                <a href="#"><i class="fa fa-ship"></i> <span>Suppliers</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-supplier')): ?>
                    <li class="<?php echo set_sub_menu('add_supplier', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'supplier/save' ); ?>"><i class="fa fa-circle-o"></i> Add Supplier</a>
                    </li>
                    <?php endif ?>
                        
                    <?php if ($controller->hasAccess('view-supplier')): ?>
                    <li class="<?php echo set_sub_menu('view_supplier', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'supplier/' ); ?>"><i class="fa fa-circle-o"></i> View Suppliers</a>
                    </li>
                    <?php endif ?>
                        
                </ul>

            </li>

            <?php endif; // end if suppliers access

            if($controller->hasAccess(['add-consumable', 'view-consumable', 'add-consumable-request', 'view-consumable-request'])) : ?>

            <li class="treeview <?php set_active_menu('consumable', $active_menu); ?>">

                <a href="#"><i class="fa fa-hourglass-half"></i> <span>Consumables</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                
                    <?php if($controller->hasAccess('add-consumable')): ?>
                    <li class="<?php echo set_sub_menu('add_consumable', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'consumable/save' ); ?>"><i class="fa fa-circle-o"></i> Add Consumable</a>
                    </li>
                    <?php endif ?>

                    <?php if ($controller->hasAccess('view-consumable')): ?>
                    <li class="<?php echo set_sub_menu('view_consumable', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'consumable/' ); ?>"><i class="fa fa-circle-o"></i> View Consumables</a>
                    </li>
                    <?php endif; ?>
                
                    <?php if($controller->hasAccess(['add-consumable-request', 'view-consumable-request'])): ?>
                    <li class="<?php echo set_sub_menu('add_consumable_request', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'consumable_request/' ); ?>"><i class="fa fa-circle-o"></i> Consumable Request</a>
                    </li>
                    <?php endif; ?>
                        

                    
                </ul>

            </li>

            <?php endif; // end if consumables access 

            if($controller->hasAccess(['add-council', 'view-council'])) : ?>

            <li class="treeview <?php set_active_menu('council', $active_menu); ?>">

                <a href="#"><i class="fa fa-hourglass-half"></i> <span>Councils</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-council')): ?>
                    <li class="<?php echo set_sub_menu('add_council', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'council/save' ); ?>"><i class="fa fa-circle-o"></i> Add Council</a>
                    </li>
                    <?php endif ?>
                        
                    <?php if ($controller->hasAccess('view-council')): ?>
                    <li class="<?php echo set_sub_menu('view_council', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'council/' ); ?>"><i class="fa fa-circle-o"></i> View Councils</a>
                    </li>
                    <?php endif ?>

                </ul>

            </li>

            <?php endif; // end if councils access

            if( $controller->hasAccess(['view-bin-liner-setting', 'view-bin-liner']) ) : ?>

            <li class="treeview <?php set_active_menu('bin_liner', $active_menu); ?>">

                <a href="#"><i class="fa fa-filter"></i> <span>Bin Liners Management</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('view-bin-liner-setting')): ?>

                    <li class="<?php echo set_sub_menu('add_bin_liner_settings', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'bin_liner/' ); ?>"><i class="fa fa-circle-o"></i> Settings</a>
                    </li>
                        
                    <?php endif ?>
    
                    <?php if ($controller->hasAccess('view-bin-liner')): ?>

                    <li class="<?php echo set_sub_menu('view_bin_liner', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'bin_liner/record_list' ); ?>"><i class="fa fa-circle-o"></i> View Bin Liners</a>
                    </li>
                        
                    <?php endif ?>

                </ul>

            </li>

            <?php endif; // end if bin_liners_managements access
            
            if ($controller->hasAccess(['add-daily-balance', 'view-daily-balance'])) { ?>
            
            <li class="treeview <?php set_active_menu('daily_balance', $active_menu); ?>">

                <a href="#"><i class="fa fa-balance-scale"></i> <span>Daily Balance</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('add-daily-balance')) { ?>
                    <li class="<?php echo set_sub_menu('add_daily_balance', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'daily_balances/save' ); ?>"><i class="fa fa-circle-o"></i> Add new balance</a>
                    </li>
                    <?php } ?>

                    <?php if ($controller->hasAccess('view-daily-balance')) { ?>
                    <li class="<?php echo set_sub_menu('view_daily_balance', $sub_menu); ?>">
                        <a href="<?php echo site_url( 'daily_balances' ); ?>"><i class="fa fa-circle-o"></i> View Balances</a>
                    </li>
                    <?php } ?>

                </ul>

            </li>
            <?php } ?>

            <li class="<?php set_active_menu('reports', $active_menu); ?>">
                
                <a href="<?php echo base_url('reports'); ?>"><i class="fa fa-file-pdf-o"></i>
                
                    <span>Reports</span> 
                
                    <!-- <i class="fa fa-angle-left pull-right"></i> -->
                
                </a>

                <!-- <ul class="treeview-menu">
                    
                    <?php if ($controller->hasAccess('export-user')): ?>
                        
                    <li>

                        <a href="<?php echo site_url( 'users/export' ); ?>">

                            <i class="fa fa-circle-o"></i> 
                            
                            Export Users

                        </a>

                    </li>
                        
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('export-client')): ?>
                        
                    <li>

                        <a href="<?php echo site_url( 'client/export' ); ?>">

                            <i class="fa fa-circle-o"></i> 
                            
                            Export Clients

                        </a>

                    </li>
                        
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('export-prospect')): ?>
                        
                    <li>
                        <a href="<?php echo site_url( 'client/export/prospects' ); ?>">

                            <i class="fa fa-circle-o"></i> 
                            
                            Export Prospects

                        </a>

                    </li>
                        
                </ul> -->

            </li>

            <?php endif; // end if reports access ?>

        </ul>

  </section>
  <!-- /.sidebar -->
  
</aside>