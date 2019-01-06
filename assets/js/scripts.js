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
});