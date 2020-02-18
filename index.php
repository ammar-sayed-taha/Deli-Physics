<?php
	ob_start();

	session_start();

	$pageTitle = "الفيزياء اللذيذة";

	include_once "init.php";  //include the initialize file

	// Get The News bar
	$defBar = selectItems('*', 'bar', 'is_thanks = ?', array(0));
	$newsBar = selectItems('*', 'bar', 'is_thanks = ?', array(1));

	//get the carousel
	$allCarousels = selectItems('*', 'carousel', 1, array(), 'id DESC');

	//get the personal info of Mr farag
	$mrFarag = selectItems('*', 'users', 'admin = ? AND owner = ?', array(1, 1));

	//Get The last 10 lessons added
	$lessonsCount = 10;
	// $lastLessons = selectItems('*', 'lessons', 'visible = ?', array(0), 'id DESC', $lessonsCount);
	$lastLessons = selectLessonsFiles('lessons.visible = ?', array(0), 'lessons.id DESC', $lessonsCount);

	// Get the amount comments, lessons, Memebers from the Database
	$commentsNum 	= selectItems('COUNT(id) AS count', 'comments');
	$usersNum 		= selectItems('COUNT(id) AS count', 'users');
	$lessonsNum 	= selectItems('COUNT(id) AS count', 'lessons');
?>

<!--  Start upper-nav section  -->
<div class="upper-nav navbar-fixed-top">
	<div class="upper-con">
		<span class="senoras-img"><img src="layout/images/background/senoras.png"></span>
		<span>
			<div class="fayoum-t"><?php echo @lang('UPPER_NAV_TITLE') ?></div>
			<div class="senoras-t"><?php echo @lang('UPPER_NAV_UNDER_T') ?></div>
		</span>
		<span class="fayoum-img"><img src="layout/images/background/fayoum.jpg"></span>
	</div>
</div>
<!--  End upper-nav section  -->

<!-- Start Header Section -->
<?php if(!empty($defBar) || !empty($allCarousels) || !empty($newsBar)){ ?>
<section class="index">
	<div class="container">
		<?php if(!empty($defBar)){ ?>
			<!-- Start Definition Bar -->
			<div class="parent-bar def-bar">
				<span class="bar-logo"><?php echo @lang('WEBSITE_NAME'); ?></span>

				<span class="bar-word">
					<ul class="list-unstyled">
						<?php foreach ($defBar as $bar) {?>
							<li><?php echo $bar['sentence']; ?></li>
							<img class="" src="layout/images/website_icon.ico">
						<?php } ?>
					</ul>
				</span>
			</div>
			<!-- End Definition Bar -->
		<?php }?>

		<!-- Start Carousel Section -->
		<?php if(!empty($allCarousels)){ ?>
			<div class="carousel-head">
				<div id="carousel-gen" class="carousel slide" data-ride="carousel">
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
					    <?php
					    $counter = 1;
					    foreach($allCarousels as $carousel){?>
					    	<div class="item <?php if($counter == 1) echo 'active'; $counter++;?>">
							   	<img src="layout/images/background/<?php echo $carousel['image'] ?>" alt="Image">
							    <div class="carousel-caption">
							        <p><?php echo $carousel['title']; ?></p>
							        <a 
							        	href="<?php echo empty($carousel['link']) ? '#' : $carousel['link']; ?>" 
							        	class="btn btn-primary btn-sm" 
							        	target="<?php echo empty($carousel['link']) ? '' : '_blank' ?>" 
							        	<?php if(empty($carousel['link'])) echo 'disabled="disabled"'; ?>
							        ><?php echo @lang('READ_MORE') ?></a>
							    </div>
						    </div>
					    <?php }?>

					</div>

					<!-- Controls -->
					<a class="left carousel-control" href="#carousel-gen" data-slide="prev">
					    <span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<a class="right carousel-control" href="#carousel-gen" data-slide="next">
					    <span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				</div>
			</div>
		<?php }?>
		<!-- End Carousel Section -->

		<?php if(!empty($newsBar)){ ?>
			<!-- Start News Bar  -->
			<div class="parent-bar news-bar">
				<span class="bar-logo"><?php echo @lang('WEBSITE_NAME'); ?></span>

				<span class="bar-word">
					<ul class="list-unstyled">
						<?php foreach ($newsBar as $bar) {?>
							<li><?php echo $bar['sentence']; ?></li>
							<img class="" src="layout/images/website_icon.ico">
						<?php } ?>
					</ul>
				</span>
			</div>
			<!-- End News Bar  -->
		<?php }?>
	</div>
</section>
<?php }?>
<!-- End Header Section -->

<!-- Start The state of the website section -->

<section class="home-state">
	<div class="container">
		<div class="row">
			<!-- The Members Count -->
			<div class="col-md-4">
				<div class="content user">
					<div class="row">
						<div class="col-xs-8">
							<div class="body">
								<div><?php echo @lang('HOME_MEM') ?></div>
								<div><?php echo !empty($usersNum[0]['count']) ? $usersNum[0]['count'] : '0'; ?></div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="font">
								<span><i class="fa fa-user"></i></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- The Comments Count -->
			<div class="col-md-4">
				<div class="content comment">
					<div class="row">
						<div class="col-xs-8">
							<div class="body">
								<div><?php echo @lang('HOME_COM') ?></div>
								<div><?php echo !empty($commentsNum[0]['count']) ? $commentsNum[0]['count'] : '0'; ?></div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="font">
								<span><i class="fa fa-comment-alt"></i></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- The Lessons Count -->
			<div class="col-md-4">
				<div class="content lesson">
					<div class="row">
						<div class="col-xs-8">
							<div class="body">
								<div><?php echo @lang('HOME_LESSON') ?></div>
								<div><?php echo !empty($lessonsNum[0]['count']) ? $lessonsNum[0]['count'] : '0'; ?></div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="font">
								<span><i class="fa fa-book"></i></span>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<!-- End The state of the website section -->


<!-- Start Teh Last Lessons Added -->
<?php if(!empty($lastLessons)){ ?>
	<section class="last-lessons">
		<div class="flag"><i class="fa fa-book"></i></div>
		<h2 class="text-center"><span><?php echo @lang('LAST_LESSONS', $lessonsCount) ?></span></h2>
		<div class="container">
			<div class="row">
				<?php foreach($lastLessons as $lastLesson){ ?>
					<div class="col-sm-6">
						<div class="lesson-info">
							<div class="row">
								<div class="col-sm-12 col-lg-4">
									<div class="header">
										<?php $image = getFileIcon(pathinfo($lastLesson['file'], PATHINFO_EXTENSION)); ?>
										<a href="lessons.php?lessonid=<?php echo $lastLesson['id'] ?>">
											<img class="img-responsive" src="layout/images/icons/<?php echo $image; ?>" draggable = "false">
										</a>
									</div>
								</div>
								<div class="col-sm-12 col-lg-8">
									<div class="body">
										<h3 title="<?php echo $lastLesson['name']; ?>">
											<a href="lessons.php?lessonid=<?php echo $lastLesson['id'] ?>"><?php echo $lastLesson['name']; ?></a>
										</h3>

										<div class="date"><i class="fa fa-calendar-alt fa-md fa-fw"></i> <?php echo @date('Y M j', strtotime($lastLesson['add_date'])); ?></div>
										<div class="user">
											<a href="profile.php?uid=<?php echo $lastLesson['userID']; ?>">
												<i class="fa fa-user fa-md fa-fw"></i> <?php echo $lastLesson['FullName'] ?>
											</a>
										</div>
										<div class="title">
											<a href="titles.php?titleid=<?php echo $lastLesson['id_title']; ?>">
												<i class="fa fa-book fa-md fa-fw"></i> <?php echo $lastLesson['title_name'] ?>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				<?php }?>
			</div>
		</div>
	</section>
<?php }?>
<!-- End Teh Last Lessons Added -->

<!-- End MR.Farag Information -->
<?php if(!empty($mrFarag)){ ?>
	<section class="short-pref">
		<div class="flag"><i class="fa fa-user"></i></div>
		<div class="container">
			<!-- <h2 class="text-center"><?php echo @lang('WHO_AM_I'); ?></h2> -->
			<div class="row">
				<div class="col-sm-3">
					<div class="text-center">
						<?php $faragImg =  !empty($mrFarag[0]['image']) ? $mrFarag[0]['image'] : 'default.png';  ?>
						<img class="img-responsive img-thumbnail" src="layout/images/profiles/avatar/<?php echo @$faragImg; ?>">
					</div>
				</div>
				<div class="col-sm-9">
					<div class="pref-info">
						<h3><a href="profile.php?uid=<?php echo $mrFarag[0]['id']; ?>"><?php echo $mrFarag[0]['FullName']; ?></a></h3>
						<div class="occupation"><bdi><?php echo $mrFarag[0]['occupation'] ?></bdi></div>
						<div class="bio"><bdi><?php echo $mrFarag[0]['bio']; ?></bdi></div>
						<div class="email"><bdi><i class="far fa-envelope-open fa-sm fa-fw"></i> </bdi><bdi><?php echo $mrFarag[0]['Email']; ?></bdi></div>
						<div class="phone"><bdi><i class="fa fa-mobile-alt fa-sm fa-fw"></i> </bdi><bdi><?php echo $mrFarag[0]['phone']; ?></bdi></div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php }?>
<!-- End MR.Farag Information -->




<script type="text/javascript">
	$('body').css('background', '#FFF !important');

</script>
<?php
	include_once $tpt_path ."footer.php";
	ob_end_flush();
?>
