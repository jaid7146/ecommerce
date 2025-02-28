<div class="top-bar animate-dropdown">
	<div class="container">
		<div class="header-top-inner">
			<div class="cnt-account">
				<ul class="list-unstyled">

					<?php if (strlen($_SESSION['login'])) { ?>
						<li><a href="#"><i class="icon fa fa-user"></i>Welcome - <?php echo htmlentities($_SESSION['username']); ?></a></li>
						<li><a href="my-account.php"><i class="icon fa fa-user"></i>My Account</a></li>
						<li><a href="#" data-toggle="modal" data-target="#logoutModal"><i class="icon fa fa-sign-out"></i>Logout</a></li>
						<!-- Logout Modal -->
						<!-- Bootstrap 5 Advanced Styled Logout Confirmation Modal -->
						<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content shadow-lg rounded-3" style="border: none;">
									<!-- Modal Header -->
									<div class="modal-header" style="background: linear-gradient(135deg,rgba(219, 29, 16, 0.42), #ff5722);">
										<h5 class="modal-title text-white" id="logoutModalLabel" style="font-family: 'Roboto', sans-serif; font-weight: 500;">Confirm Logout</h5>
										<!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
									</div>

									<!-- Modal Body -->
									<div class="modal-body" style="background-color: #f8f9fa; color: #333; font-size: 16px; font-family: 'Arial', sans-serif; line-height: 1.6;">
										<p style="font-weight: 400;">Are you sure you want to logout?</p>
									</div>

									<!-- Modal Footer -->
									<div class="modal-footer" style="background-color: #f1f1f1; border-top: none; justify-content: space-between;">
										<button type="button" class="btn btn-outline-dark btn-lg" data-dismiss="modal" style="border-radius: 25px; font-weight: 600; padding: 12px 30px;">Cancel</button>
										<a href="logout.php" class="btn btn-danger btn-lg" style="border-radius: 25px; font-weight: 600; padding: 12px 30px;">Logout</a>
									</div>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<li><a href="login.php"><i class="icon fa fa-sign-in"></i>Login</a></li>
					<?php } ?>
				</ul>
			</div><!-- /.cnt-account -->
			<div class="cnt-block">
				<ul class="list-unstyled list-inline" style="margin-left: 30px;">
					<li class="dropdown dropdown-small">
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div><!-- /.header-top-inner -->
	</div><!-- /.container -->
</div><!-- /.header-top -->