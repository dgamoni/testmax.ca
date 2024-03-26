jQuery(document).ready(function($) {
	var menuLink;
	if(jQuery("header .menu .current-menu-item a").length && jQuery("header .menu .current-menu-item a").html() != 'Home') { 
		menuLink = jQuery(".current-menu-item a").html();
		jQuery(".mobile-menu-text ").html(menuLink);
	}else{	
		menuLink = "Menu";   
	}
	if(jQuery( window ).width() <= 850){
		jQuery('.ak-menu-dropdown').addClass('ak-dropdown-menu-item');
	}
	jQuery('#aktrading-contact-form').submit(function (e){
		 e.preventDefault();
		var userEmail = jQuery('#ak-email').val();
		var userName = jQuery('#ak-name').val();
		var userPhone = jQuery('#ak-phone').val();
		var userSubject = jQuery('#ak-subject').val();
		var userMsg = jQuery('#ak-msg').val();
		var userLocation = jQuery('#ak-select-location').val();
		
		var productTitle = jQuery('#email-title').val();
		var productSKU = jQuery('#email-sku').val();
		var productPermalink = jQuery('#email-permalink').val();
		var productID = jQuery('#product-id').text();
		
		
		/*Redirections*/
		var newmarketThankYouPage = jQuery('#newmarket-loacation').val();
		var gtaThankYouPage = jQuery('#gta-loacation').val();
		var mississaugaThankYouPage = jQuery('#mississauga-loacation').val();
		var productThankYouPage = jQuery('#product-loacation').val();
		var pagestatus = jQuery('#page-status').val();
		
		var emailFinalText = 	"Name: " + userName + "\n"
								+ "Email: " + userEmail + "\n"
								+ "Phone: " + userPhone + "\n"
								+ "Message: " + userMsg + "\n";
								
		var emailFinalSubject = "";
		var emailReceiver = "";
		var redirectLink = "";

		if(userLocation ==''){
			userLocation = 'newmarket';
		}
		if(pagestatus == 1){
			if(userLocation == 'newmarket'){
				emailFinalSubject = "New Contact For Newmarket Location";
				emailReceiver = "newmarket@aktrading.org";
				redirectLink = newmarketThankYouPage;
				emailFinalText = emailFinalText + "Subject: " + userSubject + "\n"
												+ "Location: Newmarket";
			}
			else if(userLocation == 'gta') {
				emailFinalSubject = "New Contact For GTA Location";
				emailReceiver = "gta@aktrading.org";
				redirectLink = gtaThankYouPage;
				emailFinalText = emailFinalText + "Subject: " + userSubject + "\n"
												+ "Location: GTA";
			}
			else {
			    emailFinalSubject = "New Contact For Mississauga Location";
				emailReceiver = "sauga@aktrading.org";
				redirectLink = mississaugaThankYouPage;
				emailFinalText = emailFinalText + "Subject: " + userSubject + "\n"
												+ "Location: Mississauga";
			}
		}else{
			emailFinalSubject = "Inquire about: " + productTitle + " SKU: " + productSKU;
			emailReceiver = "inquiry@aktrading.org";
			redirectLink = productThankYouPage;
			emailFinalText = emailFinalText 	+ "Product Title: " + productTitle + "\n"
												+ "Product SKU: " + productSKU + "\n"
												+ "Product ID: " + productID + "\n"
												+ "Product Link: " + productPermalink + "\n";
		}
		if(userEmail != '' &&  userName !=''){  //Req Fields
	    jQuery.ajax({
		  type: 'POST',	 
		  url: aktradingAjaxurl,
			/*data: ({action : 'send_email_action',akmsg:userMsg,akproductid:productID,aklocation:userLocation,aksubject:userSubject,akemail:userEmail,akphone:userPhone,akname:userName}),*/
			data:({action : 'send_email_action', msgsubject:emailFinalSubject, msgtext:emailFinalText, msgreciever:emailReceiver}),
			success: function(html){
				if(html=='1')
				{
					jQuery('.email-error-msg').fadeOut('fast');
					jQuery('.email-succes-msg').html('<img src="http://aktrading.fastserver9.com/wp-content/uploads/2015/01/Loading-Bar.gif"/>');
					jQuery('.email-succes-msg img').fadeIn('fast');
					window.location.href = redirectLink;
				}
				else
				{
					jQuery('.email-error-msg').show();
					jQuery('.email-error-msg').html("Can't send your email");
				}
			}
		  });
		}else{
			jQuery('.email-error-msg').show();
			jQuery('.email-error-msg').html('You must fill the required fields: Name and Email');
		}
	});
	
	
	/* Mobile Menu */
	
	jQuery('.menu-hamburger').click(function(){
		jQuery('.menu .dropdown-menu').fadeOut( "fast");
		jQuery(" header > .menu > ul ").slideToggle();
		if(jQuery("header .menu .current-menu-item a").length && jQuery("header .menu .current-menu-item a").html() != 'Home' ) { 
			menuLink = jQuery(".current-menu-item a").html();   
		}else{	
			menuLink = "Menu";   
		}
		jQuery(".mobile-menu-text ").html(menuLink);
	});
	
	jQuery('.ak-dropdown-menu-item').click(function(e){
		 e.preventDefault();
		jQuery('.menu .dropdown-menu').fadeToggle( "fast");
	});
	
	jQuery('header > .menu > ul > li.menu-item-has-children').click(function(e){
		var screenWidth = jQuery(window).width()
		if(screenWidth>850 && screenWidth<1286)
			jQuery('header > .menu > ul > li.menu-item-has-children').toggleClass("clicked");
	});

  });
  /*****************Slider********************/
  jQuery( document ).ready(function() {
		coinArray = jQuery(".slider .coins").children();
		contentArray = jQuery(".slider .contents").children();
		squaresArray = jQuery(".slider .squares").children();
		var i = 0;
		var indexofcurrent=0;
		function slide(element)
		{
			if(indexofcurrent!=element)
				{
				
					var animationDuration = 800;
					jQuery(contentArray[indexofcurrent]).fadeOut(animationDuration*1.5)
					jQuery(squaresArray[indexofcurrent]).css("height","5px");
					jQuery(squaresArray[indexofcurrent]).css("background-color","#656364");
					jQuery(squaresArray[indexofcurrent]).css("margin-top","0px");
					
					jQuery(squaresArray[element]).css("height","8px");
					jQuery(squaresArray[element]).css("background-color","white");
					jQuery(squaresArray[element]).css("margin-top","-3px");
					setTimeout(function(){
						jQuery(contentArray[element]).fadeIn(animationDuration/4);
						
						indexofcurrent = element;
					}, animationDuration/4);
				}
		}
		for(;i<coinArray.length;i++)
		{
			jQuery(coinArray[i]).on( "click", { value: i }, function( event ) {
				slide(event.data.value);
				clearInterval(timer);
			});
			
			jQuery(squaresArray[i]).on( "click", { value: i }, function( event ) {
				slide(event.data.value);
				clearInterval(timer);
			});
			
		}
		var k=indexofcurrent;
		var timer = setInterval(function() {
			slide(k);
			if(k==coinArray.length-1)
				k=0;
			else
				k++;
		}, 3000)
		
		
		/*var x = jQuery('body').innerWidth();
		var height = (503*x)/1286;
		jQuery(".slider .contents").css("height", height);*/
		var x = jQuery('body').innerWidth();
		var height;
			if(x<1286)
			{
				height = (503*x)/1286;
				jQuery(".slider .contents").css("height", height);
			}
			else
			{
				jQuery(".slider .contents").css("height", 503);
			}
		jQuery( window ).resize(function() {
			x = jQuery('body').innerWidth();
			if(x<1286)
			{
				height = (503*x)/1286;
				jQuery(".slider .contents").css("height", height);
			}
			else
			{
				jQuery(".slider .contents").css("height", 503);
			}
		});
		
	});
  /*************************************/
  
  jQuery(document).ready(function($){
	if(jQuery( window ).width() >= 850){
		jQuery('.ak-menu-dropdown, .dropdown-menu').hover(function($){
			jQuery('.dropdown-menu').show();
		},
		function($){
			jQuery('.dropdown-menu').hide();
		});
	}
  });
	
	jQuery(document).ready(function($){ 
	  jQuery('.zoom').click(function(e){
		e.preventDefault();
		var zoomImg = jQuery(this).find('img');
		var zoomImgUrl = zoomImg.attr('src').replace('-90x90','');
		var photo_fullsize =  zoomImg.attr('src').replace('-90x90','-560x560');
		var loaderUrl = "https://www.aktrading.org/wp-content/uploads/2015/01/Loading-Bar.gif";
		
		jQuery.ajax({
				url:photo_fullsize,
				type:'HEAD',
				error: function()
				{
					jQuery('.woocommerce-main-image img').attr('src', zoomImgUrl);
				},
				success: function()
				{
					jQuery('.woocommerce-main-image img').attr('src', photo_fullsize);
					jQuery('.woocommerce-main-image img').removeAttr('srcset');	
				}
		});	
		});
		
		jQuery('img').bind('contextmenu', function(e) {
			return false;
		}); 
	
	});
	
	//Print
	jQuery(document).ready(function($){
	        jQuery('#ak-print-product').click(function(e){
	            e.preventDefault();
	            window.print();
	        });
	     
	    });
	
	jQuery(document).ready(function($){
		if(jQuery().colorbox) {
			jQuery(".main").colorbox({rel:'main'});
		}
				
				
	});

	
	
	
	