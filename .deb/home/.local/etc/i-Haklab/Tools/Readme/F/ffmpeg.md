In this FFmpeg tutorial, we learn to change the resolution of a video (or
resize/scale a video) using FFmpeg’s commandline tool.

Changing a video’s resolution (also known as resizing or scaling) is a very
common operation in video editing, processing, and compression. This is
particularly true for ABR video streaming where a single video is taken as the
source and compressed to several different bitrate-resolution combinations. For
example, the input video’s resolution could be 1920x1080 and ABR bitstreams
could be 1280x720, 640x480, etc.

So, as the very first step, let’s find out what the input video’s resolution
is. Using the ffprobe tool that’s shipped with the FFmpeg builds, let’s
determine the resolution of an input video. Here’s the command line using
ffprobe. If you don’t have access to ffprobe, you can download it from
OTTVerse’s FFmpeg build page.

    $  ffprobe -v error -select_streams v:0 -show_entries stream=width,height -of csv=s=x:p=0 input.mp4

The output of this command should be something like this 1920x1080 displayed on
your console. That’s great – you now know the video’s resolution and can scale
or change the resolution now.
Note:You must note that the act of up/down scaling is a lossy process and will
result in some loss of video quality.

===============================================================================
Using FFmpeg to scale or change the resolution of a video is done by the scale
filter in FFmpeg. To use the scale filter, use the following command –

    $  ffmpeg -i input.mp4 -vf scale=$w:$h <encoding-parameters> output.mp4

where, $w and $h denote the required width and height of the destination video.
For example, you could use -vf scale=640:480 to resize your video to 480p.
That’s it! With this simple command, you can change the video’s resolution with
FFmpeg.

And, after FFmpeg changes the resolution of the video, it will re-encode it at
that resolution. In the command line above, you can supply encoding parameters
to FFmpeg and encode the scaled video using those parameters. For example, you
could tell FFmpeg to encode it using crf=18 for pretty high-quality H.264/AVC
encoding, or choose something else!

All good? Okay, let’s tackle the next subject which is changing a video’s
resolution but retaining/keepings it’s aspect ratio.

===============================================================================
***** How to Resize Video While Keeping the Quality High with FFmpeg *****

After resizing, you might notice that the quality of the output video is pretty
bad or not what you expected. This can be easily fixed by telling FFmpeg the
video encoding parameters that you would like to use after the resizing
process.
Here is an example –

    $  ffmpeg -i input.mp4 -vf scale=1280:720 -preset slow -crf 18 output.mp4

Here, you are telling FFmpeg to scale the video to 720p and then encode it
using crf=18 with libx264‘s slow preset that usually provides very good quality
due to the number of coding tools that it turns on.

===============================================================================
***** How to Change the Video’s Resolution but Keep the Aspect Ratio? *****

The aspect ratio of an image is very well defined in Wikipedia as follows: The
aspect ratio of an image is the ratio of its width to its height. It is
commonly expressed as two numbers separated by a colon, as in 16:9. For an x:
y aspect ratio, the image is x units wide and y units high.
It is very common to run into this problem while working with videos: How do I
change a video’s resolution (or scaling a video) but keeping or retaining the
video’s original aspect ratio.

In FFmpeg, if you want to scale a video while retaining its aspect ratio, you
need to set either one of the height or width parameter and set the other
parameter to -1. That is if you set the height, then set the width to -1 and
vice-versa.

To demonstrate, assume the following commands take a HD video (1920x1080) as
its input. And, let’s assume that we want to change its resolution. This can be
done in two ways as discussed above, so let’s try both ways.

**** 1. Specify the Width To Retain the Aspect Ratio ****

    $  ffmpeg -i input.mp4 -vf scale=320:-1 output.mp4

The resulting video will have a resolution of 320x180. This is because 1920 /
320 = 6. Thus, the height is scaled to 1080 / 6 = 180 pixels.


**** 2. Specify the Height To Retain the Aspect Ratio ****

    $  ffmpeg -i input.mp4 -vf scale=-1:720 output.mp4

The resulting video will have a resolution of 1280x720. This is because 1080 /
720 = 1.5. Thus, the width is scaled to 1920 / 1.5 = 1280 pixels.

===============================================================================
***** Use Variables to Scale/Change Resolution of a Video in FFmpeg *****

We can implement the same scaling commands using variables that denote the
video parameters. The input video’s width and height are denoted by iw and ih
respectively.

Let’s see what a command to scale the video’s width two times (2x) looks like.

    $  ffmpeg -i input.mp4 -vf scale=iw*2:ih output.mp4

If you want to divide either the height or width by a number, the syntax
changes a little as the scale=iw/2:ih/2 argument need to be enclosed within
double quotes.

    $  ffmpeg -i input.mp4 -vf "scale=iw/2:ih/2" output.mp4  

===============================================================================
***** Avoid Upscaling a Video based on the Input Video’s Dimensions *****

As we mentioned right at the start of the article, every up/down scaling action
will usually not produce the same level of video quality as the input video.
There is bound to be a few compression losses during the scaling process. If
the input resolution is too low, FFmpeg offers a neat trick to prevent
upscaling.

    $  ffmpeg -i input.mp4 -vf "scale='min(320,iw)':'min(240,ih)'" output.mp4

In the command line above, the minimum width/height to perform scaling is set
to 320 and 240 pixels respectively. This is a very simple way to guard against
poor quality scaling.

