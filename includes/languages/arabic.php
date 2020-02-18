<?php

	//get the date
	// $year = date("Y");

	function lang($phrase = '', $additional = '') {


		$lang = array(

			//Globals
			'WEBSITE_NAME'				=> 'الفيزياء اللذيذة',
			'NO_CHANGE'					=> 'اما انك لم تغير شيئا او هناك مشكلة فى الاتصال بقاعدة البيانات ',
			'PHONE'						=> 'رقم الهاتف ',
			'F_NAME'					=> 'الاسم بالكامل ',
			'USERNAME'					=> 'اسم المستخدم ',
			'PASSWORD'					=> 'الرقم السرى ',
			'EMAIL'						=> ' البريد الالكترونى',
			'MALE'						=> 'ذكر',
			'BACK'						=> 'رجوع',
			'FEMALE'					=> 'انثى',
			'BIRTHDATE'					=> 'تارخ الميلاد',
			'IMAGE'						=> 'الصورة',
			'WEBSITE'					=> 'موقعى الخاص ',
			'LOCATION'					=> 'الموقع',
			'OCCUPATION'				=> 'العمل',
			'BIO' 						=> 'من انا؟',
			'FACEBOOK' 					=> 'Facebook',
			'TWITTER' 					=> 'Twitter',
			'YOUTUBE' 					=> 'Youtube',
			'INSTA' 					=> 'Instgram',
			'PINTEREST' 				=> 'Pinterst',
			'GOOGLE+' 					=> 'Google+',
			'LINKEDIN' 					=> 'Linkedin',
			'DELETE_COM'				=> 'حذف',
			'REPLY'						=> 'رد',
			'SEND'						=> 'إرسال',
			'LOGIN'						=> 'تسجيل',
			'SIGNUP'					=> 'انشاء',
			'COMMENT'					=> 'تعليق ',
			'SEARCH'					=> 'بحث  ',
			'MORE'						=> 'المزيد ',
			'VISIBLE'					=> 'عرض المعلومات ',
			'REMEMBER_ME'				=> 'تذكرنى ',
			'PLACE_SEARCH'				=> 'اكتب ما تريد واضغط Enter ...',
			'IMG_EXCEEDED'				=> 'حجم الصورة اكبر من 10MB ',
			'ERR_DELETE_COM'			=> 'لم يتم حذف التعليق, غالبا مشكلة فى الاتصال بقاعدة البيانات حاول مجددا',
			'META_DESCRIPTION'			=> 'الفيزياء اللذيذة من اسهل المواقع اللتى تجد فيها شروحات لمنهج الفيزياء لجميع المراحل ابتدائى اعدادى و ثانوى منهج دروس وفيديوهات شرح للفيزياء',
			'META_KEYWORDS'				=> 'الفيزياء, فيزياء, لذيذة, اللذيذة, شرح, شروحات, فيديو, فيديوهات, درس, دروس, مادة, مادة الفيزياء, ابتدائى , اعدادى, ثانوي, الابتدائية, الاعدادية, الثانوية, درس, دروس, درس فيزياء, مادة, مادة فيزياء, علوم, مادة العلوم, شرح علوم, درس علوم, دروس علوم, وحدة, وحداة, الص, الصف الابتدائى, الصف الاعدادى , الصف الثانوى, فيزياء الثانوية العامة, ثانوية , عامة',
			'EMPTY_F_NAME'				=> 'عليك ان تضيف اسمك الثنائى او الثلاثى  ',
			'INVALID_CHARS'				=> 'الحروف الوحيدة المسموحة للادخال هى (a-z) و (A-Z) و (0-9) تفقد خانات الادخال وحاول مجددا ',

			//Navbar Links
			'DASHBOARD'					=> 'لوحة التحكم ',
			'SETTINGS'					=> 'الاعدادات',
			'LOGOUT' 					=> 'خروج',
			'MY_ACCOUNT' 				=> 'حسابى ',
			'UPPER_NAV_TITLE' 			=> 'مديرية التربية والتعليم بالفيوم',
			'UPPER_NAV_UNDER_T' 		=> 'ادارة سنورس التعليمية',


			//dashboard page

			// Start Login Page

			//Global Phrases
			'USER_LESS_3_CHARS'			=> 'اسم المستخدم يجب ان يكون على الاقل 3 احرف',
			'PASS_LESS_5_CHARS'			=> 'الرقم السرى يجب ان يكون على الاقل 5 حروف',
			'EMPTY_USERNAME'			=> 'يجب ادخال اسم المستخدم ',
			'EMPTY_PASS'				=> ' يجب ادخال الرقم السرى',
			'EMPTY_EMAIL'				=> ' يجب ادخال البريد الالكترونى',
			'LOGIN_SIGNUP'				=> 'تسجيل/انشاء حساب' ,
			'PLACE_FULLNAME'			=> 'الاسم اللذى سيعرفك به الاخرون  ',
			'LOGIN_PLACE_PASS'			=> 'ادخل الرقم السرى  ',
			'LOGIN_PLACE_UNAME'			=> 'ادخل اسم المستجدم - تحتاجه للدخول الى حسابك  ',
			'ERR_SIGNUP'				=> 'حدثت مشكله اثناء انشاء الحساب رجاءا حاول مرة اخرى لاحقا',

			//Not Global Phrases
			'USER_NOT_RIGTH'			=> 'اسم المستخدم غير صحيح',
			'PASS_NOT_RIGHT'			=> 'الرقم السرى غير صحيح ',
			'EXIST_USERNAME'			=> 'اسم المستخدم موجود بالفعل استخدم غيره',
			// 'PHYSICS'					=> 'الفيزياء',


			// End Login Page

			// Start Settings Page
			//Glopal Phrases
			'SETTING_PAGE'				=> 'صفحة الاعدادات',

			//personal Info
			'PERSONAL_INFO'				=> 'معلومات شخصيه',
			'PLACE_F_NAME'				=> 'الاسم بالكامل',
			'PLACE_PHONE'				=> 'ادخل رقم الهاتف',
			'PLACE_F_NAME'				=> 'ادخل اسمك كاملا',
			'PLACE_USERNAME'			=> 'اسم المستخدم ضرورى للدخول الى حسابك',
			'PLACE_PASS'				=> 'لا يمكنك رؤية الرقم السرى للحماية ولكن يمكنك تعديله',
			'PLACE_EMAIL'				=> 'البريد الالكنرونى يستخدم فى المراسلة مع الاخرين',
			'INVALID_PASS'				=> 'الرقم السرى يجب ان يكون اكبر من <strong>5 حروف</strong>',
			'EMPTY_USERNAME'			=> 'يجب اضافة اسم المستخدم ',
			'EMPTY_EMAIL'				=> 'البريد الالكترونى لايمكن ان يكون فارغا',
			'P_INFO_UPDATED'			=> 'تم تحديث المعلومات الشخصية بنجاح ',

			//Additional Info
			'DDITIONAL_INFO'			=> 'معلومات اضافيه',
			'PLACE_LOCATION'			=> 'من اين انت ؟',
			'PLACE_BIO'					=> 'شارك شيئا عنك ',
			'PLACE_OCCUPATION'			=> 'ماذا تعمل حاليا ؟',
			'ADD_INFO_UPDATED'			=> 'تم تحديث المعلومات الاضافية بنجاح ',
			'SOCIAL_INFO_UPDATED'		=> 'تم تحديث معلومات التواصل الاجتماعى بنجاح ',

			//Social Links
			'SOCIAL_LINKS'				=> 'التواصل الاحتماعى',
			'PLACE_FACEBOOK'			=> 'Facebook رابط',
			'PLACE_TWITTER'				=> 'Twitter رابط',
			'PLACE_YOUTUBE'				=> 'Youtube رابط',
			'PLACE_INSTA'				=> 'Instagram رابط',
			'PLACE_PINTEREST'			=> 'Pinterst رابط',
			'PLACE_GOOGLE+'				=> 'google+ رابط',
			'PLACE_LINKEDIN'			=> 'Linkedin رابط',

			// End Settings Page

			// Start Profile Page
			//Global Phrases

			//this phrases from function in functions.php of avatar and cover
			'EMPTY_IMG'					=> 'يجب اضافة صورة صحيحة',
			'ERR_EXTENSION'				=> 'امتداد الصورة  <strong>' . $additional . '</strong> غير مسموح',
			'ERR_UPLOAD_IMG'			=> 'Something Wrong Happened When Uploading The Image Please Try Again',
			'ERR_IMG_NAME'				=> 'اما ان اسم الصورة طويل جدا او  هناك مشكلة فى الاتصال بقاعدة البيانات ',

			//Single Phrases
			'PRO_PAGE'					=> 'الصفحة الشخصية',
			'PRO_PERSONAL_INFO'			=> 'معلومات خاصة',
			'NO_ADDED'					=> 'لم يتم الاضافة بعد ',
			'PRO_ADDITIONAL_INFO'		=> 'معلومات اضافيه',
			'LAST_COMMENTS'				=> 'اخر 10 تعليقات',
			'NO_COMMENTS_EXIST'			=> 'ليس هناك تعليقات لعرضها',
			'SHOW_LESSON_PG'			=> 'اضغط للذهاب اللى الدرس',

			// End Profile Page

			// Start Titles Page

			'EMPTY_TITLE'				=> 'لم يتم اضافة دروس فى هذا المجلد بعد  :) ',

			// End Titles Page


			// Start Lessons Page

			'NO_SUPPORT_FRAME'			=> 'معتذر هذا المتصفح لا يدعم هذا الفريم رجاء تحديث المتصفح او استخدم غيره',
			'NO_SUPPORT_VIDEO'			=> 'متصفحك لا يدعم خاصية الفيديو رجاء تحديثه او استخدم غيره',
			'LESSON_COMS'				=> 'التعليقات',
			'DOWN_FLASH'				=> 'التحميل من هنا',
			'UPDATE_FLASH'				=> 'نحتاج اللى احدث اصدار من adobe flash player',
			'NOT_VALID_FILE'			=> 'اما ان الملف غير متاح حاليا او ان امتداده غير مدعوم ',
			'ADD_COMMENT'				=> 'اضف تعليقك',
			'PLACE_COM'					=> 'سيتم مراجعة تعليقك بواسطة الادمن قبل ظهوره',
			'LOGIN_FIRST'				=> 'تسجيل دخول </a> | <a href="login.php">انشاء حساب</a> لاضافة تعليقك',
			'COM_FIELD_EMPTY'			=> 'لايمكن ارسال تعليق فارغ اضف تعليك اولا',
			'COMMENT_ADDED_YES'			=> '<strong>تم اضافة التعليق بنجاح لكن لن يضهر حتى يتم مراجعته من خلال الادمن</strong>',

			// End Lessons Page

			// Start Index Page

			'READ_MORE'					=> 'اقراء التفاصيل',
			'WHO_AM_I'					=> 'من انا ؟',
			'LAST_LESSONS'				=> 'ااخر ما تم رفعه مؤخرا',
			'HOME_MEM'					=> 'الاعضاء',
			'HOME_COM'					=> 'التعليقات',
			'HOME_LESSON'				=> 'الدروس',
			'DEFAULT_THEME'				=> 'المزيج الافتراضى ',
			'WHITE_THEME'				=> 'سطوع الشمس ',
			'DARK_THEME'				=> 'الوضع الليلى ',
			'THEME_TITLE'				=> 'سيمات ',

			// End Index Page

			// Start Footer Page

			// End Footer Page

			//Start Search Page
			'NO_RESULT_SEARCH'			=> 'لا يوجد نتائج لهذا البحث حاول  بصيغة اخرى ',
			
			//End Search Page



		);

		return $lang[$phrase];

	}


?>
