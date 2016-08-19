<div class="top-menu">
	<ul class="nav navbar-nav pull-right">
		<!-- BEGIN NOTIFICATION DROPDOWN -->
		<!-- <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
			<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<i class="icon-bell"></i>
				<span class="badge badge-default">7</span>
			</a>
			<ul class="dropdown-menu">
				<li class="external">
					<h3>You have
						<strong>12 pending</strong> tasks</h3>
					<a href="app_todo.html">view all</a>
				</li>
				<li>
					<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
						<li>
							<a href="javascript:;">
								<span class="time">just now</span>
								<span class="details">
									<span class="label label-sm label-icon label-success">
										<i class="fa fa-plus"></i>
									</span> New user registered. </span>
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<span class="time">3 mins</span>
								<span class="details">
									<span class="label label-sm label-icon label-danger">
										<i class="fa fa-bolt"></i>
									</span> Server #12 overloaded. </span>
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<span class="time">10 mins</span>
								<span class="details">
									<span class="label label-sm label-icon label-warning">
										<i class="fa fa-bell-o"></i>
									</span> Server #2 not responding. </span>
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<span class="time">14 hrs</span>
								<span class="details">
									<span class="label label-sm label-icon label-info">
										<i class="fa fa-bullhorn"></i>
									</span> Application error. </span>
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<span class="time">2 days</span>
								<span class="details">
									<span class="label label-sm label-icon label-danger">
										<i class="fa fa-bolt"></i>
									</span> Database overloaded 68%. </span>
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<span class="time">3 days</span>
								<span class="details">
									<span class="label label-sm label-icon label-danger">
										<i class="fa fa-bolt"></i>
									</span> A user IP blocked. </span>
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<span class="time">4 days</span>
								<span class="details">
									<span class="label label-sm label-icon label-warning">
										<i class="fa fa-bell-o"></i>
									</span> Storage Server #4 not responding dfdfdfd. </span>
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<span class="time">5 days</span>
								<span class="details">
									<span class="label label-sm label-icon label-info">
										<i class="fa fa-bullhorn"></i>
									</span> System Error. </span>
							</a>
						</li>
						<li>
							<a href="javascript:;">
								<span class="time">9 days</span>
								<span class="details">
									<span class="label label-sm label-icon label-danger">
										<i class="fa fa-bolt"></i>
									</span> Storage server failed. </span>
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</li> -->
		<!-- END NOTIFICATION DROPDOWN -->
		<!-- <li class="droddown dropdown-separator">
			<span class="separator"></span>
		</li> -->
		<li class="dropdown dropdown-dark">
			<a href="javascript:;">
				離登出時間還有：<span class="logintime">600</span>秒
			</a>
		</li>
		<li class="droddown dropdown-separator">
			<span class="separator"></span>
		</li>
		<!-- BEGIN USER LOGIN DROPDOWN -->
		<li class="dropdown dropdown-user dropdown-dark">
			<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<!-- <img alt="" class="img-circle" src="<?=$global['resource']?>/layouts/layout3/img/avatar9.jpg"> -->
				<i class="glyphicon glyphicon-user"></i>
				<span class="username username-hide-mobile"><?php echo $operator["operator_name"]; ?></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-default">
				<li>
					<a href="/member/profile">
						<i class="icon-user"></i> 個人資訊 </a>
				</li>
				<li class="divider"> </li>
				<li>
					<a href="/logout">
						<i class="icon-key"></i> 登出 </a>
				</li>
			</ul>
		</li>
		<!-- END USER LOGIN DROPDOWN -->
	</ul>
</div>