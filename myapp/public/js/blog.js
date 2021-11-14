$(document).ready(function(){
    /**************************************** common ****************************************/
    //ウィンドウのキャンセルボタンを押した時の処理
    $('body').on('click', '.cancel', function() {
        $('body').removeClass('fixed');
        $('.message-box').fadeOut(500);
        logoutButtonClickState = false;
        $('.message-box__content').delay(500).queue(function () {
            $(this).empty().dequeue();
        });
    });


    //ウィンドウ外をクリックした時の処理
    $('body').on('click', '.message-box', function(event) {
        if (!$(event.target).is('.message-box-window, .message-box--window div, .message-box-window p, .message-box-window button, .logout-link')) {
            $('body').removeClass('fixed');
            $('.message-box').fadeOut(500);
            logoutButtonClickState = false;

            $('.message-box__content').delay(500).queue(function () {
                $(this).empty().dequeue();
            });
        }
    });

    //Passwordトグルボタン
    $('.main').on('click', '.password-toggle-icon', function() {
        $(this).children().toggleClass('fa-eye fa-eye-slash');

        let passwordInput = $(this).prev('.input-wrapper__label').children('input');
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
        } else {
            passwordInput.attr('type', 'password');
        }
    });

    //スマートフォン, タブレットでヘッダーメニューのアイコンをクリックした時の処理
    let headerMenuToggleState = false;
    $('.header').on('click', '.header__nav', function(){
        if (headerMenuToggleState === false){
            $(this).find('.header__nav-line').addClass('header__nav-line_open');
            $(this).find('.header__nav-line').next().addClass('header__nav-line_open');
            $(this).find('.header__nav-line').next().next().addClass('header__nav-line_open');
            $('.header__menu').css('display', 'flex');
            headerMenuToggleState = true;
        } else {
            $(this).find('.header__nav-line').removeClass('header__nav-line_open');
            $(this).find('.header__nav-line').next().removeClass('header__nav-line_open');
            $(this).find('.header__nav-line').next().next().removeClass('header__nav-line_open');
            $('.header__menu').hide();
            headerMenuToggleState = false;
        }
    });

    $('body').on('click', function (event) {
        if (!$(event.target).is('.header__menu, .header__link, .header__nav, .header__logo') && headerMenuToggleState) {
            $('.header').find('.header__nav-line').removeClass('header__nav-line_open');
            $('.header').find('.header__nav-line').next().removeClass('header__nav-line_open');
            $('.header').find('.header__nav-line').next().next().removeClass('header__nav-line_open');
            $('.header__menu').hide();
            headerMenuToggleState = false;
        }
    });

    //メニューを開いている最中にウインドウサイズが変更になった時の処理
    $(window).resize(function () {
        if (window.matchMedia('(min-width:769px)').matches) {
            // 処理...
            $('body').removeClass('fixed');
            $('.header__nav').find('.header__nav-line').removeClass('open-header-menu');
            $('.header__nav').find('.header__nav-line').next().removeClass('header__nav-line_open');
            $('.header__nav').find('.header__nav-line').next().next().removeClass('header__nav-line_open');
            $('.header__menu').show();
            headerMenuToggleState = false;
        }

        if (window.matchMedia('(max-width:770px)').matches) {
            $('.header__menu').hide();
            headerMenuToggleState = false;
        }
    });

    /**************************************** index.php, post.php ****************************************/
    if (document.location.pathname === '/' || document.URL.match(/index/) || document.URL.match(/[0-9]/)) {
        let postNavClickState = false;
        let openNavIndex;
        let index;

        $('.main').on('click', '.posts-nav', function() {
            index = $('.posts-nav').index(this);

            if (postNavClickState && openNavIndex === index) {
                $('.posts-nav__menu').hide();
                postNavClickState = false;
                openNavIndex      = undefined;
            } else {
                $('.posts-nav__menu').hide();
                $('.posts-nav__menu').eq(index).css('display', 'flex');
                postNavClickState = true;
                openNavIndex      = index;
            }
        });

        $('body').on('click', function(event) {
            if (!$(event.target).is('.posts-nav__menu, .posts-nav__icon') && postNavClickState) {
                $('.posts-nav__menu').hide();
                openNavIndex      = undefined;
                postNavClickState = false;
            }
        });
    }

    /**************************************** new.php, edit.php ****************************************/
    if (document.URL.match(/new/) || document.URL.match(/edit/)) {
        //trumbowyg生成
        $('#post-form').trumbowyg({
            autogrow:            true,
            imageWidthModalEdit: true,
            lang:                'ja',
            resetCss:            true,
            tagsToKeep:          ['i'],
            tagsToRemove:        ['script']
        });
    }
    /**************************************** login.php ****************************************/

    /**************************************** functions ****************************************/
    //インプット内容を検証してBooleanを返す
    function verificationInputValue(items, passwords, emails) {
        const EMAIL_REGEXP        = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
        let verificationPasswords = passwords === undefined ? null : passwords;
        let verificationEmails    = emails    === undefined ? null : emails;

        for (let i = 0; i < items.length; ++i) {
            if (items[i] === '') return false;
        }

        if (verificationPasswords) {
            for (let i = 0; i < verificationPasswords.length; ++i) {
                if (verificationPasswords[i].length < 8) return false;
            }
        }

        if (verificationEmails) {
            for (let i = 0; i < verificationEmails.length; ++i) {
                if (!EMAIL_REGEXP.test(verificationEmails[i])) return false;
            }
        }

        return true;
    }

    //送信ボタンの状態切り替えに関する関数
    function toggleSendButton (isEnabled, sendButton) {
        if (isEnabled) {
            sendButton.removeClass('button--disabled').addClass('button--enabled').prop('disabled', false);
        } else {
            sendButton.removeClass('button--enabled').addClass('button--disabled').prop('disabled', true);
        }
    }
});