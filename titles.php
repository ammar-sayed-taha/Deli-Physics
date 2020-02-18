<?php
	ob_start();
	session_start();
	$pageTitle = 'Titles Page';

	include_once 'init.php';

	//get the titleid
	$titleid = isset($_GET['titleid']) && is_numeric($_GET['titleid']) ? $_GET['titleid'] : 0;

	//if the titleid == 0 then redirect to index page
	if($titleid == 0){
		header('location: index.php');
		exit();
	}

	//get the name of this title
	$titlePage = selectItems('name', 'titles', 'id = ?', array($titleid));

	//get all titles of this titleid
	$allTitles = selectItems('id, name', 'titles', 'parent = ? AND visible = ?', array($titleid, 0));

	//get all lessons of this titlesid
	$allLessons = selectItems('id, name, file', 'lessons', 'title_id = ? AND visible = ?', array($titleid, 0), 'ordering DESC');

?>
	
	<!-- Set The Page title in title Tag -->
	<span id="pageTitle" hidden><?php echo @$titlePage[0]['name']; ?></span>
 
	<section class="titles">

		<div class="header">
			<!-- just used for overllay -->
			<div class="title-overlay"></div>
			<h1 class="text-center"><?php echo @$titlePage[0]['name']; ?></h1>
		</div>

		<div class="container">

			<!-- display the folders and files -->
			<div class="folder-file">
				<ul class="list-unstyled">
					<li class="grid">
						<span class="back" id="goBack" title="<?php echo @lang('BACK'); ?>"><i class="fa fa-angle-left fa-md fa-fw"></i> <?php echo @lang('BACK'); ?></span>
						
						<span class="grid-icons">
							<i class="fas fa-th-large fa-md fa-fw" data-value="large"></i>
							<i class="fas fa-th fa-md fa-fw active" data-value="small"></i>
						</span>
					</li>
					<!-- Display All Titles  -->
					<?php foreach ($allTitles as $title) {?>
						<a class="folder" href="?titleid=<?php echo $title['id'] ?>" title="<?php echo $title['name'] ?>">
							<li class="text-center">
								<div><img draggable="false" src="layout/images/icons/folder.svg"></div>
								<span class="icon-name"><?php echo $title['name'] ?></span>
							</li>
						</a>
					<?php } ?>

					<!-- Display All Files -->
					<?php foreach ($allLessons as $lesson) {
						//check the extension of the image
						$fileExtension 	= strtolower(pathinfo($lesson['file'], PATHINFO_EXTENSION));
						$fileName 		= getFileIcon($fileExtension); //get the file name
					?>
						<a class="file" href="lessons.php?lessonid=<?php echo $lesson['id'] ?>" title="<?php echo $lesson['name'] ?>">
							<li class="text-center">
								<div><img draggable="false" src="layout/images/icons/<?php echo $fileName ?>" ></div>
								<span class="icon-name"><?php echo $lesson['name'] ?></span>
							</li>
						</a>
					<?php } ?>

					<!-- if the folder empty then print empty message -->
					<?php if(empty($allTitles) && empty($allLessons)){?>
						<div class="alert alert-info text-center"><?php echo @lang('EMPTY_TITLE'); ?></div>
					<?php }?>

				</ul>
			</div>
		</div>
	</section>


<?php
	include_once $tpt_path . 'footer.php';
	ob_end_flush();
?>