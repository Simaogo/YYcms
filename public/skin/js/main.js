/**
 * Created by Administrator on 2017/7/13.
 */
$(window).ready(function(){
    $('body').on('touchstart',function(){});
    var wWidth=$(window).width();
    var times=null;
    $(function() {
        FastClick.attach(document.body);
    });
    var navLeft=$('.brief-nav');
    if(navLeft.length>0){
        var box=$('.brief-nav-con li');
        for(var k=0;k<box.length;k++){
            if(box.eq(k).find('a').length<2){
                box.eq(k).addClass('none');
            }else{
                box.eq(k).addClass('has').find('.left-yi').attr('href','javascript:;');
                if(wWidth>750){
                    box.eq(k).click(function(){
                        $(this).find('.left-er-box').slideToggle();
                        $(this).find('.zksq').toggleClass('active');
                    });
                }else{
                    box.eq(k).click(function(){
                        $(this).toggleClass('in');
                        $(this).find('.zksq').toggleClass('active');
                    });
                }

            }
        }
    }
    if(wWidth<1251){
        $('.menu-box li').click(function(){
            $(this).toggleClass('active').find('.nav-er-box').stop().slideToggle();
        });
    }else{
        $('.menu-box li').hover(function(){
            $(this).addClass('cur');
        },function(){
            $(this).removeClass('cur');
        });
    }
    //$('.zksq').click(function(){
    //    $(this).toggleClass('active');
    //    $(this).parent().toggleClass('on');
    //    $(this).siblings('.left-er-box').stop().slideToggle();
    //});
    $('#menu-handler').click(function(){
        $(this).toggleClass('active');
        $('html').toggleClass('active');
        $('.menu-box,.language,.head-top2').toggleClass('active');
    });

    $('.toTop').click(function(e){
        e.preventDefault();
        $("html,body").animate({scrollTop:0},300);
    });
    $(window).scroll(function(){
        
        var top=$(window).scrollTop();
        if(top>100){
            $('.fubox').addClass('active');
        }else{
            $('.fubox').removeClass('active');
        }
        if(top>40){
            $('.header').addClass('active');
        }else{
            $('.header').removeClass('active');
        }
        // if(wWidth<760){
        //     clearInterval(times);
        //     $('.head-top2').addClass('active');
        //     times=setInterval(function(){
        //         $('.head-top2').removeClass('active');
        //     },300)
        // }
    });
    $('.search-btn').click(function(){
        $('.search-nr,.menu-box').toggleClass('active');
        $('.search-nr .text').focus();
    });
    $('.search-close').click(function(){
        $('.search-nr,.menu-box').removeClass('active');
    });

});