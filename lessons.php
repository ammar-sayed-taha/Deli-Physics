<?php
	ob_start();
	session_start();
	$pageTitle = 'Lessons Page';

	include_once 'init.php';

	//used to show the lesson and the comments of it
	$lessonid = isset($_GET['lessonid']) && is_numeric($_GET['lessonid']) ? $_GET['lessonid'] : 0;

	//when the user add new comment then we will need this variable
	$parent 	= isset($_GET['parent']) && is_numeric($_GET['parent'])? filter_var($_GET['parent'], FILTER_SANITIZE_NUMBER_INT) : 0;

	//if the lesson id == 0 then redirect to index page
	if($lessonid == 0){
		header('location: index.php');
		exit();
	}

	/*
	** this function used to update the number of seens for the lesson
	*/
	updateLessonSeen($lessonid);



	//Get the Lesson Data
	$lesson = selectItems('*', 'lessons', 'id = ? AND visible = ?', array($lessonid, 0));
	$fileExtension = ''; //initialize the var to make it global
	if(!empty($lesson))
		$fileExtension = pathinfo($lesson[0]['file'], PATHINFO_EXTENSION); //Get the extension of the file

	//get the admin status to show delete btn of the comment if theis member is admin
	$admin = selectItems('admin', 'users', 'id = ?', array(@$_SESSION['uid']));

	/* Start Deleting Comment */
	if(isset($_GET['lessonDelete']) && $_GET['lessonDelete'] == true){
		//Get the comment id which will be deleted
		$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? $_GET['comid'] : 0;

		$delete = deleteItems('comments', 'id = ?', array($comid));
		if($delete <= 0)
			$formErrors[] = @lang('ERR_DELETE_COM');

	}
	/* End Deleting Comment */

	/* Start Adding Comment Comment */
	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		$comment 	= filter_var(trim($_POST['comment']), FILTER_SANITIZE_STRING);

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
	/* End Adding Comment Comment */



	// Get the Comments of the file
	$parentComments = selectItemsComments('comments.approve = ? AND lessons.id = ? AND parent = ?', array(1, $lessonid, 0));
	$childComments = selectItemsComments('comments.approve = ? AND lessons.id = ? AND parent != ?', array(1, $lessonid, 0));
?>

	<!-- Set The Page title in title Tag -->
	<span id="pageTitle" hidden><?php echo @$lesson[0]['name']; ?></span>

	<!-- Start Comments Section -->
	<div class="container">
		<!-- display the error or success messages -->
		<?php displayMsg(@$formErrors, @$successMsg); ?>
	</div>	

	<section class="lessons">

		<div class="header">
			<!-- just used for overllay -->
			<div class="lesson-overlay"></div>
			<h1 class="text-center"><?php echo @$lesson[0]['name']; ?></h1>
			<div class="under-name">
				<span>
					<span><i class="fa fa-eye fa-md fa-fw"></i> <?php echo @$lesson[0]['seen'] ?> | </span>
					<span><i class="fas fa-history fa-md fa-fw"></i> <?php echo @date('d M Y', @strtotime(@$lesson[0]['add_date'])) ?> | </span>
				
					<?php $member = selectItems('FullName', 'users', 'id = ?',array(@$lesson[0]['member_id'])); ?>
					<a href="profile.php?uid=<?php echo @$lesson[0]['member_id'] ?>"><span><i class="fa fa-user fa-md fa-fw"></i> <?php echo @$member[0]['FullName'] ?></span></a>
				</span>
			</div>

		</div>

		<div class="container">
			
			<div class="back">
				<span id="goBack" title="<?php echo @lang('BACK'); ?>">
					<i class="fa fa-angle-left fa-md fa-fw"></i> <?php echo @lang('BACK'); ?>
				</span>
			</div>
			<div class="files-con">
				<?php 
				switch(@$fileExtension){ 
					case 'doc':
					case 'docx':
					case 'xls':
					case 'xlsx':
					case 'ppt':
					case 'pptx':
					case 'txt': ?>
					<iframe 
							src="<?php echo $lesson[0]['external_file']; ?>" 
							allowfullscreen="true" 
							mozallowfullscreen="true" 
							webkitallowfullscreen="true">
						
							<?php echo '<div class="error-msg">' . @lang('NO_SUPPORT_FRAME') . '</div>'; ?> <!--if the browser not supported -->
						</iframe>

					<?php
					break;

					case 'pdf':
					case 'htm':
					case 'html': ?>
						<iframe 
							src="data/files/<?php echo $lesson[0]['file'] ?>"
							width="960" 
							height="749" 
						>
							<?php echo '<div class="error-msg">' . @lang('NO_SUPPORT_FRAME') . '</div>'; ?> <!--if the browser not supported -->
						</iframe>
					<?php
					break;

					case 'mp4':
					case 'wmv':
					case 'flv':
					case 'avi': ?>
						<video controls="controls" controlslist="nodownload">
							<source src="data/files/<?php echo $lesson[0]['file'] ?>" 
							type="video/<?php echo $fileExtension; ?>">

							<?php echo '<div class="error-msg">' . @lang('NO_SUPPORT_VIDEO') . '</div>'; ?> <!--if the browser not supported -->

						</video>
					<?php
					break;

					case 'png':
					case 'jpg':
					case 'jpeg':
					case 'gif': ?>
						<div><img class="img-responsive img-thumbnail" src="data/files/<?php echo $lesson[0]['file'] ?>"></div>
					<?php
					break;

					case 'swf':?>
						<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="csSWF">
			                <param name="movie" 			value="data/files/<?php echo $lesson[0]['file'] ?>" />
			                <param name="quality" 			value="best" />
			                <param name="allowfullscreen" 	value="true" />
			                <param name="scale" 			value="showall" />
			                <param name="allowscriptaccess" value="always" />
			                <param name="flashvars" value="autostart=false&showstartscreen=true&showendscreen=true" />
			                <!--[if !IE]>-->
			                <object 
			                	type="application/x-shockwave-flash" 
			                	data="data/files/<?php echo $lesson[0]['file'] ?>" 
			                >
			                    <param name="quality" value="best" />
			                    <param name="bgcolor" value="#1a1a1a" />
			                    <param name="allowfullscreen" value="true" />
			                    <param name="scale" value="showall" />
			                    <param name="allowscriptaccess" value="always" />
			                    <param name="clickable" value="true" />
			                    <param name="flashvars" value="autostart=false&showstartscreen=true&showendscreen=true" />
			                <!--<![endif]-->
			                    <div id="noUpdate">
			                        <p>
			                        	<bdi><?php echo @lang('UPDATE_FLASH') ?></bdi>
			                        	<bdi><a href="http://www.adobe.com/go/getflashplayer"><?php echo @lang('DOWN_FLASH') ?></a></bdi>
			                        </p>
			                    </div>
			                <!--[if !IE]>-->
			                </object>
			                <!--<![endif]-->
			            </object>
					<?php
					break;

					default:?>
						
						<?php echo '<div class="error-msg">' . @lang('NOT_VALID_FILE') . '</div>'; ?> <!--if the browser not supported -->

				<?php }?>
				
			</div>

		</div>
	</section>

	<section class="comments">
		<div class="container">
			<div class="com">
				<h2><?php echo @lang('LESSON_COMS') ?></h2>
				<?php if(!empty($parentComments)) {?>
					<div class="com-body">
						<?php foreach($parentComments as $parentComment) { ?>

							<div class="com-container">
								<div class="com-header">
									<?php 
										$memberImg = empty($parentComment['memberImg']) ? 'default.png' : $parentComment['memberImg']; 
										$adminLink = $parentComment['admin'] == 1 ? 'profile.php?do=Manage&uid=' . $parentComment['userID'] : '#';
									?>
									<a href="<?php echo $adminLink; ?>">
										<img src="layout/images/profiles/avatar/<?php echo @$memberImg; ?>">
									</a>
									<span class="com-n">
										<a href="<?php echo $adminLink; ?>">
											<div class="name <?php if($parentComment['admin'] != 0) echo 'admin'; ?>"><?php echo $parentComment['FullName'] ?></div>
										</a>
										<div class="date"><?php echo @date('j M Y', strtotime($parentComment['add_date'])); ?></div>
									</span>
								</div>
								<div class="com-footer">
									<p><?php echo nl2br($parentComment['comment']); ?></p>

									<!-- appear when the parentComment is on its lessons of that session -->
									<div class="under-com">
										<?php  if(isset($_SESSION['uid'])){ 
											if($admin[0]['admin'] == 1) {?>
												<a class="confirm-delete" href="?lessonid=<?php echo @$lessonid; ?>&lessonDelete=true&comid=<?php echo $parentComment['id']; ?>">
													<span><?php echo @lang('DELETE_COM') ?></span>
												</a>
											<?php }
											 } ?>

										<a class="reply-btn" data-value="_<?php echo $parentComment['id'] ?>" href="#">
											<span><?php echo @lang('REPLY') ?></span>
										</a>

									</div>
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
															<a class="confirm-delete" href="?lessonid=<?php echo @$lessonid; ?>&lessonDelete=true&comid=<?php echo $childComment['id']; ?>">
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

											<form action="lessons.php?lessonid=<?php echo $lessonid; ?>&parent=<?php echo $parentComment['id'] ?>" method="POST">
												<div class="">
													<textarea class="form-control" name="comment" placeholder="<?php echo @lang('PLACE_COM') ?>" required></textarea>
												</div>
												<input class="btn btn-primary btn-md" type="submit" value="<?php echo @lang('COMMENT') ?>">
											</form>

										<?php }else{ ?>
												<span class="no-login"><a href="login.php"><?php echo @lang('LOGIN_FIRST') ?></span>
										<?php } ?>
									</div>

								</div>
						 <?php } ?>

					</div>
				<?php }else{
					echo "<h3 class='no-comments text-center'>" . @lang('NO_COMMENTS_EXIST') . "</h3>";
				}?>

				<!-- Add New Comment on The Lesson -->
				<div class="com-now">
					<h3><?php echo @lang('ADD_COMMENT') ?></h3>
					<?php
					//make sure first if the user loged in or not
					if(isset($_SESSION['user'])){?>

						<form action="lessons.php?lessonid=<?php echo $lessonid; ?>&parent=0" method="POST">
							<div class="">
								<textarea class="form-control" name="comment" placeholder="<?php echo @lang('PLACE_COM') ?>" required></textarea>
							</div>
							<input class="btn btn-primary btn-md" type="submit" value="<?php echo @lang('COMMENT') ?>">
						</form>

					<?php }else{ ?>
							<span class="no-login"><a href="login.php"><?php echo @lang('LOGIN_FIRST') ?></span>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>

	<!-- Start Comments Section -->

<?php
	include_once $tpt_path . 'footer.php';
	ob_end_flush();
?>