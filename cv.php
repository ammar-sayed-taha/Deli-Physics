<?php

	ob_start();
	session_start();
	$pageTitle = 'CV Page';
	include_once 'init.php';

	$cvid = isset($_GET['cvid']) && is_numeric($_GET['cvid']) ? $_GET['cvid'] : 0;

	$cv = selectItems('*', 'cv', 'id = ?', array($cvid));

	if(!empty($cv)){
		
		$fileExtension = ''; //initialize the var to make it global
		if(!empty($cv))
			$fileExtension = pathinfo($cv[0]['file'], PATHINFO_EXTENSION); //Get the extension of the file

?>
	
	<section class="cv">
		<div class="container">
			<div>
				<?php
					switch ($fileExtension) {
						case 'pdf': ?>
							<iframe 
								src="data/cv/<?php echo $cv[0]['file'] ?>"
								width="100%" 
								height="749" 
							>
								<?php echo '<div class="error-msg">' . @lang('NO_SUPPORT_FRAME') . '</div>'; ?> <!--if the browser not supported -->
							</iframe>
						<?php
							
							break;
						case 'swf':?>
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="csSWF">
				                <param name="movie" 			value="data/cv/<?php echo $cv[0]['file'] ?>" />
				                <param name="quality" 			value="best" />
				                <param name="allowfullscreen" 	value="true" />
				                <param name="scale" 			value="showall" />
				                <param name="allowscriptaccess" value="always" />
				                <param name="flashvars" value="autostart=false&showstartscreen=true&showendscreen=true" />
				                <!--[if !IE]>-->
				                <object 
				                	type="application/x-shockwave-flash" 
				                	data="data/cv/<?php echo $cv[0]['file'] ?>" 
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
						
						default: ?>
							<?php echo '<div class="error-msg">' . @lang('NOT_VALID_FILE') . '</div>'; ?> <!--if the browser not supported -->

						<?php break;
					}
				?>
			</div>
		</div>
	</section>

<?php
	}else{
		header('location:index.php');
		exit();	
	}
	include_once $tpt_path . 'footer.php';
	ob_end_flush();
?>