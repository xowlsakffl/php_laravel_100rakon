$(function(){
    
    $('.menu-btn').click(function(){
        $(this).stop().toggleClass('active');
        $('.sidebar').stop().toggleClass('active side_close');
        $('.main').stop().toggleClass('active');
        $('footer').stop().toggleClass('active');
    });

    $('.menu-btn_m').click(function(){
        $(this).stop().toggleClass('active');
        $('.sidebar_m').toggle();
    });

    $('.right_area').mouseenter(function(){
        $('.auth_box').fadeIn(400);
    });

    $('.right_area').mouseleave(function(){
        $('.auth_box').fadeOut(400);
    });

    $('.sidebar .slideDownMenu').click(function(){
        $('.menu_dep_3').stop().slideUp();
        $(this).siblings('ul').stop().slideToggle();
    });
})