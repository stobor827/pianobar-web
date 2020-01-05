#!/bin/bash

# create variables
#i=0
#declare -a table
echo "" > /var/www/html/pianobar/log.txt

while read L; do
	k="`echo "$L" | cut -d '=' -f 1`"
	v="`echo "$L" | cut -d '=' -f 2`"
	export "$k=$v"
	echo "$k:$v" >> /var/www/html/pianobar/log.txt
	#echo "$k=$v"
#	table[$i]=$k
#	i=$((i+1))
done 
#< < (grep -e '^\(title\|artist\|album\|stationName\|songStationName\|pRet\|pRetStr\|wRet\|wRetStr\|songDuration\|songPlayed\|rating\|coverArt\|stationCount\|station[0-9]*\)=' /dev/stdin) # don't overwrite $1...

case "$1" in
	songstart)
#		echo 'naughty.notify({title = "pianobar", text = "Now playing: ' "$title" ' by ' "$artist" '"})' | awesome-client -
#		echo "$title -- $artist \n $coverArt \n $audioUrl " > $HOME/.config/pianobar/nowplaying
		coverArt=${coverArt/http:\/\//https:\/\/}
		echo -e "$title<br>\n$artist<br>\n$stationName<br>\n<br>\n<img src=\"$coverArt\" width=\"100%\">" > /var/www/html/pianobar/pb.html

		exec<"/var/www/html/pianobar/pblist.txt"
		echo "<table class=\"list\">" > /var/www/html/pianobar/pblist.html
		i=0
		while read line
		do
			if [ "$line" = "$stationName" ]
			then
				echo "<tr><td class=\"list\">X</td><td onclick=\"window.location='pianobar.php?action=changeStation&station=$i'\">$line</a></td></tr>" >> /var/www/html/pianobar/pblist.html
			else
				echo "<tr><td class=\"list\">&nbsp;</td><td onclick=\"window.location='pianobar.php?action=changeStation&station=$i'\">$line</a></td></tr>" >> /var/www/html/pianobar/pblist.html
			fi
			i=$((i+1))
		done
		echo "</table>" >> /var/www/html/pianobar/pblist.html

#		if [ "$rating" -eq 1 ]
#		then
#			kdialog --title pianobar --passivepopup "'$title' by '$artist' on '$album' - LOVED" 10
#		else
#			kdialog --title pianobar --passivepopup "'$title' by '$artist' on '$album'" 10
#		fi
#		# show an OS X notification
#		osascript -e "display notification \"$album\" with title \"$title\" subtitle \"$artist\""
#		# or whatever you like...
		;;

	usergetstations)
		#count = $stationCount	
		cat /dev/null > /var/www/html/pianobar/pblist.txt
		for (( i=0; i<$stationCount; i++ ))
		do
		#echo $name
		tmp="station$i"
		#echo "<tr><td>&nbsp;X&nbsp;</td><td>${!tmp}</td></tr>" >> /var/www/pblist.html
		echo "${!tmp}" >> /var/www/html/pianobar/pblist.txt
		# other stuff on $name
		done
		echo "</table>" >> /var/www/html/pianobar/pblist.html
		
		#echo "$L" > /var/www/pblist.txt
	
	
		;;




#	songfinish)
#		# scrobble if 75% of song have been played, but only if the song hasn't
#		# been banned
#		if [ -n "$songDuration" ] && [ "$songDuration" -ne 0 ] &&
#				[ $(echo "scale=4; ($songPlayed/$songDuration*100)>50" | bc) -eq 1 ] &&
#				[ "$rating" -ne 2 ]; then
#			# scrobbler-helper is part of the Audio::Scrobble package at cpan
#			# "pia" is the last.fm client identifier of "pianobar", don't use
#			# it for anything else, please
#			scrobbler-helper -P pia -V 1.0 "$title" "$artist" "$album" "" "" "" "$((songDuration/1000))" &
#		fi
#		;;

#	songlove)
#		kdialog --title pianobar --passivepopup "LOVING '$title' by '$artist' on '$album' on station '$stationName'" 10
#		;;

#	songshelf)
#		kdialog --title pianobar --passivepopup "SHELVING '$title' by '$artist' on '$album' on station '$stationName'" 10
#		;;

#	songban)
#		kdialog --title pianobar --passivepopup "BANNING '$title' by '$artist' on '$album' on station '$stationName'" 10
#		;;

#	songbookmark)
#		kdialog --title pianobar --passivepopup "BOOKMARKING '$title' by '$artist' on '$album'" 10
#		;;

#	artistbookmark)
#		kdialog --title pianobar --passivepopup "BOOKMARKING '$artist'" 10
#		;;

	*)
#		if [ "$pRet" -ne 1 ]; then
#			echo "naughty.notify({title = \"pianobar\", text = \"$1 failed: $pRetStr\"})" | awesome-client -
##			kdialog --title pianobar --passivepopup "$1 failed: $pRetStr"
#		elif [ "$wRet" -ne 1 ]; then
#			echo "naughty.notify({title = \"pianobar\", text = \"$1 failed: Network error: $wRetStr\"})" | awesome-client -
##			kdialog --title pianobar --passivepopup "$1 failed: Network error: $wRetStr"
#		fi
		;;
esac

