(function( $ ) {

	// Fixed Header.
	( function() {

		if( $( document ).scrollTop() > 0 ){
			$( '.site-header-main' ).addClass( 'shrink' );
		}

		// Add opacity class to site header
		$( document ).on('scroll', function(){

			if ( $( document ).scrollTop() > 0 ){
				$( '.site-header-main' ).addClass( 'shrink' );

			} else {
				$( '.site-header-main' ).removeClass( 'shrink' );
			}

		});

	} )();

	/**
	 * Test if an iOS device.
	*/
	function checkiOS() {
		return /iPad|iPhone|iPod/.test(navigator.userAgent) && ! window.MSStream;
	}

	/*
	 * Test if background-attachment: fixed is supported.
	 * @link http://stackoverflow.com/questions/14115080/detect-support-for-background-attachment-fixed
	 */
	function supportsFixedBackground() {
		var el = document.createElement('div'),
			isSupported;

		try {
			if ( ! ( 'backgroundAttachment' in el.style ) || checkiOS() ) {
				return false;
			}
			el.style.backgroundAttachment = 'fixed';
			isSupported = ( 'fixed' === el.style.backgroundAttachment );
			return isSupported;
		}
		catch (e) {
			return false;
		}
	}

	// Fire on document ready.
	$( document ).ready( function() {
		if ( true === supportsFixedBackground() ) {
			document.documentElement.className += ' background-fixed';
		}

		if ( ! $('.custom-header').length && ! $('#feature-slider').length ) {
			$( 'body' ).addClass( 'header-media-disabled' );
		}

		/*Fixed Nav on Scroll*/
		var headHeight = $('.site-header-main').outerHeight();

	    var shrinkNav = function(){
			$('.header-media-disabled .below-site-header').css('margin-top', headHeight);
	    }

	    // Call on Load
	    shrinkNav();

	    // Call on Scroll and resize
	    $(window).on('resize', function() {
	        shrinkNav();
	    });
	});

	// Add header video class after the video is loaded.
	$( document ).on( 'wp-custom-header-video-loaded', function() {
		$( 'body' ).addClass( 'has-header-video' );
	});

	jQuery(document).ready(function($) {

	    function initMainNavigation( container ) {
	        // Add dropdown toggle that displays child menu items.
	        var dropdownToggle = $( '<button />', {
	            'class': 'dropdown-toggle',
	            'aria-expanded': false
	        } ).append( $( '<span />', {
	            'class': 'screen-reader-text',
	            text: fotografieScreenReaderText.expand
	        } ) );

	        container.find( '.menu-item-has-children > a' ).after( dropdownToggle );

	        // Toggle buttons and submenu items with active children menu items.
	        container.find( '.current-menu-ancestor > button' ).addClass( 'toggled-on' );
	        container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

	        // Add menu items with submenus to aria-haspopup="true".
	        container.find( '.menu-item-has-children' ).attr( 'aria-haspopup', 'true' );


	        container.find( '.dropdown-toggle' ).click( function( e ) {
	            var _this            = $( this ),
	                screenReaderSpan = _this.find( '.screen-reader-text' );

	            e.preventDefault();
	            _this.toggleClass( 'toggled-on' );
	            _this.next( '.sub-menu' ).toggleClass( 'toggled-on' );

	            // jscs:disable
	            _this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
	            // jscs:enable
	            screenReaderSpan.text( screenReaderSpan.text() === fotografieScreenReaderText.expand ? fotografieScreenReaderText.collapse : fotografieScreenReaderText.expand );
	        } );
	    }

	    //For Secondary Menu
	    $('#menu-bottom-toggle').click(function(){
	        $('.header-bottom-navigation ul.nav-menu').slideToggle();
	    });

	    menuToggleSecondary     = $( '#menu-bottom-toggle' ); // button id
	    siteSecondaryMenu       = $( '#site-header-bottom-menu' ); // wrapper id
	    siteNavigationSecondary = $( '#site-header-bottom-navigation' ); // nav id
	    initMainNavigation( siteNavigationSecondary );

    	// Enable menuToggleSecondary.
	    ( function() {
	        // Return early if menuToggleSecondary is missing.
	        if ( ! menuToggleSecondary.length ) {
	            return;
	        }

	        // Add an initial values for the attribute.
	        menuToggleSecondary.add( siteNavigationSecondary ).attr( 'aria-expanded', 'false' );

	        menuToggleSecondary.on( 'click', function() {
	        	$( this ).add( menuToggleSecondary ).toggleClass( 'toggled-on' );
	            $( this ).add( siteSecondaryMenu ).toggleClass( 'toggled-on' );

	            // jscs:disable
	            $( this ).add( siteNavigationSecondary ).attr( 'aria-expanded', $( this ).add( siteNavigationSecondary ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
	            // jscs:enable
	        } );
	    } )();

	    // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	    ( function() {
	        if ( ! siteNavigationSecondary.length || ! siteNavigationSecondary.children().length ) {
	            return;
	        }

	        // Toggle `focus` class to allow submenu access on tablets.
	        function toggleFocusClassTouchScreen() {
	            if ( window.innerWidth >= 1024 ) {
	                $( document.body ).on( 'touchstart', function( e ) {
	                    if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
	                        $( '.main-navigation li' ).removeClass( 'focus' );
	                    }
	                } );
	                siteNavigationSecondary.find( '.menu-item-has-children > a' ).on( 'touchstart', function( e ) {
	                    var el = $( this ).parent( 'li' );

	                    if ( ! el.hasClass( 'focus' ) ) {
	                        e.preventDefault();
	                        el.toggleClass( 'focus' );
	                        el.siblings( '.focus' ).removeClass( 'focus' );
	                    }
	                } );
	            } else {
	                siteNavigationSecondary.find( '.menu-item-has-children > a' ).unbind( 'touchstart' );
	            }
	        }

	        if ( 'ontouchstart' in window ) {
	            $( window ).on( 'resize', toggleFocusClassTouchScreen );
	            toggleFocusClassTouchScreen();
	        }

	        siteNavigationSecondary.find( 'a' ).on( 'focus blur', function() {
	            $( this ).parents( '.menu-item' ).toggleClass( 'focus' );
	        } );
	    })();

	    $('#site-header-bottom-navigation button.dropdown-toggle').click(function() {
	        $(this).toggleClass('active');
	        $(this).parent().find('.sub-menu').first().slideToggle();
	    });
	});
    //Secondary Menu End

	$(document).ready(function() {
		/*Search and Social Container*/
		$('.header-toggle, .bottom-toggle').on('click', function(e){
			$(this).toggleClass('toggled-on');
		});

		$('#header-search-toggle').on('click', function(){
			$('#header-share-toggle, #header-menu-social, #bottom-search-toggle, #header-bottom-search-container, #bottom-share-toggle, #header-buttom-menu-social').removeClass('toggled-on');
			$('#header-search-container').toggleClass('toggled-on');
		});

		$('#header-share-toggle').on('click', function(e){
			//e.stopPropagation();
			$('#header-search-toggle, #header-search-container, #bottom-search-toggle, #header-bottom-search-container, #bottom-share-toggle, #header-buttom-menu-social').removeClass('toggled-on');
			$('#header-menu-social').toggleClass('toggled-on');
		});

		$('#bottom-share-toggle').on('click', function(){
			$('#bottom-search-toggle, #header-bottom-search-container, #header-share-toggle, #header-menu-social, header-search-toggle, #header-search-container').removeClass('toggled-on');
			$('#header-buttom-menu-social').toggleClass('toggled-on');
		});

		$('#bottom-search-toggle').on('click', function(){
			$('#bottom-share-toggle, #header-buttom-menu-social, #header-share-toggle, #header-menu-social, header-search-toggle, #header-search-container').removeClass('toggled-on');
			$('#header-bottom-search-container').toggleClass('toggled-on');
		});

	});
})( jQuery );
