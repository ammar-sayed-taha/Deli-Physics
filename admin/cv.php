<?php

	ob_start();
	session_start();

	$pageTitle = 'CV Page';

	if(isset($_SESSION['username'])){

		include_once 'init.php';

		$do = isset($_GET['do'])? $_GET['do'] : 'Manage';

		if($do == 'Manage'){

			//check if the user needs to delete a cv file
			if(isset($_GET['delete']) && $_GET['delete'] == 'delete'){
				//check if the cv id is valid
				$cvid = isset($_GET['cvid']) && is_numeric($_GET['cvid']) ? $_GET['cvid'] : 0;
				//delete the file from the folder before remove the lesson itself
				$file = selectItems('file', 'cv', 'id = ' . $cvid);
				if(!empty($file[0]['file'])){
					//remove the file
					if(file_exists('../data/cv/' . $file[0]['file'])){
						@unlink('../data/cv/' . $file[0]['file']);
					}
				}
				//delete the cv from the Batabase
				$stmt = $con->prepare('DELETE FROM cv WHERE id = ?');
				$stmt->execute(array($cvid));

				$stmt->rowCount() < 0 ? $formErrors[] = @lang('DELETE_CV_NO') : $successMsg = @lang('DELETE_CV_YES');
			}

			/*
			** check if the user clicked on the header panel 
			** to sort the data of the panel body based on what is in array
			*/
			$sortBy = 'id DESC'; //initialize the sort variable to select from the table based on it
			if(isset($_GET['sort']) && !empty($_GET['sort'])){
				$sortArray = array('id DESC', 'name ASC');
				if(in_array($_GET['sort'], $sortArray)) $sortBy = $_GET['sort'];
			}

			$allCVs = selectItems('*', 'cv', 1, array(), $sortBy);
		?>
				
			<!-- design the table which contains  the Comments -->
			<section>
				<div class="container">
					<h1 class="text-center"><?php echo @lang('MANAGE_CV'); ?></h1>
					<!-- display the error or success messages -->
					<?php displayMsg(@$formErrors, @$successMsg); ?>

					<div class="add-new-btn">
						<a href="?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> 
							<?php echo @lang('ADD_NEW_CV'); ?>
						</a>
					</div>

					<div class="table-responsive">

						<?php
							if(!empty($allCVs)){?>
								<table class="manage-table text-center table table-bordered">
									<tr>

										<td><a href="?sort=id DESC" title="<?php echo @lang('SORT_BAR_BY_ID') ?>">#ID</a></td>
										<td><a href="?sort=name ASC" title="<?php echo @lang('SORT_CV_BY_NAME') ?>"><?php echo @lang('TABLE_NAME') ?></a></td>
										<td><?php echo @lang('LINK') ?></td>
										<td><?php echo @lang('TABLE_CONTROL') ?></td>
									</tr>

									<?php 
										foreach($allCVs as $cv){
									?>

									<tr>
										<td><?php echo @$cv['id'] ?></td>
										<td class="description"><?php echo @$cv['name'] ?></td>
										<td class="description"><?php echo '&lt;a href="cv.php?cvid=' . @$cv['id'] . '" target="_blank"&gt;' . @$cv['name'] . '&lt;/a&gt;'; ?></td>
										<td class="control">
											<a href="cv.php?do=Edit&cvid=<?php echo $cv['id']; ?>" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit</a>
											<a href="cv.php?delete=delete&cvid=<?php echo $cv['id']; ?>" class="btn btn-danger btn-xs confirm-delete"><i class="fa fa-times"></i> Delete</a>
										</td>
									</tr>
									<?php
										}
									?>
							
								</table>
							<?php }else{
								echo "<div class = 'alert alert-info text-center'><h4>There is no CV files To Show</h4></div>";
							}
						?>
					</div>			
				</div>
			</section>


		<?php

		}elseif($do == 'Add'){  //Add Page
			
			/*
			** when the user clicked on add new comment btn then Enter in POST request
			*/
			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				$name 			= @filter_var(trim(@$_POST['name']), FILTER_SANITIZE_STRING);
				$fileName		= @$_FILES['file']['name'];
				$fileSize		= @$_FILES['file']['size'];
				$fileTemp		= @$_FILES['file']['tmp_name'];
				$fileExtension 	= strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
				$CVExtensions 	= array('pdf', 'swf');
		
				$formErrors = array();  //initialize ForErrors array
				if(empty($name)) 								$formErrors[]  	= @lang('CV_NAME_EMPTY');
				if($fileSize > 100*1024*1024)					$formErrors[]	= @lang('CV_SIZE_EXCEEDED');
				if(!in_array($fileExtension, $CVExtensions))	$formErrors[] 	= @lang('CV_INVAILD_EXTENSION');
				
				if(empty($formErrors)){
					$newName = encFileName($fileExtension); //just take the extension of the file and add random name for it
					$filePath = "../data/cv/" . $newName; // The Path Which Upload The file To

					if(move_uploaded_file($fileTemp, $filePath)){   //upload the image

						$addCV = insertItems('cv', 'name, file', '?, ?', array($name, $newName));
		
						$addCV > 0 ? $successMsg = @lang('CV_ADDED') : $formErrors[] = @lang('NO_CHANGE');
					}else{
						$formErrors[] = @lang('INVALID_UPLOAD');
					}
				}
			}
		?>

		<section>
			<!-- just to change the title tag content with this -->
			<span id="pageTitle" hidden="">CV Page | Add New CV</span>
			<h1 class="text-center"><?php echo lang('ADD_CV') ?></h1>	
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
						<div class="edit-form form-group">
							<!-- display the error or success messages -->
							<?php displayMsg(@$formErrors, @$successMsg); ?>

							<form action ='?do=Add' method="POST" enctype="multipart/form-data">

								<!-- Start Bar Sentence  Input -->
								<div class="input-container">
									<div class="col-sm-2"><label><?php echo @lang('CV_NAME'); ?></label></div>
									<div class="col-sm-10 ">
										<div class="custom-input">
											<input 
												class 		= "form-control" 
												name 		= "name" 
												type 		= "text"
												placeholder = "<?php echo @lang('PALCE_NAME_FIELD') ?>" 
												value 		= "<?php echo @$name; ?>"
												required 	=  "required"
												autofocus
											></input>

											<span class="style"></span>
										</div>
									</div>
								</div>
								<!-- End Bar Sentence  Input -->

								<!-- Start CV File Input -->
								<div class="input-container ">
									<div class="col-sm-2"><label><?php echo @lang('UPLOAD_CV_FILE'); ?></label></div>
									<div class="col-sm-10 ">
										<div class="custom-input">
											<input 
												class 			= "form-control input-lg" 
												type 			= "file" 
												name 			= "file" 
												title 			= "<?php echo lang('UPLOAD_CV') ?>"
												required 		= "required"
											>
											<span class="style"></span>
										</div>
										<div class="note"><?php echo @lang('NOTE_CV_EXTENSION'); ?></div>
									</div>
								</div>
								<!-- End CV File Input -->

								<input class="btn btn-primary btn-block btn-lg" type="submit" value="<?php echo @lang('ADD') ?>">
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>

		<?php
		}elseif($do == 'Edit'){

			$cvid = isset($_GET['cvid']) && is_numeric($_GET['cvid']) ? $_GET['cvid'] : 0;

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				$name 			= filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
				$fileName 		= @$_FILES['file']['name'];
				$fileTemp 		= @$_FILES['file']['tmp_name'];
				
				$formErrors = array();  //initialize ForErrors array
				/* if the used added new file then check the size and extension */
				if(!empty($fileName)){
					$fileSize 		= @$_FILES['file']['size'];
					$fileExtension 	= strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
					$CVExtensions 	= array('pdf', 'swf');
					
					if($fileSize > 100*1024*1024)					$formErrors[]	= @lang('CV_SIZE_EXCEEDED');
					if(!in_array($fileExtension, $CVExtensions))	$formErrors[] 	= @lang('CV_INVAILD_EXTENSION');
				}

				if(empty($formErrors)){
					
					//check if the lesson is exist or not to know how to deal with file of the image
					$cvExist = selectItems('file', 'cv', 'id = ?', array($cvid));

					if(!empty($cvExist)){

						//if the user changed the file of the lesson then remove the old and upload the new one
						if(!empty($fileName)){

							$newName = encFileName($fileExtension); //encrypt the name of the file to stor it in DB
							$filePath = "../data/cv/" . $newName; // The Path Which Upload The file To

							if(@move_uploaded_file($fileTemp, $filePath)){   //upload the file
								
								//remove the old file before adding the new one
								if(file_exists('../data/cv/' . $cvExist[0]['file'])){
									@unlink('../data/cv/' . $cvExist[0]['file']);
								}

								//update the data of the lesson
								$updateCV = updateItems('cv', 'name = ?, file = ?', array($name, $newName, $cvid), 'id = ?');
								$updateCV > 0 ? $successMsg = @lang('CV_UPDATED') : $formErrors[] = @lang('NO_CHANGE'); 
							}else{
								$formErrors[] = @lang('INVALID_UPLOAD');
							}
						}else{
							//update the data of the lesson
							$updateCV = updateItems('cv', 'name = ?', array($name, $cvid), 'id = ?');
							$updateCV > 0 ? $successMsg = @lang('CV_UPDATED') : $formErrors[] = @lang('NO_CHANGE'); 
						}

					}else{
						$formErrors[] = @lang('ERR_CVID');
					}
				}
			}
			$cv = selectItems('*', 'cv', 'id = ?', array($cvid));
			if(!empty($cv)){
		?>

				<section>
					<!-- just to change the title tag content with this -->
					<span id="pageTitle" hidden="">CV Page | <?php echo @$cv[0]['name'] ?></span>
					<h1 class="text-center"><?php echo lang('EDIT_CV') ?></h1>	
					<div class="container">
						<div class="row">
							<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
								<div class="edit-form form-group">
									<!-- display the error or success messages -->
									<?php displayMsg(@$formErrors, @$successMsg); ?>

									<form action ='?do=Edit&cvid=<?php echo @$cvid ?>' method="POST" enctype="multipart/form-data">

										<!-- Start Bar Sentence  Input -->
										<div class="input-container">
											<div class="col-sm-2"><label><?php echo @lang('CV_NAME'); ?></label></div>
											<div class="col-sm-10 ">
												<div class="custom-input">
													<input 
														class 		= "form-control" 
														name 		= "name" 
														type 		= "text"
														placeholder = "<?php echo @lang('PALCE_NAME_FIELD') ?>" 
														value 		= "<?php echo @$cv[0]['name']; ?>"
														required 	=  "required"
														autofocus
													></input>

													<span class="style"></span>
												</div>
											</div>
										</div>
										<!-- End Bar Sentence  Input -->

										<!-- Start CV File Input -->
										<div class="input-container ">
											<div class="col-sm-2"><label><?php echo @lang('UPLOAD_CV_FILE'); ?></label></div>
											<div class="col-sm-10 ">
												<div><?php echo $cv[0]['file'] ?></div>
												<div class="custom-input">
													<input 
														class 			= "form-control input-lg" 
														type 			= "file" 
														name 			= "file" 
														title 			= "<?php echo lang('UPLOAD_CV') ?>"
													>
													<span class="style"></span>
												</div>
												<div class="note"><?php echo @lang('NOTE_CV_EXTENSION'); ?></div>
											</div>
										</div>
										<!-- End CV File Input -->

										<input class="btn btn-primary btn-block btn-lg" type="submit" value="<?php echo @lang('EDIT') ?>">
									</form>
								</div>
							</div>
						</div>
					</div>
				</section>

		<?php
			}else{
				echo '<div class="container"><div class="error-msg">' . @lang('ERR_CVID', $cvid) .'</div></div>';
			}

		}else{
			header('location:comments.php');
			exit();
		}


		include_once  $tpt_path . 'footer.php';


	}else{
		header('location:index.php');
		exit();
	}

	ob_end_flush();