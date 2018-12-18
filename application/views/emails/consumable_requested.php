<!DOCTYPE html>
	<html>
	<head>
		<title>Consumable Requested</title>
	</head>
	<body>
	
		<table cellpadding="0" cellspacing="0" border="0" style="height:auto !important; margin:0; padding:25px; background-color:#ccc; color:#333333;">
		   <tbody>
		      <tr>
		         <td>
		            <div style="width:100% !important; max-width:740px !important; text-align:center; margin:0 auto;">
		               <table width="740" align="center" cellpadding="0" cellspacing="0" border="0" style="background-color:#FFFFFF; margin:0 auto; text-align:center; border:none; width:100% !important; max-width:740px !important;">
		                  <tbody>
		                     <tr>
		                        <td width="90%" valign="top">
		                           <div>
		                              <table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="90%" style="margin-left:auto;margin-right:auto;margin-top:25px;margin-bottom:15px;" dir="ltr">
		                                 <tbody>
		                                    <tr>
		                                       <td width="45%" bgcolor="#ffffff" style="text-align:left;">
		                                          <a rel="nofollow" target="_blank" href="http://www.jmlcleaningservices.com.au/jml">
		                                          	<img src="<?php echo site_url('assets/images/logo.png'); ?>" alt="JML Cleaning Services" style="display:inline-block; max-width:100% !important; width:auto !important; height:auto !important;" border="0">
		                                          </a>
		                                       </td>
		                                       <td width="55%" bgcolor="#ffffff"></td>
		                                    </tr>
		                                 </tbody>
		                              </table>
		                              <table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="90%" style="margin:0 auto;border-top:1px solid #cccccc;padding-top:25px;" dir="ltr">
		                                 <tbody>
		                                    <tr>
		                                       <td width="100%" valign="top" bgcolor="#ffffff" style="text-align:left;" class="yiv6726253809pe-content">
		                                          <table border="0" cellspacing="0" cellpadding="0" dir="ltr" class="yiv6726253809pe-text">
		                                             <tbody>
		                                                <tr>
		                                                   <td>
		                                                      <p style="text-align:left;color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;margin:0px;padding:0;margin-top:10px;font-weight:bold;">Consumable Requested,</p>
		                                                   </td>
		                                                </tr>
		                                             </tbody>
		                                          </table>
		                                          <table border="0" cellspacing="0" cellpadding="0" dir="ltr">
		                                             <tbody>
		                                                <tr>
		                                                   <td>
		                                                      <p style="text-align:left;color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;margin:0px;padding:0;margin-top:10px;font-weight:normal;"><strong><?php echo $requested_by->first_name . ' ' . $requested_by->last_name; ?></strong> made comsumable request at <strong><?php echo local_datetime($consumable->created_at) ?></strong>.</p>
		                                                   </td>
		                                                </tr>
		                                             </tbody>
		                                          </table>
		                                          <table border="0" cellspacing="0" cellpadding="0" dir="ltr" class="yiv6726253809pe-text">
		                                             <tbody>
		                                                <tr>
		                                                   <td>
		                                                      <p style="text-align:left;color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;margin:0px;padding:0;margin-top:10px;font-weight:normal;">Here are the details:</p>
		                                                   </td>
		                                                </tr>
		                                             </tbody>
		                                          </table>
		                                          <table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;background-color:#f1f1f1; min-width:60%" bgcolor="#f1f1f1" dir="ltr">
		                                             <tbody>
		                                                <tr>
		                                                   <td valign="middle" style="text-align:left;color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:bold;">Request ID </td>
		                                                   <td valign="middle" style="text-align:left;color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo $consumable->id; ?></td>
		                                                </tr>
		                                                <tr>
		                                                   <td valign="middle" style="text-align:left;color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:bold;">Property </td>
		                                                   <td valign="middle" style="text-align:left;color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo $property->address; ?> <?php echo $property->address_suburb; ?> <?php echo $property->address_post_code; ?></td>
		                                                </tr>
		                                                <tr>
		                                                   <td valign="middle" style="text-align:left;color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:bold;">Client </td>
		                                                   <td valign="middle" style="text-align:left;color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo $client->name; ?></td>
		                                                </tr>
		                                                <tr>
		                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:bold;">Date </td>
		                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo local_date($consumable->date); ?></td>
		                                                </tr>
		                                                <tr>
		                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:bold;">Requested By </td>
		                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo $requested_by->first_name . ' ' . $requested_by->last_name; ?></td>
		                                                </tr>
		                                                <tr>
		                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:bold;">Status </td>
		                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo get_status($consumable->status); ?></td>
		                                                </tr>
		                                                <tr>
		                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:bold;">Purchase Order # </td>
		                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo $consumable->po_no; ?></td>
		                                                </tr>
		                                                <tr>
		                                                   	<td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:bold;">Line Items </td>
		                                                   	<td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;">
															 	<table>
																 	<thead>
																	 	<tr>
																			<th valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px; padding:10px 15px 20px; border-bottom:1px solid #dddddd;">Code</th>
																			<th valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px; padding:10px 15px 20px; border-bottom:1px solid #dddddd;">Name</th>
																			<th valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px; padding:10px 15px 20px; border-bottom:1px solid #dddddd;">Supplier</th>
																			<th valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px; padding:10px 15px 20px; border-bottom:1px solid #dddddd;">Quantity</th>
																			<th valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px; padding:10px 15px 20px; border-bottom:1px solid #dddddd;">Unit</th>
																	 	</tr>
																 	</thead>
																 	<tbody>
																	 	
																	 	<?php foreach ($lineItems as $item): ?>
																			<tr>
																				<td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo $item->code; ?></td>
																				<td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo $item->name; ?></td>
																				<td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo $item->supplier; ?></td>
																				<td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo $item->qty; ?></td>
																				<td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo $item->unit; ?></td>
																			</tr>
																		<?php endforeach ?>
																	 	<tr>
																	 	</tr>
																 	</tbody>
															 	</table>
														
														 	</td>
		                                                </tr>
		                                             </tbody>
		                                          </table>
		                                       </td>
		                                    </tr>
		                                    <tr>
		                                       <td>
		                                          <table width="100%" border="0" cellpadding="0" cellspacing="0" dir="ltr">
		                                             <tbody>
		                                                <tr>
		                                                   <td width="100%" valign="top" bgcolor="#ffffff" style="text-align:left;" class="yiv6726253809pe-end-msg">
		                                                      <table style="text-align:left;" width="100%" border="0" cellpadding="0" cellspacing="0" dir="ltr" class="yiv6726253809pe-signature">
		                                                         <tbody>
		                                                            <tr>
		                                                               <td>&nbsp;</td>
		                                                            </tr>
		                                                            <tr>
		                                                               <td style="text-align:left;" dir="ltr">
		                                                                  	<span style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:19px;margin:0;padding:0;padding-bottom:10px;font-weight:normal;">
		                                                                    <p>If you have admin you can approve the request by clicking Approve button below.</p>
		                                                                    <br>
		                                                                    <a href="<?php echo site_url("consumable_request/approve/$consumable->id"); ?>" style="background-color: #05589A; color:white; display:block;text-align:center;padding: 15px; margin-bottom: 25px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 20px; box-shadow: 0px 4px 10px -5px #000000;">Approve</a>
		                                                               </td>
		                                                            </tr>
		                                                         </tbody>
		                                                      </table>
		                                                      
		                                                   </td>
		                                                </tr>
		                                             </tbody>
		                                          </table>
		                                       </td>
		                                    </tr>
		                                 </tbody>
		                              </table>
		                           </div>
		                        </td>
		                     </tr>
		                  </tbody>
		               </table>
		            </div>
		         </td>
		      </tr>
		   </tbody>
		</table>
	</body>
</html>

