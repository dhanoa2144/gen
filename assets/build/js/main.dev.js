jQuery( document ).ready( function( $ ) {
	initMobileNav();

	// Activate Popper.js tooltips.
	// $( '[data-toggle="tooltip"]' ).tooltip();

	// Filter toggle
	let acc = document.getElementsByClassName( 'gc-filter-header' );

	for ( let i = 0; i < acc.length; i++ ) {
		acc[i].addEventListener( 'click', function( e ) {
			e.stopImmediatePropagation();
			e.preventDefault();

			/* Toggle between adding and removing the "active" class,
			to highlight the button that controls the panel */
			this.classList.toggle( 'active' );

			/* Toggle between hiding and showing the active panel */
			let panel = this.nextElementSibling;
			let list = panel.getElementsByClassName( 'gc-filter-menu' )[0];

			list.style.maxHeight = ( '0px' != list.style.maxHeight ) ? '0px' : list.scrollHeight + 'px';
		});
	}

	jQuery( '.mini-cart__icon' ).hover(
		function() {
			jQuery( '.mini-cart__card' ).addClass( 'show' );
		},
		function() {
			jQuery( '.mini-cart__card' ).removeClass( 'show' );
		}
	);

	let slider = document.getElementById( 'front-slider' );
	jQuery( '#front-slider' ).slick({		
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: true,
		adaptiveHeight: false,
		prevArrow: '<span class="previous"><i class="icon far fa-angle-left"></i></span>',
		nextArrow: '<span class="next"><i class="icon far fa-angle-right"></i></span>',
		responsive: [
			{
				breakpoint: 992,
				settings: {
					arrows: false,
					dots: true
				}
			}
		]
	});

	jQuery( '.accordion .row .btn-container .btn-wrapper button').each( function() {
		jQuery( this ).on( 'click', function() {
			jQuery( this ).parent().parent().parent().children( '.content-container' ).toggle( 'slow' );
		});
	});

	jQuery( '.acf-map' ).each( function() {
		var map = initMap( jQuery( this ) );
	});

	jQuery( '.archive .card .stretched-link' ).on( 'click', function( e ) {
		var params = window.location.search.substring( 1 ),
			filters = params.replace( 'filter=', '' ),
			filterArr = filters.split( '!' ),
			filterString = 'filter=';
		e.preventDefault();

		filterArr.forEach( element => {
			let arr = element.split( ':' );
			if ( arr[0] == 'location' || arr[0] == 'study_mode' ) {
				filterString += arr[0] + ':' + arr[1] + ':' + arr[2] + '!';
			}
		});
		filterString.slice( 0, -1 );

		window.location = jQuery( this ).attr( 'href' ) + '?' + filterString;
	});
});

jQuery( window ).load( function( $ ) {
	testimonialHeightAdjust();
	featuredCoursesHeightAdjust();
});

function initMobileNav() {
	let links = document.querySelectorAll( '#mobile-nav li.menu-item-has-children > a' );
	Array.prototype.slice.call( links ).forEach( function( menuItem ) {

		let submenuToggleElement = document.createElement( 'a' );
		submenuToggleElement.setAttribute( 'href', '#' );

		const submenuToggleElementClasses = 'btn btn-white text-secondary sub-menu-toggle mr-1 px-3 py-1'.split( ' ' );
		submenuToggleElementClasses.forEach( function( submenuToggleElementClass ) {
			submenuToggleElement.classList.add( submenuToggleElementClass );
		});

		let toggleContent = document.createElement( 'span' );
		const toggleContentClasses = 'fas fa-chevron-down'.split( ' ' );
		toggleContentClasses.forEach( function( toggleContentClass ) {
			toggleContent.classList.add( toggleContentClass );
		});

		submenuToggleElement.appendChild( toggleContent );

		menuItem.appendChild( submenuToggleElement );
	});

	jQuery( '.toggle-nav' ).on( 'click', function() {
		document.body.classList.toggle( 'show-mobile-nav' );
	});

	jQuery( '.sub-menu-toggle' ).on( 'click', function() {
		jQuery( this ).toggleClass( 'sub-menu-toggle-active' );
		jQuery( this ).parent( 'a' ).next( '.sub-menu' ).slideToggle();
	});
}

function testimonialHeightAdjust() {
	let testimonials = jQuery( document.getElementsByClassName( 'testimonial-card' ) );
	var maxHeight = testimonials.children().first().delay( 400 ).height();

	testimonials.each( function() {
		if ( jQuery( this ).height() > maxHeight ) {
			maxHeight = jQuery( this ).height();
		}
	});

	testimonials.each( function() {
		jQuery( this ).children().height( maxHeight );
	});
}

function featuredCoursesHeightAdjust() {
	let testimonials = jQuery( document.getElementsByClassName( 'featured-cards' ) );
	var maxHeight = testimonials.children().first().delay( 400 ).height();

	testimonials.each( function() {
		if ( jQuery( this ).height() > maxHeight ) {
			maxHeight = jQuery( this ).height();
		}
	});

	testimonials.each( function() {
		jQuery( this ).children().height( maxHeight );
	});
}
