"use strict";

// ### Here all page JS is initialized (plugins, popups, ...)
(function($, UM, undefined){

    // Cache jQuery selectors
    var $main = $('#main'),
    $toolbar = $('#toolbar'),
    $sidebar = $('aside');
		
    // ---------------------------------------------
    // ! Hide Address Bar on iOS & Android
    // - @see: http://24ways.org/2011/raising-the-bar-on-mobile
    /*F
	 * Normalized hide address bar for iOS & Android
	 * (c) Scott Jehl, scottjehl.com
	 * MIT License
	 */
    (function (win) {
        var doc = win.document;

        // If we don't have a touch device, there's a hash, or addEventListener is undefined, stop here
        if (Modernizr.touch && !location.hash && win.addEventListener) {

            //scroll to 1
            window.scrollTo(0, 1);
            var scrollTop = 1,
            getScrollTop = function () {
                return win.pageYOffset || doc.compatMode === "CSS1Compat" && doc.documentElement.scrollTop || doc.body.scrollTop || 0;
            },

            //reset to 0 on bodyready, if needed
            bodycheck = setInterval(function () {
                if (doc.body) {
                    clearInterval(bodycheck);
                    scrollTop = getScrollTop();
                    win.scrollTo(0, scrollTop === 1 ? 0 : 1);
                }
            }, 15);

            win.addEventListener("load", function () {
                setTimeout(function () {
                    //at load, if user hasn't scrolled more than 20 or so...
                    if (getScrollTop() < 20) {
                        //reset to hide addr bar at onload
                        win.scrollTo(0, scrollTop === 1 ? 0 : 1);
                    }
                }, 0);
            });
        }
    })(window);
	
    // ---------------------------------------------
    // ! Initialize App Cache
    // @see: http://www.html5rocks.com/en/tutorials/appcache/beginner/
	
    if ($('html').attr('manifest')) {
	
        // Check if a new cache is available on page load.
        window.addEventListener('load', function (e) {
		
            try {
                var appCache = window.applicationCache;

                appCache.update(); // Attempt to update the user's cache.

                if (appCache.status == appCache.UPDATEREADY) {
                    appCache.swapCache();  // The fetch was successful, swap in the new cache.
                }
				
                appCache.addEventListener('updateready', function (e) {
                    if (window.applicationCache.status == window.applicationCache.UPDATEREADY) {
                        // Browser downloaded a new app cache.
                        // Swap it in and reload the page to get the new hotness.
                        console.info('Updating Application Cache :)');
                        window.applicationCache.swapCache();
						
                        if ($.jGrowl) {
                            $.jGrowl(UM.config.lang.appcache.PLEASE_RELOAD, {
                                header:UM.config.lang.appcache.PLEASE_RELOAD_TITLE
                                });
                        } else if (confirm(UM.config.lang.appcache.PROMT_RELOAD)) {
                            window.location.reload();
                        }
                    } else {
                    // Manifest didn't changed. Nothing new to server.
                    }
                }, false);
            } catch(e){
                console.error(e);
            }

        }, false);
	
    }
	
    // ---------------------------------------------
    // ! Do several things on $(document).ready(...)
	
	
    // ! Update cached elements
    UM.loaded(function(){
        $main = $('#main');
        $toolbar = $('#toolbar');
        $sidebar = $('aside');
    });
	
	
    // ! Browser fixes
    UM.loaded(function(){
		
	
        $toolbar.find('div.right').find('a').has('span:not(.icon)').addClass('with_red');
		
        // - Webkit/Mozilla ftw
        if ($.browser.mozilla) {
            $('html').addClass('moz');
        } else if ($.browser.webkit) {
            $('html').addClass('webkit');
        }
		
        // - Bad IE
        var ie = !!$.browser.msie,
        ieV = parseInt($.browser.version);
			
        if (ie) {
            $('html').addClass('ie');
            ieV == 9 && $('html').addClass('ie9');
        }
		
    });
	
	
    // ! Set up content
    UM.loaded(function(){
		
        var $content = $('#content');
	
        // - Wrap the 'h1's contents with 'span's
        $('h1').each(function(){
            var $this = $(this);
            $this.wrapInner('<span />');
        });

        // - Initialize Boxes Menus
        $content.find('.box:has(.header a.menu)').each(function(){
            var $box = $(this),
            $btn = $box.find('.header').find('a.menu'),
            $menu = $btn.next('menu');
				
            $btn.on({
                mousedown: function(){
                    $(this).addClass('active');
                },
                mouseup: function(){
                    $(this).removeClass('active');
                },
                click: function(){
                    $menu.fadeToggle(UM.config.fxSpeed);
                    $btn.toggleClass('open');
                }
            });
				
            $menu.find('a').on({
                mousedown: function(){
                    $(this).addClass('active');
                },
                mouseup: function(){
                    $(this).removeClass('active');
                },
                click: function(){
                    window.location = this.href;
                    return false;
                },
                dragstart: function(){
                    return false;
                }
            }).filter(':has(.icon)').addClass('with-icon');
        });
	
        // - Initialize sortable boxes
        if ($content.data('sort') && !(Modernizr.touch && !UM.settings.contents.sortableOnTouchDevices)) {			
            $content.sortable({
                handle: '.header',
                items: $content.find('.box').parent(),
								
                distance: 5,
                tolerance: 'pointer',
				
                placeholder: 'placeholder',
                forcePlaceholderSize: true,
                forceHelperSize: true
            });
        }
		
        // - Create accordions
        $('#content .accordion').not('.toggle').each(function(){
            $(this).accordion();
        });
		
        $('#content .accordion.toggle').each(function(){
            $(this).multiAccordion();
        });
		
        // - Create tabbed boxes
        $('#content .tabbedBox').tabbedBox();
		
        // - Create vertical tabs
        $('#content .vertical-tabs').tabbedBox({
            header: $('.right-sidebar'), 
            content: $('.vertical-tabs')
            });
		
        // - Create wizard boxes
        $('#content .wizard').not('.manual').wizard();
		
        // - Initialize alert boxes
        $('.alert').not('.sticky').find('.icon')
        .after($('<span>').addClass('close').text('x'));
			
        $(document).on('click', '.alert:not(.sticky) .close', function(){
            $(this).parent().slideUp(UM.config.fxSpeed);
        });

        // - Resize and scroll event handling
        $(window).on('resize scroll', function(){
            // Center dialogs
            $('.ui-dialog').position({
                my: 'center', 
                at: 'center', 
                of: window
            });
        });
		
    });
	
    // ! Phone Navigation
    UM.loaded(function(){
        var $navi = $('nav').clone();
        $navi
        .addClass('phone')
        .children('ul').removeClass('collapsible accordion').end()
        .find('.badge').remove().end()
        .find('.icon').remove().end()
        .find(base_url+'img').remove().end()
        .insertAfter('header');
			
        // The navigation menu
        var $level1 = $navi.children('ul').children('li').has('ul').children('a');
        $level1.addClass('with-sub');
        $level1.click(function(){
            var $item = $(this),
            $sub = $item.next();
				
            if ($sub.is('ul')) {
                // Slide up
                if ($sub.is(':visible')) {
                    $sub.slideUp(UM.config.fxSpeed, function(){
                        $item.parent().toggleClass('open');
                    });
                // Slide down
                } else {
                    $level1.next().not($sub).slideUp(UM.config.fxSpeed);
                    $sub.slideDown(UM.config.fxSpeed);
                    $item.parent().toggleClass('open');
                }
                return false;
            }
        });
		
        // - Open/close the menu
        $('#toolbar').find('.phone').find('.navigation').click(function(){
            $navi.fadeToggle(UM.config.fxSpeed);
        });
    });
	
    // ! High Density Mobile Logo
    UM.loaded(function(){
        if (window.devicePixelRatio && window.devicePixelRatio > 1) {
            var $img = $('.phone-title');
            if (!$img.is('img')) {
                $img = $img.find('img');
            }
		
            var src = $img[0].src;
            $img.error(function(){
                $img.attr('src', src);
            });
			
            $img.attr('src', src.replace('.png', '@2x.png'));
        }
    });
	
    // ! Set up sidebar
    UM.loaded(function(){
	
        var $menu = $sidebar.find('nav').children('ul');
		
        // - Initialize the menu
        $menu.initMenu();
        $menu.find('li').find('ul').find('li').has('.icon').addClass('with-icon');
	
        // - Progress bars in the sidebar
        var $top = $sidebar.find('.top'),
        $bottom = $sidebar.find('.bottom'),
			
        $progress = $('aside').find('div.progress'),
			
        $footer = $('footer'),
        $window = $(window);
		
        $progress.children().infobar();
		
        // - Give the sidebar a min-height
        $sidebar.css('min-height', $sidebar.find('.top').height() + $sidebar.find('.bottom').height());
		
        // - Sticky bottom area
        if ($bottom.hasClass('sticky')) {
			
            var reset = function(){
                $bottom.css({
                    position: 'absolute',
                    left: 0,
                    top: 'auto'
                });
            };
			
            var update = function(){
                var windowOffsetBottom = $window.scrollTop() + $window.height();
				
                reset();
				
                if (windowOffsetBottom + 4 < $footer.offset().top) {
                    $bottom.css({
                        position: 'fixed',
                        left: $bottom.offset().left
                    });
                }
							
                var sidebarOffsetBottom = $top.offset().top + $top.outerHeight();
                if ($bottom.offset().top - 1 <= sidebarOffsetBottom) {
                    $bottom.css({
                        top: sidebarOffsetBottom - $main.offset().top,
                        left: 0,
                        position: 'absolute'
                    });
                }
            };
			
            update();
			
            $window.bind('scroll resize', update);
        }
		
    }); // End of 'UM.loaded'
	
	
    // ! jQuery UI elements
    UM.loaded(function(){
		
        var revalidateInput = function(){
            if ($.validator) {
                var $el = $(this),
                $form = $el.parents('form'),
                validator = $form.data('validator');
					
                if (validator) {
                    validator.element(this);
                }
            }
        };
	
        // - Dialog
        $.extend($.ui.dialog.prototype.options, {
            minWidth: 350,
            resizable: false,
			
            show: {
                effect: 'fade', 
                duration: 800
            },
            hide: {
                effect: 'fade', 
                duration: 800
            }
        });
		
        // - Progressbar
        $('#content').find('.ui-progressbar').each(function(){
            var $this = $(this);
            $this.progressbar($this.data());
        });
		
        // - Datepicker
        // FIX: Wrong positioning of datepicker
        //      See: http://bit.ly/mangoDPfix
        $.extend($.datepicker,{
            _checkOffset:function(inst,offset,isFixed){
                return offset
                }
            });
		
    $.extend($.datepicker._defaults, {
        showButtonPanel: true,
        showOtherMonths: true,
        closeText: 'Close'
    });
		
    var datepickerEvents = {
        onSelect: revalidateInput,
        onClose: revalidateInput
    };
		
    $.extend($.datepicker._defaults, datepickerEvents);
        $.extend($.timepicker._defaults, datepickerEvents);
		
        // Optional: Localization
		
        $('input[type=date]').each(function(){
            var $el = $(this);
            if ($.browser.webkit) {
                $el[0].type = 'text';
            }
            $el.datepicker();
        });
        $('input[type=datetime]').each(function(){
            $(this).datetimepicker().blur(revalidateInput);
        });
        $('input[type=time]').each(function(){
            $(this).timepicker({
                ampm: $(this).data('data-timeformat') == 12
            }).blur(revalidateInput);
        });
		
        // FIX: Bug with Datepicker header
        UM.ready(function(){
            setTimeout(function(){
                $('.hasDatepicker').datepicker('refresh')
                }, 3000);
        });
		
        // Create mirror input for inline datepicker
        var inline = {
		
            // Write date to mirror
            onselect: _.debounce(function(date, inst){
                (inst.input || inst.$input).data('mirror').val(date);
            }, 300),
			
            // Create mirror
            setup: function($el){
                var $mirror = $('<input>', {
                    id: $el.data('id'),
                    'class': 'mirror',
                    name: $el.data('name'),
                    required: $el.attr('required') || 'false'
                }).hide().insertAfter($el);
                $el.data('mirror', $mirror);
            }
        };
		
        $('div[data-type=date]').each(function(){
            var $this = $(this);
            inline.setup($this);
            $this.datepicker({
                onSelect: inline.onselect
            });
        });
        $('div[data-type=datetime]').each(function(){
            var $this = $(this);
            inline.setup($this);
            $this.datetimepicker({
                onSelect: inline.onselect
            });
        });
        $('div[data-type=time]').each(function(){
            var $this = $(this);
            inline.setup($this);
            $this.timepicker({
                onSelect: inline.onselect,
                ampm: $(this).data('data-timeformat') == 12
            });
        });
		
        // - Slider
        $('input[data-type=range]').mslider();
		
        (function(){
            var $slider = $('input.eq[data-type=range]').next();
            var zindex = $slider.length + 1;
            $slider.each(function(){
                $(this).css('z-index', zindex--);
            });
        })();
		
        // - Autocomplete
        $('[data-type=autocomplete]').each(function(){
		
            var $input = $(this);
            $input.attr('autocomplete', 'off');
            $input.autocomplete({
                source: $input.data('data') || $input.data('source'),
                disabled: !!$input.attr('disabled'),
                minLength: $input.data('minlength') || 1,
                position: {
                    my: 'top',
                    at: 'bottom',
                    offset: '0 10',
                    collision: 'none'
                },
				
                select:function(){
                    if(!empty($(this).val())){
                         revalidateInput 
                    }
                  
                }                  
            });
			
        });
		
        // Reposition autocomplete after window resize
        $(window).resize( _.debounce(function(){
            $('[data-type=autocomplete]').each(function(){
                var $this = $(this),
                $menu = $this.data('autocomplete').menu.element;
					
                $menu
                .width($this.outerWidth())
                .position({
                    my: 'top',
                    at: 'bottom',
                    offset: '0 10',
                    collision: 'none',
                    of: $this
                });
            });
        }, 300));
		
    });
	
	
// ! Calendar
UM.loaded(function(){
		
    $.fullCalendar.setDefaults({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        }
    });
	
});
	
	
// ! Charts
UM.loaded(function(){
    $('.chart').not('.manual').chart();
});
	

// ! Fullstats
UM.loaded(function(){
		
    // ! Set up fullstats
    $('.full-stats').fullstats();
		
    // - Optional: Set equal hight for all stats
    $('.full-stats.equalHeight').equalHeight();
	
});
	
// ! Table
UM.loaded(function(){
		
    // Add with-table class to boxes with tables to remove paddings
    $('.box').each(function(){
        var $box = $(this);
        if ($box.children('.content').children('table').length) {
            $box.addClass('with-table');
        }
    });
		
    // Initialize DataTables for dynamic tables
    $('table.dynamic').table();
	
});
	
// ! Gallery
UM.loaded(function(){
		
    // Custom transition: fade in/out
    // Adapted from: http://jsfiddle.net/6AYkT/3/
    (function (F) {
        F.transitions.fadeIn = function() {
            var wrap     = F.wrap,
            current  = F.current,
            effect   = current.nextEffect,
            elastic  = effect === 'elastic',
            startPos = F._getPosition( elastic ),
            endPos   = {
                opacity : 1
            };

            startPos.opacity = 0;

            wrap.css(startPos)
            .show()
            .animate(endPos, {
                duration : effect === 'none' ? 0 : current.nextSpeed,
                easing   : current.nextEasing,
                complete : F._afterZoomIn
            });
        };
		 
        F.transitions.fadeOut = function() {
            var wrap     = F.wrap,
            current  = F.current,
            effect   = current.prevEffect,
            endPos   = {
                opacity : 0
            },
            cleanUp  = function () {
                $(this).trigger('onReset').remove();
            };

            wrap.removeClass('fancybox-opened');

            endPos.opacity = 0;

            wrap.animate(endPos, {
                duration : effect === 'none' ? 0 : current.prevSpeed,
                easing   : current.prevEasing,
                complete : cleanUp
            });
        };

    }(jQuery.fancybox));
	
    // Set up the gallery
    $('.gallery').each(function(){
        var $gallery = $(this);
						
        $gallery.find('a:has(img)').attr('rel', _.uniqueId('gallery'));
			
        $gallery.find('.image:has(menu)').each(function(){
            var $box = $(this),
            $btn = $box.find('a.menu'),
            $menu = $btn.next('menu');
								
            // Set up the menu
            $menu.show().position({
                my: 'left top',
                at: 'left bottom',
                of: $btn,
                offset: '-3 3'
            }).hide();
				
            // Menu button listeners
            $btn.on({
                mousedown: function(){
                    $(this).addClass('active');
                },
                mouseup: function(){
                    $(this).removeClass('active');
                },
                click: function(){
                    $menu.fadeToggle(UM.config.fxSpeed);
                    $btn.toggleClass('open');
                }
            });
					
            // Menu items listeners
            $menu.find('a').on({
                mousedown: function(){
                    $(this).addClass('active');
                },
                mouseup: function(){
                    $(this).removeClass('active');
                },
                click: function(){
                    window.location = this.href;
                    return false;
                },
                dragstart: function(){
                    return false;
                }
            }).filter(':has(.icon)').addClass('with-icon');
        });
		
    });
		
    // Fancybox for gallery
    $('.gallery a:has(img)').fancybox({
        padding: 0,
				
        nextMethod : 'fadeIn',
        nextSpeed : 250,

        prevMethod : 'fadeOut',
        prevSpeed : 250
    });
	
});
	
// ! Forms
UM.loaded(function(){
	
    // ! Checkbox and radio
    $('input:checkbox').not("[attr=ibutton]").checkbox({
        cls : 'checkbox',
        empty : base_url+'img/elements/checkbox/empty.png'
    });
    $('input:radio').checkbox({
        cls : 'radiobutton',
        empty : base_url+'img/elements/checkbox/empty.png'
    });
		
    // ! Select boxes
    var $cznSelects = $('select').not('.dualselects');
    $cznSelects.each(function(){
        var $el = $(this);
			
        $el.chosen({
            disable_search_threshold: $el.hasClass('search') ? 0 :Number.MAX_VALUE,
            allow_single_deselect: true,
            width: $el.data('width') || '100%'
        });
    });
				
    // - Set up select boxes validation
    $('.chzn-done').on('change', function(){
        var validate = $(this).parents('form').validate();
        validate && validate.element($(this));
    }).each(function(){
        // - Set up form reset listener
        var $input = $(this),
        $form = $input.parents('form');
			
        $form.on('reset', function(){
            $input[0].selectedIndex = -1;
            $input.trigger('liszt:updated');
        });
			
        $form.data('chzn-reset', true);
    });
		
    // ! Double Select Box
    if (!Modernizr.touch) {
        $('select.dualselects').dualselect();
    }
		
    // ! File input
    $('input:file').fileInput();
		
    // ! Uploader
    $('.uploader').each(function(){
        var $uploader = $(this);
        $uploader.pluploadQueue($.extend({
            runtimes: 'html5,flash,html4',
            url : 'extras/upload.php',
            max_file_size : '10mb',
            chunk_size : '1mb',
            unique_names : true,
				
            filters : [
            {
                title : "Image files", 
                extensions : "jpg,gif,png"
            },

            {
                title : "Zip files", 
                extensions : "zip"
            }
            ],
				
            flash_swf_url : 'js/mylibs/forms/uploader/plupload.flash.swf'
        }, $uploader.data()));
        $uploader.find('.plupload_button').addClass('button grey btn');
        $uploader.find('.plupload_add').addClass('icon-plus');
        $uploader.find('.plupload_start').addClass('icon-ok');
    });
		
    // ! Spinner
    $('input[data-type=spinner]').each(function(){
        var $spinner = $(this),
        opts = $spinner.data();
			
        if (opts.format) {
            opts.numberformat = opts.format;
            opts.format = undefined;
        }
        $spinner.spinner(opts);
    });
		
    // ! Color input
    $('input[type=color]').not('.flat').each(function(){
        var $input = $(this).hide(),
        $picker = $('<div class="cpicker"><div class="color"></div></div>').insertAfter($input),
        $color = $picker.children();
				
        // Update input val
        $input.val() ? $color.css('background', $input.val()) : $input.val('#ff0000');
        var origVal = $input.val();
			
        // Update preview and input val
        $picker.ColorPicker({
            onChange: function (hsb, hex, rgb) {
                $input.val('#' + hex);
                $color.css('background', '#' + hex);
            }
        });
        $picker.ColorPickerSetColor(origVal);
			
        // Reset input on form reset
        $input.parents('form').on('reset', function(){
            $input.val(origVal);
            $picker.ColorPickerSetColor(origVal);
            $color.css('background', origVal);
        });
    });
		
    $('input[type=color].flat').each(function(){
        var $input = $(this).hide(),
        $picker = $('<div>').insertAfter($input);
			
        // Update input val
        !$input.val() && $input.val('#ff0000');
        var origVal = $input.val();
			
        // Update preview and input val
        $picker.ColorPicker({
            flat: true,
            onChange: function (hsb, hex, rgb) {
                $input.val('#' + hex);
            }
        });
        $picker.ColorPickerSetColor(origVal);
			
        // Reset input on form reset
        $input.parents('form').on('reset', function(){
            $input.val(origVal);
            $picker.ColorPickerSetColor(origVal);
        });
    });
		//oly small
		   $.cleditor.defaultOptions.width = 200;
        $.cleditor.defaultOptions.height = 100;
        $.cleditor.defaultOptions.controls = "bold italic underline strikethrough bullets numbering print";
		$(".EmailContant").cleditor();
    // ! Editor
    $('textarea.editor').each(function(){
        var $input = $(this),
        isFull = $input.hasClass('full');
        $input.cleditor({			
            width: isFull ? 'auto' : '100%',
            height: '250px',
            bodyStyle: 'margin: 10px; font: 12px Arial,Verdana; cursor:text',
            useCSS: true
        });
        isFull && $input.parents('.cleditorMain').addClass('full');
    });
		
    // ! Forms
    // - In rows view: resize the labels
    var formResize = function(){
        $('#content,#login,.ui-dialog:not(:has(#settings))').find('form').each(function(){
            var $form = $(this);

            // Set up rows view
            // Let labels have equal width and same height as the corresponding <div>
				
            // - Clean up old values
            var $rows = $form.find('.row'),
            $label = $rows.children('label'),
            $divs = $rows.children('div');
				
            $label.css('width', '');
            $divs.css('height', '');
            $divs.css('margin-left', '');
				
            $label.equalWidth();
            $divs.css('margin-left', $label.width() + parseInt($label.css('margin-right')) );
				
            $label.each(function(){
                var $lbl = $(this),
                $div = $lbl.next();
                var heightLbl = $lbl.outerHeight(),
                heightDiv = $div.height();
						
                if (heightLbl > heightDiv) {
                    $div.height(heightLbl);
                }
            });
				
            // Not Boxed
            if (!$form.parents('.box').length && !$form.is('.box')) {
                $form.addClass('no-box');
            }
				
            // Update pw meter
            $form.find(':password.meter').each(function(){
                $(this).data('reposition') && $(this).data('reposition')();
            })
        });
    };
		
    formResize();
		
    // Expose to public
    UM.utils.forms = {
        resize: formResize
    };
		
    // - Resize labels after webfont was loaded
    //   (otherwise crazy stuff could happen)
    $(window).on('fontsloaded', function(){
        formResize();
    });
		
    // - Resize labels when changing from desktop to mobile layout
    var windowWidth = $(window).width();
    $(window).on('resize', _.debounce(function(){
        formResize();
    }, 200));
		
    // ! Inline Labels
    var inlineLabelResize = function($input, $label){
        $input.css('padding-left', $label.outerWidth(true));
    };
		
    $('form').each(function(){
        var $form = $(this)
        , $inlineLabels = $form.find('label.inline');
						  
        $inlineLabels.each(function(){
            var $label = $(this),
            $input = $('#' + $label.attr('for'));
				
            inlineLabelResize($input, $label);
            $(window).on('fontsloaded', function(){
                inlineLabelResize($input, $label);
            });
				
            var ie8 = ($.browser.msie && parseInt($.browser.version) == 8);
				
            if (ie8) {
                $label.css('position', 'absolute');
            }
				
            $label.position({
                my: 'left center',
                at: 'left center',
                of: $input,
                using: function(pos){
                    $label.css('top', pos.top);
                    if (ie8) {
                        $label.css('top', pos.top * 2);
                    }
                }
            });
        });
    });
	
});
	
// ! Explorer
UM.loaded(function(){
    elFinder.prototype._options.resizable = false;
    $('.explorer').each(function(){
        var $el = $(this);
        $el.elfinder({
            url: $el.data('backend') || 'extras/explorer/'
        });
    });
});
	
	
// - Demos
UM.loaded(function(){
	
    // - Animated Progress Bar Demo
    UM.ready(function(){
        $('#animprog').progressbar({
            fx: {
                animate: true,
                duration: 5,
                start: new Date(new Date().getTime() + 5 * 1000) // Now + 5s
            }
        });
    });
	
// - Calendar Demo
if ($('.calendar.demo').length) {
		
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
		
    $('.calendar.demo').fullCalendar({
        /* dayClick: function(date, allDay, jsEvent, view) {
                                
        if (allDay) {
            alert('Clicked on the entire day: ' + date);
        }else{
            alert('Clicked on the slot: ' + date);
        }

        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

        alert('Current view: ' + view.name);

        // change the day's background color just for fun
        $(this).css('background-color', 'red');
    },*/
        eventClick: function(event, element) {

            event.title = "CLICKED!";

            $('#calendar').fullCalendar('updateEvent', event);
        },
        selectable: true,
        selectHelper: true,
        			select: function(start, end, allDay) {
        				var title = prompt('Event Title:');
                                        //add new event
        				if (title) {
        					$('.calendar.demo').fullCalendar('renderEvent',
        						{
        							title: title,
        							start: start,
        							end: end,
        							allDay: allDay
        						},
        						true // make the event "stick"
        					);
        				}
        				$('.calendar.demo').fullCalendar('unselect');
        			},
        editable: true,
        eventDragStart :function( event, jsEvent, ui, view ) { console.log(event);
          console.log(jsEvent._start);
         },
        eventDragStop:function(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view){
          //update event in backend
           // AjaxCall(base_url+"index.php/isis/GetEmail/count","","NoEmail","id","","");
        },
         eventSources:[
			 {
            url: base_url+"index.php/isis/GetEvetsCal" // use the `url` property
        }
        ]
		
        // events: [
        // {
            // title: 'Pmo Cron Job Running',
            // start: new Date(y, m, 1), userid: 21
        // },
        // {
            // title: 'Barring Peroid is Start',
            // start: new Date(y, m, d-5),
            // end: new Date(y, m, d-2), userid: 22
        // },
        // {
            // title: 'Student Appel Peroid is Start',
            // start: new Date(y, m, d-3, 16, 0),
            // end: new Date(y, m, d),
            // allDay: false,
            // userid: 24
        // },
        // {
            // title: 'Dean Approvel',
            // start: new Date(y, m, d+3, 16, 0),
            // end: new Date(y, m, d+6),
            // allDay: false, userid: 25
        // },
        // {
            // title: 'Meeting to Exam Divisons',
            // start: new Date(y, m, d, 10, 30),
            // allDay: false, userid: 26
        // },
        // {
            // title: 'Barring Close',
            // start: new Date(y, m, d+1, 19, 0),
            // end: new Date(y, m, d+1, 22, 30),
            // allDay: false, userid: 27
        // },{
            // title: 'Exam preparation is open',
            // start: new Date(y, m, d+2, 19, 0),
            // end: new Date(y, m, d+5, 22, 30),
            // allDay: false, userid: 28
        // },
        // {
            // title: 'Pmo Open ',
            // start: new Date(y, m, 28),
            // end: new Date(y, m, 29),
            // url: 'http://google.com/', userid: 29
        // }
        // ]			
    });
}
		
});

	
	
	
	
// -----------------------------------------
// ! Things to set up on $(window).load(...)
	
	
// ! Set up different elements
UM.ready(function(){
	
    // - Disabled buttons
    $('a.button.disabled').click(function(){
        return false;
    });
		
});
	
	
// ! Set forms
UM.ready(function(){
	
    // ! Textarea autogrow
    $('textarea').not('.nogrow').not('.editor').autosize();
		
		
    // ! Password strength meter
    $('input:password.meter').passwordMeter();
		
		
    // ! Masked input
    $('.maskDate').mask('99-99-9999');
    $('.maskPhone').mask('(999) 999-9999');
    $('.maskPhoneExt').mask('(999) 999-9999? x99999');
    $('.maskIntPhone').mask('+33 999 999 999');
    $('.maskTin').mask('99-9999999');
    $('.maskSsn').mask('999-99-9999');
    $('.maskProd').mask('a*-999-a999');
    $('.maskPo').mask('PO: aaa-999-***');
    $('.maskPct').mask('99%');
    $('.maskCustom').each(function(){
        $(this).mask($(this).data('mask') || '');
    });
		
		
    // ! Validation
		
    // - Add new method: password
    $.validator.addMethod('strongpw', function(pwd, el){
        return $.pwdStrength(pwd) > 80;
    }, 'Your password is insecure');
		
    // - Add new method: checked
    $.validator.addMethod('checked', function(val, el){
        return !!$(el)[0].checked;
    }, 'You have to select this option');
		
    // - Set defaults
    $.validator.setDefaults({
		
        // Do not ignore chosen-selects | datepicker mirrors | checkboxes | radio buttons
        ignore: ':hidden:not(select.chzn-done):not(input.mirror):not(:checkbox):not(:radio):not(.dualselects),.ignore',
			
        // If a field is switches from invalid to valid
        success: function(label){
            // Change icon from error to valid
            $(label).prev().filter('.error-icon').removeClass('error-icon').addClass('valid-icon');
				
            // If file input: remove 'error' from '.customfile'
            $(label).prev('.customfile').removeClass('error');
        },
			
        // Where to place the error labels
        errorPlacement: function($error, $element){
						
            if ($element.hasClass('customfile-input-hidden')) {
					
            } else if ($element.hasClass('customfile-input-hidden')) {
				
                $error.insertAfter($element.parent().addClass('error'));
				
            // Password meter || Textarea || Spinner || Inline Datepicker || Checkbox || Radiobutton: No icon
            } else if ($element.is(':password.meter') || $element.is('textarea') || $element.is('.ui-spinner-input') || $element.is('input.mirror')) {
				
                $error.insertAfter($element);

            // Checkbox: No icon, after replacement
            } else if ($element.is(':checkbox') || $element.is(':radio')) {
				
                if ($element.is(':checkbox')) {
                    $error.insertAfter($element.next().next());
                } else {
                    // Find last radion button
                    $error.insertAfter($('[name=' + $element[0].name + ']').last().next().next());
                }
				
            // Select: No icon, insert after select box replacement
            } else if ($element.is('select.chzn-done') || $element.is('.dualselects')) {
					
                $error.insertAfter($element.next());

            // Default: Insert after element, show icon
            } else {
			
                $error.insertAfter($element);
					
                // Show icon
                var $icon = $('<div class="error-icon icon" />').insertAfter($element).position({
                    my: 'right',
                    at: 'right',
                    of: $element,
                    offset: '-5 0',
                    overflow: 'none',
                    using: function(pos) {
                        // Figure out the right and bottom css properties 
                        var offsetWidth = $(this).offsetParent().outerWidth();
                        var right = offsetWidth - pos.left - $(this).outerWidth();
							
                        // Position the element so that right and bottom are set.
                        $(this).css({
                            left: '', 
                            right: right, 
                            top: pos.top
                            });  
                    }
                });
				
            }
        },
			
        // Reposition error labels and hide unneeded labels
        showErrors: function(map, list){
            var self = this;
				
            this.defaultShowErrors();
				
            list.forEach(function(err){
                var $element = $(err.element),
                $error = self.errorsFor(err.element);
				
                // Select || Textarea || File Input || Inline Datepicker || Checkbox || Radio button: Inline Error Labels
                if ( $element.data('errorType') == 'inline' || $element.is('select') || $element.is('textarea') || $element.hasClass('customfile-input-hidden') || $element.is('input.mirror') || $element.is(':checkbox') || $element.is(':radio') || $element.is('.dualselect')) {
					
                    // Get element to which the error label is aligned
                    var $of;
                    if ($element.is('select')) {
                        $of = $element.next();
                    } else if ($element.is(':checkbox') || $element.is(':radio')) {
                        if ($element.is(':checkbox')) {
                            $of = $element.next();
                        } else {
                            // Find last radio button
                            $of = $('[name=' + $element[0].name + ']').last().next().next();
                        }
                        $error.css('display', 'block');
                    } else if ($element.is('input.mirror')) {
                        $of = $element.prev();
                    } else {
                        $of = $element;
                    }
						
                    $error.addClass('inline').position({
                        my: 'left top',
                        at: 'left bottom',
                        of: $of,
                        offset: '0 5',
                        collision: 'none'
                    });
						
                    if (!($element.is(':checkbox') && $element.is(':radio'))) {
                        $error.css('left', '');
                    }
					
                // Default: Tooltip labels
                } else {
						
                    $error.position({
                        my: 'right top',
                        at: 'right bottom',
                        of: $element,
                        offset: '1 8',
                        using: function(pos) {
                            // Figure out the right and bottom css properties 
                            var offsetWidth = $(this).offsetParent().outerWidth();
                            var right = offsetWidth - pos.left - $(this).outerWidth();
								
                            // Position the element so that right and bottom are set.
                            $(this).css({
                                left: '', 
                                right: right, 
                                top: pos.top
                                });  
                        }
                    });
					
                } // End if
					
                // Switch icon from valid to error
                $error.prev().filter('.valid-icon').removeClass('valid-icon').addClass('error-icon');
			
                // Hide error labe on .noerror
                if ($element.hasClass('noerror')) {
                    $error.hide();
                    $element.next('.icon').hide();
                }
            });
				
            // Hide success labels
            this.successList.forEach(function(el){
                self.errorsFor(el).hide();
            });
				
        }
    });
		
    // - Validate
    $('form.validate').each(function(){
        $(this).validate({
            submitHandler: function(form){
                $(this).data('submit') ? $(this).data('submit')() :  form.submit() ;
            }
        });
    });
	$('form.Ajaxvalidate').each(function(){       
        $(this).validate({
			submitHandler: function(form) {
                            //dalert(url+postdata+returnid+type+callback+returnType);
				 $(this).data('submit') ? $(this).data('submit')() :  AjaxCall($('form.Ajaxvalidate').attr("action"),$('form.Ajaxvalidate').serialize(),$('form.Ajaxvalidate').attr("returnid"),$('form.Ajaxvalidate').attr("type"),$('form.Ajaxvalidate').attr("callback"),$('form.Ajaxvalidate').attr("returnType"));                                 
                               $('.Reset').trigger("click");
                               $("#"+$('form.Ajaxvalidate').attr("returnid")).html("");
			}
		});
    });	
  
    // - Reset validation on form reset
    $('form.validate').on('reset', function(){
          var $form = $(this);
       $form.validate().resetForm();
        $form.find('label.error').remove().end()
        .find('.error-icon').remove().end()
        .find('.valid-icon').remove().end()
        .find('.valid').removeClass('valid').end()
        .find('.customfile.error').removeClass('error');
    });
     
  $('.Reset').live('click', function(){
        var $form = $(this).closest("form");
       $form.validate().resetForm();
        $form.find('label.error').remove().end()
        .find('.error-icon').remove().end()
        .find('.valid-icon').remove().end()
        .find('.valid').removeClass('valid').end()
        .find('.customfile.error').removeClass('error');
         $form.data('chzn-reset', true);
    });

		
    // ! Polyfill: 'form' tag on <input>s
    if (!('form' in document.createElement('input'))) {
        $('input:submit').each(function(){
            var $el = $(this);
            if ($el.attr('form')){
                $el.click(function(){
                    $('#' + $el.attr('form')).submit();
                });
            }
        });
        $('input:reset').each(function(){
            var $el = $(this);
            if ($el.attr('form')){
                $el.click(function(){
                    $('#' + $el.attr('form'))[0].reset();
                });
            }
        });
    }
		
});

	
// ! Browser fixes and polyfills
UM.ready(function(){
	
    // - Bad IE
    var ie = !!$.browser.msie,
    ieV = parseInt($.browser.version);
		
    // - IE 6-7 fixes
    if (ie && ieV < 8) {
        $('input[type=search]').addClass('search');
        $('input[type="search"] + ul.searchResults').addClass('in_toolbar');
    }
    if (ie && ieV == 9) {
        $('button, input:submit, input:reset, input:button').addClass('gradient');
    }
		
    // - IE 6-8 fixes
    if (ie && ieV < 9) {
        $toolbar.find('div.right').find('a').has('span.icon').addClass('has_icon');
    }
		
    if (ie && ieV == 9) {
        $sidebar.find('.badge').addClass('gradient');
    }
		
    // - Other fixes
    $('input, textarea').placeholder(); // Placeholder-polyfill
		
});
	
	
// ! Set up click handler
UM.ready(function(){
	
    var $user_box = $main.find('section.toolbar').find('div.user'),
    $shortcuts_menu = $main.find('ul.shortcuts').find('li').has('div'),
    $toolbar_menu = $toolbar.children().find('ul').find('li').has('div.popup'),
    $box_menu = $main.find('.box').find('.header').find('menu'),
    $gallery_menu = $main.find('.gallery').find('menu');
	
    // - Hide popups on click outside
    $('html').click(function(e){
		
        var $target = $(e.target);
        if ($target.hasClass('ui-widget-overlay') || $target.hasClass('ui-dialog ui-widget') || $target.parents('.ui-dialog').length) {
            return;
        }
		
        // User-Box
        if (e.target !== $user_box[0] && !$user_box.doesHave(e.target) && $user_box.hasClass('clicked')) {
            $user_box.find('ul').slideUp(UM.config.fxSpeed, function(){
                $user_box.removeClass('clicked');
            });
        }
			
        // Shortcut popups
        if (!$shortcuts_menu.doesHave(e.target)) {			
            $shortcuts_menu.removeClass('active').children('div:visible').fadeOut(UM.config.fxSpeed);
        }
			
        // Toolbar popups
        if (!$toolbar_menu.doesHave(e.target)) {
            $toolbar_menu.removeClass('active').children('div.popup:visible').fadeOut(UM.config.fxSpeed);
        }
			
        // Box Menu popups
        $box_menu.each(function(){
            var $menu = $(this);
            if ($menu.is(':visible') && e.target != $menu.prev()[0] && !$menu.doesHave(e.target)) {
                $menu.prev().removeClass('open');
                $menu.fadeOut(UM.config.fxSpeed);
            }
        });

        // Gallery popups
        $gallery_menu.each(function(){
            var $menu = $(this);
            if ($menu.is(':visible') && e.target != $menu.prev()[0] && !$menu.doesHave(e.target)) {
                $menu.prev().removeClass('open');
                $menu.fadeOut(UM.config.fxSpeed);
            }
        });
			
    });

});
	
	
// ! Set up tooltips
UM.ready(function(){
		
    // If tooltips are not included
    if (!$.fn.tipsy) {
        return;
    }
		
    $.fn.tipsy.defaults.opacity = 1;
		
    $('.tooltip').each(function(){
        var $tooltip = $(this),
        grav = $tooltip.data('gravity') || $.fn.tipsy.autoNS,
        anim = $tooltip.data('anim') || true;
			
        $tooltip.tipsy({
            gravity: grav,
            fade: anim,html: true 
        });
    });
	
});
	
	
// ! Set up the user menu (most left toolbar menu)
UM.ready(function(){
	
    $main.find('section.toolbar').find('div.user')
    .click(function(){
			
        var $this = $(this);
				
        // If the menu is already shown
        if ($this.hasClass('clicked')) {
				
            // Slide up
            $this.find('ul').slideUp(UM.config.fxSpeed, function(){
                $this.removeClass('clicked');
            });
				
        // The menu is not shown
        } else {
				
            // Slide down
            $this.find('ul').slideDown(UM.config.fxSpeed);
            $this.addClass('clicked');
					
        }
				
    })
    .find('ul')
    .click(UM.utils.noBubbling);
		
});
	
	
// ! Shortcuts popups
UM.ready(function(){
		
    // For every shortcut with popup item:
    var $shortcuts_menu = $main.find('ul.shortcuts').find('li').has('div').each(function(){
		
        var $item = $(this), $box = $item.children('div');
			
        // On shourtcut click
        $item.click(function(e){		
			
            // Hide other opened popups
            $shortcuts_menu.not($item).children('div').fadeOut(UM.config.fxSpeed, function(){
                $shortcuts_menu.not($item).removeClass('active');
            });
				
            // Show the requestedd one
            $box.fadeToggle(UM.config.fxSpeed);
            $item.toggleClass('active');
				
        });
			
        // Do not bubble up
        $box.click(UM.utils.noBubbling);
			
    });
	
});
	
	
// ! Toolbar popups
UM.ready(function(){
		
    // For every shortcut with popup item:
    var $shortcuts_menu = $toolbar.children().find('ul').find('li').has('div.popup').each(function(){
		
        var $item = $(this), $box = $item.children('div');
			
        // On shortcut click
        $item.click(function(e){
			
            if ($item.hasClass('disabled')) {
                return false;
            }
			
            // Hide other open popups
            $shortcuts_menu.not($item).children('div').fadeOut(UM.config.fxSpeed, function(){
                $shortcuts_menu.not($item).removeClass('active');
            });
				
            // FIX: wrong position in IE8
            if ($('html').hasClass('lt-ie9') && $box.is(':hidden')) {
                $box.show().css({
                    left: 0
                }).position({
                    my: 'top',
                    at: 'bottom',
                    of: $item,
                    offset: '0 15',
                    using: function(pos){
                        $box.css({
                            'left': pos.left,
                            'top': 37
                        });
                    }
                }).hide();
            }
				
            // Show the requested shortcut
            $box.fadeToggle(UM.config.fxSpeed);
            $item.toggleClass('active');
				
            return false;
        });
			
        // Do not bubble up
        $box.click(UM.utils.noBubbling);
			
    });
		
    // ! Mail List
    var $mail = $('.mail').has('.text');
    $mail
    .on('click', 'li', function(){
        $mail.find('.text:visible').slideUp(UM.config.fxSpeed / 2);
        $(this).find('.text:hidden').slideToggle(UM.config.fxSpeed / 2);
    })
    .on('hover', 'li', function(){
        $(this).toggleClass('normal');
    })
    .find('.text')
    .hover(function(){
        $(this).parent('li').toggleClass('normal');
    })
    .click(UM.utils.noBubbling);
			
    // ! Popup positioning
    $shortcuts_menu.each(function(){
        var $el = $(this);
        $el.find('.popup').show().position({
            my: 'top',
            at: 'bottom',
            of: $el,
            offset: '0 15'
        }).hide();
    });
			
});
	
	
// ! The search box
UM.ready(function(){
		
    // - Initialize the search
    $main.find('.toolbar').find('input[type="search"]').search({
        // source is set via data-source attribute
        minLength: 2
    });
	
});
	
	
// ! Scroll to Top button
UM.ready(function(){
		
    if (UM.config.scollToTop) {
			
        var $toTop = $('<a>', {
            href: '#top',
            id: 'gotoTop'
        }).appendTo('body'),
        $window = $(window);
			
        // On scroll: create debounced function (see http://documentcloud.github.com/underscore/#debounce)
        $window
        .scroll(_.debounce(function(){
            if(!jQuery.support.hrefNormalized) {
                $toTop.css({
                    'position': 'absolute',
                    'top': $window.scrollTop() + $window.height() - settings.ieOffset
                });
            }
						
            // If we are not at the top: fade out
            if ($window.scrollTop() >= 1) {
                $toTop.fadeIn();
            } else {
                // Else: fade in						
                $toTop.fadeOut();
            }
						
        }, 300))
        // Call scroll handler (if page loads scrolled from cache)
        .scroll();
			
        // Scroll up on click
        $toTop.click(function(){
			
            $("html, body").animate({
                scrollTop: 0
            });
            return false;
				
        });
    }
	
});
	
	
// ! Notifications
UM.ready(function(){
    $.jGrowl.defaults.life = 8000;
    $.jGrowl.defaults.pool = 5;
});
	
// ! Syntax Highlighter	
// Set up autoloader
// @see: https://github.com/alexgorbatchev/SyntaxHighlighter/issues/133
UM.utils.tryF(function(){
    SyntaxHighlighter.autoload = function (brushes) {
        function handler(e) {
            e = e || window.event;
            if (!e.target) {
                e.target = e.srcElement;
                e.preventDefault = function () {
                    this.returnValue = false;
                }
            }
            SyntaxHighlighter.autoloader.apply(this, brushes);
            SyntaxHighlighter.all();
        }
        if (window.attachEvent) window.attachEvent("on" + "load", handler);
        else window.addEventListener("load", handler, false)
    };

    function addPath(path, array) {
        var result = [];
        for (var i = 0; i < array.length; ++i) {
            var elem = array[i].slice();
            elem[elem.length - 1] = path + elem[elem.length - 1];
            result.push(elem);
        }
        return result;
    }
    SyntaxHighlighter.autoload(addPath("js/mylibs/syntaxhighlighter/", [
        ["applescript", "shBrushAppleScript.js"],
        ["actionscript3", "as3", "shBrushAS3.js"],
        ["bash", "shell", "shBrushBash.js"],
        ["coldfusion", "cf", "shBrushColdFusion.js"],
        ["cpp", "c", "shBrushCpp.js"],
        ["c#", "c-sharp", "csharp", "shBrushCSharp.js"],
        ["css", "shBrushCss.js"],
        ["delphi", "pascal", "shBrushDelphi.js"],
        ["diff", "patch", "pas", "shBrushDiff.js"],
        ["erl", "erlang", "shBrushErlang.js"],
        ["groovy", "shBrushGroovy.js"],
        ["java", "shBrushJava.js"],
        ["jfx", "javafx", "shBrushJavaFX.js"],
        ["js", "jscript", "javascript", "shBrushJScript.js"],
        ["perl", "pl", "shBrushPerl.js"],
        ["php", "shBrushPhp.js"],
        ["text", "plain", "shBrushPlain.js"],
        ["py", "python", "shBrushPython.js"],
        ["ruby", "rails", "ror", "rb", "shBrushRuby.js"],
        ["sass", "scss", "shBrushSass.js"],
        ["scala", "shBrushScala.js"],
        ["sql", "shBrushSql.js"],
        ["vb", "vbnet", "shBrushVb.js"],
        ["xml", "xhtml", "xslt", "html", "shBrushXml.js"]
        ]));
})();
	
	
    // ! Login
    UM.ready(function(){
	
        var $login = $('#login'),
        $msg = $login.find('.login-messages');
			
        // Positioning of the messages
        $msg.height($msg.height());
        $msg.children().css('position', 'absolute');
		
        // Set up validation
        var $form = $login.find('form');
        $form.validationOptions({
            invalidHandler: function(){
                $msg.find('.welcome').fadeOut();
                $msg.find('.failure').fadeIn();
            }
        });

    });
	
	
    // ! Centered Elements
    // TODO: remove?
    /*
	UM.ready(function(){
		
		$(window).resize(_.debounce(function(){
			$('.center-elements').each(function(){
				$(this).children().each(function(){
					var $this = $(this).css('width', '');
					$this.width($this.width());
				});
			});
		}, 100)).resize();
	
	});
	// */
	
	
    // ! Disable dragging on some elements
    UM.ready(function(){
			
        var disableDrag = [];
        disableDrag.push($toolbar.find('li'));
        disableDrag.push($('nav').find('li'));
        disableDrag.push($('section.toolbar').find('li').find('a'));
        disableDrag.push($('header').find('img'));
        disableDrag.push($('div.avatar').find('img'));
        disableDrag.push($('ul.shortcuts').find('li'));
        disableDrag.push($('a.button'));
        disableDrag.push($('.profile').find('.avatar').children());
        disableDrag.push($('.messages').find('.buttons').children());
        disableDrag.push($('.full-stats').find('.stat'));
        disableDrag.push($('.ui-slider'));
        disableDrag.push($('.checkbox'));
        disableDrag.push($('.radiobutton'));
        disableDrag.push($('#gotoTop'));
        disableDrag.push($('.uploader'));
        disableDrag.push($('.dataTables_paginate'));
        disableDrag.push($('.avatar'));
        disableDrag.push($('header a'));
        disableDrag.push($('.gallery'));
        disableDrag.push($('.tabletools').find('a'));
		
        $.each(disableDrag, function(){
            $(this).on('dragstart', function(event) {
                event.preventDefault();
            });
        });
		
    });
		
	
    // ! Loading screen
    UM.ready(function(){
	
        // ! Hide loading screen
        $('#loading').fadeOut(UM.config.fxSpeed);
        $('#loading-overlay').delay(100 + UM.config.fxSpeed).fadeOut(UM.config.fxSpeed * 2);

        // - Start counting when #loading fadeout is finished
        setTimeout(function(){
			
            // ! The lock screen
            // - Start only, if required html is complete and we don't have a phone
            if ($('#lock-screen').length && $('#btn-lock').length && !UM.utils.isPhone) {
                UM.lock();
            }
			
        }, UM.config.fxSpeed);
    });
	
	
    // ! Preload images
    UM.ready(function(){
		
        if (!UM.config.preloadImages) {
            return;
        }
		
        UM.utils.preload([
            base_url+'img/layout/navigation/arrow-active.png',
            base_url+'img/layout/navigation/arrow-hover.png',
            base_url+'img/layout/navigation/arrow.png',
            base_url+'img/layout/navigation/bg-current.png',
            base_url+'img/layout/navigation/bg-active.png',
            base_url+'img/layout/navigation/bg-hover.png',
            base_url+'img/layout/navigation/bg-normal.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/layout/sidebar/bg-right.png',
            base_url+'img/layout/sidebar/bg.png',
            base_url+'img/layout/sidebar/divider.png',
            base_url+'img/layout/sidebar/shadow-right.png',
            base_url+'img/layout/sidebar/shadow.png',
            base_url+'img/layout/sidebar-right/header-bg.png',
            base_url+'img/layout/sidebar-right/nav-bg-hover.png',
            base_url+'img/layout/sidebar-right/nav-bg.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/layout/toolbar/bg.png',
            base_url+'img/layout/toolbar/buttons/bg-active.png',
            base_url+'img/layout/toolbar/buttons/bg-disabled.png',
            base_url+'img/layout/toolbar/buttons/bg-hover.png',
            base_url+'img/layout/toolbar/buttons/bg-red-active.png',
            base_url+'img/layout/toolbar/buttons/bg-red-disabled.png',
            base_url+'img/layout/toolbar/buttons/bg-red-hover.png',
            base_url+'img/layout/toolbar/buttons/bg-red.png',
            base_url+'img/layout/toolbar/buttons/bg.png',
            base_url+'img/layout/toolbar/buttons/divider.png'
            ]);
		
        UM.utils.preload([base_url+'img/layout/footer/divider.png']);
		
				
        UM.utils.preload([
            base_url+'img/layout/bg.png',
            base_url+'img/layout/content/box/actions-bg.png',
            base_url+'img/layout/content/box/bg.png',
            base_url+'img/layout/content/box/header-bg.png',
            base_url+'img/layout/content/box/menu-active-bg.png',
            base_url+'img/layout/content/box/menu-arrow.png',
            base_url+'img/layout/content/box/menu-bg.png',
            base_url+'img/layout/content/box/menu-item-bg-hover.png',
            base_url+'img/layout/content/box/menu-item-bg.png',
            base_url+'img/layout/content/box/tab-hover.png',
            base_url+'img/layout/content/toolbar/bg-shortcuts.png',
            base_url+'img/layout/content/toolbar/bg.png',
            base_url+'img/layout/content/toolbar/divider.png',
            base_url+'img/layout/content/toolbar/popup-arrow.png',
            base_url+'img/layout/content/toolbar/popup-header.png',
            base_url+'img/layout/content/toolbar/user/arrow-normal.png',
            base_url+'img/layout/content/toolbar/user/avatar-bg.png',
            base_url+'img/layout/content/toolbar/user/avatar.png',
            base_url+'img/layout/content/toolbar/user/bg-hover.png',
            base_url+'img/layout/content/toolbar/user/bg-menu-hover.png',
            base_url+'img/layout/content/toolbar/user/counter.png'
            ]);
		
		
        UM.utils.preload([
            base_url+'img/elements/alert-boxes/bg-error.png',
            base_url+'img/elements/alert-boxes/bg-information.png',
            base_url+'img/elements/alert-boxes/bg-note.png',
            base_url+'img/elements/alert-boxes/bg-success.png',
            base_url+'img/elements/alert-boxes/bg-warning.png',
            base_url+'img/elements/alert-boxes/error.png',
            base_url+'img/elements/alert-boxes/information.png',
            base_url+'img/elements/alert-boxes/note.png',
            base_url+'img/elements/alert-boxes/success.png',
            base_url+'img/elements/alert-boxes/warning.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/breadcrumb/bg-active.png',
            base_url+'img/elements/breadcrumb/bg-hover.png',
            base_url+'img/elements/breadcrumb/divider-active.png',
            base_url+'img/elements/breadcrumb/divider-hover.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/headerbuttons/bg-active.png',
            base_url+'img/elements/headerbuttons/bg-hover.png'
            ]);
	
        UM.utils.preload([
            base_url+'img/elements/autocomplete/el-bg-hover.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/calendar/arrow-hover-bg.png'
            ]);
		
        UM.utils.preload([base_url+'img/elements/charts/hover-bg.png']);
		
        UM.utils.preload([
            base_url+'img/elements/messages/button-active-bg.png',
            base_url+'img/elements/messages/button-hover-bg.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/messages/button-active-bg.png',
            base_url+'img/elements/messages/button-hover-bg.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/mail/actions-bg.png',
            base_url+'img/elements/mail/button-bg-disabled.png',
            base_url+'img/elements/mail/button-bg-hover.png',
            base_url+'img/elements/mail/button-bg.png',
            base_url+'img/elements/mail/button-red-bg-hover.png',
            base_url+'img/elements/mail/button-red-bg.png',
            base_url+'img/elements/mail/button-red-disabled.png',
            base_url+'img/elements/mail/hover-bg.png',
            base_url+'img/elements/mail/mail.png',
            base_url+'img/elements/mail/text-arrow.png',
            base_url+'img/elements/mail/text-bg.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/fullstats/list/hover-bg.png',
            base_url+'img/elements/fullstats/simple/a-active.png',
            base_url+'img/elements/fullstats/simple/a-hover.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/checkbox/checked-active.png',
            base_url+'img/elements/checkbox/checked-disabled.png',
            base_url+'img/elements/checkbox/checked-hover.png',
            base_url+'img/elements/checkbox/checked-normal.png',
            base_url+'img/elements/checkbox/unchecked-active.png',
            base_url+'img/elements/checkbox/unchecked-disabled.png',
            base_url+'img/elements/checkbox/unchecked-hover.png',
            base_url+'img/elements/checkbox/unchecked-normal.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/radiobutton/checked-active.png',
            base_url+'img/elements/radiobutton/checked-disabled.png',
            base_url+'img/elements/radiobutton/checked-hover.png',
            base_url+'img/elements/radiobutton/checked-normal.png',
            base_url+'img/elements/radiobutton/unchecked-active.png',
            base_url+'img/elements/radiobutton/unchecked-disabled.png',
            base_url+'img/elements/radiobutton/unchecked-hover.png',
            base_url+'img/elements/radiobutton/unchecked-normal.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/colorpicker/arrow.png',
            base_url+'img/elements/colorpicker/bg.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/forms/icon-error.png',
            base_url+'img/elements/forms/icon-success.png',
            base_url+'img/elements/forms/tooltip-error-arrow.png',
            base_url+'img/elements/forms/tooltip-error.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/profile/change-active-bg.png',
            base_url+'img/elements/profile/change-hover-bg.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/search/arrow.png',
            base_url+'img/elements/search/glass.png',
            base_url+'img/elements/search/list-hover.png',
            base_url+'img/elements/search/loading.gif'
            ]);

        UM.utils.preload([
            base_url+'img/elements/select/bg-active.png',
            base_url+'img/elements/select/bg-hover.png',
            base_url+'img/elements/select/bg-right-hover.png',
            base_url+'img/elements/select/list-hover-bg.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/settings/header-bg.png',
            base_url+'img/elements/settings/header-current-bg.png',
            base_url+'img/elements/settings/header-hover-bg.png',
            base_url+'img/elements/settings/seperator-current-left.png',
            base_url+'img/elements/settings/seperator-current-right.png',
            base_url+'img/elements/settings/seperator.png'
            ]);

        UM.utils.preload([
            base_url+'img/elements/slide-unlock/lock-slider.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/spinner/arrow-down-active.png',
            base_url+'img/elements/spinner/arrow-down-hover.png',
            base_url+'img/elements/spinner/arrow-up-active.png',
            base_url+'img/elements/spinner/arrow-up-hover.png',
            base_url+'img/elements/table/pagination/active.png',
            base_url+'img/elements/table/pagination/disabled.png',
            base_url+'img/elements/table/pagination/hover.png',
            base_url+'img/elements/table/toolbar/hover.png',
            base_url+'img/elements/table/sorting-asc.png',
            base_url+'img/elements/table/sorting-desc.png',
            base_url+'img/elements/table/sorting.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/tags/bg.png',
            base_url+'img/elements/tags/left.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/to-top/active.png',
            base_url+'img/elements/to-top/hover.png',
            base_url+'img/elements/to-top/normal.png'
            ]);
		
        UM.utils.preload([base_url+'img/elements/tooltips/bg.png']);
		
        UM.utils.preload([
            base_url+'img/elements/upload/bg-hover.png',
            base_url+'img/elements/upload/bg-normal.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/elements/wizard/arrow-current.png',
            base_url+'img/elements/wizard/arrow-error.png',
            base_url+'img/elements/wizard/arrow-normal.png',
            base_url+'img/elements/wizard/arrow-success.png',
            base_url+'img/elements/wizard/bg-current.png',
            base_url+'img/elements/wizard/bg-error.png',
            base_url+'img/elements/wizard/bg-normal.png',
            base_url+'img/elements/wizard/bg-success.png',
            base_url+'img/elements/wizard/bg.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/external/chosen-sprite.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/external/colorpicker/blank.gif',
            base_url+'img/external/colorpicker/colorpicker_background.png',
            base_url+'img/external/colorpicker/colorpicker_hex.png',
            base_url+'img/external/colorpicker/colorpicker_hsb_b.png',
            base_url+'img/external/colorpicker/colorpicker_hsb_h.png',
            base_url+'img/external/colorpicker/colorpicker_hsb_s.png',
            base_url+'img/external/colorpicker/colorpicker_indic.gif',
            base_url+'img/external/colorpicker/colorpicker_overlay.png',
            base_url+'img/external/colorpicker/colorpicker_rgb_b.png',
            base_url+'img/external/colorpicker/colorpicker_rgb_g.png',
            base_url+'img/external/colorpicker/colorpicker_rgb_r.png',
            base_url+'img/external/colorpicker/colorpicker_select.gif',
            base_url+'img/external/colorpicker/colorpicker_submit.png',
            base_url+'img/external/colorpicker/custom_background.png',
            base_url+'img/external/colorpicker/custom_hex.png',
            base_url+'img/external/colorpicker/custom_hsb_b.png',
            base_url+'img/external/colorpicker/custom_hsb_h.png',
            base_url+'img/external/colorpicker/custom_hsb_s.png',
            base_url+'img/external/colorpicker/custom_indic.gif',
            base_url+'img/external/colorpicker/custom_rgb_b.png',
            base_url+'img/external/colorpicker/custom_rgb_g.png',
            base_url+'img/external/colorpicker/custom_rgb_r.png',
            base_url+'img/external/colorpicker/custom_submit.png',
            base_url+'img/external/colorpicker/select.png',
            base_url+'img/external/colorpicker/select2.png',
            base_url+'img/external/colorpicker/slider.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/external/editor/buttons.gif',
            base_url+'img/external/editor/toolbar.gif'
            ]);
		
        UM.utils.preload([
            base_url+'img/external/explorer/arrows-active.png',
            base_url+'img/external/explorer/arrows-normal.png',
            base_url+'img/external/explorer/crop.gif',
            base_url+'img/external/explorer/dialogs.png',
            base_url+'img/external/explorer/icons-big.png',
            base_url+'img/external/explorer/icons-small.png',
            base_url+'img/external/explorer/logo.png',
            base_url+'img/external/explorer/progress.gif',
            base_url+'img/external/explorer/quicklook-bg.png',
            base_url+'img/external/explorer/quicklook-icons.png',
            base_url+'img/external/explorer/resize.png',
            base_url+'img/external/explorer/spinner-mini.gif',
            base_url+'img/external/explorer/toolbar.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/external/gallery/blank.gif',
            base_url+'img/external/gallery/fancybox_buttons.png',
            base_url+'img/external/gallery/fancybox_loading.gif',
            base_url+'img/external/gallery/fancybox_sprite.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/external/jquery-ui/ui-bg_flat_0_000000_40x100.png',
            base_url+'img/external/jquery-ui/ui-bg_flat_30_000000_40x100.png',
            base_url+'img/external/jquery-ui/ui-bg_flat_65_e3e3e3_40x100.png',
            base_url+'img/external/jquery-ui/ui-bg_flat_75_ffffff_40x100.png',
            base_url+'img/external/jquery-ui/ui-bg_glass_55_fbf9ee_1x400.png',
            base_url+'img/external/jquery-ui/ui-bg_highlight-hard_100_f0f0f0_1x100.png',
            base_url+'img/external/jquery-ui/ui-bg_highlight-soft_100_e8e8e8_1x100.png',
            base_url+'img/external/jquery-ui/ui-bg_highlight-soft_75_b3bfcb_1x100.png',
            base_url+'img/external/jquery-ui/ui-bg_inset-soft_95_fef1ec_1x100.png',
            base_url+'img/external/jquery-ui/ui-icons_222222_256x240.png',
            base_url+'img/external/jquery-ui/ui-icons_2e83ff_256x240.png',
            base_url+'img/external/jquery-ui/ui-icons_3a4450_256x240.png',
            base_url+'img/external/jquery-ui/ui-icons_454545_256x240.png',
            base_url+'img/external/jquery-ui/ui-icons_888888_256x240.png',
            base_url+'img/external/jquery-ui/ui-icons_cd0a0a_256x240.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/external/uploader/backgrounds.gif',
            base_url+'img/external/uploader/buttons-disabled.png',
            base_url+'img/external/uploader/buttons.png',
            base_url+'img/external/uploader/delete.gif',
            base_url+'img/external/uploader/done.gif',
            base_url+'img/external/uploader/error.gif',
            base_url+'img/external/uploader/throbber.gif',
            base_url+'img/external/uploader/transp50.png'
            ]);
		
        UM.utils.preload([
            base_url+'img/jquery-ui/accordion-header-active.png',
            base_url+'img/jquery-ui/accordion-header-hover.png',
            base_url+'img/jquery-ui/accordion-header.png',
            base_url+'img/jquery-ui/datepicker/arrow-left.png',
            base_url+'img/jquery-ui/datepicker/arrow-right.png',
            base_url+'img/jquery-ui/datepicker/button-bg.png',
            base_url+'img/jquery-ui/datepicker/button-hover-bg.png',
            base_url+'img/jquery-ui/datepicker/button-seperator.png',
            base_url+'img/jquery-ui/datepicker/day-current.png',
            base_url+'img/jquery-ui/datepicker/day-hover.png',
            base_url+'img/jquery-ui/datepicker/days-of-week-bg.png',
            base_url+'img/jquery-ui/datepicker/header-bg.png',
            base_url+'img/jquery-ui/datepicker/time-bg.png',
            base_url+'img/jquery-ui/datepicker/top-arrow.png',
            base_url+'img/jquery-ui/dialog-titlebar-close-hover.png',
            base_url+'img/jquery-ui/dialog-titlebar.png',
            base_url+'img/jquery-ui/loading.gif',
            base_url+'img/jquery-ui/progressbar/bg.png',
            base_url+'img/jquery-ui/progressbar/fill-blue-small.png',
            base_url+'img/jquery-ui/progressbar/fill-blue.gif',
            base_url+'img/jquery-ui/progressbar/fill-blue.png',
            base_url+'img/jquery-ui/progressbar/fill-grey.gif',
            base_url+'img/jquery-ui/progressbar/fill-grey.png',
            base_url+'img/jquery-ui/progressbar/fill-orange-small.png',
            base_url+'img/jquery-ui/progressbar/fill-orange.gif',
            base_url+'img/jquery-ui/progressbar/fill-orange.png',
            base_url+'img/jquery-ui/progressbar/fill-red-small.png',
            base_url+'img/jquery-ui/progressbar/fill-red.gif',
            base_url+'img/jquery-ui/progressbar/fill-red.png',
            base_url+'img/jquery-ui/slider/bg-range.png',
            base_url+'img/jquery-ui/slider/bg.png',
            base_url+'img/jquery-ui/slider/disabled-bg-range.png',
            base_url+'img/jquery-ui/slider/disabled-bg.png',
            base_url+'img/jquery-ui/slider/disabled-picker.png',
            base_url+'img/jquery-ui/slider/disabled-vertical-bg-range.png',
            base_url+'img/jquery-ui/slider/disabled-vertical-bg.png',
            base_url+'img/jquery-ui/slider/disabled-vertical-picker.png',
            base_url+'img/jquery-ui/slider/picker.png',
            base_url+'img/jquery-ui/slider/vertical-bg-range.png',
            base_url+'img/jquery-ui/slider/vertical-bg.png',
            base_url+'img/jquery-ui/slider/vertical-picker.png'
            ]);
		
    });
	
})(jQuery, $$);

window.AjaxCall=function(url,postdata,returnid,type,callback,returnType){
    //dalert(url+postdata+returnid+type+callback+returnType);  
  
    $.ajax
    ({
        type: "POST",
        url: url,
        beforeSend: function()
        {    
            if((type=="class")&&(!empty(returnid))){                    
                 $("."+returnid).html("<img  height='25%' src='"+base_url+"img/elements/search/loading.gif'>");
            }else if(!empty(returnid)){
               $("#"+returnid).html("<img height='25%' src='"+base_url+"img/elements/search/loading.gif'>");      
            }
        },
        data:postdata+"&LN="+ln,
        cache: false,
        success: function(html)
        {
            if(empty(returnType)){
                if((type=="class")&&(!empty(returnid))){
                    $("."+returnid).html("");
                    $("."+returnid).html(html);
                }else if(!empty(returnid)){
                    $("#"+returnid).html("");
                    $("#"+returnid).html(html);
                }
                $(document).ready(function(){                      
                    if(!empty(callback)){
                        $("#callback").html("<script>"+callback+"</script>");
                    }
                });
            }else{
                 
                //alert(html);
                if(returnType=="alert"){
                   $.jGrowl(html, { header: 'Info' });  
                }else if(returnType=="jAlert"){
                    jAlert(html);
                }else if(html.search("<script>")>=0){
                    $("#callback").html(html);
                }else if(returnType=="returnType"){
                     $("#returnType").html(html);
                }else{
                    $("#"+returnType).html(html);
                }
                $(document).ready(function(){                      
                    if(!empty(callback)){
                        $("#callback").html("<script>"+callback+"</script>");
                    }
                });
            }
        },
        error:function (e, XHR, options){
            if(e.status==0){
                jAlert('You are offline!!\n Please Check Your Network.');
            }else if(e.status==404){
                jAlert('Requested URL not found.');
            }else if(e.status==500){
                jAlert('Internel Server Error.');
            }else if(e.status=='parsererror'){
                jAlert('Error.\nParsing JSON Request failed.');
            }else if(e.status=='timeout'){
                jAlert('Request Time out.');
            }else if(e.status==789){
                jAlert('Authentication failed or Permission denied.');
            }else {
                jAlert("Server is not responding. Data is not saved.Please re-login.");
            }
        }
    });
};

window.UmEncp=function(data){
    return base64_encode(base64_encode(data));
    
};
window.UmDecp=function(data){
     return base64_decode(base64_decode(data));
    
};

function sBs(ss1,ss2,fs) {
    ss1 = fs.search(ss1) + ss1.length; // continue *after* the first substring
    ss2 = fs.search(ss2); //grab the position of the beginning of substring2
    var sbsResult = fs.slice(ss1,ss2); 
    // alert(sbsResult);
    $('#container_12').alert(fs, {
        type:"success",
        position:"note"
    });
    $('#container_12').alert(sbsResult, {
        type:"success",
        position:"note"
    });
    return sbsResult;
}
 
 $(".paginate_button").live("click",function(){
    FormelemenInti();

});
function FormelemenInti(){
    var $el=$('select');
    $el.chosen({
        disable_search_threshold: $el.hasClass('search') ? 0 :Number.MAX_VALUE,
        allow_single_deselect: true,
        width: $el.data('width') || '100%'
    });
    if (!$.fn.tipsy) {
        return;
    }
		
    $.fn.tipsy.defaults.opacity = 1;
		
    $('.tooltip').each(function(){
        var $tooltip = $(this),
        grav = $tooltip.data('gravity') || $.fn.tipsy.autoNS,
        anim = $tooltip.data('anim') || true;
			
        $tooltip.tipsy({
            gravity: grav,
            fade: anim
        });
    });
    $('form.Ajaxvalidate').each(function(){       
        $(this).validate({
            submitHandler: function(form) {
                //dalert(url+postdata+returnid+type+callback+returnType);
                $(this).data('submit') ? $(this).data('submit')() :  AjaxCall($('form.Ajaxvalidate').attr("action"),$('form.Ajaxvalidate').serialize(),$('form.Ajaxvalidate').attr("returnid"),$('form.Ajaxvalidate').attr("type"),$('form.Ajaxvalidate').attr("callback"),$('form.Ajaxvalidate').attr("returnType"));                                 
                $('.Reset').trigger("click");
                $("#"+$('form.Ajaxvalidate').attr("returnid")).html("");
            }
        });
    });
}

function logView(data){
    $(data).each(function(key,val){
        if(is_array(val)){
            logView(val);
        }else{
            console.log(key+"=>"+val);
        }
    });
    return false;
}
function ServerValidFail(data){
    data=$.parseJSON(data); 
    $(data).each(function(key,val){
           var Elementdata=explode("=",key);
           var  forname=substr(Elementdata[1], 0, -1);
           $(key).find("div.error-icon").remove().end();
           $(key).find("label.error").remove().end();
        $(key).after('<div class="error-icon icon" style="right:8.99996px; top: 33.5px;"></div><label for="'+forname+'" generated="true" class="error" style="top: 55px; right: -1.00029px;">'+val+'</label>');
    });
}
  
