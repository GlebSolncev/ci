/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/
;( function( $, window, document, undefined ) {
	'use strict';
	
	var cssTransitionSupport = function() {
			var s = document.body || document.documentElement, s = s.style;
			if( s.WebkitTransition == '' ) return '-webkit-';
			if( s.MozTransition == '' ) return '-moz-';
			if( s.OTransition == '' ) return '-o-';
			if( s.transition == '' ) return '';
			return false;
		},

		isCssTransitionSupport = cssTransitionSupport() === false ? false : true,

		cssTransitionTranslateX = function(element, positionX, speed) {
			var options = {}, prefix = cssTransitionSupport();
			options[ prefix + 'transform' ]	 = 'translateX(' + positionX + ')';
			options[ prefix + 'transition' ] = prefix + 'transform ' + speed + 's linear';
			element.css(options);
		},

		hasTouch	= ( 'ontouchstart' in window ),
		hasPointers = window.navigator.pointerEnabled || window.navigator.msPointerEnabled,
		wasTouched	= function(event) {
			if(hasTouch)
				return true;

			if( !hasPointers || typeof event === 'undefined' || typeof event.pointerType === 'undefined' )
				return false;

			if( typeof event.MSPOINTER_TYPE_MOUSE !== 'undefined' ) {
				if( event.MSPOINTER_TYPE_MOUSE != event.pointerType )
					return true;
			}
			else
				if( event.pointerType != 'mouse' )
					return true;

			return false;
		},
		overlayOn = function(options) {
			var overlay = $('<div id="imagelightbox-overlay"></div>');
			overlay.appendTo( 'body' );
			// Append navigation arrows
			if (options.navigation_arrows) {
				$('body').append($('<a href="#"><span></span></a>').addClass(options.prev_class));
				$('body').append($('<a href="#"><span></span></a>').addClass(options.next_class));
				// Show nav arrows
				var slide_selector = '.lightbox';
				var slides_count = $(slide_selector).length;
				if (slides_count > 1) {
					var arrows =  $('body').find('.'+options.prev_class+', .'+options.next_class);
					setTimeout(function() { arrows.fadeIn(500) }, 1000);
				}
			}
			// Append close button
			$('body').append($('<div><span>Close</span></div>').addClass('imagelightbox-close'));
			setTimeout(function() { $('.imagelightbox-close').animate({ opacity: 1 }, 500) }, 1000);
		},
		overlayOff = function(options) {
			$('#imagelightbox-overlay').remove();
			$('.imagelightbox-close').remove();
			$('body').find('.'+options.prev_class+', .'+options.next_class).remove();
		};
		
	$.fn.imageLightbox = function( options ) {
		var options	   = $.extend({
						 	selector:		'id="imagelightbox"',
						 	allowed_types:	'png|jpg|jpeg|gif',
						 	animation_speed:	250,
							viewport_fill: 0.95,
							navigation_arrows: true,
							prev_class: 'prev-arrow',
							next_class: 'next-arrow',
						 	preload_next:	true,
						 	enable_keyboard:	true,
						 	quit_on_end:		false,
						 	quit_on_img_click: false,
						 	quit_on_doc_click: true,
						 	on_start:		false,
						 	on_end:			false,
						 	on_load_start:	false,
						 	on_load_end:		false
						 },
						 options ),

			targets		= $([]),
			target		= $(),
			source		= $(),
			wrap = $(),
			image		= $(),
			PinchZoom = {},
			imageWidth	= 0,
			imageHeight = 0,
			swipeDiff	= 0,
			inProgress	= false,
			opened = false,
			disable_slide = false,

			isTargetValid = function(element)	{
				return $(element).prop('tagName').toLowerCase() == 'a' && (new RegExp('\.(' + options.allowed_types + ')$', 'i' )).test($(element).attr( 'href' ));
			},
			
			// Add pinch and double-tap/double-click zoom capability
			addZoomControler = function() {
				if($('div').hasClass('pinch-zoom-container') === false) {
					$('.imagelightbox-wrap').each(function () {
						PinchZoom = new RTP.PinchZoom($(this), {});
					});
				}
			},

			setImage = function(resize) {
				var screenWidth	 = $(window).width(),
						screenHeight = $(window).height(),
						tmpImage 	 = new Image(),
						imageScale = 1,
						imageRatio = 1,
						viewportRatio = screenWidth / screenHeight;
				
				if(image.length) {
					tmpImage.src	= image.attr('src');
				} else if(source.length) {
					tmpImage.src	= $(source).prop('src');
				}

				if(tmpImage.src) {
					tmpImage.onload = function() {
						imageWidth	 = tmpImage.width;
						imageHeight	 = tmpImage.height;
						imageRatio	= imageWidth / imageHeight;
					
						// Calculate scale based on orientation
						if(viewportRatio > imageRatio) {
							imageScale = screenHeight * options.viewport_fill / imageHeight;
						} else {
							imageScale = screenWidth * options.viewport_fill / imageWidth;
						}
						
						var params = { 
							'opacity': 1 ,
							'width' : imageWidth * imageScale,
							'height' : imageHeight * imageScale,
							'top' : ((screenHeight - (imageHeight * imageScale)) / 2) + $(window).scrollTop() + 'px',
							'left' : (screenWidth - (imageWidth * imageScale)) / 2 + 'px'
						};
						
						if(resize) {
							wrap.css(params);
						}
							
						if (!opened) {
							wrap.css({
								'width'	: source.width,
								'height': source.height,
								'top'	: $(source).offset().top,
								'left'	: $(source).offset().left
							});
							$('body').css({ 'overflow-y': 'hidden' });
							if(!resize) $('.product-img-box img:first').animate({ 'opacity' : 0 }, 50);
							$('#imagelightbox-overlay').animate({opacity: 1}, 250, function(){});
							wrap.animate(params, 500, function() {
								inProgress = false;
								if(options.on_load_end !== false) options.on_load_end();
								addZoomControler();
							});
							opened = true;
						}
					}
				};
				
				$('body').find('.'+options.prev_class+', .'+options.next_class).css('visibility', 'visible');
				if(targets.index(target) == 0) { // hide left arrow nav
					$('body').find('.'+options.prev_class).css('visibility', 'hidden');
				}
				if(targets.index(target) >= targets.length-1) { // hide right arrow nav
					$('body').find('.'+options.next_class).css('visibility', 'hidden');
				}
			},

			loadImage = function(direction) {
				if(inProgress) return false;
				
				direction = typeof direction === 'undefined' ? false : direction == 'left' ? 1 : -1;
				
				$('body').css('overflow-x','hidden');
				
				if(image.length) {
					if( direction !== false && ( targets.length < 2 || ( options.quit_on_end === true && ( ( direction === -1 && targets.index( target ) == 0 ) || ( direction === 1 && targets.index( target ) == targets.length - 1 ) ) ) ) ) {
						quitLightbox();
						return false;
					}
					var params = { 'opacity': 0 };
					if( isCssTransitionSupport ) cssTransitionTranslateX( image, ( 100 * direction ) - swipeDiff + 'px', options.animation_speed / 1000 );
					else params.left = parseInt( image.css( 'left' ) ) + 100 * direction + 'px';
					image.animate( params, options.animation_speed, function(){ removeImage(); });
					swipeDiff = 0;
				}

				inProgress = true;
				if( options.on_load_start !== false ) options.on_load_start();
				
				if(!opened) {
					wrap.css({ 
						opacity : 1,
						visibility: 'visible',
						backgroundImage : 'url('+$(source).attr("src")+')',
						backgroundSize : 'contain',
						backgroundPosition : '50%'
					});
				}
				setImage();
				wrap.addClass('spinner');
				
				setTimeout( function() {
					image = $('<img ' + options.selector + ' />');
					image.css('opacity', 0);
					image.attr('src', target.attr('href'));
					wrap.append(image);

					image.load(function() {
						image.css('opacity', 0);
						wrap.append(image);

						if(!opened) {
							overlayOn(options);
							$('body').on('click', '.'+options.prev_class, function(e){ 
								slideImage(e, 'left');
							});
							$('body').on('click', '.'+options.next_class, function(e){ 
								slideImage(e, 'right');
							});
							$('.imagelightbox-close').on('click', function() {
								quitLightbox();
								return false;
							});
							$('.product-img-box figure').removeClass('spinner');
						}

						var params = { 'opacity': 1 };

						if(isCssTransitionSupport) {
							cssTransitionTranslateX( wrap, -100 * direction + 'px', 0 );
							setTimeout( function(){ cssTransitionTranslateX( wrap, 0 + 'px', options.animation_speed / 1000 ) }, 50 );
						} else {
							var imagePosLeft = parseInt( wrap.css( 'left' ) );
							params.left = imagePosLeft + 'px';
							wrap.css( 'left', imagePosLeft - 100 * direction + 'px' );
						}
						setImage();
						wrap.removeClass('spinner');
						image.animate(params, options.animation_speed, function() {
							inProgress = false;
							wrap.css('background-image', 'none');
							if(options.on_load_end !== false) options.on_load_end();
						});
						if(options.preload_next) {
							var nextTarget = targets.eq( targets.index( target ) + 1 );
							if( !nextTarget.length ) nextTarget = targets.eq( 0 );
							$('<img />').attr('src', nextTarget.attr('href')).load();
						}
						setImage(true);
					})
					.error(function() {
						if(options.on_load_end !== false) options.on_load_end();
					})

					var swipeStart	 = 0,
						swipeEnd	 = 0,
						imagePosLeft = 0;
							
					image.on( hasPointers ? 'pointerup MSPointerUp' : 'click', function( e ) {
						if(disable_slide) return true;
						if (!e.touches) { e = e.originalEvent; }
						e.preventDefault();
						if( options.quit_on_img_click ) {
							quitLightbox();
							return false;
						}
						if(wasTouched(e)) return true;
					})
					.on( 'touchstart pointerdown MSPointerDown', function(e) {
						if(disable_slide) return true;
						if (!e.touches) { e = e.originalEvent; }
						if(!wasTouched(e) || options.quit_on_img_click) return true;
						if(isCssTransitionSupport) imagePosLeft = parseInt(image.css('left'));
						swipeStart = e.pageX || e.touches[0].pageX;
					})
					.on( 'touchmove pointermove MSPointerMove', function(e) {
						if(!wrap.hasClass('disable-slide')){
							disable_slide = false;
						}
						if(disable_slide) return true;
						if (!e.touches) { e = e.originalEvent; }
						if( !wasTouched( e ) || options.quit_on_img_click ) return true;
						e.preventDefault();
						swipeEnd = e.pageX || e.touches[ 0 ].pageX;
						swipeDiff = swipeStart - swipeEnd;
						if( isCssTransitionSupport ) cssTransitionTranslateX( image, -swipeDiff + 'px', 0 );
						else image.css( 'left', imagePosLeft - swipeDiff + 'px' );
					})
					.on( 'touchend touchcancel pointerup pointercancel MSPointerUp MSPointerCancel', function(e) {
						// Detect when pinchzoom.js is in use
						if(disable_slide || wrap.hasClass('disable-slide')){
							disable_slide = true;
							return true;
						} else {
							disable_slide = false;
						}
						if (!e.touches) { e = e.originalEvent; }
						if( !wasTouched( e ) || options.quit_on_img_click ) return true;
						if( Math.abs( swipeDiff ) > 50 ) {
							target = targets.eq( targets.index( target ) - ( swipeDiff < 0 ? 1 : -1 ) );
							if( !target.length ) target = targets.eq( swipeDiff < 0 ? targets.length : 0 );
							loadImage( swipeDiff > 0 ? 'right' : 'left' );	
						} else {
							if( isCssTransitionSupport ) cssTransitionTranslateX( image, 0 + 'px', options.animation_speed / 1000 );
							else image.animate({ 'left': imagePosLeft + 'px' }, options.animation_speed / 2 );
						}
					});
					
					setTimeout(function(){$('body').css('overflow-x','')},500);
				}, options.animation_speed + 100 );
			},

			removeImage = function() {
				if( !image.length ) return false;
				image.remove();
				image = $();
			},
			
			slideImage = function(e, direction) {
				e.preventDefault();
				if(inProgress) return false;
				inProgress = false;
				if( options.on_start !== false ) options.on_start();
				var next_target = (direction == 'left') ? $(targets.eq(targets.index(target) - 1)) : $(targets.eq(targets.index(target) + 1));
				if(next_target.attr('href') == target.attr('href')) {
					target = (direction == 'left') ? $(targets.eq(targets.index(target) - 2)) : $(targets.eq(targets.index(target) + 2));
				} else {
					target = next_target;
				}
				source = e.target;
				loadImage(direction);
			},

			quitLightbox = function() {
				$('.imagelightbox-wrap').remove();
				opened = false;
				disable_slide = false;
				$('.product-img-box img:first').animate({ 'opacity' : 1 }, 250);
				removeImage();
				inProgress = false;
				if( options.on_end !== false ) options.on_end();
				overlayOff(options);
				$('body').css({ 'overflow-y': 'scroll' });
			},

			getTargets = function(el) {
				targets	= $([]);
				el.each(function() {
					if(!isTargetValid(this)) return true;
					targets = targets.add($(this));
				});
				
				if($(".more-views")[0] && $(targets[0]).hasClass('lightbox') && !$('.more-views').hasClass('no-swap')) targets = targets.slice(1);
			};
		
		$(window).resize(function() {
			setImage(true);
		});

		if(options.quit_on_doc_click) {
			$(document).on(hasTouch ? 'touchend' : 'click', function(e) {
				if(image.length && !$( e.target ).is( image )) quitLightbox();
			})
		}

		if(options.enable_keyboard) {
			$(document).on('keyup', function(e) {
				if(!image.length) return true;
				e.preventDefault();
				if(e.keyCode == 27) quitLightbox();
				if(e.keyCode == 37 || e.keyCode == 39)
				{
					target = targets.eq(targets.index(target) - (e.keyCode == 37 ? 1 : -1));
					if(!target.length) target = targets.eq(e.keyCode == 37 ? targets.length : 0);
					loadImage(e.keyCode == 37 ? 'left' : 'right');
				}
			});
		}

		$(document).on('click', this.selector, function(e) {
			if(!isTargetValid(this)) return true;
			e.preventDefault();
			var $this = $(this);

			$('.product-img-box figure').addClass('spinner');
			
			if($this.parents('.more-views').length) {
				var medium_image_url = $this.attr('data-url-medium');
				var large_image_url = $this.attr('href');
				$('.product-img-box figure a').attr('href', large_image_url);
				$('.product-img-box figure img').attr('src', medium_image_url);
				$this.parents('.more-views').find('li').removeClass('selected');
				$this.parents('li').addClass('selected');
				$('.product-img-box figure').removeClass('spinner');
				return true;
			};
			
			// Append wrapper
			if(!$('.imagelightbox-wrap')[0]) {
				wrap = $('<div class="imagelightbox-wrap" />');
				wrap.appendTo('body');
			}
			
			if(inProgress || disable_slide) return false;
			inProgress = false;
			if(options.on_start !== false) options.on_start();
			target = targets.filter(function(index) {
				return $(this).attr('href') == $this.attr('href');
			});
			source = e.target;
			loadImage();
		});

		getTargets(this);
		
		this.switchImageLightbox = function(index) {
			var tmpTarget = targets.eq(index);
			if(tmpTarget.length) {
				var currentIndex = targets.index(target);
				target = tmpTarget;
				loadImage( index < currentIndex ? 'left' : 'right' );
			}
			return this;
		};

		this.quitImageLightbox = function() {
			quitLightbox();
			return this;
		};

		this.updateTargets = function(el) {
			getTargets(el);
			return this;
		};

		return this;
	};
	
})( jQuery, window, document );