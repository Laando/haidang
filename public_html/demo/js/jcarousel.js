!function ($) {
    "use strict";
    var JCarousel = function (element, options) {
        this.$element = $(element)
        this.options = options
        this.options.jslide && this.slide(this.options.jslide)
        this.options.pause == 'hover' && this.$element.on('mouseenter', $.proxy(this.pause, this)).on('mouseleave', $.proxy(this.cycle, this))
        this.transition = (function () {
            var transitionEnd = (function () {
                var el = document.createElement('bootstrap'),
                    transEndEventNames = {
                        'WebkitTransition': 'webkitTransitionEnd',
                        'MozTransition': 'transitionend',
                        'OTransition': 'oTransitionEnd otransitionend',
                        'transition': 'transitionend'
                    },
                    name
                for (name in transEndEventNames) {
                    if (el.style[name] !== undefined) {
                        return transEndEventNames[name]
                    }
                }
            }())
            return transitionEnd && {
                    end: transitionEnd
                }
        })()
    }

    JCarousel.prototype = {
        cycle: function (e) {
            if (!e) this.paused = false
            if (this.interval) {
                clearInterval(this.interval)
                this.interval = null
            }
            this.options.interval && !this.paused && (this.interval = setInterval($.proxy(this.next, this), this.options.interval))
            return this
        },
        to: function (pos) {
            var $active = this.$element.find('.item.active'),
                children = $active.parent().children(),
                activePos = children.index($active),
                that = this
            if (pos > (children.length - 1) || pos < 0) return
            if (this.sliding) {
                return this.$element.one('jslid', function () {
                    that.to(pos)
                })
            }
            if (activePos == pos) {
                return this.pause().cycle()
            }
            return this.slide(pos > activePos ? 'next' : 'prev', $(children[pos]))
        },
        pause: function (e) {
            if (!e) this.paused = true
            if (this.$element.find('.next, .prev').length && this.transition.end) {
            }
            clearInterval(this.interval)
            this.interval = null
            return this
        },
        next: function () {
            if (this.sliding) return
            return this.slide('next')
        },
        prev: function () {
            if (this.sliding) return
            return this.slide('prev')
        },
        slide: function (type, next) {
            var $active = this.$element.find('.item.active'),
                $next = next || $active[type](),
                isCycling = this.interval,
                direction = type == 'next' ? 'left' : 'right',
                fallback = type == 'next' ? 'first' : 'last',
                that = this

            this.sliding = true
            isCycling && this.pause()
            $next = $next.length ? $next : this.$element.find('.item')[fallback]()
            if ($next.hasClass('active')) return
            var e = $.Event('jslide', {
                relatedTarget: $next[0]
            })
            if (this.transition && this.$element.hasClass('slide')) {
                this.$element.trigger(e)
                if (e.isDefaultPrevented()) return
                $next.addClass(type)
                $next[0].offsetWidth
                $active.addClass(direction)
                $next.addClass(direction)
                this.$element.one(this.transition.end, function () {
                    $next.removeClass([type, direction].join(' ')).addClass('active')
                    $active.removeClass(['active', direction].join(' '))
                    that.sliding = false
                    setTimeout(function () {
                        that.$element.trigger('jslid')
                    }, 0)
                })
            } else {
                this.$element.trigger(e)
                if (e.isDefaultPrevented()) return
                if (this.options.pager) {
                    $(this.options.pager).removeClass('sel').eq($next.index()).addClass('sel');
                }
                var that = this, end = 0, endFn = function () {
                        $active.removeClass('active')
                        $next.addClass('active')
                        $active.attr('style', null)
                        $next.attr('style', null)
                        that.sliding = false
                        that.$element.trigger('jslid')
                    },
                    chk4end = function () {
                        end++;
                        if (end == 2) {
                            endFn();
                        }
                    },
                    nextCss = {
                        display: 'block',
                        width: '100%',
                        position: 'absolute',
                        top: 0,
                        left: '100%'
                    },
                    nextOpt = {
                        left: '0'
                    },
                    actiOpt = {
                        left: '-100%'
                    },
                    commOpt = {
                        duration: 800,
                        complete: chk4end
                    };
                if (this.$element.hasClass('slide')) {
                    if (type == 'prev') {
                        nextCss.left = '-100%';
                        actiOpt.left = '100%';
                    } else if (type == 'next') {
                    }

                } else {
                    nextCss.left = 0;
                    nextCss.opacity = 0;
                    nextOpt = {
                        opacity: 1
                    }
                    actiOpt = {
                        opacity: 0
                    }
                }
                $next.css(nextCss).animate(nextOpt, commOpt);
                $active.animate(actiOpt, commOpt);
            }
            isCycling && this.cycle()
            return this
        }
    }

    $.fn.jcarousel = function (option) {
        return this.each(function () {
            var $this = $(this),
                data = $this.data('jcarousel'),
                options = $.extend({}, $.fn.jcarousel.defaults, typeof option == 'object' && option),
                action = typeof option == 'string' ? option : options.jslide
            if (!data) $this.data('jcarousel', (data = new JCarousel(this, options)))
            if (typeof action == 'number') data.to(action)
            else if (action) data[action]()
            else if (options.interval) data.cycle()
        })
    }

    $.fn.jcarousel.defaults = {
        interval: 5000,
        pause: 'hover'
    }

    $.fn.jcarousel.Constructor = JCarousel

    $(function () {
        $("img.lazy").lazyload();
        var isMobile = false; //initiate as false
        // device detection
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;
        if(isMobile){
            $('#tourweek').find('.items-grid.ajaxtabs01-4.ajaxtabs02-2.ajaxtabs03-2.ajaxtabs04-1').each(function(index,element){
                $(element).find('.item-wrap').each(function(ii,ele){
                    if(ii>0){
                        $('<div class="items-grid  ajaxtabs01-4 ajaxtabs02-2 ajaxtabs03-2 ajaxtabs04-1 item"></div>').append(ele).insertAfter($(element));
                    }
                });
            });
            $('#tourtoday').find('.items-grid.ajaxtabs01-4.ajaxtabs02-2.ajaxtabs03-2.ajaxtabs04-1').each(function(index,element){
                $(element).find('.item-wrap').each(function(ii,ele){
                    if(ii>0){
                        $('<div class="items-grid  ajaxtabs01-4 ajaxtabs02-2 ajaxtabs03-2 ajaxtabs04-1 item"></div>').append(ele).insertAfter($(element));
                    }
                });
            });
        }
        $('body').on('click.jcarousel.data-api', '[data-jslide]', function (e) {
            var $this = $(this), href,
                $target = $($this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')),
                options = !$target.data('modal') && $.extend({}, $target.data(), $this.data())
            $target.jcarousel(options)
            e.preventDefault()
        });
        $('[data-start-jcarousel]').each(function () {
            var $this = $(this), options = options = !$this.data('modal') && $.extend({}, $this.data());
            $this.jcarousel(options);
            $this.bind('jslide', function (e) {
                var index = $(this).find(e.relatedTarget).index();
                $('[data-jslide]').each(function () {
                    var $nav = $(this), $navData = $nav.data(), href, $target = $($nav.attr('data-target') || (href = $nav.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, ''));
                    if (!$target.is($this)) return;
                    if (typeof $navData.jslide == 'number' && $navData.jslide == index) {
                        $nav.addClass('sel');
                    } else {
                        $nav.removeClass('sel');
                    }
                });
            });
        });
    })
}(window.jQuery);