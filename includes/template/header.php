<?php
	include_once "init.php";

	$isAdmin = false; //used to check if the user admin or not 

?>

<!DOCKTYP html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="<?php echo @lang('META_DESCRIPTION') ?>">
	    <meta name="keywords" content="<?php echo @lang('META_KEYWORDS') ?>">
	    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title><?php pageTitle(); ?></title>
		<link rel="shortcut icon" type="image/x-icon" href="layout/images/website_icon.ico">
		<link rel="stylesheet" href="<?php echo $admin_css_path; ?>bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $admin_css_path; ?>fontawesome-all.min.css">
		<link rel="stylesheet" href="<?php echo $admin_css_path; ?>jquery-ui.min.css">
		<link rel="stylesheet" href="<?php echo $admin_css_path; ?>jquery.selectBoxIt.css">
		<link rel="stylesheet" href="<?php echo $css_path; ?>frontend.css">
		<!-- set acarbic.css file -->
		<?php
			if(!isset($_COOKIE['lang']) || (isset($_COOKIE['lang'])  && $_COOKIE['lang'] == 'arabic.php')){?>
				<link rel="stylesheet" href="<?php echo $css_path; ?>arabic.css">
		<?php } ?>
		<link rel="stylesheet" href="<?php echo $css_path; ?>theme.css">
		<link rel="stylesheet" href="<?php echo $css_path; ?>mediaQuery.css">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	    <!-- Global site tag (gtag.js) - Google Analytics -->
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125822163-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-125822163-1');
		</script>



		<script src="<?php echo $admin_js_path; ?>jquery-3.2.1.min.js"></script>

		<script type="text/javascript">
	    	/* check if the user chosed a specific theme */
			if (localStorage['theme'] != null) {
				$('link[href*="theme"]').attr('href', localStorage['theme']);
		    }else{
		    	$('link[href*="theme"]').attr('href', 'layout/css/default_theme.css');
		    }
	    </script>

	</head>

	<body>

		<?php
			// Start Getting The Aatar Image If The User Logged In
			if(isset($_SESSION['user'])){
				$myImg = 'layout/images/profiles/avatar/default.png'; //the default image

				$profileImg = selectItems('image', 'users', 'id = ?', array($_SESSION['uid']));
				if(! empty($profileImg[0]['image'])){
					$myImg = 'layout/images/profiles/avatar/' . $profileImg[0]['image'];
				}
			}
		?>

		<!-- End Getting The Aatar Image If The User Logged In -->


		<!-- ***** Start The Menu ************ -->

		<div class="list-menu">
			<a href="index.php">
				<h3><?php echo @lang('WEBSITE_NAME') ? @lang('WEBSITE_NAME') : 'الفيزياء اللذيذة'; ?></h3>
			</a>
			<div class="personal">
				<!-- if the user didn't login -->
				<?php if(! isset($_SESSION['user'])){?>
					<div class="menu-login">
						<a href="login.php" title="<?php echo @lang('LOGIN_SIGNUP') ?>">
							<i class="fas fa-sign-in-alt fa-sm fa-fw"></i> <?php echo @lang('LOGIN') ?>
						</a>
					</div>
			    <?php }?>

				<!-- Show The Personal Links if the user login -->
				<?php if(isset($_SESSION['uid'])){ ?>
					<a href="profile.php?uid=<?php echo @$_SESSION['uid'] ?>">
						<div class="my-account"><?php echo @lang('MY_ACCOUNT'); ?></div>
					</a>

					 <?php
		            	//display dashboard if the user is admin
				        if(isset($_SESSION['user'])){
				        	$admin = selectItems('admin', 'users', 'username = ?', array($_SESSION['user']));
				        	if(@$admin[0]['admin'] == 1 || @$admin[0]['admin'] == 2){
				        		echo '<a class="dashboard" href="admin/index.php"><div>' . @lang('DASHBOARD') . '</div></a>';

				        		$isAdmin = true; //the user is admin
				        		if(!isset($_SESSION['username'])){
				        			$_SESSION['username'] = $_SESSION['user'];
				        			$_SESSION['userid'] = $_SESSION['uid'];
				        			$_SESSION['admin'] = $admin[0]['admin'];
				        		}
							}
						}
					?>

					<a href="settings.php">
						<div class="settings"><?php echo @lang('SETTINGS'); ?></div>
					</a>
				<?php }?>

				<?php if(isset($_SESSION['uid'])){ ?>
					<a href="logout.php">
						<div class="logout"><?php echo @lang('LOGOUT'); ?></div>
					</a>
				<?php }?>
			</div>
			<ul class="parent-title-con list-unstyled">
				<?php
					// Get The Titles From The Database
					$parentTitles = selectItems('id, name', 'titles', 'parent = ?', array(0), 'ordering DESC'); //parent Titles
					$childTitles = selectItems('id, name, parent', 'titles', 'parent != ?', array(0));  //Get Child Titles

					foreach ($parentTitles as $parentTitle) {?>
						<li class="parent-title">
							<span>
								<?php echo $parentTitle['name'] ?>
								<i class="fa fa-angle-right fa-sm fa-fw"></i>
							</span>
							<ul class="child-title-con list-unstyled">
								<?php
									//check if this parent title has childs or not if exist diplay it
									foreach ($childTitles as $childTitle) {
										if($childTitle['parent'] == $parentTitle['id']){?>
											<a href="titles.php?titleid=<?php echo $childTitle['id']; ?>">
												<li class="child-title"><?php echo $childTitle['name'] ?></li>
											</a>
										<?php }
									}
								?>
							</ul>
						</li>
					<?php }

				?>
			</ul>

			<!-- Themes Sections  -->
			<div class="theme">
				<h3><?php echo @lang('THEME_TITLE') ?></h3>
				<ul class="list-unstyled">
					<li data-value="<?php echo $css_path; ?>default_theme.css">
						<span class="inner default"><i class="fas fa-adjust"></i></span>
						<span class="text"><?php echo @lang('DEFAULT_THEME') ?></span>
						
					</li>
					<li data-value="<?php echo $css_path; ?>white_theme.css">
						<span class="inner white"><i class="fas fa-sun"></i></span>
						<span class="text"><?php echo @lang('WHITE_THEME') ?></span>
					</li>
					<li data-value="<?php echo $css_path; ?>dark_theme.css">
						<span class="inner dark"><i class="fas fa-moon"></i></span>
						<span class="text"><?php echo @lang('DARK_THEME') ?></span>
					</li>

				</ul>
			</div>
		</div>

		<!-- ***** End The Menu ************ -->

		<!-- ****** Start The Body -->

		<!-- this section will hold the whole body of the page and use it when click on menu btn -->
		<section class="body-container">

			<!-- Overllay just used to overlay the body when click on the list menu -->
			<div class="overlay"></div>

			<nav class="navbar navbar-inverse navbar-fixed-top">
				<div class="container">
				    <div class="navbar-header">
				      <a class="navbar-brand" href="index.php">
				      	<span><?php echo @lang('WEBSITE_NAME'); ?></span>
				      </a>
				    </div>

				    <!-- Menu button -->
				    <div class="menu nav navbar-nav navbar-right"><span></span></div> <!-- this span in <li> used for making the bars of the menu -->

				    <!-- Start The Profile DropDown Menu -->
			      	<ul class="dropdown-pro nav navbar-nav navbar-right">
			      		<?php if(isset($_SESSION['user'])){ ?>
					        <li class="dropdown custom-dropdown">
					          <img class="img-responsive img-profile" src="<?php echo $myImg; ?>" data-toggle="dropdown">

					          <ul class="dropdown-menu">
					            <li>
					            	<a href="profile.php?do=Manage&uid=<?php echo $_SESSION['uid']; ?>">
					            		<?php
					            			$fullname = selectItems('FullName', 'users', 'id = ?', array($_SESSION['uid']));
					            			echo $fullname[0]['FullName'];
					            		?>
					            	</a>
					            </li>

					            <?php
						        	if(isset($isAdmin) && $isAdmin == true){  //the user is admin
						        		echo '<li><a class="dashboard" href="admin/index.php">' . @lang('DASHBOARD') . '</a></li>';
									}
								?>

					            <li><a href="settings.php"><?php echo lang('SETTINGS'); ?></a></li>
					            <li role="separator" class="divider"></li>
					            <li><a href="logout.php"> <?php echo lang('LOGOUT'); ?> </a></li>
					          </ul>
					        </li>
				        <?php }?>
				        
				        <li class="search-btn visible-xs"><i class="fa fa-search fa-lg fa-fw"></i></li>
				    </ul>
				      <!-- End The Profile DropDown Menu -->

				    <!-- Start Collecting All Menus That Will be in the button when the screen be for mobiles -->
				    <div class="collapse navbar-collapse" id="target-app">
				    	<!-- Start Menu Btn -->
				    	<ul class="nav navbar-nav navbar-right">
				    		<li class="login-signup">
					        	<!-- show login link if the user dosen't login -->
					        	<?php if(! isset($_SESSION['user'])){?>
									<span title="<?php echo @lang('LOGIN_SIGNUP') ?>"><a href="login.php"><i class="fas fa-sign-in-alt fa-sm fa-fw"></i> <?php echo @lang('LOGIN') ?></a></span>
								<?php }?>
					        </li>

				      	</ul>


				    	<!-- End Menu Btn -->



					    <!-- Start The Titles DropDown Menu -->
				 	     <?php
				 	     	// Get The Titles From The Database							
							$parentTitles = selectItems('id, name', 'titles', 'parent = ? AND visible = ?', array(0, 0), 'ordering DESC'); //parent Categiories
							$childTitles = selectItems('id, name, parent', 'titles', 'parent != ?', array(0));  //Get Child Categories

							//get the id's of the first five parents
							$getIds = array(); //initialize the array
							$counter = 1; //stop the foor loop after 5 iterations
							foreach ($parentTitles as $parentTitle) {
								if($counter > 5) break; else $counter++;
								$getIds[] = $parentTitle['id'];
							?>
								<div class="dropdown navbar-right custom-dropdown">
									 <span id="dLabel" role="button" data-toggle="dropdown" ><?php echo $parentTitle['name']; ?> <i class="fa fa-angle-down"></i></span>

									 <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
									    <?php foreach($childTitles as $childTitle){
									    	if($childTitle['parent'] == $parentTitle['id']){
									    ?>
									    		<li><a href="titles.php?titleid=<?php echo $childTitle['id'] ?>"><?php echo $childTitle['name']; ?></a></li>
									    <?php }}?>
									 </ul>
								</div>

						<?php }
							//display More Menu that holds the rest parent titles
							if(@count($parentTitles) > 5){ ?>
								<div class="dropdown navbar-right custom-dropdown">
									<span id="dLabel" role="button" data-toggle="dropdown" ><?php echo @lang('MORE'); ?> <i class="fa fa-angle-down"></i></span>

									<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
									    <?php foreach($parentTitles as $parentTitle){
									    	if(in_array($parentTitle['id'], $getIds)) continue;
									    ?>
									    		<li><a href="titles.php?titleid=<?php echo $parentTitle['id'] ?>"><?php echo $parentTitle['name']; ?></a></li>
									    <?php }?>
									</ul>
								</div>
						<?php }?>

						

				    	<!-- End The Titles DropDown Menu -->

				    	 <!-- Start The Dashboard Link -->
					    <ul class="nav navbar-nav navbar-right">

					    	<li class="search-btn"><i class="fa fa-search fa-lg fa-fw"></i></li>

					        <?php
					        	if(isset($isAdmin) && $isAdmin == true){
					        		echo '<li><a class="dashboard" href="admin/index.php">' . @lang('DASHBOARD') . '</a></li>';
								}
							?>
					    </ul>
					    <!-- End The Dashboard Link -->

				    </div>
				    <!-- End Collecting All Menus That Will be in the button when the screen be for mobiles -->
				</div>
			</nav>

			<!-- Start lower-nav section -->
			<div class="lower-nav">
				<!-- Search Section -->
				<div class="search">
					<div class="container">
						<form class="form-group" action="search.php" method="GET">
							<div class="custom-input">
								<input 
									class 		 = "form-control" 
									type 		 = "search" 
									name 		 = "search"
									autocomplete = "off"
									placeholder = "<?php echo @lang('PLACE_SEARCH') ?>" 
								>
								<span class="style"></span>
							</div>
						</form>
					</div>
					
				</div>
				<div class="container">

					<!-- Time And Language Section -->
					<div>
						<div class="time-now">
							<div class="navbar-left">
								<i class="far fa-calendar-alt fa-sm fa-fw"></i> <span id="date"></span> |
								<i class="fa fa-history fa-md"></i> <span id="time"></span>
							</div>
						</div>

						<div class="navbar-right lang">
							<a
								id 			= "arabicBtn"
								href 		= "?changeLang=arabic"
								data-value 	= "arabic.css"
							>عربى </a> |
							<a
								id 			= "englishBtn"
								href 		= "?changeLang=english"
								data-value 	= "frontend.css"
							>English</a>
						</div>
					</div>
				</div>
			</div>
			<!-- Ens lower-nav section -->
