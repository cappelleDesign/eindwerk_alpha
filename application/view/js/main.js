$(init);
function init() {
    $('.noScript').remove();
    $('.no-js-push').removeClass('no-js-push');
    setListeners();
    $('#main-menu').slicknav({
        label: 'NEOLUDUS',
        duration: 600,
        easingOpen: 'easeOutBounce',
        prependTo: 'body'
    });
    setSubMenuWidths();
    repaint();
    dispNotif();
}
function setListeners() {
    $('#login-main').on('click', function () { 
        $url = window.location.href;        
        Cookies.set('last_page', $url);
    });
    $('#main-menu li a').on('click', function () {        
        $url = $(this).attr('href');
        Cookies.set('last_page', $url);
    });
    $('[data-toggle="tooltip"]').tooltip();
    $(window).resize(function () {
        repaint();
    });
    (function ($) {
        $.fn.hasScrollBar = function () {
            return this.get(0).scrollHeight > this.height();
        };
    })(jQuery);
    $('header > form > .form-group > input').on({
        keyup: function (e) {
            if (e.which === 13) {
                $(this).next().click();
            }
            if (e.which === 27) {
                $(this).val('');
            }
        }
    });
    $('#main-search').on({
        click: function (e) {
            //handle this event
            $(this).prev().val();
        }
    });

    $('#account-panel > a:first-child').on({
        touchstart: function (e) {
            e.preventDefault();
            if ($(this).parent().hasClass('expanded')) {
                this.blur();
                expandProfileMenu(this, false);
            } else {
                this.focus();
                expandProfileMenu(this, true);
            }
        },
        focusout: function () {
            expandProfileMenu(this, false);
        },
        mouseenter: function () {
            this.focus();
            expandProfileMenu(this, true);
        },
        mouseleave: function () {
            this.blur();
            expandProfileMenu(this, false);

        },
        click: function (e) {
            e.preventDefault();
        }
    });
    $('.submenu-trigger').hover(
            function () {
                triggerSubMenu(this, true);
            },
            function () {
                triggerSubMenu(this, false);
            }
    );
    $('.submenu-trigger > a:first-child').on({
        touchstart: function (e) {
            e.preventDefault();
            if ($(this).next().hasClass('submenu-visible')) {
                this.blur();
                triggerSubMenu($(this).parent(), false);
            } else {
                this.focus();
                triggerSubMenu($(this).parent(), true);
            }
        },
//        click: function(e) {
//            e.preventDefault();
//        },
        focusout: function () {
            triggerSubMenu($(this).parent(), false);
        }
    });
    $('body').on({
        touchstart: function () {
            if ($(this).hasClass('slicknav_collapsed')) {
                triggerMobileSubmenu(true);
            } else {
                triggerMobileSubmenu(false);
            }
        }
    }, 'a.slicknav_btn');
    $('.mobile-menu-addon a').on({
        touchstart: function (e) {
            e.preventDefault();
            $('#mobile-menu-addon-extended').hide('slide', {'direction': 'left'}, 'fast', function () {
                $('#mobile-menu-addon-extended').css({
                    position: 'fixed'
                });
            });
            triggerMobileMenuAddon(this);
        },
    });
    $('.mobile-menu-addon').on({
        focusout: function () {
//            mobileMenuAddonHideAll(true);
        }
    });
    $('#mobile-menu-addon-extended i').on({
        touchstart: function (e) {
            e.preventDefault();
            mobileMenuAddonHideAll(true);
        }
    });
}
function repaint() {
    $w = $(document).width();
    if ($w > 1100) {
        $('.customScroll').mCustomScrollbar({
            theme: 'scrollBarStyles',
            scrollButtons: {enable: true}
        });
    } else {
        $('.customScroll').mCustomScrollbar("destroy");
    }
    $h = $(window).height();
    $('#neo-wrapper').css('minHeight', $h + 'px');
    if ($w <= 810) {
        toggleSubmenuStyles(false);
    } else {
        toggleSubmenuStyles(true);
    }
}
function toggleSubmenuStyles($show) {
    if ($show) {
        $('.submenu').addClass('menu');
    } else {
        $('.submenu').removeClass('menu');
    }
}
function expandProfileMenu($el, $show) {
    $class = 'expanded';
    $height = getProfileMenuHeight();
    if ($show) {
        $($el).parent().addClass($class);
    } else {
        $($el).parent().removeClass($class);
    }
}
function getProfileMenuHeight() {
    $w = $(document).width();
    if ($w <= 1500) {
        return '21px';
    }
    return '27px';
}
function setSubMenuWidths() {
    $submenus = $('.submenu');
    $.each($submenus, function (i, $el1) {
        $($el1).hide();
        $children = $($el1).children();
        $devide = 100 / $children.length;
        $.each($children, function (i, $el2) {
            $($el2).css('width', $devide + '%');
        });
    });
}
function triggerSubMenu($el, $show) {
    $sub = $($el).data('submenu-trigger');
    $subEl = $('.submenu-' + $sub);
    if ($show) {
        $subEl.addClass('submenu-visible');
        $subEl.stop().fadeIn('slow');
    } else {
        $subEl.stop().fadeOut('fast', function () {
            $subEl.removeClass('submenu-visible');
        });
    }
}
function triggerMobileSubmenu($show) {
    if ($show) {
        $('.mobile-menu-addon').stop().fadeOut('slow');
    } else {
        $('.mobile-menu-addon').stop().fadeIn('slow');
    }
}

function triggerMobileMenuAddon($el) {
    $id = $($el).attr('id');
    $show = true;
    $($el).parent().focus();
    if ($($el).hasClass('active')) {
        mobileMenuAddonHideAll();
        $show = false;
    } else {
        $($el).focus();
        mobileMenuAddonStyleTrigger($id);
    }
    if ($show) {
        switch ($id) {
            case 'mobile-social-trigger' :
                triggerMobileSocial();
                break;
            case 'mobile-profile-trigger' :
                triggerMobileProfile();
                break;
            case 'mobile-search-trigger' :
                triggerMobileSearch();
                break;
        }
        $('#mobile-menu-addon-extended').css({position: 'fixed'}).show('slide', 'fast');
    } else {
        $('#mobile-menu-addon-extended').hide('slide', {'direction': 'left'}, 'fast', function () {
            $('#mobile-menu-addon-extended').css({
                position: 'fixed'
            });
        });
    }
}
function mobileMenuAddonStyleTrigger($id) {
    $.each($('.mobile-menu-addon a'), function ($i, $elC) {
        $workEl = $($elC);
        if ($workEl.attr('id') === $id) {
            $workEl.addClass('active');
        } else {
            $workEl.removeClass('active');
        }
    });
}
function mobileMenuAddonHideAll($forced) {
    mobileMenuAddonStyleTrigger('none');
    if ($forced) {
        $('#mobile-menu-addon-extended').hide('slide', {'direction': 'left'}, 'fast', function () {
            $('#mobile-menu-addon-extended').css({
                position: 'fixed'
            });
        });
    }
}
function triggerMobileSocial() {
    $('#mobile-addon-content').removeClass();
    $('#mobile-addon-content').addClass('social');
    $mail = '<a href="mailto::info@neoludus.com"><i class="fa fa-envelope" title="Mail us" aria-hidden="true"></i></a>';
    $fb = '<a href="https://www.facebook.com/Neoludus" target="_blank"><i class="fa fa-facebook" title="Visit our Facebook page" aria-hidden="true"></i></a>';
    $yt = '<a href="https://www.youtube.com/channel/UCmt2BsAl7VdWx8rsLwBpHNA" target="_blank"><i class="fa fa-youtube" title="Visit our Youtube channel" aria-hidden="true"></i></a>';
    $twitch = '<a href="https://www.twitch.tv/neoludus" target="_blank"><i class="fa fa-twitch" title="Visit our Twitch channel" aria-hidden="true"></i></a>';
    $twitt = '<a href="https://twitter.com/Neoludus" target="_blank"><i class="fa fa-twitter" title="Visit our Twitter page" aria-hidden="true"></i></a>';
    $payp = '<i class="fa fa-paypal" title="Make a donation" aria-hidden="true"></i>';
    $html = $mail + $fb + $yt + $twitch + $twitt + $payp;
    $('#mobile-addon-content').html($html);
}
function triggerMobileProfile() {
    //TODO if user logged in -> logout button
    $('#mobile-addon-content').removeClass();
    $('#mobile-addon-content').addClass('profile');
    $loggedOn = $('#account-panel').data('logged-on');
    $logout = '<a class="solo" href="account/logout/true"><i class="fa fa-sign-out fa-fw"></i><p>Sign out</p></a>';
    $login = '<a id="login-main" href="account/loginPage/true"><i class="fa fa-sign-in fa-fw"></i><p>Login</p></a>';
    $register = '<a href="account/register/true"><i class="fa fa-pencil-square-o fa-fw"></i><p>Register</p></a>';
    if ($loggedOn === false) {
        $html = $login + $register;
    } else {
        $html = $logout;
    }
    $('#mobile-addon-content').html($html);
}
function triggerMobileSearch() {
    $('#mobile-addon-content').removeClass();
    $('#mobile-addon-content').addClass('search');
    $search = '<form id="search-form" class="mobile-search-form" method="POST" action="#">' +
            '<div class="form-group">' +
            '<input type="text" placeholder="search games.." tabindex="1">' +
            '<a class="script-only" id="main-search" href="#" tabindex="2">' +
            '<i class="fa fa-search"></i>' +
            '</a>' +
            '<button class="noScript" type="submit">' +
            '<i class="fa fa-search"></i>' +
            '</button>' +
            '</div>' +
            '</form>';
    $html = $search;
    $('#mobile-addon-content').html($html);
}

function cleanPath($string) {
    $string = $string.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '_');
    return $string;
}