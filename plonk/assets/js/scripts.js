$(function(){
    $("#gallery").justifiedGallery({
        rowHeight : 350,
        margins : 3,
        captions: false,
        sizeRangeSuffixes: {
            100 : '_t',
            320 : '_n',
            800 : '_c', 
            1600 : '_h',
            2048 : '_k'
        }
    }).on('jg.complete',function(){
        $(this).children().each(function(i){
            $(this).append('<a href="/d/'+$(this).attr('data-folder')+'/'+$(this).attr('data-filename')+'" class="download_orig" target="_blank">Download Original</a>');
        });
        $('.thumb').swipebox();

    });

    $("#gallery").on('mouseenter','.thumb',function(){
        $(this).addClass('hover');
    }).on('mouseleave','.thumb',function(){
        $(this).removeClass('hover');
    });
/*
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
          for (var i = 0; i < 5; i++) {
            $('#gallery').append('<a>' +
                '<img src="http://path/to/image" />' + 
                '</a>');
          }
          $('#gallery').justifiedGallery('norewind');
        }
      });*/
});