

	<!-- The End Of body-container section which holds the whole body of the page -->
		</section>

		<!-- Start Footer Section -->

		<section class="footer">
			<div class="container">
				<div class="under-care">
					<span>
						<?php echo @lang('SUPERVISED_BY');?>
						<a href="#"><?php echo @lang('MR_FARAG'); ?></a>
						<?php echo @lang('SUPERVISOR_WORK'); ?>
					</span>
				</div>
				<div class="copyright">
					<span><?php echo @lang('MADE_WITH') ?> <i class="fa fa-heart fa-lg"></i> <?php echo @lang('BY'); ?> 
						<a href="https://www.facebook.com/ammar.romancic" target="_blank"><?php echo @lang('DEV_NAME'); ?></a>
						<span><i class="fa fa-mobile-alt fa-fw fa-md"></i> 01018466725 - </span>
					</span>
					<span><?php echo @lang('ALL_RIGHTS') ?> &copy; <?php echo @date('Y'); ?></span>
				</div>
			</div>
		</section>

		<!-- End Footer Section -->


		
		<script src="<?php echo $js_path; ?>jquery-ui.min.js"></script>
		<script src="<?php echo $js_path; ?>jquery.selectBoxIt.min.js"></script>
		<script src="<?php echo $js_path; ?>bootstrap.min.js"></script>
		<script src="<?php echo $js_path; ?>backend.js"></script>
	</body>
</html>