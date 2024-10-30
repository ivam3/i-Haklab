function codec
	if test "$argv[1]" = "r"
    ffprobe -v error -select_streams v:0 -show_entries stream=width,height -of csv=s=x:p=0 "$argv[2]"
  else if test "$argv[1]" = "c"
    ffmpeg -i "$argv[2]" -vf scale=1920:1080 -preset slow -crf 18 "$argv[2]_1920x1080.mp4"
  else
    echo "USAGE: codec [r = verify video resolution]<|>[c = codec video at 1920x1080]"
	end
end
