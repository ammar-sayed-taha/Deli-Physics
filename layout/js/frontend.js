$(function(){

	'use strict';

	var win 		= $(window),
		winWidth 	= win.outerWidth(),
		winHeight 	= win.outerHeight();

	// ************** Start Global Scripts **************

	//Turn on The SelectBoxIt Library
	$("select").selectBoxIt({
		theme: "jqueryui",

	    showEffect: "fadeIn",
	    showEffectSpeed: 200,
	    hideEffect: "fadeOut",
	    hideEffectSpeed: 200
	});

	//When the user click on Back Btn then go back to the prevois page
	$('#goBack').click(function() {
		window.history.back();
	});

	//if the input tag is required then do the following

	$('[required]').each(function () {
		$(this).attr('placeholder', $(this).attr('placeholder') + '(Required)');
	});

	/* any id with #pageTitle Chane the title tag with its content */
	if($('#pageTitle')){
		$('title').html($('#pageTitle').html());
	}

	//When Any Button Of Delete is clicked then confirm that item will delete already
	$('.confirm-delete').click(function () {
		return confirm('Are You Sure You Want To Delete ?');
	});

	/* hide error and success maessages after a specific time from displaying */
	$('.error-msg').delay(15000).slideUp(2000);
	$('.success-msg').delay(10000).slideUp(2000);

	//Start Placeholder script
	$('[placeholder]').on("focus", function() {
		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');

	}).on("blur", function () {
		$(this).attr('placeholder', $(this).attr('data-text'));
	});
	//End Placeholder script

	/* Start Navbar Scripting */

	//Make the body padding-top of the same px of the navbar
	var 
		navbar 			= $('.navbar-inverse'),
		navHeight 		= $('.navbar-inverse').outerHeight(),
		upperNav 		= $('.upper-nav'),
		upperNavHeight 	= $('.upper-nav').outerHeight();

	if(upperNavHeight == null) upperNavHeight = 0;

	$('body, .body-container, .search').css('margin-top', navHeight + upperNavHeight);
	navbar.css('top', upperNavHeight);

	var searchBtn 	= $('.navbar .search-btn'),
		searchField = $('.lower-nav .search');

	searchBtn.click(function () {
		searchBtn.toggleClass('active'); //to toggle trhe class from tow seach btns
		searchField.slideToggle();

		if(searchBtn.hasClass('active')){
			$('body, html').animate({scrollTop: 0}, 1000);
		}

	});

	//hide the upper-nav when scrolling
	win.scroll(function () {
		if(win.scrollTop() > upperNavHeight){
			navbar.css({top: 0});
			upperNav.slideUp(310);
			

		}else{
			upperNav.slideDown(250);
			navbar.css({top: upperNavHeight});
		}
	});

	/* End Navbar Scripting */


	// get the local time to print in navbar
	var now 	= new Date(),
		months 	= ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		hours 	= [12, 1,2,3,4,5,6,7,8,9,10,11,12, 1,2,3,4,5,6,7,8,9,10,11];

	$('#date').text(now.getFullYear() + ' ' + months[now.getMonth()] + ' ' + now.getDate());
	$('#time').text(hours[now.getHours()] + ':' + now.getMinutes() + ':' + now.getSeconds());

	setInterval(function() {
		now = new Date();
		$('#time').text(hours[now.getHours()] + ':' + now.getMinutes() + ':' + now.getSeconds());
	}, 1000)
 

	// ************** End Global Scripts **************

	// ******** Start Scripting of Titles Page ***********

	
	var gridIcon 	 		= $('.folder-file .grid .grid-icons i'),
	 	file_folder 		= $('.folder-file a.folder, .folder-file a.file'),
		file_folder_img 	= $('.folder-file .folder img, .folder-file .file img'),
		file_folder_name 	= $('.folder-file .icon-name');

	/*
	** when click on the folder or file one click do nothing
	** but when click double click then open the file or folder
	*/
	file_folder.click(function() {
		if(winWidth > 768) return false;
        else return true;
    }).dblclick(function() {
        window.location = this.href;
        return false;
    });
 

	////when click on grid icons then change the height and width of the files and folders
	gridIcon.click(function() {
		gridIcon.removeClass('active'); //remove the class active from all icons
		if($(this).attr('data-value') == 'large'){
			$(this).addClass('active');
			file_folder_img.css({width: '125px', height: '125px'});
			file_folder_name.addClass('lg-size');
		}else{
			$(this).addClass('active');
			file_folder_img.css({width: '75px', height: '75px'});
			file_folder_name.removeClass('lg-size');
		}
	});

	// ******** End Scripting of Titles Page ***********


	/* When the Avatar Or The Cover of The Profile camera clicked 
	   then show the menu of upload or delete the image
	*/
	$('.avatar-container .camera, .pro-cover .camera').on('click', function() {
		$(this).next('.camera-menu').fadeToggle();
	});

	// ************ Start The Scripting of list menu ************

	//open the list menu of the Titles
	var menu 			= $('.navbar .menu'),
		menuLines 		= $('.navbar .menu span'),
		bodyContainer 	= $('.body-container, .navbar-inverse .container, .upper-nav'),
		bodyOverlay		= $('.body-container .overlay'),
		listMenu 		= $('.list-menu');

	//poen the menu when click on the menu btn
	menu.on('click', function () {
		if(menuLines.hasClass('disable')){
			//do what the overlay calss will do and also remove disable class from themeun to back to its normal shap
			bodyContainer.animate({right:0});
			listMenu.animate({right: '-330px'});
			bodyOverlay.fadeOut();
			menuLines.removeClass('disable');
		}
		else{
			bodyOverlay.fadeIn();
			listMenu.animate({right: 0});
			menuLines.addClass('disable');

			if(winWidth >= 768){
				bodyContainer.animate({right: '315px'});
			}else{
				bodyContainer.animate({right: '288px'});
			}
		}

		
	});

	//close the menu when click on overlay body
	bodyOverlay.on('click', function() {
		$(this).fadeOut();
		bodyContainer.animate({right:0}).removeClass('blur');
		listMenu.animate({right: '-330px'});
		//remove the disable class from menu when click on Overlay
		menuLines.removeClass('disable');
	});

	//change the theme to the color which the user chooses
	$('.list-menu .theme ul li').click(function () {
		$('link[href*="theme"]').attr('href', $(this).attr('data-value'));
        localStorage['theme'] = $(this).attr('data-value');
	});
	


	//open the child Titles when click on the parent
	var parentTitle  = $('.list-menu .parent-title > span:first-child'),
		childTitles  = $('.list-menu .child-title-con');

		parentTitle.on('click', function () {
			childTitles.slideUp(250); //close other childTitles 

			//change the arrow to describe that the menu is closed
			parentTitle.find('i').removeClass('moveSmothy');

			//open this menu and change the arrow
			$(this).find('i').addClass('moveSmothy').end()
					.next('.child-title-con').slideDown(250);
		});

	// ************ End The Scripting of list menu ************


	/************* Start Scripting Login And Signup Forms *************/

	// When Click On Signup or login header do the following
	$('.log-regist span').click(function () {
		$(this).css('color', $(this).attr('data-color')).siblings().css('color', '#b5b5b5');

		$('.' + $(this).attr('data-class')).fadeIn().siblings().fadeOut(0);
	});

	var	input_user 	= $('.login-container input[type=text]'),
		input_pass 	= $('.login-container input[type=password]');

	// Check The Validation Of Login Username
	input_user.on('keyup blur', function () {
		if($(this).val().length < 3){
			$(this).css('borderColor', '#c71a1ac7').next('.style').css('background', '#d0494a').end()
				   .parent().parent().find('.errorMsg').css('display', 'block').fadeIn();
		
		}else{
			$(this).css('borderColor', 'green').next('.style').css('background', 'green').end()
				   .parent().parent().find('.errorMsg').fadeOut();
		}

	});

	// Check The Validation Of Login Password
	input_pass.on('keyup blur', function () {
		if($(this).val().length  < 5){
			$(this).css('borderColor', '#c71a1ac7').next('.style').css('background', '#d0494a').end()
				   .parent().parent().find('.errorMsg').css('display', 'block').fadeIn();
		}else{
			$(this).css('borderColor', 'green').next('.style').css('background', 'green').end()
				   .parent().parent().find('.errorMsg').fadeOut();
		}

	});

	/************ End Scripting Login And Signup Forms *************/



	/* Start Scripting Profile Page */

	//Add The Image To The Avatar image when change the avatar
	$('.avatar-container input[type=file]').on('change', function (event) {
		$("#change-avatar-img").attr('src',URL.createObjectURL(event.target.files[0]));
	});

	//cahnge the cover of the profile when changign the cover
	$('.pro-cover input[type=file]').on('change', function (event) {
		$("#change-cover-img").attr('src',URL.createObjectURL(event.target.files[0]));
	});

	/* End Scripting Profile Page */

	/* Start Scripting of Lessons Page */

	$('.reply-btn').on('click', function() {
		$('html, body').animate({
			scrollTop: $('#' + $(this).attr('data-value')).offset().top - $('.navbar-inverse').outerHeight() * 1.5
		});
	});

	/* End Scripting of Lessons Page */

	/* Start Index Page */

		//Start The Definition Bar Scripting
	var parentDef 		= $('.def-bar'),
		defBar 			= $('.def-bar .bar-word'),
		innerDefBar 	= $('.def-bar .bar-word  ul li:first-of-type'),
		rightDefBar 	= parentDef.outerWidth(),
		timerDefBar 	= null; //used when the user hover on the bar then stop the bar and move otherwise

	defBar.css('right', rightDefBar); //initialize the position of the definition bar


    function checkDefHover() {
      
      	//check the definition bar
      	if(parentDef.offset().left + parentDef.outerWidth() < innerDefBar.offset().left){
			
			rightDefBar = parentDef.outerWidth();
			defBar.css('right', rightDefBar);
		}else{
			rightDefBar -= 1;
			defBar.css('right', rightDefBar);
		}

        startDefBar();        // restart the timerDefBar
    };

    function startDefBar() {  // use a one-off timerDefBar
        timerDefBar = setTimeout(checkDefHover, 10);
    };

    function stopDefBar() {
        clearTimeout(timerDefBar);
    };

    defBar.on('mouseenter', stopDefBar);
    defBar.on('mouseleave', startDefBar);

    startDefBar();  // if you want it to auto-start

    //End The Definition Bar Scripting

    //Start The News Bar Scripting 
    var parentNews 		= $('.news-bar'),
		newsBar 		= $('.news-bar .bar-word'),
		innerNewsBar 	= $('.news-bar .bar-word  ul li:first-of-type'),
		rightNewsBar 	= parentNews.outerWidth(),
		timerNewsBar    = null;//used when the user hover on the bar then stop the bar and move otherwise
		newsBar.css('right', rightNewsBar); //initialize the position of the definition bar


    function checkNewsBar() {

		//check the news bar
		if(parentNews.offset().left + parentNews.outerWidth() < innerNewsBar.offset().left){
			
			rightNewsBar = parentNews.outerWidth();
			newsBar.css('right', rightNewsBar);
		}else{
			rightNewsBar -= 1;
			newsBar.css('right', rightNewsBar);
		}

        startNewsBar();        // restart the timerNewsBar
    };

    function startNewsBar() {  // use a one-off timerNewsBar
        timerNewsBar = setTimeout(checkNewsBar, 10);
    };

    function stopNewsBar() {
        clearTimeout(timerNewsBar);
    };

    newsBar.on('mouseenter', stopNewsBar);
    newsBar.on('mouseleave', startNewsBar);

    newsBar.hide(0).delay(2000).show(0, startNewsBar);  // if you want it to auto-start)

    //End The News Bar Scripting 

    //fix the news-bar when its offset become on the top of the page
 //    var carousel = $('.carousel-head');
 //    win.scroll(function() {
 //    	if(carousel.offset().top + carousel.outerHeight() <= $(this).scrollTop() + navHeight){
 //    		parentNews.addClass('fixed').css('top', navHeight);
 //    	}else{
 //    		parentNews.removeClass('fixed').css('top', 0);
 //    	}
 //    });

 //    //without scroll
 //    if(carousel.offset().top + carousel.outerHeight() <= $(this).scrollTop() + navHeight){
	// 	parentNews.addClass('fixed').css('top', navHeight);
	// }else{
	// 	parentNews.removeClass('fixed').css('top', 0);
	// }

	/* End Index Page */

	


});