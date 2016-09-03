/**
 * Intenso Theme Library
 * http://itactica.com/intenso
 * Copyright 2014-2015, ITACTICA
 * http://getintenso.com/license
 */

;(function ($, window, document, undefined) {
  'use strict';

  	/** 
  	 * Description:  Parses data-options attribute
	 * Arguments:  'el' (jQuery Object): Element to be parsed.
	 * Returns:  Options (Javascript Object): Contents of the element's data-options attribute.
	 */    
    var data_options = function(el) {
		var opts = {}, ii, p, opts_arr,
			data_options = function (el) {
				return el.data('options');
			};

		var cached_options = data_options(el);

		if (typeof cached_options === 'object') {
			return cached_options;
		}

		opts_arr = (cached_options || ':').split(';'),
		ii = opts_arr.length;

		function isNumber (o) {
			return ! isNaN (o-0) && o !== null && o !== "" && o !== false && o !== true;
		}

		function trim(str) {
			if (typeof str === 'string') return $.trim(str);
			return str;
		}

		while (ii--) {
			p = opts_arr[ii].split(':');

			if (/true/i.test(p[1])) p[1] = true;
			if (/false/i.test(p[1])) p[1] = false;
			if (isNumber(p[1])) p[1] = parseInt(p[1], 10);

			if (p.length === 2 && p[0].length > 0) {
				opts[trim(p[0])] = trim(p[1]);
			}
		}

		return opts;
	};

	var createCookie = function(name, value, days) {
	    var expires;

	    if (days) {
	        var date = new Date();
	        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
	        expires = "; expires=" + date.toGMTString();
	    } else {
	        expires = "";
	    }
	    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
	};

	var readCookie = function(name) {
	    var nameEQ = escape(name) + "=";
	    var ca = document.cookie.split(';');
	    for (var i = 0; i < ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
	        if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
	    }
	    return null;
	};

	var eraseCookie = function(name) {
	    createCookie(name, "", -1);
	};
	
	var random_str = function(length) {
		var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.split('');
		if (!length) {
			length = Math.floor(Math.random() * chars.length);
		}
		var str = '';
		while (length--) {
			str += chars[Math.floor(Math.random() * chars.length)];
		}
		return str;
	};
	
	var replace_inline_SVG = function() {
		// handles inline SVG images in case the browser doesn´t support SVG format
		if(!Modernizr.svg) {
			$('img[src*="svg"]').attr('src', function () {
				return $(this).attr('src').replace('.svg', '.png');
			});
		}
	};
	
	var toggle_input_placeholder = function() {
		// toggle input's placeholder text
		if($(".placeholder").val()!=''){
			$(".placeholder").next("label").hide();
		}
		$(".placeholder").focus(function() {
			$(this).next("label").hide();
		});
		$(".placeholder").focusout(function() {
			if($(this).val()!=''){
				$(this).next("label").hide();
			} else {
				$(this).next("label").show();
			}
		});
	};
	
	var init_form_select = function() {
		if ($('body').hasClass('mdformfields')) {
			// init Chosen select boxes
			var selectEl,
				selectVal;
			if($.fn.chosen){
				$("select").each(function(){
					if ($(this).hasClass('no-display')) return;
					$(this).chosen({
						disable_search_threshold: 10,
						width: 'auto',
					});
					// dismiss validation-advice onchange
					$(this).off().on('change', function() {
						$(this).siblings('.validation-advice').hide(300);
					});
					// update original select boxes for configurable products on product's page
					if ($(this).hasClass('super-attribute-select') 
						|| this.id == 'limits' || this.id == 'orders' || $(this).hasClass('simulate-change')) {
						$(this).off().on('change keyup', function(event) {
							if (selectEl == $(this)[0] && selectVal == $(this).val()) return;
							selectEl = $(this)[0];
							selectVal = $(this).val();
							setTimeout(function(){
								if (selectEl === event.target) {
									selectEl.simulate('change');
								}
								$("select").each(function(){
									$(this).trigger("chosen:updated");
								});
							},0);
						});
					}
				});
			};
			$('.input-box').has('select').addClass('input-box-select');
			$('.input-box').has('select').parent().addClass('select-list');
			// temporary fix for issue #1887 (https://github.com/harvesthq/chosen/issues/1887)
			$('.chosen-container .chosen-results').on('touchend', function(event) {
			    event.stopPropagation();
			    event.preventDefault();
			    return;
			});
		}
	};

	var input_focus = function(el) {
		if ($('body').hasClass('mdformfields')) {
			var mainColor,
				top;
			if ($(el).is(":focus")) $(el).parents('.input-box').addClass('focus');
			if ($(el).val().length > 0) {
				if ($(el).parents('.input-box').hasClass('fade-label')) {
					$(el).parents('.input-box').siblings('label').hide();
				} else {
					mainColor = $('.main-color').css('color');
					if (typeof mainColor === 'undefined' || mainColor.length == 0) mainColor = '#999';
					top = ($(el).is("textarea")) ? 26 : 18;

					if (!$(el).hasClass('label-animated')) {
						$(el).addClass('label-animated');
						$(el).parents('.input-box').siblings('label').animate({
							top: '-='+top,
							fontSize: '-=1'
						}, 150, function() {
							$(this).css({'font-weight': 'normal', 'color': mainColor});
						});
					}
				}
			}
		}
		// dismiss validation-advice onchange
		$(el).on('change keyup', function() {
			$(this).siblings('.validation-advice').hide(300);
		});
	};

	var input_blur = function(el) {
		if ($('body').hasClass('mdformfields')) {
			$(el).parents('.input-box').removeClass('focus');
			if ($(el).val().length == 0) {
				$(el).removeClass('label-animated');
				$(el).parents('.input-box').siblings('label').show();
				$(el).parents('.input-box').siblings('label').css({
					'top': '',
					'font-size': '',
					'font-weight': '',
					'color': ''
				});
			}
		}
	};

	var fix_label = function() {
		if ($('body').hasClass('mdformfields')) {
			// add class to textarea's label
			fix_textarea();
			// add class to checkbox's label
			fix_checkbox();
			// for ajax generated forms distpaching a custom event is needed for this to work
			$(document).on('new:ajaxform', function() {
				fix_textarea();
				fix_checkbox();
				init_form_select();
			});
		}
	};

	var fix_textarea = function() {
		$('.input-box').each(function() {
			$(this).has('textarea').addClass('textarea');
			$(this).has('textarea').siblings('label').addClass('textarea');
		});
	};

	var fix_checkbox = function() {
		$('.input-box').each(function() {
			if ($(this).children("input[type='checkbox']").length > 0) {
				$(this).addClass('checkbox');
				$(this).siblings('label').addClass('checkbox');
			}
		});
	};
	
	var bind_inputbox_focus = function() {
		// apply focus effect to labels in case they are prefilled when page load
		$('.input-text').each(function() {
			input_focus(this);
		});
		// bind focus event to every inputbox
		$('body').on('focus keyup change input', '.input-text', function() {
			input_focus(this);
		});
		$('#newsletter').on('focus keyup change input', function() { input_focus(this); });
		$('#newsletter-popup').on('focus keyup change input', function() { input_focus(this); });
		// for programmatically filled or ajax generated forms
		$(document).on('new:ajaxform', function() {
			$('.input-text').each(function() {
				input_focus(this);
			});
			$("select").each(function(){
				$(this).trigger("chosen:updated");
			});
		});
		$('body').on('focusout', '.input-text', function() {
			input_blur(this);
		});
		$('#newsletter').on('focusout', function() { input_blur(this); });
		$('#newsletter-popup').on('focusout', function() { input_blur(this); });
		// bind focus event to every textarea
		$('body').on('focus keyup change input', 'textarea', function() {
			input_focus(this);
		});
		$('body').on('focusout', 'textarea', function() {
			input_blur(this);
		});
	};
	
	var toggle_newsletter_inputbox = function() {
		// On click event to open and close newsletter inputbox
		$('.newsletter-subscribe').on('click', function(e) {
			e.preventDefault();
			$('.newsletter-ribbon .newsletter-subscribe-form').slideToggle(50);
		});
	};

	var toggle_tags_inputbox = function() {
		// On click event to open and close tags inputbox
		$('#add-tag').on('click', function(e) {
			e.preventDefault();
			$('#addTagForm').slideToggle(50);
		});
	};

	var toggle_secmenu = function() {
		$('.icon-sec-menu').hover(function(e) {
			$('.sec-menu-dropdown').addClass('show');
		}, function(e) {
			if(e.target.tagName.toLowerCase() != 'select'
				&& e.target.tagName.toLowerCase() != 'option') {
				$('.sec-menu-dropdown').removeClass('show');
			}
		});
	};

	var init_mega_menu = function() {
		$(".level0.has-dropdown").hoverIntent({
            over: show_mega_menu,
            out: hide_mega_menu,
            timeout: 300
        });
        $('.top-bar-section .right li.has-dropdown').hoverIntent({
            over: show_dropdown,
            out: hide_dropdown,
            timeout: 100
        });
	};

	var show_mega_menu = function() {
		$(this).addClass('hover');
		$(this).find('.level0.dropdown').show();
	};

	var hide_mega_menu = function() {
		$(this).removeClass('hover');
		$(this).find('.level0.dropdown').hide();
	};

	var show_dropdown = function() {
		$(this).addClass('hover');
		$(this).find('ul.dropdown').show();
	};

	var hide_dropdown = function() {
		$(this).removeClass('hover');
		$(this).find('ul.dropdown').hide();
	};

	var init_vertical_menu = function() {
		if ($('.right-off-canvas-menu.main-nav').hasClass('vertical')) {
			$('.vertical ul.left li:not(:first)').hide();
			$('.vertical-menu-link').mouseenter(function(e) {
				$('.vertical ul.left li:not(:nth-child(2)):not(.js-generated)').show();
				$('body').append('<div class="vertical-menu-overlay"></div>');
				var headerHeight = $('.main-header').height();
				$('.vertical-menu-overlay').css('top',headerHeight);
			});
			$('.vertical ul.left').mouseleave(function(e) {
				if (Modernizr.mq('only screen and (min-width: 40.063em)')) {
					$('.vertical ul.left li:not(:nth-child(2))').hide();
					$('.vertical-menu-overlay').remove();
				}
			});
			$('.vertical .custom-menu').mouseenter(function(e) {
				if (Modernizr.mq('only screen and (min-width: 40.063em)')) {
					$(".vertical ul.left li:not(:nth-child(2))").hide();
					$('.vertical-menu-overlay').remove();
				}
			});
			$('.vertical ul.left li.level0:last').addClass('last-vt');
			$(window).on('orientationchange resize', function(e) {
				self.calculateDropdownsWidth();
				if (Modernizr.mq('only screen and (max-width: 40em)')) {
					$(".vertical ul.left li:not(:nth-child(2))").show();
				}
			});
			self.calculateDropdownsWidth();
			if (Modernizr.mq('only screen and (max-width: 40em)')) {
				$(".vertical ul.left li:not(:nth-child(2))").show();
			}
		}
	};

	self.calculateDropdownsWidth = function() {
		// calculates width of divs for vertical menu dropdowns
		var dropdown = $('.vertical .top-bar-section ul.left li.mega-menu ul.level0');
		var screen_width = parseInt($('.off-canvas-wrap').width());
		var menu_width = $('.vertical ul.left').width();
		var margin_left = parseInt($('.vertical ul.left').css('margin-left'));
		var dropdown_width = screen_width - menu_width - (margin_left * 2);
		dropdown.each(function(){
			var style = $(this).attr('style');
			style = (typeof style === 'undefined') ? '' : style.replace(/width:.+/g, '');

			if (Modernizr.mq('only screen and (max-width: 40em)')) {
				$(this).attr('style', style);
			} else {
				$(this).attr('style', 'width: '+dropdown_width+'px !important;' + style);
			}
		});
		var menu_item_width = $('.vmenu-title').outerWidth() + 50;
		$('.vertical ul.left > li:nth-child(2)').css('width', menu_item_width);
		$('.vertical ul.left li.custom-menu').each(function(index){
			menu_item_width = menu_item_width + 30;
			$(this).css('left', menu_item_width);
			menu_item_width = menu_item_width + $(this).outerWidth();
		})
	};
	
	var touch_exit_canvas = function() {
		// Allow closing Foundation Off Canvas Menu by swiping on touch devices
		var idx = 0;
		var exit_off_canvas = $('.exit-off-canvas');
		exit_off_canvas.on('touchstart.fndtn.offcanvas', function(e) {
			if (!e.touches) {e = e.originalEvent;}
			var data = {
				start_page_x: e.touches[0].pageX,
				start_page_y: e.touches[0].pageY,
				start_time: (new Date()).getTime(),
				delta_x: 0,
				is_scrolling: undefined
			};
			exit_off_canvas.data('swipe-transition', data);
			e.stopPropagation();
		})
		.on('touchmove.fndtn.offcanvas', function(e) {
			if (!e.touches) { e = e.originalEvent; }
			// Ignore pinch/zoom events
			if(e.touches.length > 1 || e.scale && e.scale !== 1) return;

			var data = exit_off_canvas.data('swipe-transition');
			if (typeof data === 'undefined') {data = {};}

			data.delta_x = e.touches[0].pageX - data.start_page_x;

			if ( typeof data.is_scrolling === 'undefined') {
				data.is_scrolling = !!( data.is_scrolling || Math.abs(data.delta_x) < Math.abs(e.touches[0].pageY - data.start_page_y) );
			}

			if (!data.is_scrolling && !data.active) {
				e.preventDefault();
				var direction = (data.delta_x < 0) ? (idx+1) : (idx-1);
				data.active = true;
				if(direction<0) $(".off-canvas-wrap").removeClass("move-left");
				if(direction>0) $(".off-canvas-wrap").removeClass("move-right");
			}
		})
		.on('touchend.fndtn.orbit', function(e) {
			exit_off_canvas.data('swipe-transition', {});
			e.stopPropagation();
		})
	};
	
	var show_nav_arrows = function(container, settings) {
		/* Hide/Show arrow navigations on mouse stop/move */
		var slide_selector = (settings.slide_selector == '*') ? '.item' : '.'+settings.slide_selector;
		var slides_count = $(container).find(slide_selector).length;
		if (slides_count > 1) {
			var i = null;
			$(container).mousemove(function() {
				clearTimeout(i);
				$(container).find('.'+settings.prev_class+', .'+settings.next_class).fadeIn(300);
				if($('.'+settings.prev_class).hasClass('is-hover') || $('.'+settings.next_class).hasClass('is-hover')) {
					clearTimeout(i);
				} else {
					i = setTimeout(function() { $(container).find('.'+settings.prev_class+', .'+settings.next_class).fadeOut(); }, 1500);
				}
			});
		}
	};

	var minicart_build_markup = function() {
		var slideCount = $('.mini-products-container > ul').length;
		var bullets_container = $('<ul>');
		if (slideCount > 1) {
			$('.mini-products-wrapper').after(bullets_container);
			bullets_container.wrap('<nav class="simple-nav"></nav>');
			for(var i = 0; i < slideCount; i++) {
				var bullet = $('<li>').attr('data-featured-slide', i);
				bullets_container.append(bullet);
			}
		}
	}
	
	var minicart_toggle_item_attr = function() {
		// Cart dropdown - Expand and hide item attributes
		$(".view-more-attr").click(function(event){
			$(event.target).closest("li").children(".item-options").slideToggle(200, function() {
				$(".view-more-attr").html(($(this).is(':visible') ? Translator.translate('Show less details') : Translator.translate('Show more details')));
				
			});
		});
	};
		
	var minicart_slider_control = function(width) {
		// Cart dropdown - Slider control
		var slideCount = $(".mini-products-container > ul").length;
		var slideWidth = width;
		$(".mini-products-container").width(slideWidth*slideCount);
		$(".cart-dropdown .simple-nav > ul > li:first-child").addClass("active");
		$(".cart-dropdown .simple-nav > ul > li").click(function(event) {
			event.preventDefault();
				$(".mini-products-container").animate({marginLeft: - slideWidth*$(this).index()}, 200);
			$(".cart-dropdown .simple-nav > ul > li.active").removeClass("active");
			$(".cart-dropdown .simple-nav > ul > li").eq($(this).index()).addClass("active");
		});
	};
	
	var back_to_top = function() {
		if ($('.back-to-top').length) {
			$('.back-to-top').on('click', function() {
				var body = $("html, body");
				body.animate({scrollTop:0}, '1000', 'swing', function() { 
					// callback
				});
			});
		}
	};
	
	var OrbitSlider = function(el, settings) {
		var self = this,
			container = el;
				
		self.orbit_height = function() {
			if ($(container).find('.full-screen').length != 0 &&
				$(container).find('.hero-text').css('position') != 'relative') { // full screen setting enabled
				if ($('.main-header').css('position') == 'absolute') {
					var orbit_height = $("body").innerHeight() + 4;
				} else {
					var orbit_height = $("body").innerHeight() - $('.main-header').outerHeight();
				}
				$(container).find("li.item").each(function(){
					if ($(this).find('img').attr('src') != 'undefined') {
						$(this).css('background-image', 'url(' + $(this).find('img').attr('src') + ')');
					}
				});
			} else {
				$(container).find('.hero-text').css('height','');
				if($(container).find('.hero-text').first().css('position') == 'relative') { // adjust hero's text height only on mobile
					$(container).find('.hero-text').css('height','');
					var maxHeight = Math.max.apply(null, $(container).find('.hero-text').map(function () {
						return $(this).outerHeight();
					}).get());
					// check if there is only one slide
					if ($(container).find('.'+settings.bullets_container_class+' > li').length == 1) {
						maxHeight = maxHeight - 10;
					} else {
						maxHeight = (settings.outside_bullets) ? maxHeight + 30 : maxHeight + 15;
					}
					$(container).find('.hero-text').css('height', maxHeight);
				}
				var heights = new Array();
				$(container).find("li.item").each(function(){
					heights.push($(this).outerHeight());
				});
				var orbit_height = Math.max.apply(null, heights);
			}
			return orbit_height;
		};
				
		self.fix_orbit_height = function(resize) {
			var orbitHeight = self.orbit_height();
			if(resize) {
				if (!isNaN(parseFloat(orbitHeight)) && isFinite(orbitHeight)) {
					$(container).css("height", orbitHeight);
					$(container).find('.orbit-container').css("height", orbitHeight);
				}
			} else {
				// This fixes "height: 0" bug in Foundation's Orbit Slider when using in conjunction with Interchange.
				$(container).find("li img").on("load", function () { // waits until Interchange has placed the image
					if (!isNaN(parseFloat(orbitHeight)) && isFinite(orbitHeight)) {
						$(container).css("height", orbitHeight); // asign correct height to slider
						$(container).find('.orbit-container').css("height", orbitHeight);
						$('.hero-text').css('visibility', 'visible');
						$('.orbit-wrapper').css('min-height', 'initial');
						$('.orbit-wrapper').removeClass('spinner');
						$(document).resize();
					}
				});
			}
		};
		
		self.orbit_bullets = function() {
			// Hide bullets container if there is only one slide
			if ($(container).find('.'+settings.bullets_container_class+' > li').length == 1) {
				$(container).find('.orbit-bullets-container').hide(0);
			} else {
				// Adjust hero's bullets for slides with a dark background
				if($(container).find("li:first-child").hasClass("dark")){
					self.bulletsDark();
				}
				$(container).on('after-slide-change.fndtn.orbit', function(event, orbit) {
					if($(container).find('li:eq(' + orbit.slide_number + ')').hasClass('dark')){
						$('.'+settings.bullets_container_class+' > li').addClass('dark');
					} else {
						$('.'+settings.bullets_container_class+' > li').removeClass('dark');
					}
				});
			}
		};
	
		self.bulletsDark = function(){
			$('.'+settings.bullets_container_class+' > li').addClass("dark");
		};

		self.adjustFontSizeForMobile = function() {
			var ratio = 0.8;
			// adjust slides font-size on medium screens
			if (Modernizr.mq('only screen and (min-width: 40.063em) and (max-width: 48em)')) {
				$(container).find('li .hero-text > h1').each(function(){
					var headerSize = $(this).data('size') * ratio;
					if (headerSize > 0) {
						$(this).css('font-size',headerSize);
					}
				});
				$(container).find('li .hero-text > h5').each(function(){
					var textSize = $(this).data('size') * ratio;
					if (textSize > 0) {
						$(this).css('font-size',textSize);
					}
				});
			} else {
				$(container).find('li .hero-text > h1').each(function(){
					$(this).css('font-size',$(this).data('size'));
				});
				$(container).find('li .hero-text > h5').each(function(){
					$(this).css('font-size',$(this).data('size'));
				});
			}
		};
		
		self.init = function(){
			$(container).find('.'+settings.prev_class).hover(function(){ $(this).toggleClass('is-hover'); });
			$(container).find('.'+settings.next_class).hover(function(){ $(this).toggleClass('is-hover'); });
			$(window).resize(function() {
				self.fix_orbit_height(true);
				self.adjustFontSizeForMobile();
			});
			self.fix_orbit_height();
			self.orbit_bullets();
			if (settings.navigation_arrows && $('html').hasClass('no-touch')) {
				show_nav_arrows(container, settings);
			}
			// add active class to first bullet
			var active_class = $('.'+settings.bullets_container_class).children('[data-orbit-slide]').eq(0);
			active_class.addClass(settings.bullets_active_class);
		};
		
		self.init();
	};
	
	var Featured = function(el, settings, uuid) {
		
		var self = this,
				idx = 0,
				container = el,
				count_visible_items = 1,
				featured_items_count = {},
				featured_item_width,
				current = {},
				bullets_container = $('<ul>'),
				pages = {},
				animate;
				
		self.touch_slide = function() {
			if (settings.navigation_arrows) {
				$(container).append($('<a href="#"><span></span></a>').addClass(settings.prev_class));
				$(container).append($('<a href="#"><span></span></a>').addClass(settings.next_class));
			}
			if (settings.bullets) {
				$(container).append(bullets_container);
				bullets_container.wrap('<nav class="simple-nav"></nav>');
			}
			$(container).on('click', '.'+settings.next_class, {settings: settings}, self.next);
			$(container).on('click', '.'+settings.prev_class, {settings: settings}, self.prev);
			$(container).find('.'+settings.prev_class).hover(function(){ $(this).toggleClass('is-hover'); });
			$(container).find('.'+settings.next_class).hover(function(){ $(this).toggleClass('is-hover'); });
			$(container).on('click', '[data-cat-slide]', self.link_category);
			if (settings.swipe) {
				$(container).on('touchstart.fndtn.orbit', 'ol', function(e) {
					if (!e.touches) {e = e.originalEvent;}
					var data = {
						start_page_x: e.touches[0].pageX,
						start_page_y: e.touches[0].pageY,
						start_time: (new Date()).getTime(),
						delta_x: 0,
						is_scrolling: undefined
					};
					$(container).data('swipe-transition', data);
					e.stopPropagation();
				})
				.on('touchmove.fndtn.orbit', 'ol', function(e) {
					if (!e.touches) { e = e.originalEvent; }
					// Ignore pinch/zoom events
					if(e.touches.length > 1 || e.scale && e.scale !== 1) return;
	
					var data = $(container).data('swipe-transition');
					if (typeof data === 'undefined') {data = {};}
	
					data.delta_x = e.touches[0].pageX - data.start_page_x;
	
					if ( typeof data.is_scrolling === 'undefined') {
						data.is_scrolling = !!( data.is_scrolling || Math.abs(data.delta_x) < Math.abs(e.touches[0].pageY - data.start_page_y) );
					}
	
					if (!data.is_scrolling && !data.active) {
						e.preventDefault();
						var direction = (data.delta_x < 0) ? (idx+1) : (idx-1);
						data.active = true;
						self._goto(direction);
					}
				})
				.on('touchend.fndtn.orbit', 'ol', function(e) {
					$(container).data('swipe-transition', {});
					e.stopPropagation();
				})
			}
		};
		
		self.update_nav_arrows = function(container, index) {
			if (settings.navigation_arrows && $('html').hasClass('no-touch')) {
				$(container).find('.'+settings.prev_class+', .'+settings.next_class).css('visibility', 'visible');
				if (idx == 0) {
					$(container).find('.'+settings.prev_class).css('visibility', 'hidden');
				}
				if (pages[uuid, index]-1 == 0) {
					$(container).find('.'+settings.next_class).css('visibility', 'hidden');
				}
				if (idx == pages[uuid, index]-1) {
					$(container).find('.'+settings.next_class).css('visibility', 'hidden');
				}
			}
		};
		
		self.link_bullet = function(e) {
			var index = $(this).attr('data-featured-slide');
			if ((typeof index === 'string') && (index = $.trim(index)) != "") {
				if(isNaN(parseInt(index))) {
					var slide = container.find('[data-orbit-slide='+index+']');
					if (slide.index() != -1) {self._goto(slide.index() + 1);}
				} else {
					self._goto(parseInt(index));
				}
			}
		};
		
		self.sort_by_attr = function(container) {
			container.find('li').sort(function (a, b) {
    		return +a.getAttribute('data-cat-slide') - +b.getAttribute('data-cat-slide');
			}).appendTo(container);
		};
						
		self.link_category = function(e) {    
			var index = $(this).attr('data-cat-slide');
			if ((typeof index === 'string') && (index = $.trim(index)) != "") {
				$(container).find('ol:visible').hide();
				$(container).find('ol').eq(parseInt(index)).show();
				
				idx = current[uuid, index];
				if (current[uuid, index] === undefined) current[uuid, index] = 0;
				self._goto(current[uuid, index], true);
				$(container).find('.category-nav li').removeClass('active');
				$(container).find('[data-cat-slide='+parseInt(index)+']').addClass('active');
				
				self.init();
				self._goto(idx, true);
				self.update_slide_number(idx);
				
				self.sort_by_attr($(container).find('.category-nav'));
				if($(container).find('.category-nav li.active').css('display') == 'block') {
					$(container).find('.category-nav li.active').prependTo($(container).find('.category-nav'));
					$(container).find('.category-nav li').toggleClass('show-options');
				}
			}
		};
		
		self.update_slide_number = function(index) {
			bullets_container.children().removeClass(settings.bullets_active_class);
			$(bullets_container.children().get(index)).addClass(settings.bullets_active_class);
		};
		
		self.next = function(e) {
			e.stopImmediatePropagation();
			e.preventDefault();
			self._goto(idx + 1);
		};
		
		self.prev = function(e) {
			e.stopImmediatePropagation();
			e.preventDefault();
			self._goto(idx - 1);
		};
		
		self._goto = function(next_idx, no_animate) {
			no_animate = typeof no_animate === 'undefined' ? false : no_animate;
			if (next_idx < 0) {return false;}
			var slides = $(container).find('ol:visible');
			while (next_idx >= Math.ceil(featured_items_count[uuid, slides.index()-1] / count_visible_items)) {
				--next_idx;
			}
			var dir = 'next';
			if (next_idx < idx) {dir = 'prev';}
			idx = next_idx;
			var empty_positions = count_visible_items -(featured_items_count[uuid, slides.index()-1] % count_visible_items);
			if (empty_positions == count_visible_items) empty_positions = 0;
			var adjust_last_page = (idx == pages[uuid, slides.index()-1] - 1 && pages[uuid, slides.index()-1] - 1 > 0) ? (empty_positions * featured_item_width) : 0;
			self.update_slide_number(idx);
			self.update_nav_arrows(container, slides.index()-1);
			if (dir === 'next') {animate.next(slides, uuid, current, idx, adjust_last_page, count_visible_items, featured_item_width, no_animate);}
			if (dir === 'prev') {animate.prev(slides, uuid, current, idx, adjust_last_page, count_visible_items, featured_item_width, no_animate);}        
		};
		
		self.cat_nav_build_markup = function() {
			var categories_array = $.map($(container).find('ol'), function(el) {
     		return {value: $(el).data('featured-cat-name')}
			});
			var cat_nav_container = $('<ul>').addClass('category-nav');
			if (categories_array.length > 1) { // build menu only if has more than one category
				$(container).append(cat_nav_container);
				for(var i = 0; i < categories_array.length; i++ ) {
					var nav_option = $('<li>'+categories_array[i].value+'</li>').attr('data-cat-slide', i);
					cat_nav_container.append(nav_option);
				}
				$(container).find('.category-nav li:first-child').addClass('active');
			};
		};
		
		self.init = function(){
			featured_item_width = settings.min_item_width;
			var number_of_items = 0;
			var padding_left = parseInt($(container).css("padding-left"));
			var margin_right = parseInt($(container).find('.'+settings.slide_selector+':first-child').css("margin-right"));
			var available_width = parseInt($('.off-canvas-wrap').width()) - settings.sneak_peak_width - padding_left;
			while (featured_item_width >= settings.min_item_width) {
				number_of_items++;
				featured_item_width = available_width / number_of_items
			}
			if (number_of_items > 1) number_of_items = number_of_items - 1;
			count_visible_items = number_of_items;
			featured_item_width = parseInt(available_width / number_of_items);
			$(container).find('.'+settings.slide_selector).css("width", featured_item_width - margin_right);
			$(container).find('ol').each(function(index){
				featured_items_count[uuid, index] = $(this).find('.'+settings.slide_selector).length;
				//featured_item_width = (featured_item_width == available_width) ? available_width : featured_item_width;
				//if (available_width < 320 && featured_item_width < 280) featured_item_width = 280;
				var container_width = featured_items_count[uuid, index]*(featured_item_width + margin_right + 20);
				if (container_width < available_width) container_width = available_width;
				$(this).css("width", container_width);
			});
			if (settings.bullets) { // update bullets
				$(container).find('ol:visible').each(function(index){
					pages[uuid, $(this).index()-1] = Math.ceil(featured_items_count[uuid, $(this).index()-1] / count_visible_items);
					bullets_container.html('');
					if (pages[uuid, index] <= settings.max_bullets_count && pages[uuid, index] > 1) {
						for(var i = 0; i < pages[uuid, $(this).index()-1]; i++ ) {
							var bullet = $('<li>').attr('data-featured-slide', i);
							bullets_container.append(bullet);
						}
					}
					bullets_container.on('click', '[data-featured-slide]', self.link_bullet);
				});
			}
			self.update_nav_arrows(container, 0);
			self.update_slide_number(0);
		};
		
		self.on_resize = function() {
			self.init();
			self._goto(idx, true);
			if($(container).find('.category-nav li.active').css('display') == 'inline-block') {
				self.sort_by_attr($(container).find('.category-nav'));
			} else {
				$(container).find('.category-nav li.active').prependTo($(container).find('.category-nav'));
			}
		};
		
		$(container).find('ol').not(':first').hide();
		self.init();
		$(document).on('click', function(e){ // Hides category dropdown when clicked outside of it
			if (!$(e.target).hasClass('show-options')) {
				$(container).find('.category-nav li').removeClass('show-options');
			}
		});
		$(container).each(function() {
			var touch_events = self.touch_slide();
			animate = new SlideAnimation(settings);
			if (settings.navigation_arrows && $('html').hasClass('no-touch')) {
				show_nav_arrows(this, settings);
			};
			if (settings.category_nav_menu) {
				self.cat_nav_build_markup();
			}
		});
		if ($('html').hasClass('touch')) {
			$(window).on('orientationchange resize', function(e) {
				self.on_resize();
			});
			self.update_slide_number(idx);
		} else {
			$( window ).resize(function() {
				self.on_resize();
			});
		}
	};
	
	var BrandSlider = function(el, settings, uuid) {
		var self = this,
				idx = 0,
				container = el,
				count_visible_items = 1,
				featured_items_count = {},
				logo_item_width = {},
				current = {},
				bullets_container = $('<ul>'),
				pages = {},
				is_collapsed = true,
				animate;
				
		self.touch_slide = function() {
			if (settings.navigation_arrows) {
				$(container).append($('<a href="#"><span></span></a>').addClass(settings.prev_class));
				$(container).append($('<a href="#"><span></span></a>').addClass(settings.next_class));
			}
			if (settings.bullets) {
				$(container).append(bullets_container);
				bullets_container.wrap('<nav class="simple-nav"></nav>');
			}
			$(container).on('click', '.'+settings.next_class, {settings: settings}, self.next);
			$(container).on('click', '.'+settings.prev_class, {settings: settings}, self.prev);
			$(container).find('.'+settings.prev_class).hover(function(){ $(this).toggleClass('is-hover'); });
			$(container).find('.'+settings.next_class).hover(function(){ $(this).toggleClass('is-hover'); });
			if (settings.swipe) {
				$(container).on('touchstart.fndtn.orbit', 'ol', function(e) {
					if (!e.touches) {e = e.originalEvent;}
					var data = {
						start_page_x: e.touches[0].pageX,
						start_page_y: e.touches[0].pageY,
						start_time: (new Date()).getTime(),
						delta_x: 0,
						is_scrolling: undefined
					};
					$(container).data('swipe-transition', data);
					e.stopPropagation();
				})
				.on('touchmove.fndtn.orbit', 'ol', function(e) {
					if (!e.touches) { e = e.originalEvent; }
					// Ignore pinch/zoom events
					if(e.touches.length > 1 || e.scale && e.scale !== 1) return;
	
					var data = $(container).data('swipe-transition');
					if (typeof data === 'undefined') {data = {};}
	
					data.delta_x = e.touches[0].pageX - data.start_page_x;
	
					if ( typeof data.is_scrolling === 'undefined') {
						data.is_scrolling = !!( data.is_scrolling || Math.abs(data.delta_x) < Math.abs(e.touches[0].pageY - data.start_page_y) );
					}
	
					if (!data.is_scrolling && !data.active) {
						e.preventDefault();
						var direction = (data.delta_x < 0) ? (idx+1) : (idx-1);
						data.active = true;
						self._goto(direction);
					}
				})
				.on('touchend.fndtn.orbit', 'ol', function(e) {
					$(container).data('swipe-transition', {});
					e.stopPropagation();
				})
			}
		};
		
		self.update_nav_arrows = function(container, index) {
			if (settings.navigation_arrows && $('html').hasClass('no-touch')) {
				$(container).find('.'+settings.prev_class+', .'+settings.next_class).css('visibility', 'visible');
				if (idx == 0) {
					$(container).find('.'+settings.prev_class).css('visibility', 'hidden');
				}
				if (pages[uuid]-1 == 0) {
					$(container).find('.'+settings.next_class).css('visibility', 'hidden');
				}
				if (idx == pages[uuid]-1) {
					$(container).find('.'+settings.next_class).css('visibility', 'hidden');
				}
			}
		};
		
		self.link_bullet = function(e) {
			var index = $(this).attr('data-featured-slide');
			if ((typeof index === 'string') && (index = $.trim(index)) != "") {
				if(isNaN(parseInt(index))) {
					var slide = container.find('[data-orbit-slide='+index+']');
					if (slide.index() != -1) {self._goto(slide.index() + 1);}
				} else {
					self._goto(parseInt(index));
				}
			}
		};
		
		self.update_slide_number = function(index) {
			bullets_container.children().removeClass(settings.bullets_active_class);
			$(bullets_container.children().get(index)).addClass(settings.bullets_active_class);
		};
		
		self.next = function(e) {
			e.stopImmediatePropagation();
			e.preventDefault();
			self._goto(idx + 1);
		};
		
		self.prev = function(e) {
			e.stopImmediatePropagation();
			e.preventDefault();
			self._goto(idx - 1);
		};
		
		self._goto = function(next_idx, no_animate) {
			no_animate = typeof no_animate === 'undefined' ? false : no_animate;
			if (next_idx < 0) {return false;}
			var slides = $(container).find('ol:visible');
			while (next_idx >= Math.ceil(featured_items_count[uuid] / count_visible_items)) {
				--next_idx;
			}
			var dir = 'next';
			if (next_idx < idx) {dir = 'prev';}
			idx = next_idx;
			var empty_positions = count_visible_items -(featured_items_count[uuid] % count_visible_items);
			if (empty_positions == count_visible_items || featured_items_count[uuid] <= count_visible_items) {
				empty_positions = 0;
			}
			var adjust_last_page = (idx == pages[uuid] - 1) ? (empty_positions * (logo_item_width+4)) : 0;
			self.update_slide_number(idx);
			self.update_nav_arrows(container, slides.index()-1);
			if (dir === 'next') {animate.next(slides, uuid, current, idx, adjust_last_page, count_visible_items, logo_item_width+4, no_animate);}
			if (dir === 'prev') {animate.prev(slides, uuid, current, idx, adjust_last_page, count_visible_items, logo_item_width+4, no_animate);}        
		};
		
		self.show_all = function() {
			var expand_all_text = Translator.translate('Show all Brands');
			var collapse_all_text = Translator.translate('Hide all Brands');
			// -------------------------------------
			$(container).append($('<div><a href="#" class="arrow-down">'+expand_all_text+'</a></div>').addClass('show-all-brands'));
			$(container).on('click', '.show-all-brands a', function(e){
				e.preventDefault();
				$(this).toggleClass('active');
				if ($(this).hasClass('active')) {
					is_collapsed = false;
					$(container).find('.show-all-brands a').html(collapse_all_text).blur();
					var available_width = $('.off-canvas-wrap').width() - (parseInt($(container).css('padding-left')) * 2) + 120;
					$(container).find('.simple-nav').hide();
					$(container).find('.brand-prev,.brand-next').stop(true).css('visibility', 'hidden');
					$(container).find('ol').stop(true).css({width: available_width, marginLeft : ''});
					self.adjust_margin();
				} else {
					$(container).find('.simple-nav').stop(true).show();
					$(container).find('.brand-prev,.brand-next').stop(true).css('visibility', 'visible');
					$(container).find('.'+settings.slide_selector).css('margin-right', '');
					$(container).find('.show-all-brands a').html(expand_all_text).blur();
					is_collapsed = true;
					self.init();
					self._goto(idx, true);
					self.update_slide_number(idx);
				}
			});
		};
		
		self.adjust_margin = function() {
			var current_margin_right = parseInt($(container).find('.'+settings.slide_selector).css('margin-right'));
			var available_width = $('.off-canvas-wrap').width() - (parseInt($(container).css('padding-left')) * 2);
			var item_width = logo_item_width;
			var rows = Math.floor(available_width / item_width);
			var margin_right = (available_width - ((item_width - 46) * rows)) / (rows - 1);
			$(container).find('ol').css('width', available_width + 120);
			$(container).find('.'+settings.slide_selector).css('margin-right', margin_right);
		}
		
		self.init = function(){
			var available_width,
					margin_right,
					padding_left,
					container_width,
					number_of_items = 0;
			
			$(container).find('ol').css('padding-left','');
			padding_left = parseInt($(container).css('padding-left'));
			if (is_collapsed) {
				available_width = parseInt($('.off-canvas-wrap').width()) - settings.sneak_peak_width - padding_left;
			} else {
				available_width = $('.off-canvas-wrap').width() - (parseInt($(container).css('padding-left')) * 2);
				$(container).find('.'+settings.slide_selector).css('margin-right', '');
			}
			margin_right = parseInt($(container).find('.'+settings.slide_selector+':first-child').css("margin-right"));
			
			logo_item_width = settings.min_item_width + margin_right;
			while(logo_item_width >= (settings.min_item_width + margin_right)) {
				number_of_items++;
				logo_item_width = available_width / number_of_items;
			}
			if (number_of_items > 1) number_of_items = number_of_items - 1;
			count_visible_items = number_of_items;
			
			if (number_of_items == 1) { // center logo container for mobile view
				var centered = (margin_right + settings.sneak_peak_width + padding_left) / 2;
				$(container).find('ol').css('padding-left', centered);
			}
			logo_item_width = parseInt(available_width / number_of_items);
			$(container).find('.'+settings.slide_selector).css("width", logo_item_width - margin_right);
			
			featured_items_count[uuid] = $(container).find('.'+settings.slide_selector).length;
			logo_item_width = (logo_item_width == available_width) ? available_width : logo_item_width;
			container_width = featured_items_count[uuid]*(logo_item_width + margin_right);
			$(container).find('ol').css("width", container_width);
			
			if (is_collapsed) {
				pages[uuid] = Math.ceil(featured_items_count[uuid] / count_visible_items);
				bullets_container.html('');
				if (pages[uuid] <= settings.max_bullets_count && pages[uuid] > 1) {
					for(var i = 0; i < pages[uuid]; i++ ) {
						var bullet = $('<li>').attr('data-featured-slide', i);
						if (settings.bullets) bullets_container.append(bullet);
					}
				}
				if (settings.bullets) { // update bullets
					bullets_container.on('click', '[data-featured-slide]', self.link_bullet);
				}
				self.update_nav_arrows(container, 0);
			} else {
				available_width = $('.off-canvas-wrap').width() - (parseInt($(container).css('padding-left')) * 2) + 120;
				$(container).find('.'+settings.slide_selector).css('margin-right', '');
				$(container).find('ol').stop(true).css({width: available_width, marginLeft : ''});
				self.adjust_margin();
			}
		};
		
		self.on_resize = function() {
			self.init();
			if (is_collapsed) {
				self._goto(idx, true);
			}
		};
		
		self.init();
		$(container).each(function() {
			var touch_events = self.touch_slide();
			animate = new SlideAnimation(settings);
			if (settings.navigation_arrows && $('html').hasClass('no-touch')) {
				show_nav_arrows(this, settings);
			};
		});
		
		if ($('html').hasClass('touch')) {
			$(window).on('orientationchange resize', function(e) {
				self.on_resize();
			});
			self.update_slide_number(idx);
		} else {
			$(window).smartresize(function() {
				self.on_resize();
			});
		};
		
		self.show_all();
	};
	
	var ProductsGrid = function(el, settings) {
		var self = this,
			container = el,
			featured_items_count,
			featured_item_width,
			count_visible_items,
			$grid = $('.category-products');
				
		self.setItemWidth = function() {
			featured_item_width = settings.min_item_width;
			if($grid.hasClass('list') || parseInt($grid.css('border-left-width')) == 3) {
				var list_width = parseInt($grid.width());
				featured_item_width = list_width;
			}
			var number_of_items = 0;
			var margin_right = parseInt($grid.find('.'+settings.item_selector+':first-child').css("margin-right"));
			var available_width = parseInt($grid.width());
			while(featured_item_width >= settings.min_item_width) {
				number_of_items++;
				featured_item_width = available_width / number_of_items
			}
			if (number_of_items > 1) number_of_items = number_of_items - 1;
			if($grid.hasClass('list') || parseInt($grid.css('border-left-width')) == 3) {
				number_of_items = 1;
			}
			count_visible_items = number_of_items;
			featured_item_width = parseInt(available_width / number_of_items);
			$(container).find('.'+settings.item_selector).css("width", featured_item_width - margin_right - 1);
		};
		
		self.slide_layered_nav = function() {
			if ($(container).find('.layered-nav-container').hasClass('open')) {
				$('.layered-nav-toggle').removeClass('active');
				$(container).find('.layered-nav-container').animate({ left : -260 }, 300).removeClass('open');
				$grid.animate({ marginLeft : '3.5%' }, 300, function() {
					$grid.removeClass('list-narrow');
					self.setItemWidth();
					$grid.isotope().isotope('layout');
				});
			} else {
				$('.layered-nav-toggle').addClass('active');
				$(container).find('.layered-nav-container').animate({ left : 0 }, 300).addClass('open');
				$grid.animate({ marginLeft : '268' }, 300, function() {
					if(document.documentElement.clientWidth / parseFloat($("body").css("font-size")) <= 64 &&
						$grid.hasClass('list')) {
							$grid.addClass('list-narrow');
					}
					self.setItemWidth();
					$grid.isotope().isotope('layout');
				});
			}
		};

		self.narrow_list_check = function() {
			// if layered nav is open and width < 64rem add narrow-list style
			$grid.removeClass('list-narrow');
			if(document.documentElement.clientWidth / parseFloat($("body").css("font-size")) <= 64 &&
				$(container).find('.layered-nav-container').hasClass('open')) {
					$grid.addClass('list-narrow');
			}
		};
		
		self.list_mode = function() {
			$grid.addClass('list');
			if(document.documentElement.clientWidth / parseFloat($("body").css("font-size")) <= 40) {
				$grid.addClass('list-narrow');
			}
			self.narrow_list_check();
			self.setItemWidth();
			$grid.isotope().isotope('layout');
			$('.toggle-grid').removeClass('active');
			$('.toggle-list').addClass('active');
			if(readCookie('mage-listmode') == null){
				createCookie('mage-listmode', 1, 10);
			}
		};
		
		self.grid_mode = function() {
			$grid.removeClass('list');
			$grid.removeClass('list-narrow');
			self.setItemWidth();
			$grid.isotope().isotope('layout');
			$('.toggle-list').removeClass('active');
			$('.toggle-grid').addClass('active');
			eraseCookie('mage-listmode');
		};
		
		self.init = function() {
			if(readCookie('mage-listmode')) {
				self.list_mode();
			}
			if ($(container).find('.layered-nav-container').hasClass('open')) {
				$(container).find('.layered-nav-container').css({ left : 0, display : 'block' });
				$('.layered-nav-toggle').addClass('active');
				$grid.css({ marginLeft : '268px' });
				if(document.documentElement.clientWidth / parseFloat($("body").css("font-size")) <= 64 &&
					$grid.hasClass('list')) {
						$grid.addClass('list-narrow');
				}
				self.setItemWidth();
				$grid.isotope().isotope('layout');
			} else {
				$(container).find('.layered-nav-container').css({ left : -260, display : 'block' });
			}
			self.setItemWidth();
			$(container).on('click', '.layered-nav-toggle', function(e) {
				e.preventDefault();
				self.slide_layered_nav();
			});
			$(container).on('click', '.toggle-list', function(e) {
				e.preventDefault();
				self.list_mode();
			});
			$(container).on('click', '.toggle-grid', function(e) {
				e.preventDefault();
				self.grid_mode();
			});
			if(settings.show_filters_by_default == true) {
				self.slide_layered_nav();
			} else if($(location).attr('href').replace(/^.*?(#|$)/,'') == 'layered-nav') {
				self.slide_layered_nav();
			}
			if ($('#catalog-listing').hasClass('keep-aspect-ratio')) {
				// masonry layout is enabled - check for images to load
				imagesLoaded($grid, function() {
					$grid.isotope({
					  	itemSelector: '.isotope-item'
					});
				});
				// reload masonry layout when clicking configurable swatch
				$('.swatch-link').on('click', function(e){
					var img = $(this).parents('.item-content').find('.item-images');
					imagesLoaded(img,
						function(img){
							$grid.isotope('reloadItems');
							$grid.isotope().isotope('layout');
						});
				});
			} else {
				$grid.isotope({
				  	itemSelector: '.isotope-item'
				});
			}
			$('#catalog-listing').on('isotope:update', function(e) {
				// masonry layout is enabled - check for images to load
				if ($('#catalog-listing').hasClass('keep-aspect-ratio')) {
					imagesLoaded($grid, function() {
						self.setItemWidth();
						$grid.isotope('reloadItems');
						$grid.isotope().isotope('layout');
					});
				} else {
					self.setItemWidth();
					$grid.isotope('reloadItems');
					$grid.isotope().isotope('layout');
				}
				init_form_select();
			});
			$(document).ready(function() {
				$(document).trigger('product-media-loaded');
			});
		};
		
		self.init();

		if ($('html').hasClass('touch')) {
			$(window).on('orientationchange resize', function(e) {
				setTimeout(function(){
					self.narrow_list_check();
					self.setItemWidth();
					$grid.isotope().isotope('layout');
				},500);
			});
		} else {
			$(window).resize(function() {
				if(document.documentElement.clientWidth / parseFloat($("body").css("font-size")) > 64) {
					$grid.removeClass('list-narrow');
				} else if(document.documentElement.clientWidth / parseFloat($("body").css("font-size")) <= 64 &&
						$grid.hasClass('list') &&
						$('.layered-nav-toggle').hasClass('active')) {
							$grid.addClass('list-narrow');
				}
				self.setItemWidth();
				$grid.isotope().isotope('layout');
			});
		}
	};
	
	var SlideAnimation = function(settings) {
		var duration;
    	var is_rtl = ($('html[dir=rtl]').length === 1);
    	var margin = is_rtl ? 'marginRight' : 'marginLeft';
    	var animMargin = {};
		var current = this.current;

	    this.next = function(slides, uuid, current, next, adjust_last_page, count_visible_items, featured_item_width, no_animate) {
			duration = (no_animate) ? 0 : settings.animation_speed;
			animMargin[margin] = -(next*count_visible_items*featured_item_width) -12 + adjust_last_page;
			slides.animate(animMargin, duration, function() {
				current[uuid, slides.index()-1] = next;
				// force lazy loading plugin to render without scroll
				setTimeout(function(){ echo.render(); },0);
			});
	    };

	    this.prev = function(slides, uuid, current, prev, empty_positions, count_visible_items, featured_item_width, no_animate) {
			duration = (no_animate) ? 0 : settings.animation_speed;
			animMargin[margin] = -(prev*count_visible_items*featured_item_width)-12;
			slides.animate(animMargin, duration, function() {
				current[uuid, slides.index()-1] = prev;
				// force lazy loading plugin to render without scroll
				setTimeout(function(){ echo.render('render'); },0);
			});
	    };
  };
		
	window.Intenso = {
    name : 'Intenso',

    version : '1.0.0',
		
		init : function (scope, libraries, method, options, response) {
			var library_arr,
          args = [scope, method, options, response],
          responses = [];
			
			// set global scope
      this.scope = scope || this.scope;
			
			if (libraries && typeof libraries === 'string') {
        if (this.libs.hasOwnProperty(libraries)) {
          responses.push(this.init_lib(libraries, args));
        }
      } else {
        for (var lib in this.libs) {
          responses.push(this.init_lib(lib, libraries));
        }
      }

      return scope;
		},
		
		init_lib : function (lib, args) {
      if (this.libs.hasOwnProperty(lib)) {

        if (args && args.hasOwnProperty(lib)) {
          return this.libs[lib].init.apply(this.libs[lib], [this.scope, args[lib]]);
        }

        args = args instanceof Array ? args : Array(args);    // PATCH: added this line
        return this.libs[lib].init.apply(this.libs[lib], args);
      }

      return function () {};
    },
		
		libs : {}
		
	};

	$.fn.intenso = function () {
		var args = Array.prototype.slice.call(arguments, 0);

    return this.each(function () {
      Intenso.init.apply(Intenso, [this].concat(args));
      return this;
    });
  };
	
	Intenso.libs = Intenso.libs || {};

	// User interface 
  Intenso.libs.ui = {
		settings: {
			svg_fallback: true
		},
		
		init : function(scope, method, options){
			var self = this;
			var settings = $.extend({}, self.settings, (options || method));
			Intenso.libs.ui.setup(settings);
		},
		
		setup : function(settings){
			if(settings.svg_fallback) replace_inline_SVG();
			touch_exit_canvas();
			// Toggle placeholder´s text on focus/blur
			toggle_input_placeholder();
			// Close offcanvas menu on browser resize
			if ($('html').hasClass('touch')) {
				$(window).on('orientationchange resize', function(e) {
					if(document.documentElement.clientWidth / parseFloat($("body").css("font-size")) >= 40.063) {
						$(".off-canvas-wrap").removeClass("move-left");
						$(".off-canvas-wrap").removeClass("move-right");
					}
				});
			} else {
				$( window ).resize(function() {
					if(document.documentElement.clientWidth / parseFloat($("body").css("font-size")) >= 40.063) {
						$(".off-canvas-wrap").removeClass("move-left");
						$(".off-canvas-wrap").removeClass("move-right");
					}
				});
			}
			// add empty span referencing main color to allow querying main color when needed
			$('<span class="main-color"></span>').appendTo('body');
			// open global message (if any)
			$("#reveal-messages").foundation("reveal", "open");

			back_to_top();

			init_form_select(); // Init form selects
			bind_inputbox_focus(); // Change border color on input focus and animate labels
			fix_label(); // Add class to textarea, checkbox and radio labels
			toggle_newsletter_inputbox(); // Toggle newsletter inputbox on click
			toggle_tags_inputbox(); // Toggle tags inputbox on click
			toggle_secmenu(); // prevent menu from losing focus when select-box option is hover
			init_mega_menu();
			init_vertical_menu();
			echo.init({ // init lazy loading of images
				offset: 300,
				throttle: 250,
				unload: false,
				callback: function(element, op) {
					if(op === 'load') {
						$(element).css('background-image', 'none');
					}
				}
			});
		},
		bindInputboxes : function() {
			bind_inputbox_focus();
		},
		readCookie : function(name) {
			return readCookie(name);
		},
		createCookie : function(name, value, days) {
			createCookie(name, value, days);
		},
		eraseCookie : function(name) {
			eraseCookie(name);
		}
	},
	
	// Mini cart dropdown
	Intenso.libs.miniCart = {
		settings: {
			sliderWidth: '322'
		},
		
		init : function(scope, method, options){
			var self = this;
			var settings = $.extend({}, self.settings, (options || method));
			Intenso.libs.miniCart.setup(settings);
		},
		
		setup : function(settings){
			minicart_build_markup();
			minicart_toggle_item_attr();
			minicart_slider_control(settings.sliderWidth);
		}
	},
	
	// Featured slider
	Intenso.libs.featured = {
		settings: {
			container_class: 'featured-slider',
			sneak_peak_width: 32,
			min_item_width: 220,
			animation_speed: 300,
			slide_selector: 'item',
			navigation_arrows: true,
			prev_class: 'featured-prev',
			next_class: 'featured-next',
			bullets: true,
			max_bullets_count: 10,
			bullets_active_class: 'active',
			category_nav_menu: true,
			swipe: true
		},
		
		uuid : function (separator) {
			var delim = separator || "-",
				self = this;

			function S4() {
				return random_str(5);
			}

			return (S4() + S4() + delim + S4() + delim + S4()
				+ delim + S4() + delim + S4() + S4() + S4());
		},
		
		init : function(scope, method, options){
			var self = this,
				data_options_attr = data_options($('.featured-slider')); // get data attr
			var settings = $.extend({}, self.settings, data_options_attr);
			Intenso.libs.featured.setup(settings);
		},
		
		setup : function(settings){
			var self = this;
			$('.'+settings.container_class).each(function(){
				var uuid = self .uuid();
				$(this).attr('data-uuid', uuid);
				var featured_instance = new Featured(this, settings, uuid);
			});
		}
	},
	
	// Orbit slider
	Intenso.libs.orbit = {
		settings: {
			outside_bullets: false
		},

		init : function(){
			var self = this,
				data_options = Foundation.utils.data_options($('.orbit-slides-container')); // get data attr
					
			var settings = $.extend({}, self.settings, $('.orbit-slides-container').data('orbit-init'), data_options);
			Intenso.libs.orbit.setup(settings);
		},
		
		setup : function(settings){
			$('.'+settings.container_class).each(function(){
				var orbit_slider_instance = new OrbitSlider($(this).parent('.orbit-container'), settings);
			});
		}
	},
	
	// Brands slider
	Intenso.libs.brandSlider = {
		settings: {
			container_class: 'brand-slider',
			sneak_peak_width: 62,
			min_item_width: 120,
			animation_speed: 300,
			slide_selector: 'brand',
			navigation_arrows: true,
			prev_class: 'brand-prev',
			next_class: 'brand-next',
			bullets: true,
			max_bullets_count: 10,
			bullets_active_class: 'active',
			swipe: true
		},
		
		uuid : function (separator) {
      var delim = separator || "-",
          self = this;

      function S4() {
        return random_str(5);
      }

      return (S4() + S4() + delim + S4() + delim + S4()
        + delim + S4() + delim + S4() + S4() + S4());
    },
		
		init : function(scope, method, options){
			var self = this,
				data_options_attr = data_options($('.brand-slider')); // get data attr
			var settings = $.extend({}, self.settings, data_options_attr);
			Intenso.libs.brandSlider.setup(settings);
		},
		
		setup : function(settings){
			var self = this;
			$('.'+settings.container_class).each(function(){
				var uuid = self .uuid();
				$(this).attr('data-uuid', uuid);
				var brandSlider_instance = new BrandSlider(this, settings, uuid);
			});
		}
	},
	
	// Products Grid
	Intenso.libs.productsGrid = {
		settings: {
			container_class: 'products-grid',
			min_item_width: 220,
			item_selector: 'item',
			show_filters_by_default: false
		},
		
		init : function(scope, method, options){
			var self = this;
			var settings = $.extend({}, self.settings, (options || method));
			Intenso.libs.productsGrid.setup(settings);
		},
		
		setup : function(settings){
			var self = this;
			var productsGrid_instance = new ProductsGrid($('.'+settings.container_class), settings);
		}
	}

}(jQuery, this, this.document));

(function($,sr){
  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null;
          };

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100);
      };
  }
  // smartresize 
  jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');


/*!
 * Isotope PACKAGED v2.0.0
 * Filter & sort magical layouts
 * http://isotope.metafizzy.co
 */
(function(t){function e(){}function i(t){function i(e){e.prototype.option||(e.prototype.option=function(e){t.isPlainObject(e)&&(this.options=t.extend(!0,this.options,e))})}function n(e,i){t.fn[e]=function(n){if("string"==typeof n){for(var s=o.call(arguments,1),a=0,u=this.length;u>a;a++){var p=this[a],h=t.data(p,e);if(h)if(t.isFunction(h[n])&&"_"!==n.charAt(0)){var f=h[n].apply(h,s);if(void 0!==f)return f}else r("no such method '"+n+"' for "+e+" instance");else r("cannot call methods on "+e+" prior to initialization; "+"attempted to call '"+n+"'")}return this}return this.each(function(){var o=t.data(this,e);o?(o.option(n),o._init()):(o=new i(this,n),t.data(this,e,o))})}}if(t){var r="undefined"==typeof console?e:function(t){console.error(t)};return t.bridget=function(t,e){i(e),n(t,e)},t.bridget}}var o=Array.prototype.slice;"function"==typeof define&&define.amd?define("jquery-bridget/jquery.bridget",["jquery"],i):i(t.jQuery)})(window),function(t){function e(e){var i=t.event;return i.target=i.target||i.srcElement||e,i}var i=document.documentElement,o=function(){};i.addEventListener?o=function(t,e,i){t.addEventListener(e,i,!1)}:i.attachEvent&&(o=function(t,i,o){t[i+o]=o.handleEvent?function(){var i=e(t);o.handleEvent.call(o,i)}:function(){var i=e(t);o.call(t,i)},t.attachEvent("on"+i,t[i+o])});var n=function(){};i.removeEventListener?n=function(t,e,i){t.removeEventListener(e,i,!1)}:i.detachEvent&&(n=function(t,e,i){t.detachEvent("on"+e,t[e+i]);try{delete t[e+i]}catch(o){t[e+i]=void 0}});var r={bind:o,unbind:n};"function"==typeof define&&define.amd?define("eventie/eventie",r):"object"==typeof exports?module.exports=r:t.eventie=r}(this),function(t){function e(t){"function"==typeof t&&(e.isReady?t():r.push(t))}function i(t){var i="readystatechange"===t.type&&"complete"!==n.readyState;if(!e.isReady&&!i){e.isReady=!0;for(var o=0,s=r.length;s>o;o++){var a=r[o];a()}}}function o(o){return o.bind(n,"DOMContentLoaded",i),o.bind(n,"readystatechange",i),o.bind(t,"load",i),e}var n=t.document,r=[];e.isReady=!1,"function"==typeof define&&define.amd?(e.isReady="function"==typeof requirejs,define("doc-ready/doc-ready",["eventie/eventie"],o)):t.docReady=o(t.eventie)}(this),function(){function t(){}function e(t,e){for(var i=t.length;i--;)if(t[i].listener===e)return i;return-1}function i(t){return function(){return this[t].apply(this,arguments)}}var o=t.prototype,n=this,r=n.EventEmitter;o.getListeners=function(t){var e,i,o=this._getEvents();if(t instanceof RegExp){e={};for(i in o)o.hasOwnProperty(i)&&t.test(i)&&(e[i]=o[i])}else e=o[t]||(o[t]=[]);return e},o.flattenListeners=function(t){var e,i=[];for(e=0;t.length>e;e+=1)i.push(t[e].listener);return i},o.getListenersAsObject=function(t){var e,i=this.getListeners(t);return i instanceof Array&&(e={},e[t]=i),e||i},o.addListener=function(t,i){var o,n=this.getListenersAsObject(t),r="object"==typeof i;for(o in n)n.hasOwnProperty(o)&&-1===e(n[o],i)&&n[o].push(r?i:{listener:i,once:!1});return this},o.on=i("addListener"),o.addOnceListener=function(t,e){return this.addListener(t,{listener:e,once:!0})},o.once=i("addOnceListener"),o.defineEvent=function(t){return this.getListeners(t),this},o.defineEvents=function(t){for(var e=0;t.length>e;e+=1)this.defineEvent(t[e]);return this},o.removeListener=function(t,i){var o,n,r=this.getListenersAsObject(t);for(n in r)r.hasOwnProperty(n)&&(o=e(r[n],i),-1!==o&&r[n].splice(o,1));return this},o.off=i("removeListener"),o.addListeners=function(t,e){return this.manipulateListeners(!1,t,e)},o.removeListeners=function(t,e){return this.manipulateListeners(!0,t,e)},o.manipulateListeners=function(t,e,i){var o,n,r=t?this.removeListener:this.addListener,s=t?this.removeListeners:this.addListeners;if("object"!=typeof e||e instanceof RegExp)for(o=i.length;o--;)r.call(this,e,i[o]);else for(o in e)e.hasOwnProperty(o)&&(n=e[o])&&("function"==typeof n?r.call(this,o,n):s.call(this,o,n));return this},o.removeEvent=function(t){var e,i=typeof t,o=this._getEvents();if("string"===i)delete o[t];else if(t instanceof RegExp)for(e in o)o.hasOwnProperty(e)&&t.test(e)&&delete o[e];else delete this._events;return this},o.removeAllListeners=i("removeEvent"),o.emitEvent=function(t,e){var i,o,n,r,s=this.getListenersAsObject(t);for(n in s)if(s.hasOwnProperty(n))for(o=s[n].length;o--;)i=s[n][o],i.once===!0&&this.removeListener(t,i.listener),r=i.listener.apply(this,e||[]),r===this._getOnceReturnValue()&&this.removeListener(t,i.listener);return this},o.trigger=i("emitEvent"),o.emit=function(t){var e=Array.prototype.slice.call(arguments,1);return this.emitEvent(t,e)},o.setOnceReturnValue=function(t){return this._onceReturnValue=t,this},o._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},o._getEvents=function(){return this._events||(this._events={})},t.noConflict=function(){return n.EventEmitter=r,t},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return t}):"object"==typeof module&&module.exports?module.exports=t:this.EventEmitter=t}.call(this),function(t){function e(t){if(t){if("string"==typeof o[t])return t;t=t.charAt(0).toUpperCase()+t.slice(1);for(var e,n=0,r=i.length;r>n;n++)if(e=i[n]+t,"string"==typeof o[e])return e}}var i="Webkit Moz ms Ms O".split(" "),o=document.documentElement.style;"function"==typeof define&&define.amd?define("get-style-property/get-style-property",[],function(){return e}):"object"==typeof exports?module.exports=e:t.getStyleProperty=e}(window),function(t){function e(t){var e=parseFloat(t),i=-1===t.indexOf("%")&&!isNaN(e);return i&&e}function i(){for(var t={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},e=0,i=s.length;i>e;e++){var o=s[e];t[o]=0}return t}function o(t){function o(t){if("string"==typeof t&&(t=document.querySelector(t)),t&&"object"==typeof t&&t.nodeType){var o=r(t);if("none"===o.display)return i();var n={};n.width=t.offsetWidth,n.height=t.offsetHeight;for(var h=n.isBorderBox=!(!p||!o[p]||"border-box"!==o[p]),f=0,c=s.length;c>f;f++){var d=s[f],l=o[d];l=a(t,l);var y=parseFloat(l);n[d]=isNaN(y)?0:y}var m=n.paddingLeft+n.paddingRight,g=n.paddingTop+n.paddingBottom,v=n.marginLeft+n.marginRight,_=n.marginTop+n.marginBottom,I=n.borderLeftWidth+n.borderRightWidth,L=n.borderTopWidth+n.borderBottomWidth,z=h&&u,S=e(o.width);S!==!1&&(n.width=S+(z?0:m+I));var b=e(o.height);return b!==!1&&(n.height=b+(z?0:g+L)),n.innerWidth=n.width-(m+I),n.innerHeight=n.height-(g+L),n.outerWidth=n.width+v,n.outerHeight=n.height+_,n}}function a(t,e){if(n||-1===e.indexOf("%"))return e;var i=t.style,o=i.left,r=t.runtimeStyle,s=r&&r.left;return s&&(r.left=t.currentStyle.left),i.left=e,e=i.pixelLeft,i.left=o,s&&(r.left=s),e}var u,p=t("boxSizing");return function(){if(p){var t=document.createElement("div");t.style.width="200px",t.style.padding="1px 2px 3px 4px",t.style.borderStyle="solid",t.style.borderWidth="1px 2px 3px 4px",t.style[p]="border-box";var i=document.body||document.documentElement;i.appendChild(t);var o=r(t);u=200===e(o.width),i.removeChild(t)}}(),o}var n=t.getComputedStyle,r=n?function(t){return n(t,null)}:function(t){return t.currentStyle},s=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"];"function"==typeof define&&define.amd?define("get-size/get-size",["get-style-property/get-style-property"],o):"object"==typeof exports?module.exports=o(require("get-style-property")):t.getSize=o(t.getStyleProperty)}(window),function(t,e){function i(t,e){return t[a](e)}function o(t){if(!t.parentNode){var e=document.createDocumentFragment();e.appendChild(t)}}function n(t,e){o(t);for(var i=t.parentNode.querySelectorAll(e),n=0,r=i.length;r>n;n++)if(i[n]===t)return!0;return!1}function r(t,e){return o(t),i(t,e)}var s,a=function(){if(e.matchesSelector)return"matchesSelector";for(var t=["webkit","moz","ms","o"],i=0,o=t.length;o>i;i++){var n=t[i],r=n+"MatchesSelector";if(e[r])return r}}();if(a){var u=document.createElement("div"),p=i(u,"div");s=p?i:r}else s=n;"function"==typeof define&&define.amd?define("matches-selector/matches-selector",[],function(){return s}):window.matchesSelector=s}(this,Element.prototype),function(t){function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t){for(var e in t)return!1;return e=null,!0}function o(t){return t.replace(/([A-Z])/g,function(t){return"-"+t.toLowerCase()})}function n(t,n,r){function a(t,e){t&&(this.element=t,this.layout=e,this.position={x:0,y:0},this._create())}var u=r("transition"),p=r("transform"),h=u&&p,f=!!r("perspective"),c={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"otransitionend",transition:"transitionend"}[u],d=["transform","transition","transitionDuration","transitionProperty"],l=function(){for(var t={},e=0,i=d.length;i>e;e++){var o=d[e],n=r(o);n&&n!==o&&(t[o]=n)}return t}();e(a.prototype,t.prototype),a.prototype._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},a.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},a.prototype.getSize=function(){this.size=n(this.element)},a.prototype.css=function(t){var e=this.element.style;for(var i in t){var o=l[i]||i;e[o]=t[i]}},a.prototype.getPosition=function(){var t=s(this.element),e=this.layout.options,i=e.isOriginLeft,o=e.isOriginTop,n=parseInt(t[i?"left":"right"],10),r=parseInt(t[o?"top":"bottom"],10);n=isNaN(n)?0:n,r=isNaN(r)?0:r;var a=this.layout.size;n-=i?a.paddingLeft:a.paddingRight,r-=o?a.paddingTop:a.paddingBottom,this.position.x=n,this.position.y=r},a.prototype.layoutPosition=function(){var t=this.layout.size,e=this.layout.options,i={};e.isOriginLeft?(i.left=this.position.x+t.paddingLeft+"px",i.right=""):(i.right=this.position.x+t.paddingRight+"px",i.left=""),e.isOriginTop?(i.top=this.position.y+t.paddingTop+"px",i.bottom=""):(i.bottom=this.position.y+t.paddingBottom+"px",i.top=""),this.css(i),this.emitEvent("layout",[this])};var y=f?function(t,e){return"translate3d("+t+"px, "+e+"px, 0)"}:function(t,e){return"translate("+t+"px, "+e+"px)"};a.prototype._transitionTo=function(t,e){this.getPosition();var i=this.position.x,o=this.position.y,n=parseInt(t,10),r=parseInt(e,10),s=n===this.position.x&&r===this.position.y;if(this.setPosition(t,e),s&&!this.isTransitioning)return this.layoutPosition(),void 0;var a=t-i,u=e-o,p={},h=this.layout.options;a=h.isOriginLeft?a:-a,u=h.isOriginTop?u:-u,p.transform=y(a,u),this.transition({to:p,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})},a.prototype.goTo=function(t,e){this.setPosition(t,e),this.layoutPosition()},a.prototype.moveTo=h?a.prototype._transitionTo:a.prototype.goTo,a.prototype.setPosition=function(t,e){this.position.x=parseInt(t,10),this.position.y=parseInt(e,10)},a.prototype._nonTransition=function(t){this.css(t.to),t.isCleaning&&this._removeStyles(t.to);for(var e in t.onTransitionEnd)t.onTransitionEnd[e].call(this)},a.prototype._transition=function(t){if(!parseFloat(this.layout.options.transitionDuration))return this._nonTransition(t),void 0;var e=this._transn;for(var i in t.onTransitionEnd)e.onEnd[i]=t.onTransitionEnd[i];for(i in t.to)e.ingProperties[i]=!0,t.isCleaning&&(e.clean[i]=!0);if(t.from){this.css(t.from);var o=this.element.offsetHeight;o=null}this.enableTransition(t.to),this.css(t.to),this.isTransitioning=!0};var m=p&&o(p)+",opacity";a.prototype.enableTransition=function(){this.isTransitioning||(this.css({transitionProperty:m,transitionDuration:this.layout.options.transitionDuration}),this.element.addEventListener(c,this,!1))},a.prototype.transition=a.prototype[u?"_transition":"_nonTransition"],a.prototype.onwebkitTransitionEnd=function(t){this.ontransitionend(t)},a.prototype.onotransitionend=function(t){this.ontransitionend(t)};var g={"-webkit-transform":"transform","-moz-transform":"transform","-o-transform":"transform"};a.prototype.ontransitionend=function(t){if(t.target===this.element){var e=this._transn,o=g[t.propertyName]||t.propertyName;if(delete e.ingProperties[o],i(e.ingProperties)&&this.disableTransition(),o in e.clean&&(this.element.style[t.propertyName]="",delete e.clean[o]),o in e.onEnd){var n=e.onEnd[o];n.call(this),delete e.onEnd[o]}this.emitEvent("transitionEnd",[this])}},a.prototype.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(c,this,!1),this.isTransitioning=!1},a.prototype._removeStyles=function(t){var e={};for(var i in t)e[i]="";this.css(e)};var v={transitionProperty:"",transitionDuration:""};return a.prototype.removeTransitionStyles=function(){this.css(v)},a.prototype.removeElem=function(){this.element.parentNode.removeChild(this.element),this.emitEvent("remove",[this])},a.prototype.remove=function(){if(!u||!parseFloat(this.layout.options.transitionDuration))return this.removeElem(),void 0;var t=this;this.on("transitionEnd",function(){return t.removeElem(),!0}),this.hide()},a.prototype.reveal=function(){delete this.isHidden,this.css({display:""});var t=this.layout.options;this.transition({from:t.hiddenStyle,to:t.visibleStyle,isCleaning:!0})},a.prototype.hide=function(){this.isHidden=!0,this.css({display:""});var t=this.layout.options;this.transition({from:t.visibleStyle,to:t.hiddenStyle,isCleaning:!0,onTransitionEnd:{opacity:function(){this.isHidden&&this.css({display:"none"})}}})},a.prototype.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},a}var r=t.getComputedStyle,s=r?function(t){return r(t,null)}:function(t){return t.currentStyle};"function"==typeof define&&define.amd?define("outlayer/item",["eventEmitter/EventEmitter","get-size/get-size","get-style-property/get-style-property"],n):(t.Outlayer={},t.Outlayer.Item=n(t.EventEmitter,t.getSize,t.getStyleProperty))}(window),function(t){function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t){return"[object Array]"===f.call(t)}function o(t){var e=[];if(i(t))e=t;else if(t&&"number"==typeof t.length)for(var o=0,n=t.length;n>o;o++)e.push(t[o]);else e.push(t);return e}function n(t,e){var i=d(e,t);-1!==i&&e.splice(i,1)}function r(t){return t.replace(/(.)([A-Z])/g,function(t,e,i){return e+"-"+i}).toLowerCase()}function s(i,s,f,d,l,y){function m(t,i){if("string"==typeof t&&(t=a.querySelector(t)),!t||!c(t))return u&&u.error("Bad "+this.constructor.namespace+" element: "+t),void 0;this.element=t,this.options=e({},this.constructor.defaults),this.option(i);var o=++g;this.element.outlayerGUID=o,v[o]=this,this._create(),this.options.isInitLayout&&this.layout()}var g=0,v={};return m.namespace="outlayer",m.Item=y,m.defaults={containerStyle:{position:"relative"},isInitLayout:!0,isOriginLeft:!0,isOriginTop:!0,isResizeBound:!0,isResizingContainer:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}},e(m.prototype,f.prototype),m.prototype.option=function(t){e(this.options,t)},m.prototype._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),e(this.element.style,this.options.containerStyle),this.options.isResizeBound&&this.bindResize()},m.prototype.reloadItems=function(){this.items=this._itemize(this.element.children)},m.prototype._itemize=function(t){for(var e=this._filterFindItemElements(t),i=this.constructor.Item,o=[],n=0,r=e.length;r>n;n++){var s=e[n],a=new i(s,this);o.push(a)}return o},m.prototype._filterFindItemElements=function(t){t=o(t);for(var e=this.options.itemSelector,i=[],n=0,r=t.length;r>n;n++){var s=t[n];if(c(s))if(e){l(s,e)&&i.push(s);for(var a=s.querySelectorAll(e),u=0,p=a.length;p>u;u++)i.push(a[u])}else i.push(s)}return i},m.prototype.getItemElements=function(){for(var t=[],e=0,i=this.items.length;i>e;e++)t.push(this.items[e].element);return t},m.prototype.layout=function(){this._resetLayout(),this._manageStamps();var t=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;this.layoutItems(this.items,t),this._isLayoutInited=!0},m.prototype._init=m.prototype.layout,m.prototype._resetLayout=function(){this.getSize()},m.prototype.getSize=function(){this.size=d(this.element)},m.prototype._getMeasurement=function(t,e){var i,o=this.options[t];o?("string"==typeof o?i=this.element.querySelector(o):c(o)&&(i=o),this[t]=i?d(i)[e]:o):this[t]=0},m.prototype.layoutItems=function(t,e){t=this._getItemsForLayout(t),this._layoutItems(t,e),this._postLayout()},m.prototype._getItemsForLayout=function(t){for(var e=[],i=0,o=t.length;o>i;i++){var n=t[i];n.isIgnored||e.push(n)}return e},m.prototype._layoutItems=function(t,e){function i(){o.emitEvent("layoutComplete",[o,t])}var o=this;if(!t||!t.length)return i(),void 0;this._itemsOn(t,"layout",i);for(var n=[],r=0,s=t.length;s>r;r++){var a=t[r],u=this._getItemLayoutPosition(a);u.item=a,u.isInstant=e||a.isLayoutInstant,n.push(u)}this._processLayoutQueue(n)},m.prototype._getItemLayoutPosition=function(){return{x:0,y:0}},m.prototype._processLayoutQueue=function(t){for(var e=0,i=t.length;i>e;e++){var o=t[e];this._positionItem(o.item,o.x,o.y,o.isInstant)}},m.prototype._positionItem=function(t,e,i,o){o?t.goTo(e,i):t.moveTo(e,i)},m.prototype._postLayout=function(){this.resizeContainer()},m.prototype.resizeContainer=function(){if(this.options.isResizingContainer){var t=this._getContainerSize();t&&(this._setContainerMeasure(t.width,!0),this._setContainerMeasure(t.height,!1))}},m.prototype._getContainerSize=h,m.prototype._setContainerMeasure=function(t,e){if(void 0!==t){var i=this.size;i.isBorderBox&&(t+=e?i.paddingLeft+i.paddingRight+i.borderLeftWidth+i.borderRightWidth:i.paddingBottom+i.paddingTop+i.borderTopWidth+i.borderBottomWidth),t=Math.max(t,0),this.element.style[e?"width":"height"]=t+"px"}},m.prototype._itemsOn=function(t,e,i){function o(){return n++,n===r&&i.call(s),!0}for(var n=0,r=t.length,s=this,a=0,u=t.length;u>a;a++){var p=t[a];p.on(e,o)}},m.prototype.ignore=function(t){var e=this.getItem(t);e&&(e.isIgnored=!0)},m.prototype.unignore=function(t){var e=this.getItem(t);e&&delete e.isIgnored},m.prototype.stamp=function(t){if(t=this._find(t)){this.stamps=this.stamps.concat(t);for(var e=0,i=t.length;i>e;e++){var o=t[e];this.ignore(o)}}},m.prototype.unstamp=function(t){if(t=this._find(t))for(var e=0,i=t.length;i>e;e++){var o=t[e];n(o,this.stamps),this.unignore(o)}},m.prototype._find=function(t){return t?("string"==typeof t&&(t=this.element.querySelectorAll(t)),t=o(t)):void 0},m.prototype._manageStamps=function(){if(this.stamps&&this.stamps.length){this._getBoundingRect();for(var t=0,e=this.stamps.length;e>t;t++){var i=this.stamps[t];this._manageStamp(i)}}},m.prototype._getBoundingRect=function(){var t=this.element.getBoundingClientRect(),e=this.size;this._boundingRect={left:t.left+e.paddingLeft+e.borderLeftWidth,top:t.top+e.paddingTop+e.borderTopWidth,right:t.right-(e.paddingRight+e.borderRightWidth),bottom:t.bottom-(e.paddingBottom+e.borderBottomWidth)}},m.prototype._manageStamp=h,m.prototype._getElementOffset=function(t){var e=t.getBoundingClientRect(),i=this._boundingRect,o=d(t),n={left:e.left-i.left-o.marginLeft,top:e.top-i.top-o.marginTop,right:i.right-e.right-o.marginRight,bottom:i.bottom-e.bottom-o.marginBottom};return n},m.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},m.prototype.bindResize=function(){this.isResizeBound||(i.bind(t,"resize",this),this.isResizeBound=!0)},m.prototype.unbindResize=function(){this.isResizeBound&&i.unbind(t,"resize",this),this.isResizeBound=!1},m.prototype.onresize=function(){function t(){e.resize(),delete e.resizeTimeout}this.resizeTimeout&&clearTimeout(this.resizeTimeout);var e=this;this.resizeTimeout=setTimeout(t,100)},m.prototype.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&this.layout()},m.prototype.needsResizeLayout=function(){var t=d(this.element),e=this.size&&t;return e&&t.innerWidth!==this.size.innerWidth},m.prototype.addItems=function(t){var e=this._itemize(t);return e.length&&(this.items=this.items.concat(e)),e},m.prototype.appended=function(t){var e=this.addItems(t);e.length&&(this.layoutItems(e,!0),this.reveal(e))},m.prototype.prepended=function(t){var e=this._itemize(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this._manageStamps(),this.layoutItems(e,!0),this.reveal(e),this.layoutItems(i)}},m.prototype.reveal=function(t){var e=t&&t.length;if(e)for(var i=0;e>i;i++){var o=t[i];o.reveal()}},m.prototype.hide=function(t){var e=t&&t.length;if(e)for(var i=0;e>i;i++){var o=t[i];o.hide()}},m.prototype.getItem=function(t){for(var e=0,i=this.items.length;i>e;e++){var o=this.items[e];if(o.element===t)return o}},m.prototype.getItems=function(t){if(t&&t.length){for(var e=[],i=0,o=t.length;o>i;i++){var n=t[i],r=this.getItem(n);r&&e.push(r)}return e}},m.prototype.remove=function(t){t=o(t);var e=this.getItems(t);if(e&&e.length){this._itemsOn(e,"remove",function(){this.emitEvent("removeComplete",[this,e])});for(var i=0,r=e.length;r>i;i++){var s=e[i];s.remove(),n(s,this.items)}}},m.prototype.destroy=function(){var t=this.element.style;t.height="",t.position="",t.width="";for(var e=0,i=this.items.length;i>e;e++){var o=this.items[e];o.destroy()}this.unbindResize(),delete this.element.outlayerGUID,p&&p.removeData(this.element,this.constructor.namespace)},m.data=function(t){var e=t&&t.outlayerGUID;return e&&v[e]},m.create=function(t,i){function o(){m.apply(this,arguments)}return Object.create?o.prototype=Object.create(m.prototype):e(o.prototype,m.prototype),o.prototype.constructor=o,o.defaults=e({},m.defaults),e(o.defaults,i),o.prototype.settings={},o.namespace=t,o.data=m.data,o.Item=function(){y.apply(this,arguments)},o.Item.prototype=new y,s(function(){for(var e=r(t),i=a.querySelectorAll(".js-"+e),n="data-"+e+"-options",s=0,h=i.length;h>s;s++){var f,c=i[s],d=c.getAttribute(n);try{f=d&&JSON.parse(d)}catch(l){u&&u.error("Error parsing "+n+" on "+c.nodeName.toLowerCase()+(c.id?"#"+c.id:"")+": "+l);continue}var y=new o(c,f);p&&p.data(c,t,y)}}),p&&p.bridget&&p.bridget(t,o),o},m.Item=y,m}var a=t.document,u=t.console,p=t.jQuery,h=function(){},f=Object.prototype.toString,c="object"==typeof HTMLElement?function(t){return t instanceof HTMLElement}:function(t){return t&&"object"==typeof t&&1===t.nodeType&&"string"==typeof t.nodeName},d=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,o=t.length;o>i;i++)if(t[i]===e)return i;return-1};"function"==typeof define&&define.amd?define("outlayer/outlayer",["eventie/eventie","doc-ready/doc-ready","eventEmitter/EventEmitter","get-size/get-size","matches-selector/matches-selector","./item"],s):t.Outlayer=s(t.eventie,t.docReady,t.EventEmitter,t.getSize,t.matchesSelector,t.Outlayer.Item)}(window),function(t){function e(t){function e(){t.Item.apply(this,arguments)}return e.prototype=new t.Item,e.prototype._create=function(){this.id=this.layout.itemGUID++,t.Item.prototype._create.call(this),this.sortData={}},e.prototype.updateSortData=function(){if(!this.isIgnored){this.sortData.id=this.id,this.sortData["original-order"]=this.id,this.sortData.random=Math.random();var t=this.layout.options.getSortData,e=this.layout._sorters;for(var i in t){var o=e[i];this.sortData[i]=o(this.element,this)}}},e}"function"==typeof define&&define.amd?define("isotope/js/item",["outlayer/outlayer"],e):(t.Isotope=t.Isotope||{},t.Isotope.Item=e(t.Outlayer))}(window),function(t){function e(t,e){function i(t){this.isotope=t,t&&(this.options=t.options[this.namespace],this.element=t.element,this.items=t.filteredItems,this.size=t.size)}return function(){function t(t){return function(){return e.prototype[t].apply(this.isotope,arguments)}}for(var o=["_resetLayout","_getItemLayoutPosition","_manageStamp","_getContainerSize","_getElementOffset","needsResizeLayout"],n=0,r=o.length;r>n;n++){var s=o[n];i.prototype[s]=t(s)}}(),i.prototype.needsVerticalResizeLayout=function(){var e=t(this.isotope.element),i=this.isotope.size&&e;return i&&e.innerHeight!==this.isotope.size.innerHeight},i.prototype._getMeasurement=function(){this.isotope._getMeasurement.apply(this,arguments)},i.prototype.getColumnWidth=function(){this.getSegmentSize("column","Width")},i.prototype.getRowHeight=function(){this.getSegmentSize("row","Height")},i.prototype.getSegmentSize=function(t,e){var i=t+e,o="outer"+e;if(this._getMeasurement(i,o),!this[i]){var n=this.getFirstItemSize();this[i]=n&&n[o]||this.isotope.size["inner"+e]}},i.prototype.getFirstItemSize=function(){var e=this.isotope.filteredItems[0];return e&&e.element&&t(e.element)},i.prototype.layout=function(){this.isotope.layout.apply(this.isotope,arguments)},i.prototype.getSize=function(){this.isotope.getSize(),this.size=this.isotope.size},i.modes={},i.create=function(t,e){function o(){i.apply(this,arguments)}return o.prototype=new i,e&&(o.options=e),o.prototype.namespace=t,i.modes[t]=o,o},i}"function"==typeof define&&define.amd?define("isotope/js/layout-mode",["get-size/get-size","outlayer/outlayer"],e):(t.Isotope=t.Isotope||{},t.Isotope.LayoutMode=e(t.getSize,t.Outlayer))}(window),function(t){function e(t,e){var o=t.create("masonry");return o.prototype._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns();var t=this.cols;for(this.colYs=[];t--;)this.colYs.push(0);this.maxY=0},o.prototype.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var t=this.items[0],i=t&&t.element;this.columnWidth=i&&e(i).outerWidth||this.containerWidth}this.columnWidth+=this.gutter,this.cols=Math.floor((this.containerWidth+this.gutter)/this.columnWidth),this.cols=Math.max(this.cols,1)},o.prototype.getContainerWidth=function(){var t=this.options.isFitWidth?this.element.parentNode:this.element,i=e(t);this.containerWidth=i&&i.innerWidth},o.prototype._getItemLayoutPosition=function(t){t.getSize();var e=t.size.outerWidth%this.columnWidth,o=e&&1>e?"round":"ceil",n=Math[o](t.size.outerWidth/this.columnWidth);n=Math.min(n,this.cols);for(var r=this._getColGroup(n),s=Math.min.apply(Math,r),a=i(r,s),u={x:this.columnWidth*a,y:s},p=s+t.size.outerHeight,h=this.cols+1-r.length,f=0;h>f;f++)this.colYs[a+f]=p;return u},o.prototype._getColGroup=function(t){if(2>t)return this.colYs;for(var e=[],i=this.cols+1-t,o=0;i>o;o++){var n=this.colYs.slice(o,o+t);e[o]=Math.max.apply(Math,n)}return e},o.prototype._manageStamp=function(t){var i=e(t),o=this._getElementOffset(t),n=this.options.isOriginLeft?o.left:o.right,r=n+i.outerWidth,s=Math.floor(n/this.columnWidth);s=Math.max(0,s);var a=Math.floor(r/this.columnWidth);a-=r%this.columnWidth?0:1,a=Math.min(this.cols-1,a);for(var u=(this.options.isOriginTop?o.top:o.bottom)+i.outerHeight,p=s;a>=p;p++)this.colYs[p]=Math.max(u,this.colYs[p])},o.prototype._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var t={height:this.maxY};return this.options.isFitWidth&&(t.width=this._getContainerFitWidth()),t},o.prototype._getContainerFitWidth=function(){for(var t=0,e=this.cols;--e&&0===this.colYs[e];)t++;return(this.cols-t)*this.columnWidth-this.gutter},o.prototype.needsResizeLayout=function(){var t=this.containerWidth;return this.getContainerWidth(),t!==this.containerWidth},o}var i=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,o=t.length;o>i;i++){var n=t[i];if(n===e)return i}return-1};"function"==typeof define&&define.amd?define("masonry/masonry",["outlayer/outlayer","get-size/get-size"],e):t.Masonry=e(t.Outlayer,t.getSize)}(window),function(t){function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t,i){var o=t.create("masonry"),n=o.prototype._getElementOffset,r=o.prototype.layout,s=o.prototype._getMeasurement;e(o.prototype,i.prototype),o.prototype._getElementOffset=n,o.prototype.layout=r,o.prototype._getMeasurement=s;var a=o.prototype.measureColumns;o.prototype.measureColumns=function(){this.items=this.isotope.filteredItems,a.call(this)};var u=o.prototype._manageStamp;return o.prototype._manageStamp=function(){this.options.isOriginLeft=this.isotope.options.isOriginLeft,this.options.isOriginTop=this.isotope.options.isOriginTop,u.apply(this,arguments)},o}"function"==typeof define&&define.amd?define("isotope/js/layout-modes/masonry",["../layout-mode","masonry/masonry"],i):i(t.Isotope.LayoutMode,t.Masonry)}(window),function(t){function e(t){var e=t.create("fitRows");return e.prototype._resetLayout=function(){this.x=0,this.y=0,this.maxY=0},e.prototype._getItemLayoutPosition=function(t){t.getSize(),0!==this.x&&t.size.outerWidth+this.x>this.isotope.size.innerWidth&&(this.x=0,this.y=this.maxY);var e={x:this.x,y:this.y};return this.maxY=Math.max(this.maxY,this.y+t.size.outerHeight),this.x+=t.size.outerWidth,e},e.prototype._getContainerSize=function(){return{height:this.maxY}},e}"function"==typeof define&&define.amd?define("isotope/js/layout-modes/fit-rows",["../layout-mode"],e):e(t.Isotope.LayoutMode)}(window),function(t){function e(t){var e=t.create("vertical",{horizontalAlignment:0});return e.prototype._resetLayout=function(){this.y=0},e.prototype._getItemLayoutPosition=function(t){t.getSize();var e=(this.isotope.size.innerWidth-t.size.outerWidth)*this.options.horizontalAlignment,i=this.y;return this.y+=t.size.outerHeight,{x:e,y:i}},e.prototype._getContainerSize=function(){return{height:this.y}},e}"function"==typeof define&&define.amd?define("isotope/js/layout-modes/vertical",["../layout-mode"],e):e(t.Isotope.LayoutMode)}(window),function(t){function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t){return"[object Array]"===h.call(t)}function o(t){var e=[];if(i(t))e=t;else if(t&&"number"==typeof t.length)for(var o=0,n=t.length;n>o;o++)e.push(t[o]);else e.push(t);return e}function n(t,e){var i=f(e,t);-1!==i&&e.splice(i,1)}function r(t,i,r,u,h){function f(t,e){return function(i,o){for(var n=0,r=t.length;r>n;n++){var s=t[n],a=i.sortData[s],u=o.sortData[s];if(a>u||u>a){var p=void 0!==e[s]?e[s]:e,h=p?1:-1;return(a>u?1:-1)*h}}return 0}}var c=t.create("isotope",{layoutMode:"masonry",isJQueryFiltering:!0,sortAscending:!0});c.Item=u,c.LayoutMode=h,c.prototype._create=function(){this.itemGUID=0,this._sorters={},this._getSorters(),t.prototype._create.call(this),this.modes={},this.filteredItems=this.items,this.sortHistory=["original-order"];for(var e in h.modes)this._initLayoutMode(e)},c.prototype.reloadItems=function(){this.itemGUID=0,t.prototype.reloadItems.call(this)},c.prototype._itemize=function(){for(var e=t.prototype._itemize.apply(this,arguments),i=0,o=e.length;o>i;i++){var n=e[i];n.id=this.itemGUID++}return this._updateItemsSortData(e),e},c.prototype._initLayoutMode=function(t){var i=h.modes[t],o=this.options[t]||{};this.options[t]=i.options?e(i.options,o):o,this.modes[t]=new i(this)},c.prototype.layout=function(){return!this._isLayoutInited&&this.options.isInitLayout?(this.arrange(),void 0):(this._layout(),void 0)},c.prototype._layout=function(){var t=this._getIsInstant();this._resetLayout(),this._manageStamps(),this.layoutItems(this.filteredItems,t),this._isLayoutInited=!0},c.prototype.arrange=function(t){this.option(t),this._getIsInstant(),this.filteredItems=this._filter(this.items),this._sort(),this._layout()},c.prototype._init=c.prototype.arrange,c.prototype._getIsInstant=function(){var t=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;return this._isInstant=t,t},c.prototype._filter=function(t){function e(){f.reveal(n),f.hide(r)}var i=this.options.filter;i=i||"*";for(var o=[],n=[],r=[],s=this._getFilterTest(i),a=0,u=t.length;u>a;a++){var p=t[a];if(!p.isIgnored){var h=s(p);h&&o.push(p),h&&p.isHidden?n.push(p):h||p.isHidden||r.push(p)}}var f=this;return this._isInstant?this._noTransition(e):e(),o},c.prototype._getFilterTest=function(t){return s&&this.options.isJQueryFiltering?function(e){return s(e.element).is(t)}:"function"==typeof t?function(e){return t(e.element)}:function(e){return r(e.element,t)}},c.prototype.updateSortData=function(t){this._getSorters(),t=o(t);var e=this.getItems(t);e=e.length?e:this.items,this._updateItemsSortData(e)
},c.prototype._getSorters=function(){var t=this.options.getSortData;for(var e in t){var i=t[e];this._sorters[e]=d(i)}},c.prototype._updateItemsSortData=function(t){for(var e=0,i=t.length;i>e;e++){var o=t[e];o.updateSortData()}};var d=function(){function t(t){if("string"!=typeof t)return t;var i=a(t).split(" "),o=i[0],n=o.match(/^\[(.+)\]$/),r=n&&n[1],s=e(r,o),u=c.sortDataParsers[i[1]];return t=u?function(t){return t&&u(s(t))}:function(t){return t&&s(t)}}function e(t,e){var i;return i=t?function(e){return e.getAttribute(t)}:function(t){var i=t.querySelector(e);return i&&p(i)}}return t}();c.sortDataParsers={parseInt:function(t){return parseInt(t,10)},parseFloat:function(t){return parseFloat(t)}},c.prototype._sort=function(){var t=this.options.sortBy;if(t){var e=[].concat.apply(t,this.sortHistory),i=f(e,this.options.sortAscending);this.filteredItems.sort(i),t!==this.sortHistory[0]&&this.sortHistory.unshift(t)}},c.prototype._mode=function(){var t=this.options.layoutMode,e=this.modes[t];if(!e)throw Error("No layout mode: "+t);return e.options=this.options[t],e},c.prototype._resetLayout=function(){t.prototype._resetLayout.call(this),this._mode()._resetLayout()},c.prototype._getItemLayoutPosition=function(t){return this._mode()._getItemLayoutPosition(t)},c.prototype._manageStamp=function(t){this._mode()._manageStamp(t)},c.prototype._getContainerSize=function(){return this._mode()._getContainerSize()},c.prototype.needsResizeLayout=function(){return this._mode().needsResizeLayout()},c.prototype.appended=function(t){var e=this.addItems(t);if(e.length){var i=this._filterRevealAdded(e);this.filteredItems=this.filteredItems.concat(i)}},c.prototype.prepended=function(t){var e=this._itemize(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this._manageStamps();var o=this._filterRevealAdded(e);this.layoutItems(i),this.filteredItems=o.concat(this.filteredItems)}},c.prototype._filterRevealAdded=function(t){var e=this._noTransition(function(){return this._filter(t)});return this.layoutItems(e,!0),this.reveal(e),t},c.prototype.insert=function(t){var e=this.addItems(t);if(e.length){var i,o,n=e.length;for(i=0;n>i;i++)o=e[i],this.element.appendChild(o.element);var r=this._filter(e);for(this._noTransition(function(){this.hide(r)}),i=0;n>i;i++)e[i].isLayoutInstant=!0;for(this.arrange(),i=0;n>i;i++)delete e[i].isLayoutInstant;this.reveal(r)}};var l=c.prototype.remove;return c.prototype.remove=function(t){t=o(t);var e=this.getItems(t);if(l.call(this,t),e&&e.length)for(var i=0,r=e.length;r>i;i++){var s=e[i];n(s,this.filteredItems)}},c.prototype._noTransition=function(t){var e=this.options.transitionDuration;this.options.transitionDuration=0;var i=t.call(this);return this.options.transitionDuration=e,i},c}var s=t.jQuery,a=String.prototype.trim?function(t){return t.trim()}:function(t){return t.replace(/^\s+|\s+$/g,"")},u=document.documentElement,p=u.textContent?function(t){return t.textContent}:function(t){return t.innerText},h=Object.prototype.toString,f=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,o=t.length;o>i;i++)if(t[i]===e)return i;return-1};"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size","matches-selector/matches-selector","isotope/js/item","isotope/js/layout-mode","isotope/js/layout-modes/masonry","isotope/js/layout-modes/fit-rows","isotope/js/layout-modes/vertical"],r):t.Isotope=r(t.Outlayer,t.getSize,t.matchesSelector,t.Isotope.Item,t.Isotope.LayoutMode)}(window);


/**
* Event.simulate(@element, eventName[, options]) -> Element
*
* - @element: element to fire event on
* - eventName: name of event to fire (only MouseEvents and HTMLEvents interfaces are supported)
* - options: optional object to fine-tune event properties - pointerX, pointerY, ctrlKey, etc.
*
* $('foo').simulate('click'); // => fires "click" event on an element with id=foo
*
**/
(function(){
  
  var eventMatchers = {
    'HTMLEvents': /^(?:load|unload|abort|error|select|change|submit|reset|focus|blur|resize|scroll)$/,
    'MouseEvents': /^(?:click|mouse(?:down|up|over|move|out))$/
  }
  var defaultOptions = {
    pointerX: 0,
    pointerY: 0,
    button: 0,
    ctrlKey: false,
    altKey: false,
    shiftKey: false,
    metaKey: false,
    bubbles: true,
    cancelable: true
  }
  
  Event.simulate = function(element, eventName) {
    var options = Object.extend(defaultOptions, arguments[2] || { });
    var oEvent, eventType = null;
    
    element = $(element);
    
    for (var name in eventMatchers) {
      if (eventMatchers[name].test(eventName)) { eventType = name; break; }
    }

    if (!eventType)
      throw new SyntaxError('Only HTMLEvents and MouseEvents interfaces are supported');

    if (document.createEvent) {
      oEvent = document.createEvent(eventType);
      if (eventType == 'HTMLEvents') {
        oEvent.initEvent(eventName, options.bubbles, options.cancelable);
      }
      else {
        oEvent.initMouseEvent(eventName, options.bubbles, options.cancelable, document.defaultView,
          options.button, options.pointerX, options.pointerY, options.pointerX, options.pointerY,
          options.ctrlKey, options.altKey, options.shiftKey, options.metaKey, options.button, element);
      }
      element.dispatchEvent(oEvent);
    }
    else {
      options.clientX = options.pointerX;
      options.clientY = options.pointerY;
      oEvent = Object.extend(document.createEventObject(), options);
      element.fireEvent('on' + eventName, oEvent);
    }
    return element;
  }
  
  Element.addMethods({ simulate: Event.simulate });
})();

/*! echo.js v1.7.0 | (c) 2015 @toddmotto | https://github.com/toddmotto/echo */
!function(t,e){"function"==typeof define&&define.amd?define(function(){return e(t)}):"object"==typeof exports?module.exports=e:t.echo=e(t)}(this,function(t){"use strict";var e,n,o,r,c,a={},u=function(){},d=function(t){return null===t.offsetParent},i=function(t,e){if(d(t))return!1;var n=t.getBoundingClientRect();return n.right>=e.l&&n.bottom>=e.t&&n.left<=e.r&&n.top<=e.b},l=function(){(r||!n)&&(clearTimeout(n),n=setTimeout(function(){a.render(),n=null},o))};return a.init=function(n){n=n||{};var d=n.offset||0,i=n.offsetVertical||d,f=n.offsetHorizontal||d,s=function(t,e){return parseInt(t||e,10)};e={t:s(n.offsetTop,i),b:s(n.offsetBottom,i),l:s(n.offsetLeft,f),r:s(n.offsetRight,f)},o=s(n.throttle,250),r=n.debounce!==!1,c=!!n.unload,u=n.callback||u,a.render(),document.addEventListener?(t.addEventListener("scroll",l,!1),t.addEventListener("load",l,!1)):(t.attachEvent("onscroll",l),t.attachEvent("onload",l))},a.render=function(){for(var n,o,r=document.querySelectorAll("img[data-echo], [data-echo-background]"),d=r.length,l={l:0-e.l,t:0-e.t,b:(t.innerHeight||document.documentElement.clientHeight)+e.b,r:(t.innerWidth||document.documentElement.clientWidth)+e.r},f=0;d>f;f++)o=r[f],i(o,l)?(c&&o.setAttribute("data-echo-placeholder",o.src),null!==o.getAttribute("data-echo-background")?o.style.backgroundImage="url("+o.getAttribute("data-echo-background")+")":o.src=o.getAttribute("data-echo"),c||(o.removeAttribute("data-echo"),o.removeAttribute("data-echo-background")),u(o,"load")):c&&(n=o.getAttribute("data-echo-placeholder"))&&(null!==o.getAttribute("data-echo-background")?o.style.backgroundImage="url("+n+")":o.src=n,o.removeAttribute("data-echo-placeholder"),u(o,"unload"));d||a.detach()},a.detach=function(){document.removeEventListener?t.removeEventListener("scroll",l):t.detachEvent("onscroll",l),clearTimeout(n)},a});

/*!
 * imagesLoaded PACKAGED v3.1.4
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
(function(){function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,o=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(e,n.listener),o=n.listener.apply(this,t||[]),o===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=o,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):e.eventie=o}(this),function(e,t){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof exports?module.exports=t(e,require("eventEmitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(this,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"===d.call(e)}function o(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0,i=e.length;i>n;n++)t.push(e[n]);else t.push(e);return t}function s(e,t,n){if(!(this instanceof s))return new s(e,t);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=o(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),a&&(this.jqDeferred=new a.Deferred);var r=this;setTimeout(function(){r.check()})}function c(e){this.img=e}function f(e){this.src=e,v[e]=this}var a=e.jQuery,u=e.console,h=u!==void 0,d=Object.prototype.toString;s.prototype=new t,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);for(var i=n.querySelectorAll("img"),r=0,o=i.length;o>r;r++){var s=i[r];this.addImage(s)}}},s.prototype.addImage=function(e){var t=new c(e);this.images.push(t)},s.prototype.check=function(){function e(e,r){return t.options.debug&&h&&u.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},s.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify&&t.jqDeferred.notify(t,e)})},s.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},a&&(a.fn.imagesLoaded=function(e,t){var n=new s(this,e,t);return n.jqDeferred.promise(a(this))}),c.prototype=new t,c.prototype.check=function(){var e=v[this.img.src]||new f(this.img.src);if(e.isConfirmed)return this.confirm(e.isLoaded,"cached was confirmed"),void 0;if(this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this;e.on("confirm",function(e,n){return t.confirm(e.isLoaded,n),!0}),e.check()},c.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("confirm",this,t)};var v={};return f.prototype=new t,f.prototype.check=function(){if(!this.isChecked){var e=new Image;n.bind(e,"load",this),n.bind(e,"error",this),e.src=this.src,this.isChecked=!0}},f.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},f.prototype.onload=function(e){this.confirm(!0,"onload"),this.unbindProxyEvents(e)},f.prototype.onerror=function(e){this.confirm(!1,"onerror"),this.unbindProxyEvents(e)},f.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},f.prototype.unbindProxyEvents=function(e){n.unbind(e.target,"load",this),n.unbind(e.target,"error",this)},s});

// Pointer abstraction
/**
 * This class provides an easy and abstracted mechanism to determine the
 * best pointer behavior to use -- that is, is the user currently interacting
 * with their device in a touch manner, or using a mouse.
 *
 * Since devices may use either touch or mouse or both, there is no way to
 * know the user's preferred pointer type until they interact with the site.
 *
 * To accommodate this, this class provides a method and two events
 * to determine the user's preferred pointer type.
 *
 * - getPointer() returns the last used pointer type, or, if the user has
 *   not yet interacted with the site, falls back to a Modernizr test.
 *
 * - The mouse-detected event is triggered on the window object when the user
 *   is using a mouse pointer input, or has switched from touch to mouse input.
 *   It can be observed in this manner: $j(window).on('mouse-detected', function(event) { // custom code });
 *
 * - The touch-detected event is triggered on the window object when the user
 *   is using touch pointer input, or has switched from mouse to touch input.
 *   It can be observed in this manner: $j(window).on('touch-detected', function(event) { // custom code });
 */
var PointerManager = {
    MOUSE_POINTER_TYPE: 'mouse',
    TOUCH_POINTER_TYPE: 'touch',
    POINTER_EVENT_TIMEOUT_MS: 500,
    standardTouch: false,
    touchDetectionEvent: null,
    lastTouchType: null,
    pointerTimeout: null,
    pointerEventLock: false,

    getPointerEventsSupported: function() {
        return this.standardTouch;
    },

    getPointerEventsInputTypes: function() {
        if (window.navigator.pointerEnabled) { //IE 11+
            //return string values from http://msdn.microsoft.com/en-us/library/windows/apps/hh466130.aspx
            return {
                MOUSE: 'mouse',
                TOUCH: 'touch',
                PEN: 'pen'
            };
        } else if (window.navigator.msPointerEnabled) { //IE 10
            //return numeric values from http://msdn.microsoft.com/en-us/library/windows/apps/hh466130.aspx
            return {
                MOUSE:  0x00000004,
                TOUCH:  0x00000002,
                PEN:    0x00000003
            };
        } else { //other browsers don't support pointer events
            return {}; //return empty object
        }
    },

    /**
     * If called before init(), get best guess of input pointer type
     * using Modernizr test.
     * If called after init(), get current pointer in use.
     */
    getPointer: function() {
        // On iOS devices, always default to touch, as this.lastTouchType will intermittently return 'mouse' if
        // multiple touches are triggered in rapid succession in Safari on iOS
        if(Modernizr.ios) {
            return this.TOUCH_POINTER_TYPE;
        }

        if(this.lastTouchType) {
            return this.lastTouchType;
        }

        return Modernizr.touch ? this.TOUCH_POINTER_TYPE : this.MOUSE_POINTER_TYPE;
    },

    setPointerEventLock: function() {
        this.pointerEventLock = true;
    },
    clearPointerEventLock: function() {
        this.pointerEventLock = false;
    },
    setPointerEventLockTimeout: function() {
        var that = this;

        if(this.pointerTimeout) {
            clearTimeout(this.pointerTimeout);
        }

        this.setPointerEventLock();
        this.pointerTimeout = setTimeout(function() { that.clearPointerEventLock(); }, this.POINTER_EVENT_TIMEOUT_MS);
    },

    triggerMouseEvent: function(originalEvent) {
        if(this.lastTouchType == this.MOUSE_POINTER_TYPE) {
            return; //prevent duplicate events
        }

        this.lastTouchType = this.MOUSE_POINTER_TYPE;
        $j(window).trigger('mouse-detected', originalEvent);
    },
    triggerTouchEvent: function(originalEvent) {
        if(this.lastTouchType == this.TOUCH_POINTER_TYPE) {
            return; //prevent duplicate events
        }

        this.lastTouchType = this.TOUCH_POINTER_TYPE;
        $j(window).trigger('touch-detected', originalEvent);
    },

    initEnv: function() {
        if (window.navigator.pointerEnabled) {
            this.standardTouch = true;
            this.touchDetectionEvent = 'pointermove';
        } else if (window.navigator.msPointerEnabled) {
            this.standardTouch = true;
            this.touchDetectionEvent = 'MSPointerMove';
        } else {
            this.touchDetectionEvent = 'touchstart';
        }
    },

    wirePointerDetection: function() {
        var that = this;

        if(this.standardTouch) { //standard-based touch events. Wire only one event.
            //detect pointer event
            $j(window).on(this.touchDetectionEvent, function(e) {
                switch(e.originalEvent.pointerType) {
                    case that.getPointerEventsInputTypes().MOUSE:
                        that.triggerMouseEvent(e);
                        break;
                    case that.getPointerEventsInputTypes().TOUCH:
                    case that.getPointerEventsInputTypes().PEN:
                        // intentionally group pen and touch together
                        that.triggerTouchEvent(e);
                        break;
                }
            });
        } else { //non-standard touch events. Wire touch and mouse competing events.
            //detect first touch
            $j(window).on(this.touchDetectionEvent, function(e) {
                if(that.pointerEventLock) {
                    return;
                }

                that.setPointerEventLockTimeout();
                that.triggerTouchEvent(e);
            });

            //detect mouse usage
            $j(document).on('mouseover', function(e) {
                if(that.pointerEventLock) {
                    return;
                }

                that.setPointerEventLockTimeout();
                that.triggerMouseEvent(e);
            });
        }
    },

    init: function() {
        this.initEnv();
        this.wirePointerDetection();
    }
};

/*!
 * hoverIntent v1.8.0 // 2014.06.29 // jQuery v1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license. Basically that
 * means you are free to use hoverIntent as long as this header is left intact.
 * Copyright 2007, 2014 Brian Cherne
 */
(function($){$.fn.hoverIntent=function(handlerIn,handlerOut,selector){var cfg={interval:100,sensitivity:6,timeout:0};if(typeof handlerIn==="object"){cfg=$.extend(cfg,handlerIn)}else{if($.isFunction(handlerOut)){cfg=$.extend(cfg,{over:handlerIn,out:handlerOut,selector:selector})}else{cfg=$.extend(cfg,{over:handlerIn,out:handlerIn,selector:handlerOut})}}var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if(Math.sqrt((pX-cX)*(pX-cX)+(pY-cY)*(pY-cY))<cfg.sensitivity){$(ob).off("mousemove.hoverIntent",track);ob.hoverIntent_s=true;return cfg.over.apply(ob,[ev])}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=false;return cfg.out.apply(ob,[ev])};var handleHover=function(e){var ev=$.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t)}if(e.type==="mouseenter"){pX=ev.pageX;pY=ev.pageY;$(ob).on("mousemove.hoverIntent",track);if(!ob.hoverIntent_s){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}}else{$(ob).off("mousemove.hoverIntent",track);if(ob.hoverIntent_s){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob)},cfg.timeout)}}};return this.on({"mouseenter.hoverIntent":handleHover,"mouseleave.hoverIntent":handleHover},cfg.selector)}})(jQuery);
