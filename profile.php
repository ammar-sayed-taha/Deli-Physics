<?php
	ob_start();
	session_start();
	$pageTitle = "Profile Page";

	include_once 'init.php';

	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';	

	if($do == 'Manage'){

		$uid = isset($_GET['uid'])  && is_numeric($_GET['uid']) ? $_GET['uid'] : 0;

		$myprofile = selectItems('*', 'users', 'id = ' . $uid);

		//if this user is not admin then redirect to homepage
		if($myprofile[0]['admin'] == 0){
			header('location:index.php');
			exit();
		}

		/*
		  Get The social media links of this profile
		*/
		$socialLinks = selectItems('*', 'social_links', 'member_id = ' . $uid);
		if(!empty($socialLinks)){

			//get the social Media Links
			@$facebook 		= @$socialLinks[0]['facebook'];
			@$youtube  		= @$socialLinks[0]['youtube'];
			@$twitter 		= @$socialLinks[0]['twitter'];
			@$instagram 	= @$socialLinks[0]['instagram'];
			@$pintrest 		= @$socialLinks[0]['pintrest'];
			@$googleplus 	= @$socialLinks[0]['googleplus'];
			@$linkedin 		= @$socialLinks[0]['linkedin'];

		}

		/* Start checking if this profile of the user then change cover or avatar */
		if(isset($_SESSION['uid']) && @$_SESSION['uid'] == $uid){

			//if the user will update the avatar or the cover image
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				// Changing The Cover Image Profile

				if(@$_POST['changeCover'])
					$formErrors = uploadImg($_FILES, $myprofile, 'cover', $_SESSION['uid']);
				// Changing The Avatar Image Profile
				elseif(@$_POST['changeAvatar'])
					$formErrors = uploadImg($_FILES, $myprofile, 'image', $_SESSION['uid']);

				if(empty($formErrors) && (isset($_POST['changeCover']) || isset($_POST['changeAvatar']))){  //refresh the page to update the image in navbar section
					header('location:profile.php?uid=' . $uid);
					exit();
				}
			}

			//if the user need to delete the avatar or the cover image
			elseif(isset($_GET['delete'])) {
				// Deleting The Cover Image
				if($_GET['delete'] == 'cover')
					$formErrors = deleteImg($myprofile, 'cover', $_SESSION['uid']);
				// Deleting The Avatar Image
				elseif($_GET['delete'] == 'avatar')
					$formErrors = deleteImg($myprofile, 'image', $_SESSION['uid']);

				if(empty($formErrors)){  //refresh the page to update the image in navbar section
					header('location:profile.php?uid=' . $uid);
					exit();
				}
			}			
		}
		/* End checking if this profile of the user then do the following */

		/* Start Deleting Comment */
		if(isset($_GET['deleteComment']) && $_GET['deleteComment'] == true){
			//Get the comment id which will be deleted
			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? $_GET['comid'] : 0;

			$delete = deleteItems('comments', 'id = ?', array($comid));
			if($delete <= 0)
				$formErrors[] = @lang('NO_CHANGE');

		}
		/* End Deleting Comment */

		/* Start Adding The comments */

		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])){
			$comment 	= filter_var(trim($_POST['comment']), FILTER_SANITIZE_STRING);
			//when the user add new comment then we will need this variable that tell us which parent of this comment
			$parent 	= isset($_GET['parent']) && is_numeric($_GET['parent'])? filter_var($_GET['parent'], FILTER_SANITIZE_NUMBER_INT) : 0;
			$lessonid 	= isset($_GET['lessonid']) && is_numeric($_GET['lessonid'])? filter_var($_GET['lessonid'], FILTER_SANITIZE_NUMBER_INT) : 0;


			$formErrors = array();  //initialize ForErrors array
			if(empty($comment)) $formErrors[]  = @lang('COM_FIELD_EMPTY');
			
			if(empty($formErrors)){
				$approve = $parent != 0 ? 1 : 0; //if the parent comment is approved then the child comment also approved
				$addComment = insertItems('comments', 'comment, add_date, member_id, lesson_id, parent, approve',
								'?, NOW(), ?, ?, ?, ?',
								array($comment, @$_SESSION['uid'], $lessonid, $parent, $approve));
				if($parent == 0) //show the message only for the parent comments
					$addComment > 0 ? $successMsg = @lang('COMMENT_ADDED_YES') : $formErrors[] = @lang('NO_CHANGE');

			}
		}

		/* End Adding The comments */

		/*if there is no data selected for this $uid 
		this means this $uid is not in data base then redirect this page to home page */

		if(!empty($myprofile)){  //if not empty then print the profile

			//Get The Last 10 Comments On Items For This Profile
			$latestComments = 10;
			$parentComments = selectItemsComments('comments.approve = ? AND lessons.member_id = ? AND comments.parent = ?', array(1, $uid, 0), NULL, $latestComments);
			//the reply comments
			$childComments = selectItemsComments('comments.approve = ? AND lessons.member_id = ? AND parent != ?', array(1, $uid, 0));

		?>
			<!-- Set The Page title in title Tag -->
			<span id="pageTitle" hidden><?php echo  @lang('PRO_PAGE') . ' | ' . $myprofile[0]['FullName']; ?></span>
 

			<section class="pro">
				<div class="container">
					<!-- display the error or success messages -->
					<?php displayMsg(@$formErrors, @$successMsg); ?>

					<div class="pro-cover">
						<?php 
							// $coverImg = selectItems('cover', 'users', 'userID = ' . $uid);
							$cover = empty($myprofile[0]['cover']) ? 'default.jpg' : $myprofile[0]['cover']; ?>
						<div class="img-con"><img id ="change-cover-img" src="layout/images/profiles/cover/<?php echo @$cover; ?>"></div>

						<!-- Start The Cover Camera Icon And Its Menu -->
						<?php if(isset($_SESSION['uid']) && @$_SESSION['uid'] == $myprofile[0]['id']){ ?>
							<span class="camera"><i class="fa fa-camera" title="Upload or delete the cover"></i></span>
							<div class="camera-menu">
								<span class="change-img">
									<form action="<?php echo $_SERVER['PHP_SELF'] . '?uid='. $uid ;?>" method="POST" enctype="multipart/form-data">
										<div>
											<input type="file" name="image" title="upload image">
											<span><i class="fa fa-camera fa-fw"></i> Change</span>
										</div>

										<div>
											<input class="btn btn-default" type="submit" name="changeCover" value="Upload">
											<span><i class="fa fa-upload fa-fw"></i> Upload</span>
										</div>
									</form>
								</span>
								<a class="confirm-delete" href="<?php echo $_SERVER['PHP_SELF'] ?>?delete=cover&uid=<?php echo $uid; ?>"><div title="delete image"><i class="fa fa-times fa-fw"></i> Delete</div></a>
							</div>
						<?php }?>
						<!-- End The Cover Camera Icon And Its Menu -->

					</div>
		
					<div class="pro-avatar">
						<div class="avatar">
							<div class="avatar-container">
								<?php 
									$avatar = empty($myprofile[0]['image']) ? 'default.png' : $myprofile[0]['image']; ?>
								<img id="change-avatar-img" src="layout/images/profiles/avatar/<?php echo @$avatar; ?>">

								<!-- Start The Avatar Camera Icon And Its Menu -->
								<?php if(isset($_SESSION['uid']) && @$_SESSION['uid'] == $myprofile[0]['id']){ ?>
									<span class="camera"><i class="fa fa-camera" title="Upload or delete the avatar"></i></span>
									<div class="camera-menu">
										<span class="change-img">
											<form action="<?php echo $_SERVER['PHP_SELF'] . '?uid='. $uid ;?>" method="POST" enctype="multipart/form-data">
												<div>
													<input type="file" name="image" title="upload image">
													<span><i class="fa fa-camera fa-fw"></i> Change</span>
												</div>
												<div>
													<input class="btn btn-default" type="submit" name="changeAvatar" value="Upload">
													<span><i class="fa fa-upload fa-fw"></i> Upload</span>
												</div>
											</form>
										</span>
										<a class="confirm-delete" href="<?php echo $_SERVER['PHP_SELF'] ?>?delete=avatar&uid=<?php echo $uid; ?>"><div title="delete image"><i class="fa fa-times fa-fw"></i> Delete</div></a>
									</div>
								<?php }?>
								<!-- End The Avatar Camera Icon And Its Menu -->
							</div>
						</div>
						<div class="avatar-info">
							<ul class="list-unstyled">
								<li><?php 
									echo $myprofile[0]['FullName'];

									if(@$uid == @$_SESSION['uid'])
										echo '<a href="settings.php?#personal-info"><i class="fa fa-edit fa-fw fa-xs" title="Edit"></i></a>';
								?></li>

								<li>
									<span class="links">
										<a <?php if(!empty($facebook)) echo 'href="' . $facebook . '"'; else echo 'disabled'; ?> target="_blank" >
											<span class="facebook"><i class="fab fa-facebook-square fa-lg fa-fw"></i></span>
										</a>
										<a <?php if(!empty($youtube)) echo 'href="' . $youtube . '"'; else echo 'disabled'; ?> target="_blank">
											<span class="youtube"><i class="fab fa-youtube fa-lg fa-fw"></i></span>
										</a>
										<a <?php if(!empty($twitter)) echo 'href="' . $twitter . '"'; else echo 'disabled'; ?> target="_blank">
											<span class="twitter"><i class="fab fa-twitter fa-lg fa-fw"></i></span>
										</a>
										<a <?php if(!empty($instagram)) echo 'href="' . $instagram . '"'; else echo 'disabled'; ?> target="_blank">
											<span class="instagram"><i class="fab fa-instagram fa-lg fa-fw"></i></span>
										</a>
										<a <?php if(!empty($pintrest)) echo 'href="' . $pintrest . '"'; else echo 'disabled'; ?> target="_blank">
											<span class="pintrest"><i class="fab fa-pinterest fa-lg fa-fw"></i></span>
										</a>
										<a <?php if(!empty($googleplus)) echo 'href="' . $googleplus . '"'; else echo 'disabled'; ?> target="_blank">
											<span class="googleplus"><i class="fab fa-google-plus fa-lg fa-fw"></i></span>
										</a>
										<a <?php if(!empty($linkedin)) echo 'href="' . $linkedin . '"'; else echo 'disabled'; ?> target="_blank">
											<span class="linkedin"><i class="fab fa-linkedin fa-lg fa-fw"></i></span>
										</a>

									</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</section>

			<section class="pro-body">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<div class="info">
								<h3 class="b-info"><?php echo @lang('PRO_PERSONAL_INFO') ?></h3>
								<div>
									<div>
										<span><?php echo @lang('F_NAME') ?></span>
										<span><?php echo !empty($myprofile[0]['FullName']) ? $myprofile[0]['FullName'] : @lang('NO_ADDED'); ?> </span>
									</div>
									<div>
										<span><?php echo @lang('EMAIL') ?></span>
										<span><?php echo !empty($myprofile[0]['Email']) ? $myprofile[0]['Email'] : @lang('NO_ADDED'); ?></span>
									</div>
									<div>
										<span><?php echo @lang('PHONE') ?></span>
										<span><?php 
											if(!empty($myprofile[0]['phone'])) echo $myprofile[0]['phone'];
											else echo @lang('NO_ADDED');
										?></span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="info additional-info">
								<h3 class="b-info"><?php echo @lang('PRO_ADDITIONAL_INFO') ?></h3>
								<div>
									<div>
										<span><?php echo @lang('LOCATION') ?></span>
										<span><?php 
											if(!empty($myprofile[0]['location'])) echo $myprofile[0]['location'];
											else echo @lang('NO_ADDED');
										?></span>
									</div>

									<div>
										<span><?php echo @lang('WEBSITE') ?></span>
										<span><?php 
											if(!empty($myprofile[0]['website'])) echo $myprofile[0]['website'];
											else echo @lang('NO_ADDED');
										?></span>
									</div>

									<div>
										<span><?php echo @lang('OCCUPATION') ?></span>
										<span><?php 
											if(!empty($myprofile[0]['occupation'])) echo $myprofile[0]['occupation'];
											else echo @lang('NO_ADDED');
										?></span>
									</div>

									<div class="bio">
										<span>Bio:</span>
										<span class="inner-bio"><?php 
											if(!empty($myprofile[0]['bio'])) echo $myprofile[0]['bio'];
											else echo @lang('NO_ADDED');
										?></span>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="com">
						<h2><?php echo @lang('LAST_COMMENTS') ?></h2>
						<?php if(!empty($parentComments)) {?>
							<div class="com-body">
								<?php foreach($parentComments as $parentComment){ ?>

									<div class="com-container">
										<div class="com-header">
											<?php $memberImg = empty($parentComment['memberImg']) ? 'default.png' : $parentComment['memberImg']; ?>
											<a href="?do=Manage&uid=<?php echo $parentComment['userID']; ?>">
												<img src="layout/images/profiles/avatar/<?php echo @$memberImg; ?>">
											</a>
											<span class="com-n">
												<a href="?do=Manage&uid=<?php echo $parentComment['userID']; ?>">
													<div class="name <?php if($parentComment['admin'] != 0) echo 'admin'; ?>"><?php echo $parentComment['FullName'] ?></div>
												</a>
												<div class="date"><?php echo @date('j M Y', strtotime($parentComment['add_date'])); ?></div>
											</span>
											<a href="lessons.php?do=Manage&lessonid=<?php echo $parentComment['id_lesson']; ?>">
												<span class="lesson-n" title="<?php echo @lang('SHOW_LESSON_PG') ?>"><?php echo $parentComment['lesson_name']; ?></span>
											</a>
										</div>
										<div class="com-footer">
											<p><?php echo nl2br($parentComment['comment']); ?></p>

											<!-- appear when the parentComment is on its lessons of that session -->
											<?php 
												if(isset($_SESSION['uid'])){ ?>
													<div class="under-com">
														<a class="confirm-delete" href="?uid=<?php echo @$uid; ?>&lessonDelete=true&comid=<?php echo $parentComment['id']; ?>">
															<span class="delete"><?php echo @lang('DELETE_COM') ?></span>
														</a>
													</div>
											<?php } 
											?>
										</div>

										<?php
										// Display the child Comments
											foreach($childComments as $childComment){
												if($childComment['parent'] == $parentComment['id']){?>

													<div class="child-com">
														<div class="com-header">
															<?php 
																$memberImg = empty($childComment['memberImg']) ? 'default.png' : $childComment['memberImg']; 
																$adminLink = $childComment['admin'] == 1 ? 'profile.php?do=Manage&uid=' . $childComment['userID'] : '#';
															?>
															<a href="<?php echo $adminLink; ?>">
																<img src="layout/images/profiles/avatar/<?php echo @$memberImg; ?>">
															</a>
															<span class="com-n">
																<a href="<?php echo $adminLink; ?>">
																	<div class="name <?php if($childComment['admin'] != 0) echo 'admin'; ?>"><?php echo $childComment['FullName'] ?></div>
																</a>
																<div class="date"><?php echo @date('j M Y', strtotime($childComment['add_date'])); ?></div>
															</span>
														</div>
														<div class="com-footer">
															<p><?php echo nl2br($childComment['comment']); ?></p>

															<!-- appear when the childComment is on its lessons of that session -->
															<div class="under-com">
																<?php  if(isset($_SESSION['uid'])){ 
																	//if the user is admin or the owner of the comment then he can delete it
																	if($admin[0]['admin'] == 1 || $childComment['member_id'] == $_SESSION['uid']) {?>
																		<a class="confirm-delete" href="?lessonid=<?php echo @$lessonid; ?>&deleteComment=true&comid=<?php echo $childComment['id']; ?>&uid=<?php echo $uid; ?>">
																			<span><?php echo @lang('DELETE_COM') ?></span>
																		</a>
																	<?php }	
																	 } ?>
																	<a class="reply-btn" data-value="_<?php echo $parentComment['id'] ?>" href="#">
																		<span><?php echo @lang('REPLY') ?></span>
																	</a>

															</div>
														</div>
													</div>

										<?php 	}
											}?>

											<!-- reply Comment will apprear under every parent comment -->
											<div class="add-reply com-now" id="_<?php echo $parentComment['id'] ?>">
												<?php
												//make sure first if the user loged in or not
												if(isset($_SESSION['user'])){?>

													<form action="profile.php?lessonid=<?php echo $parentComment['id_lesson']; ?>&parent=<?php echo $parentComment['id'] ?>&uid=<?php echo @$uid; ?>" method="POST">
														<div>
															<textarea class="form-control" name="comment" placeholder="<?php echo @lang('PLACE_COM') ?>" required></textarea>
														</div>
														<input class="btn btn-primary btn-md" type="submit" value="Comment">
													</form>

												<?php }else{ ?>
														<span class="no-login"><a href="login.php"><?php echo @lang('LOGIN_FIRST') ?></span>
												<?php } ?>
											</div>

									</div>

								<?php }?>

							</div>
						<?php }else{
							echo "<h3 class='no-comments text-center'>" . @lang('NO_COMMENTS_EXIST') . "</h3>";
						}?>
					</div>
				</div>
			</section>


		<?php

		}else{
			header('location:index.php');
			exit();
		}

	}else{
		
		header('Location:index.php');
		exit();
	}


?>


<?php 
	include_once $tpt_path . 'footer.php';
	ob_end_flush();
?>