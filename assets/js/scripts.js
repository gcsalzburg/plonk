$(function(){
    $("#gallery").justifiedGallery({
        rowHeight : 350,
        margins : 3,
        captions: true,
        sizeRangeSuffixes: {
            100 : '_t',
            320 : '_n',
            800 : '_c', 
            1600 : '_h',
            2048 : '_k'
        }
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