# 🖼️ plonk

> See it here: https://photos.67hours.co.uk/

Plonk is a super clean, basic, image gallery.
It does just two things well: 

* Display a grid of your photos, sorted into albums
* Allow easy download of any originals for the pictures

This is achieved with no admin interface and no database. Upload your photos to a folder on your server and you're done!

## How to use

> See folder `albums/demo` for an example of how to set up the folders

This projects requires a server running PHP7 or later (or probably earlier too).

1. [Download this project here](https://github.com/gcsalzburg/plonk/archive/master.zip) and upload it into a folder on your server
2. Create a folder for your album inside the `albums` directory.
2. ~~Upload your original photos into your new folder~~
3. Add files to the album with suffixes as follows:

| _ | How to generate | Example |
| --- | --- | -- |
| t | 100 pixel max on widest side | DSC03317_t.jpg |
| n | 320 pixel max on widest side | DSC03317_n.jpg |
| c | 800 pixel max on widest side | DSC03317_c.jpg |
| h | 1600 pixel max on widest side | DSC03317_h.jpg |
| k | 2048 pixel max on widest side | DSC03317_k.jpg |
| o | Original source image | DSC03317_o.jpg |

4. The gallery will be available at the url `http://yourwebsite.com/albumname`

## Customisation

A small amount of page customisation is possible.

Add a file called `meta.json` to the album folder wWith some of the following options:

```json
{
    "header": "Basename (without suffix) of the file to use as header image, e.g. DSC00317",
    "title": "Title of album",
    "description": "Sentence or two about the album. Can include links."
}
```

## Future

* Add full album zip download
* Create script to generate thumbnails on server on first load, for any images found that don't yet have thumbnails (with callback for one-by-one processing)
* Add original download link to swipebox view
* Add size scaling icons for grid display (just 2?)
* Fix URL parsing in descriptions
* Add OG meta data for each album
* Turn off download original button if needed

## Acknowledgements

This project is possible thanks to these wonderful projects:

* [Justified Gallery project](https://github.com/miromannino/Justified-Gallery) - creates the main gallery view
* [Swipebox](http://brutaldesign.github.io/swipebox/) - Touchable jQuery lightbox
* [Mustache](http://mustache.github.io/) - Logic-less templates
* [jQuery](http://jquery.com/) - JS library for Swipebox & Justified Gallery