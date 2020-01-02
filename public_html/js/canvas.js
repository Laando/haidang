        var canvas;
        var stage;
        var screen_width;
        var screen_height;
        var bmpAnimation;
        var bmpAnimationWelcome;
        var bmpAnimationWelcome2;
        var isStop = false;
        var isIntro = false;
        var isRight = false;
        var isClose = false;
        var isOpenBox = false;
        var _this = this;

        var numberOfImagesLoaded = 0;

        var imgSprite = new Image();

        function init() {
            canvas = document.getElementById("welcomeCanvas");

            imgSprite.onload = handleImageLoad;
            imgSprite.onerror = handleImageError;
            imgSprite.src = "../images/sprites.png";

        }

        function handleImageLoad(e) {
            numberOfImagesLoaded++;

            if (numberOfImagesLoaded == 1) {
                numberOfImagesLoaded = 0;
                startSprite();
            }
        }

        function reset() {
            stage.removeAllChildren();
            createjs.Ticker.removeAllListeners();
            stage.update();
        }

        function startSprite() {
            stage = new createjs.Stage(canvas);
            if ($('body').width()>700) {
                screen_width = canvas.width;
            } else {
                screen_width = 100;
                $('.phone-box').css('left',76);
            }
            screen_height = canvas.height;

            var spriteSheet = new createjs.SpriteSheet({
                images: [imgSprite],
                frames: { width: 81, height: 193, regX: 81, regY: 0 },
                animations: {
                    walkLeft: [0, 3, "walkLeft", 12],
                    walkRight: [4, 7, "walkRight", 12],
                    welcome: [8, 9, "welcome", 2],
                    intro: [10, 11, "intro", 2],
                    end: [10]
                }
            });

            createjs.SpriteSheetUtils.addFlippedFrames(spriteSheet, true, false, false);


            bmpAnimation = new createjs.BitmapAnimation(spriteSheet);

            bmpAnimation.gotoAndPlay("walkLeft"); 	//walking from left to right

            bmpAnimation.name = "fpt-girl";
            bmpAnimation.direction = 90;
            bmpAnimation.vX = 1;

            // have each monster start at a specific frame
            bmpAnimation.currentFrame = 0;
            stage.addChild(bmpAnimation);

            createjs.Ticker.addListener(window);
            createjs.Ticker.useRAF = true;
            createjs.Ticker.setFPS(60);
        }

        function handleImageError(e) {
            console.log("Error Loading Image : " + e.target.src);
        }

        function tick() {
            if (!isIntro && !isClose) {
                if (bmpAnimation.x >= screen_width - 16) {
                    bmpAnimation.gotoAndStop("walkLeft");
                    bmpAnimation.gotoAndPlay("welcome");
                    isStop = true;
                    createjs.Ticker.setFPS(2);
                    setTimeout(function () {
                        bmpAnimation.gotoAndStop("welcome");
                        setTimeout(function () {
                            isIntro = true;
                            createjs.Ticker.setFPS(60);
                            bmpAnimation.gotoAndPlay("intro");
                            bmpAnimation.currentFrame = 10;
                        }, 1000);
                    }, 400);
                }
            } else if (isIntro && !isClose) {
                isStop = true;
                createjs.Ticker.setFPS(3);
                if (bmpAnimation.currentFrame == 11) {
                    bmpAnimation.currentFrame = 10;
                    createjs.Ticker.setPaused(true);
                    stage.update();
                }
                setTimeout(function () {
                    createjs.Ticker.setPaused(false);
                }, 3000);
                if (!isOpenBox) {
                    isOpenBox = true;
                    openGetPhoneBox();
                }
            }
            if (isClose) {
                if (!isRight) {
                    isRight = true;
                    createjs.Ticker.setFPS(2);
                    bmpAnimation.gotoAndStop("intro");
                    bmpAnimation.gotoAndPlay("welcome");
                    //			bmpAnimation.currentFrame = 9;
                    stage.update();
                    setTimeout(function () {
                        $('.phone-box').removeAttr('style').addClass('active');
                        $("#txtGetPhone").attr('placeholder', 'Nhập số điện thoại của bạn');
                        bmpAnimation.gotoAndStop("welcome");
                        bmpAnimation.direction -= 90;
                        createjs.Ticker.setFPS(60);
                        bmpAnimation.gotoAndPlay("walkRight");
                    }, 400);
                }
            }
            if (bmpAnimation.x < 85 && isClose) {
                bmpAnimation.gotoAndStop("walkRight");
                createjs.Ticker.setPaused(true);
                bmpAnimation.gotoAndPlay("end");
                stage.update();
                $('#welcomeCanvas').animate({ 'top': '20px' }, 500, function () {
                    //$('.canvasHolder').addClass('active');
                    $('#welcomeCanvas').hide();
                });
                $("#txtGetPhone").unbind('blur');
                createjs.Ticker.removeAllListeners();
                stage.update();
            }
            if (!isStop && bmpAnimation.direction == 90) {
                bmpAnimation.x += bmpAnimation.vX;
            } else if (isClose) {
                bmpAnimation.x -= bmpAnimation.vX;
            }
            stage.update();
        }
        $(window).load(function () {
            if(getCookie('hideSuggest')!='true') {
                if ($('#welcomeCanvas').length > 0) {
                    setTimeout(function () {
                        init();
                        $('.content-text-hide a').attr('href', $('.main-phone-box a').attr('href'));
                    }, 2000);
                }
            } else {
                $('.canvasHolder').remove();
            }
        });
        function closePhoneBox() {
            $('.content-phone-box').css({
                visibility: 'hidden'
            });
            $('.phone-box').css({
                width: '20px',
                height: '20px',
                padding: '0',
                visibility: 'hidden'
            });
            isStop = false;
            isClose = true;
        }

        function openGetPhoneBox() {
            if ($('body').width()>700) {
                $('.phone-box').css({
                    width: '300px',
                    height: '130px',
                    padding: '12px',
                    visibility: 'visible'
                });
            } else {
                $('.phone-box').css({
                    width: '200px',
                    height: '130px',
                    padding: '12px',
                    visibility: 'visible'
                });
            }
            setTimeout(function () {
                    $('.content-phone-box').css({
                        visibility: 'visible'
                    });
            }, 250);
            $("#btnGetPhone").click(function (e) {
                var typeName = $('#typeNameBox').val();
	    e.preventDefault();
	    var ckphone = /^0[0-9]{9,10}$/;
	    if (!ckphone.test($("#txtGetPhone").val())) {
	        alert('Số điện thoại không đúng, vui lòng nhập lại');
	    } else {
	        
	    }

	});
	$(".close-phone-box").click(function (e) {
	    e.preventDefault();
        setCookie('hideSuggest','true');
	    closePhoneBox();
	});
	$(".close-canvas").click(function (e) {
	    e.preventDefault();
	    $('.canvasHolder').css({ 'bottom': '-200px' });
	});
	setTimeout(function () {
	    if ($.trim($("#txtGetPhone").val()).length <= 0) {
	        if (!$("#txtGetPhone").is(":focus")) {
	            $('.content-phone-box').css({
	                visibility: 'hidden'
	            });
	            closePhoneBox();
	        }
	    }
	    $("#txtGetPhone").blur(function () {
	        if ($.trim($("#txtGetPhone").val()).length <= 0) {
	            $('.content-phone-box').css({
	                visibility: 'hidden'
	            });
	            closePhoneBox();
	        }
	    });
	}, 180000);
	}
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
            }
            return "";
        }