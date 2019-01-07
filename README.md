# 🖼️ plonk

> Basic SQL-less image gallery display
> 
> See it here: https://photos.67hours.co.uk/demo/

## Design requirements

1. Provide a simple, Flickr style image wall for display of photos
2. Easy to configure - upload photos to a folder on server and display should work
3. Allow download of original images for any in the set
4. Allow simple customisation of display (e.g. choose a header image)


## How to use

> See folder `demo-src` for an example of how to set up the folders

This projects requires a server running PHP7 or later (or probably earlier too).

1. [Download this repo here](https://github.com/gcsalzburg/plonk/archive/master.zip) and upload it into a folder on your server
2. Create a folder called `folder-name-src` in root directory with this readme.
2. Add a file called `meta.json` to this folder with the following data as a minimum:

```json
{
    "header": "Basename (without suffix) of the file to use as header image, e.g. DSC00317",
    "title": "Title of album",
    "description": "Sentence or two about the album. Can include links."
}
```

3. Add files to the album with suffixes as follows:

| _ | How to generate | Example |
| --- | --- | -- |
| t | 100 pixel max on widest side | DSC03317_t.jpg |
| n | 320 pixel max on widest side | DSC03317_n.jpg |
| c | 800 pixel max on widest side | DSC03317_c.jpg |
| h | 1600 pixel max on widest side | DSC03317_h.jpg |
| k | 2048 pixel max on widest side | DSC03317_k.jpg |
| o | Original source image | DSC03317_o.jpg |

4. The gallery will be available at the url `[root folder]/folder-name`

## Future

* Add full album zip download
* Add front page with list of all albums
* Create script to generate thumbnails on server (with callback for one-by-one processing)

## Acknowledgements

Makes good use of the Justified Gallery project: https://github.com/miromannino/Justified-Gallery