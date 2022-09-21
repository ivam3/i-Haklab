function codec
	if test "$argv[1]" = "r"
    ffprobe -v error -select_streams v:0 -show_entries stream=width,height -of csv=s=x:p=0 "$argv[2]"
  else if test "$argv[1]" = "c"
    ffmpeg -i "$argv[1]" -vf scale=1920:816 -preset slow -crf 18 "$argv[1]_1920x816.mp4"
  else
    echo "USAGE: codec [r = verify video resolution]<|>[c = codec video at 1920x816]"
	end
end
