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
            var download_link = '/d/'+$(this).attr('data-folder')+'/'+$(this).attr('data-filename');
            $(this).append('<a href="'+download_link+'" class="download_orig" target="_blank">Download Original</a>');
        });

        // Initialise swipebox
        $('.thumb').swipebox();

    });

    // Prevent clicks on download link propagating up (and opening swipebox gallery as well)
    $("#gallery").on('click','.download_orig',function(e){
        e.stopPropagation();
    });

    // Scroll handler for infinite scrolling

    var is_fetching = false;
    var bottom_tolerance = 150;

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= ($(document).height()-bottom_tolerance)) {
            fetch_next();
        }
    });

    // Call function to load next items for infinite scroller
    function fetch_next(){
        if(!is_fetching){
            is_fetching = true;
            var next = $("#gallery").attr('data-next');
            var folder = $("#gallery").attr('data-folder');
            $.getJSON("/f/"+folder+"/"+next).done(function(data){
                if(data.has_imgs){
                    $.each(data.imgs, function(i, item){
                        $("#gallery").append('<a href="'+item.link+'" class="thumb" data-folder="'+item.folder+'" data-filename="'+item.filename+'">' +
                        '<img alt="'+item.alt+'" src="'+item.src+'">' +
                        '</a>');
                    }); 
                    $('#gallery').justifiedGallery('norewind'); 
                }
                $("#gallery").attr('data-next',data.next);
                is_fetching = false;
            }).fail(function() {
                // I wonder why it failed?
                is_fetching = false;
            });
        }
    }
    
    // Handler for photos to process
    if($("#process").length){
        process_next($("#process").attr('data-filename'));
    }else{
        fetch_next();
    }



    function process_next(filename){
        $.getJSON("/plonk/process.php",{
            f: filename
        },function(result){
            console.log(result);
            if(!result.error){
                if(result.to_process){
                    console.log(((parseInt($("#process").attr('data-current'))/parseInt($("#process").attr('data-total')))*100)+"%");
                    $("#progress_bar").css('width', ((parseInt($("#process").attr('data-current'))/parseInt($("#process").attr('data-total')))*100)+"%" );
    
                    $("#process").attr('data-filename',result.process_filename);
                    $("#process").attr('data-current',parseInt($("#process").attr('data-current'))+1);
    
                    $("#process_current").text($("#process").attr('data-current'));
    
                    $("#process_filename").text(result.process_filename_no_path);
                    process_next(result.process_filename);

                }else{
                    // All done!
                    $("#progress_bar").css('width', "100%" );
                    $("#process_msg").html("<strong>Done!</strong> Reload page to see the album");
                }
            }
        });
    }
});
