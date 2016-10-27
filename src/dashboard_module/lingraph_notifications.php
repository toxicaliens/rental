<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- Line Graph and Notifications -->
					<div class="row-fluid">
						<div class="span8">
							<!-- BEGIN SITE VISITS PORTLET-->
							<div class="widget">
								<div class="widget-title">
									<h4><i class="icon-signal"></i>Site Visits</h4>
									<span class="tools">
									<a href="javascript:;" class="icon-chevron-down"></a>
									<a href="#widget-config" data-toggle="modal" class="icon-wrench"></a>
									<a href="javascript:;" class="icon-refresh"></a>		
									<a href="javascript:;" class="icon-remove"></a>
									</span>							
								</div>
								<div class="widget-body">
									<div id="site_statistics_loading">
										<img src="assets/img/loading.gif" alt="loading" />
									</div>
									<div id="site_statistics_content" class="hide">
										<div class="btn-toolbar no-top-space clearfix">
											<div class="btn-group" data-toggle="buttons-radio">
												<button class="btn btn-mini">Asia</button><button class="btn btn-mini">Europe</button><button class="btn btn-mini">USA</button>		
											</div>
											<div class="btn-group pull-right" data-toggle="buttons-radio">
												<button class="btn btn-mini active">Sales</button><button class="btn btn-mini">
												<span class="visible-phone">In</span>
												<span class="hidden-phone">Income</span>
												</button><button class="btn btn-mini">Stock</button>		
											</div>
										</div>
										<div id="site_statistics" class="chart"></div>
									</div>
								</div>
							</div>
							<!-- END SITE VISITS PORTLET-->
						</div>
						<div class="span4">
							<!-- BEGIN NOTIFICATIONS PORTLET-->
							<div class="widget">
								<div class="widget-title">
									<h4><i class="icon-bell"></i>Notifications</h4>
									<span class="tools">
									<a href="javascript:;" class="icon-chevron-down"></a>
									<a href="#widget-config" data-toggle="modal" class="icon-wrench"></a>
									<a href="javascript:;" class="icon-refresh"></a>
									</span>							
								</div>
								<div class="widget-body">
									<ul class="item-list scroller padding" data-height="307" data-always-visible="1">
										<li>
											<span class="label label-success"><i class="icon-bell"></i></span>
											<span>New user registered.</span>
											<span class="small italic">Just now</span>
										</li>
										<li>
											<span class="label label-success"><i class="icon-bell"></i></span>
											<span>New order received.</span>
											<span class="small italic">15 mins ago</span>
										</li>
										<li>
											<span class="label label-warning"><i class="icon-bullhorn"></i></span>
											<span>Alerting a user account balance.</span>
											<span class="small italic">2 hrs ago</span>
										</li>
										<li>
											<span class="label label-important"><i class="icon-bolt"></i></span>
											<span>Alerting administrators staff.</span>
											<span class="small italic">11 hrs ago</span>
										</li>
										<li>
											<span class="label label-important"><i class="icon-bolt"></i></span>
											<span>Messages are not sent to users.</span>
											<span class="small italic">14 hrs ago</span>
										</li>
										<li>
											<span class="label label-warning"><i class="icon-bullhorn"></i></span>
											<span>Web server #12 failed to relosd.</span>
											<span class="small italic">2 days ago</span>										
										</li>
										<li>
											<span class="label label-success"><i class="icon-bell"></i></span>
											<span>New order received.</span>
											<span class="small italic">15 mins ago</span>
										</li>
										<li>
											<span class="label label-warning"><i class="icon-bullhorn"></i></span>
											<span>Alerting a user account balance.</span>
											<span class="small italic">2 hrs ago</span>
										</li>
										<li>
											<span class="label label-important"><i class="icon-bolt"></i></span>
											<span>Alerting administrators support staff.</span>
											<span class="small italic">11 hrs ago</span>
										</li>
										<li>
											<span class="label label-important"><i class="icon-bolt"></i></span>
											<span>Messages are not sent to users.</span>
											<span class="small italic">14 hrs ago</span>
										</li>
										<li>
											<span class="label label-warning"><i class="icon-bullhorn"></i></span>
											<span>Web server #12 failed to relosd.</span>
											<span class="small italic">2 days ago</span>										
										</li>
										<li>
											<span class="label label-success"><i class="icon-bell"></i></span>
											<span>New order received.</span>
											<span class="small italic">15 mins ago</span>
										</li>
										<li>
											<span class="label label-warning"><i class="icon-bullhorn"></i></span>
											<span>Alerting a user account balance.</span>
											<span class="small italic">2 hrs ago</span>
										</li>
										<li>
											<span class="label label-important"><i class="icon-bolt"></i></span>
											<span>Alerting administrators support staff.</span>
											<span class="small italic">11 hrs ago</span>
										</li>
										<li>
											<span class="label label-important"><i class="icon-bolt"></i></span>
											<span>Messages are not sent to users.</span>
											<span class="small italic">14 hrs ago</span>
										</li>
										<li>
											<span class="label label-warning"><i class="icon-bullhorn"></i></span>
											<span>Web server #12 failed to relosd.</span>
											<span class="small italic">2 days ago</span>										
										</li>
									</ul>
									<div class="space5"></div>
									<a href="#" class="pull-right">View all notifications</a>										
									<div class="clearfix no-top-space no-bottom-space"></div>
								</div>
							</div>
							<!-- END NOTIFICATIONS PORTLET-->
						</div>
					</div>






<div class="row-fluid">
						<div class="span6">
							<!-- BEGIN RECENT ORDERS PORTLET-->
							<div class="widget">
								<div class="widget-title">
									<h4><i class="icon-shopping-cart"></i>Recent Orders</h4>
									<span class="tools">
									<a href="javascript:;" class="icon-chevron-down"></a>
									<a href="#widget-config" data-toggle="modal" class="icon-wrench"></a>
									<a href="javascript:;" class="icon-refresh"></a>		
									<a href="javascript:;" class="icon-remove"></a>
									</span>							
								</div>
								<div class="widget-body">
									<table class="table table-striped table-bordered table-advance table-hover">
										<thead>
											<tr>
												<th><i class="icon-briefcase"></i> <span class="hidden-phone">From</span></th>
												<th><i class="icon-user"></i> <span class="hidden-phone ">Contact</span></th>
												<th><i class="icon-shopping-cart"> </i><span class="hidden-phone">Amount</span></th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="highlight">
													<div class="success"></div>
													<a href="#">Ikea</a>
												</td>
												<td>Elis Yong</td>
												<td>4560.60$ 
													<span class="label label-warning label-mini">Paid</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="important"></div>
													<a href="#">Apple</a>
												</td>
												<td>Daniel Kim</td>
												<td>360.60$ <a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> </td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="info"></div>
													<a href="#">37Singals</a>
												</td>
												<td>Edward Cooper</td>
												<td>960.50$ 
													<span class="label label-success label-mini">Pending</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="warning"></div>
													<a href="#">Google</a>
												</td>
												<td>Paris Simpson</td>
												<td>1101.60$ 
													<span class="label label-success label-mini">Pending</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="success"></div>
													<a href="#">Ikea</a>
												</td>
												<td>Elis Yong</td>
												<td>4560.60$ 
													<span class="label label-warning label-mini">Paid</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="warning"></div>
													<a href="#">Google</a>
												</td>
												<td>Paris Simpson</td>
												<td>1101.60$ 
													<span class="label label-success label-mini">Pending</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="important"></div>
													<a href="#">Apple</a>
												</td>
												<td>Daniel Kim</td>
												<td>360.60$ <a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> </td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="warning"></div>
													<a href="#">Google</a>
												</td>
												<td>Paris Simpson</td>
												<td>1101.60$ 
													<span class="label label-success label-mini">Pending</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
										</tbody>
									</table>
									<div class="space7"></div>
									<div class="clearfix">
										<a href="#" class="btn btn-mini pull-right">All Orders</a>
									</div>
								</div>
							</div>
							<!-- END RECENT ORDERS PORTLET-->
						</div>
						<div class="span6">
							<!-- BEGIN CHAT PORTLET-->
							<div class="widget" id="chats">
								<div class="widget-title">
									<h4><i class="icon-tasks"></i>Chats</h4>
									<span class="tools">
									<a href="javascript:;" class="icon-chevron-down"></a>
									<a href="#widget-config" data-toggle="modal" class="icon-wrench"></a>
									<a href="javascript:;" class="icon-refresh"></a>		
									<a href="javascript:;" class="icon-remove"></a>
									</span>
								</div>
								<div class="widget-body">
									<div class="scroller" data-height="322px" data-always-visible="1" data-rail-visible1="1">
										<ul class="chats">
											<li class="in">
												<img class="avatar" alt="" src="assets/img/avatar1.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Mark King</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="out">
												<img class="avatar" alt="" src="assets/img/avatar2.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Lisa Wong</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="in">
												<img class="avatar" alt="" src="assets/img/avatar1.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Mark King</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="out">
												<img class="avatar" alt="" src="assets/img/avatar3.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Richard Doe</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="in">
												<img class="avatar" alt="" src="assets/img/avatar3.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Richard Doe</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="out">
												<img class="avatar" alt="" src="assets/img/avatar1.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Mark King</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="in">
												<img class="avatar" alt="" src="assets/img/avatar3.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Richard Doe</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, 
													sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
										</ul>
									</div>
									<div class="chat-form">
										<div class="input-cont">   
											<input type="text" placeholder="Type a message here..." />
										</div>
										<div class="btn-cont"> 
											<a href="javascript:;" class="btn btn-primary"><i class="icon-ok icon-white"></i></a>
										</div>
									</div>
								</div>
							</div>
							<!-- END CHAT PORTLET-->
						</div>
					</div>





<div class="row-fluid">
						<div class="span6">
							<!-- BEGIN SERVER LOAD PORTLET-->
							<div class="widget">
								<div class="widget-title">
									<h4><i class="icon-cogs"></i>Server Load</h4>
									<span class="tools">
									<a href="javascript:;" class="icon-chevron-down"></a>
									<a href="#widget-config" data-toggle="modal" class="icon-wrench"></a>
									<a href="javascript:;" class="icon-refresh"></a>		
									<a href="javascript:;" class="icon-remove"></a>
									</span>							
								</div>
								<div class="widget-body">
									<div id="load_statistics_loading">
										<img src="assets/img/loading.gif" alt="loading" />
									</div>
									<div id="load_statistics_content" class="hide">
										<div id="load_statistics" class="chart"></div>
										<div class="btn-toolbar no-bottom-space clearfix">
											<div class="btn-group" data-toggle="buttons-radio">
												<button class="btn btn-mini">Web</button><button class="btn btn-mini">Database</button><button class="btn btn-mini">Static</button>		
											</div>
											<div class="btn-group pull-right" data-toggle="buttons-radio">
												<button class="btn btn-mini active">Asia</button><button class="btn btn-mini">
												<span class="visible-phone">Eur</span>
												<span class="hidden-phone">Europe</span>
												</button><button class="btn btn-mini">USA</button>		
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- END SERVER LOAD PORTLET-->
						</div>
						<div class="span6">
							<!-- BEGIN REGIONAL STATS PORTLET-->
							<div class="widget">
								<div class="widget-title">
									<h4><i class="icon-globe"></i>Regional Stats</h4>
									<span class="tools">
									<a href="javascript:;" class="icon-chevron-down"></a>
									<a href="#widget-config" data-toggle="modal" class="icon-wrench"></a>
									<a href="javascript:;" class="icon-refresh"></a>		
									<a href="javascript:;" class="icon-remove"></a>										
									</span>							
								</div>
								<div class="widget-body">
									<div id="region_statistics_loading">
										<img src="assets/img/loading.gif" alt="loading" />
									</div>
									<div id="region_statistics_content" class="hide">
										<div class="btn-toolbar no-top-space clearfix">
											<div class="btn-group" data-toggle="buttons-radio">
												<button class="btn btn-mini active">Users</button><button class="btn btn-mini">Orders</button><button class="btn btn-mini">Income</button>		
											</div>
											<div class="btn-group pull-right">
												<button class="btn btn-mini dropdown-t	oggle" data-toggle="dropdown">
												Select Region 
												<span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<li><a href="javascript:;" id="regional_stat_world">World</a></li>
													<li><a href="javascript:;" id="regional_stat_usa">USA</a></li>
													<li><a href="javascript:;" id="regional_stat_europe">Europe</a></li>
													<li><a href="javascript:;" id="regional_stat_russia">Russia</a></li>
													<li><a href="javascript:;" id="regional_stat_germany">Germany</a></li>
												</ul>
											</div>
										</div>
										<div id="vmap_world" class="vmaps  chart hide"></div>
										<div id="vmap_usa" class="vmaps chart hide"></div>
										<div id="vmap_europe" class="vmaps chart hide"></div>
										<div id="vmap_russia" class="vmaps chart hide"></div>
										<div id="vmap_germany" class="vmaps chart hide"></div>
									</div>
								</div>
							</div>
							<!-- END REGIONAL STATS PORTLET-->
						</div>
					</div>





<div class="row-fluid">
						<div class="span6">
							<!-- BEGIN RECENT ORDERS PORTLET-->
							<div class="widget">
								<div class="widget-title">
									<h4><i class="icon-shopping-cart"></i>Recent Orders</h4>
									<span class="tools">
									<a href="javascript:;" class="icon-chevron-down"></a>
									<a href="#widget-config" data-toggle="modal" class="icon-wrench"></a>
									<a href="javascript:;" class="icon-refresh"></a>		
									<a href="javascript:;" class="icon-remove"></a>
									</span>							
								</div>
								<div class="widget-body">
									<table class="table table-striped table-bordered table-advance table-hover">
										<thead>
											<tr>
												<th><i class="icon-briefcase"></i> <span class="hidden-phone">From</span></th>
												<th><i class="icon-user"></i> <span class="hidden-phone ">Contact</span></th>
												<th><i class="icon-shopping-cart"> </i><span class="hidden-phone">Amount</span></th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="highlight">
													<div class="success"></div>
													<a href="#">Ikea</a>
												</td>
												<td>Elis Yong</td>
												<td>4560.60$ 
													<span class="label label-warning label-mini">Paid</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="important"></div>
													<a href="#">Apple</a>
												</td>
												<td>Daniel Kim</td>
												<td>360.60$ <a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> </td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="info"></div>
													<a href="#">37Singals</a>
												</td>
												<td>Edward Cooper</td>
												<td>960.50$ 
													<span class="label label-success label-mini">Pending</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="warning"></div>
													<a href="#">Google</a>
												</td>
												<td>Paris Simpson</td>
												<td>1101.60$ 
													<span class="label label-success label-mini">Pending</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="success"></div>
													<a href="#">Ikea</a>
												</td>
												<td>Elis Yong</td>
												<td>4560.60$ 
													<span class="label label-warning label-mini">Paid</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="warning"></div>
													<a href="#">Google</a>
												</td>
												<td>Paris Simpson</td>
												<td>1101.60$ 
													<span class="label label-success label-mini">Pending</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="important"></div>
													<a href="#">Apple</a>
												</td>
												<td>Daniel Kim</td>
												<td>360.60$ <a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> </td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
											<tr>
												<td class="highlight">
													<div class="warning"></div>
													<a href="#">Google</a>
												</td>
												<td>Paris Simpson</td>
												<td>1101.60$ 
													<span class="label label-success label-mini">Pending</span>
													<a href="#" class="btn btn-mini visible-phone hidden-tablet">View</a> 
												</td>
												<td><a href="#" class="btn btn-mini hidden-phone hidden-tablet">View</a></td>
											</tr>
										</tbody>
									</table>
									<div class="space7"></div>
									<div class="clearfix">
										<a href="#" class="btn btn-mini pull-right">All Orders</a>
									</div>
								</div>
							</div>
							<!-- END RECENT ORDERS PORTLET-->
						</div>
						<div class="span6">
							<!-- BEGIN CHAT PORTLET-->
							<div class="widget" id="chats">
								<div class="widget-title">
									<h4><i class="icon-tasks"></i>Chats</h4>
									<span class="tools">
									<a href="javascript:;" class="icon-chevron-down"></a>
									<a href="#widget-config" data-toggle="modal" class="icon-wrench"></a>
									<a href="javascript:;" class="icon-refresh"></a>		
									<a href="javascript:;" class="icon-remove"></a>
									</span>
								</div>
								<div class="widget-body">
									<div class="scroller" data-height="322px" data-always-visible="1" data-rail-visible1="1">
										<ul class="chats">
											<li class="in">
												<img class="avatar" alt="" src="assets/img/avatar1.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Mark King</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="out">
												<img class="avatar" alt="" src="assets/img/avatar2.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Lisa Wong</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="in">
												<img class="avatar" alt="" src="assets/img/avatar1.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Mark King</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="out">
												<img class="avatar" alt="" src="assets/img/avatar3.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Richard Doe</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="in">
												<img class="avatar" alt="" src="assets/img/avatar3.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Richard Doe</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="out">
												<img class="avatar" alt="" src="assets/img/avatar1.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Mark King</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
											<li class="in">
												<img class="avatar" alt="" src="assets/img/avatar3.jpg" />
												<div class="message">
													<span class="arrow"></span>
													<a href="#" class="name">Richard Doe</a>
													<span class="datetime">at Jul 25, 2012 11:09</span>
													<span class="body">
													Lorem ipsum dolor sit amet, consectetuer adipiscing elit, 
													sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
													</span>
												</div>
											</li>
										</ul>
									</div>
									<div class="chat-form">
										<div class="input-cont">   
											<input type="text" placeholder="Type a message here..." />
										</div>
										<div class="btn-cont"> 
											<a href="javascript:;" class="btn btn-primary"><i class="icon-ok icon-white"></i></a>
										</div>
									</div>
								</div>
							</div>
							<!-- END CHAT PORTLET-->
						</div>
					</div>