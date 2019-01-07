//
// Main PLONK scripts
//

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

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            fetch_next();
        }
      });


      function fetch_next(){
        var next = $("#gallery").attr('data-next');
        var folder = $("#gallery").attr('data-folder');
        $.getJSON("/plonk/fetch.php",{
            f: folder,
            s: next
        }).done(function(data){
            if(data.has_imgs){
                $.each(data.imgs, function(i, item){
                    $("#gallery").append('<a href="'+item.link+'" class="thumb" data-folder="'+item.folder+'" data-filename="'+item.filename+'">' +
                        '<img alt="'+item.alt+'" src="'+item.src+'">' +
                        '</a>');
                }); 
                $('#gallery').justifiedGallery('norewind'); 
            }
            $("#gallery").attr('data-next',data.next);
        });
      }

      fetch_next();
});
