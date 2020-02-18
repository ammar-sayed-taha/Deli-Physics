<?php

	//get the date
	// $year = date("Y");

	function lang($phrase = '', $additional = '') {


		$lang = array(

			//Globals
			'WEBSITE_NAME'				=> 'DELI PHYSICS',
			'NO_CHANGE'					=> 'either you didn\'t change anything or failed to connect with the database',
			'PHONE'						=> 'Phone',
			'F_NAME'					=> 'Full Name',
			'USERNAME'					=> 'Username',
			'PASSWORD'					=> 'Password',
			'EMAIL'						=> 'Email',
			'MALE'						=> 'Male',
			'BACK'						=> 'Back',
			'FEMALE'					=> 'Female',
			'BIRTHDATE'					=> 'Birthdate',
			'IMAGE'						=> 'Image',
			'LOCATION'					=> 'Location',
			'WEBSITE'					=> 'Website',
			'OCCUPATION'				=> 'Occupation',
			'BIO' 						=> 'Bio',
			'FACEBOOK' 					=> 'Facebook',
			'TWITTER' 					=> 'Twitter',
			'YOUTUBE' 					=> 'Youtube',
			'INSTA' 					=> 'Instgram',
			'PINTEREST' 				=> 'Pinterst',
			'GOOGLE+' 					=> 'Google+',
			'LINKEDIN' 					=> 'Linkedin',
			'DELETE_COM'				=> 'Delete',
			'REPLY'						=> 'Reply',
			'SEND'						=> 'Send',
			'LOGIN'						=> 'Login',
			'SIGNUP'					=> 'Signup',
			'COMMENT'					=> 'Comment',
			'SEARCH'					=> 'Search',
			'MORE'						=> 'More',
			'VISIBLE'					=> 'show info',
			'REMEMBER_ME'				=> 'Remember Me',
			'IMG_EXCEEDED'				=> 'The image size larger than 10MB',
			'PLACE_SEARCH'				=> 'Type what you wnat and click enter',
			'ERR_DELETE_COM'			=> 'The Comment wasn\'t deleted, oftern probelm of connection with database, try again',
			'META_DESCRIPTION'			=> 'delicious physics, you will find all physics materials of primary, preparatory, secondary years,  very simple explanation for physics material ',
			'META_KEYWORDS'				=> 'physics, materials, video, videos, explanation, explain, primary, preparatory, secondary, lesson, lessons, unit, units, physics material, delicious, delicious physics, good video, good lesson',
			'EMPTY_F_NAME'				=> 'The Fullname field can\'t be empty',
			'INVALID_CHARS'				=> 'only allowed characters (a-z), (A-Z) and (0-9) check your fields and tyr again',


			//Navbar Links
			'DASHBOARD'					=> 'Dashboard',
			'SETTINGS'					=> 'Settings',
			'LOGOUT' 					=> 'Logout',
			'MY_ACCOUNT' 				=> 'My Account',
			'UPPER_NAV_TITLE' 			=> 'Directorate of Education Fayoum',
			'UPPER_NAV_UNDER_T' 		=> 'Senors Educational Administration',


			//dashboard page

			// Start Login Page

			//Global Phrases
			'USER_LESS_3_CHARS'			=> 'the username Must be at Least 3 Characters',
			'PASS_LESS_5_CHARS'			=> 'The Password Must be at Least 5 Characters',
			'EMPTY_USERNAME'			=> 'The Username Can\' be Empty',
			'EMPTY_PASS'				=> 'The Password Can\' be Empty',
			'EMPTY_EMAIL'				=> 'The Email Can\' be Empty',
			'LOGIN_SIGNUP'				=> 'login/Signup',
			'PLACE_FULLNAME'			=> 'fullname appears to users',
			'LOGIN_PLACE_PASS'			=> 'Enter the password',
			'LOGIN_PLACE_UNAME'			=> 'Enter the username - used in login account',
			'ERR_SIGNUP'				=> 'Something wrong happened, please try again in few minuets',

			//Not Global Phrases
			'USER_NOT_RIGTH'			=> 'This Username is not correct',
			'PASS_NOT_RIGHT'			=> 'This password is not correct',
			'EXIST_USERNAME'			=> 'Can\'t Signup This Username is Already Exist',
			'EXIST_USERNAME'			=> 'can\'t insert the account to database please, try again in a few seconds',
			'PHYSICS'					=> 'Physics',


			// End Login Page

			// Start Settings Page
			//Glopal Phrases
			'SETTING_PAGE'				=> 'Settings Page',

			//personal Info
			'PERSONAL_INFO'				=> 'personal info',
			'PLACE_F_NAME'				=> 'Full Name',
			'PLACE_PHONE'				=> 'Type your Phone number',
			'PLACE_F_NAME'				=> 'Type You Full Name',
			'PLACE_USERNAME'			=> 'Username Used to Login Account',
			'PLACE_PASS'				=> 'you can\'t see your password but you can update it',
			'PLACE_EMAIL'				=> 'Email used for notifications and more',
			'INVALID_PASS'				=> 'The password must br larger than <strong>5 characters</strong>',
			'EMPTY_USERNAME'			=> 'The username field can\'t be empty',
			'EMPTY_EMAIL'				=> 'The Email field can\'t be empty',
			'P_INFO_UPDATED'			=> 'The personal information updated successfully!',

			//Additional Info
			'DDITIONAL_INFO'			=> 'Additional Info',
			'PLACE_LOCATION'			=> 'Where are you from ?',
			'PLACE_WEBSITE'				=> 'Do you have website ?',
			'PLACE_BIO'					=> 'Share something about you',
			'PLACE_OCCUPATION'			=> 'Your current job ?',
			'ADD_INFO_UPDATED'			=> 'The Additional information updated successfully!',
			'SOCIAL_INFO_UPDATED'		=> 'The Social information updated successfully!',

			//Social Links
			'SOCIAL_LINKS'				=> 'Social links',
			'PLACE_FACEBOOK'			=> 'Facebook link',
			'PLACE_TWITTER'				=> 'Twitter link',
			'PLACE_YOUTUBE'				=> 'Youtube link',
			'PLACE_INSTA'				=> 'Instagram link',
			'PLACE_PINTEREST'			=> 'Pinterst link',
			'PLACE_GOOGLE+'				=> 'google+ link',
			'PLACE_LINKEDIN'			=> 'Linkedin link',

			// End Settings Page

			// Start Profile Page
			//Global Phrases

			//this phrases from function in functions.php of avatar and cover
			'EMPTY_IMG'					=> 'You Must Add Valid Image',
			'ERR_EXTENSION'				=> 'The Image Extension <strong>' . $additional . '</strong> is not Allowed',
			'ERR_UPLOAD_IMG'			=> 'Something Wrong Happened When Uploading The Image Please Try Again',
			'ERR_IMG_NAME'				=> 'either the image name is too long or faild to connect with the database',

			//Single Phrases
			'PRO_PAGE'					=> 'Profile Page',
			'PRO_PERSONAL_INFO'			=> 'Personal Info',
			'NO_ADDED'					=> 'Nothing added yet!',
			'PRO_ADDITIONAL_INFO'		=> 'Additional info',
			'LAST_COMMENTS'				=> 'Last 10 Comments',
			'NO_COMMENTS_EXIST'			=> 'There is no Comments to Show',
			'SHOW_LESSON_PG'			=> 'Click to Show The Details of This Lesson',

			// End Profile Page

			// Start Titles Page

			'EMPTY_TITLE'				=> 'No lessons added in this folder yet :)',

			// End Titles Page


			// Start Lessons Page

			'NO_SUPPORT_FRAME'			=> 'Sorry your browser does not support inline frames.',
			'NO_SUPPORT_VIDEO'			=> 'Your browser does not support the video tag.',
			'LESSON_COMS'				=> 'Lesson Comments',
			'DOWN_FLASH'				=> 'downloading here',
			'UPDATE_FLASH'				=> 'The Camtasia Studio video content presented here requires a more recent version of the Adobe Flash Player. If you are you using a browser with JavaScript disabled please enable it now. Otherwise, please update your version of the free Flash Player by ',
			'NOT_VALID_FILE'			=> 'the file is no longer exsist or its extension is Not supported',
			'ADD_COMMENT'				=> 'Add Comment',
			'PLACE_COM'					=> 'Your Comment Will Not Appear Untill Approved By The Admin',
			'LOGIN_FIRST'				=> 'Login</a> Or <a href="login.php">Register</a> To Add Comment',
			'COM_FIELD_EMPTY'			=> 'The Comment Field Can\'t Be Empty',
			'COMMENT_ADDED_YES'			=> '<strong>The comment added successfully! But will not appear untill the admin approve on it</strong>',

			// End Lessons Page

			// Start Index Page

			'READ_MORE'					=> 'See More',
			'WHO_AM_I'					=> 'Who am i ?',
			'LAST_LESSONS'				=> 'Last <strong>' . $additional . '</strong> Uploaded Lessons',
			'HOME_MEM'					=> 'Members',
			'HOME_COM'					=> 'Comments',
			'HOME_LESSON'				=> 'Lessons',
			'DEFAULT_THEME'				=> 'Default combination',
			'WHITE_THEME'				=> 'Sun ray',
			'DARK_THEME'				=> 'Dark night',
			'THEME_TITLE'				=> 'Themes',

			// End Index Page

			// Start Footer Page

			'DEV_NAME'					=> 'Ammar Sayed',
			'MADE_WITH'					=> 'Made with',
			'BY'						=> 'by',
			'ALL_RIGHTS'				=> 'All rights reserved',
			'SUPERVISED_BY'				=> 'Supervised by',
			'MR_FARAG'					=> 'Dr.Farag rezk',
			'SUPERVISOR_WORK'			=> 'Professor of Science and Physics',

			// End Footer Page

			//Start Search Page
			'NO_RESULT_SEARCH'			=> 'Ooopps, there is no result for you search',
			
			//End Search Page


		);

		return $lang[$phrase];

	}


?>
