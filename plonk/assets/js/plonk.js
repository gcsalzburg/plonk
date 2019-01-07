//
// Main PLONK scripts
//

$(function(){

    // Load gallery justifier
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

        // Once gallery loaded, append download links to each item
        $(this).children().each(function(i){
            $(this).append('<a href="/d/'+$(this).attr('data-folder')+'/'+$(this).attr('data-filename')+'" class="download_orig" target="_blank">Download Original</a>');
        });

        // Initialise swipebox
        $('.thumb').swipebox();

    });

    // Prevent clicks on download link propagating up (and opening swipebox gallery as well)
    $("#gallery").on('click','.download_orig',function(e){
        e.stopPropagation();
    });

    // Scroll handler for infinite scrolling
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            fetch_next();
        }
    });

    // Call function to load next items for infinite scroller
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
