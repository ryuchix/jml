<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order</title>
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
	                              <table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="90%" style="margin-left:auto;margin-right:auto;margin-top:25px;margin-bottom:15px;" dir="ltr" class="yiv6726253809widthfix yiv6726253809logo-marg yiv6726253809pe-header">
	                                 <tbody>
	                                    <tr>
	                                       <td width="45%" bgcolor="#ffffff" style="text-align:left;">
	                                          <a rel="nofollow" target="_blank" href="<?php echo site_url(); ?>"><img src="<?php echo site_url('assets/images/logo.png'); ?>" alt="JML Cleaning Services" style="display:inline-block; max-width:100% !important; width:auto !important; height:auto !important;" border="0">
	                                          </a>
	                                       </td>
	                                       <td width="55%" bgcolor="#ffffff"></td>
	                                    </tr>
	                                 </tbody>
	                              </table>
	                              <table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" width="90%" style="margin:0 auto;border-top:1px solid #cccccc;padding-top:25px;" dir="ltr" class="yiv6726253809widthfix yiv6726253809pe-main-con">
	                                 <tbody>
	                                    <tr>
	                                       <td width="100%" valign="top" bgcolor="#ffffff" style="text-align:left;">
	                                          <table border="0" cellspacing="0" cellpadding="0" dir="ltr">
	                                             <tbody>
	                                                <tr>
	                                                   <td>
	                                                      <p style="text-align:left;color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;margin:0px;padding:0;margin-top:10px;font-weight:bold;">Hi,</p>
	                                                   </td>
	                                                </tr>
	                                             </tbody>
	                                          </table>
	                                          <table border="0" cellspacing="0" cellpadding="0" dir="ltr">
	                                             <tbody>
	                                                <tr>
	                                                   <td>
	                                                      <p style="text-align:left;color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;margin:0px;padding:0;margin-top:10px;font-weight:normal;">Please find below new order for JML Cleaning Services, reference number <strong><?php echo $consumable->id ?></strong>.</p>
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
	                                          <table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;background-color:#f1f1f1; min-width:80%" bgcolor="#f1f1f1" dir="ltr">
	                                             <tbody>
	                                                <tr>
	                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:bold;">Date </td>
	                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo date('d/m/Y'); ?></td>
	                                                </tr>
	                                                <tr>
	                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:bold;">Purchase Order # </td>
	                                                   <td valign="middle" style="color:#333333;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22px;margin:0px;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:15px;border-bottom:1px solid #dddddd;font-weight:normal;"><?php echo $consumable->po_no ?></td>
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
	                                                                     	<p style="margin-bottom: 10px;">Don't hesitate to contact us if you have any questions.</p>
																			<p style="font-weight: bold; margin-bottom: 0px;">JML Cleaning Services</p>
																			<p style="margin: 0;">w: <a style="color: #127DB3;" href="http://jmlcleaningservices.com.au" target="_blank">www.jmlcleaningservices.com.au</a></p>
																			<p style="margin: 0;">e: <a style="color: #127DB3;" href="mailto:info@jmlcleaningservices.com.au" target="_blank">info@jmlcleaningservices.com.au</a></p>
																			<p style="margin: 0;">p: <a style="color: #127DB3;" href="tel:1300906604">1300 906 604</a></p>
																			<p style="margin: 0;">a: <a style="color: #127DB3;" href="https://www.google.com/maps/place/1%2F27+Comserv+Loop,+Ellenbrook+WA+6069,+Australia/@-31.7768718,115.9668069,19.5z/data=!4m5!3m4!1s0x2a32b4690b3c5abf:0x4d76a4331828fcda!8m2!3d-31.776889!4d115.9672382">Unit 1, 27 Comserv Loop, Ellenbrook, WA</a></p>
	                                                                     	<p>Thank you</p>
	                                                                  </span>
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