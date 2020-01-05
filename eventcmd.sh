#!/bin/bash

cd "$(dirname "$0")"
echo "" > log.txt

while read L; do
	k="`echo "$L" | cut -d '=' -f 1`"
	v="`echo "$L" | cut -d '=' -f 2`"
	export "$k=$v"
	echo "$k:$v" >> log.txt
done 

case "$1" in
	songstart)
		coverArt=${coverArt/http:\/\//https:\/\/}
		echo -e "$title<br>\n$artist<br>\n$stationName<br>\n<br>\n<img src=\"$coverArt\" width=\"100%\">" > pb.html

		exec<"pblist.txt"
		echo "<table class=\"list\">" > pblist.html
		i=0
		while read line
		do
			if [ "$line" = "$stationName" ]
			then
				echo "<tr><td class=\"list\">X</td>" >> pblist.html 
			else
				echo "<tr><td class=\"list\">&nbsp;</td>" >> pblist.html
			fi
			echo "<td onclick=\"changeStation($i)\">$line</a></td></tr>" >> pblist.html
			i=$((i+1))
		done
		echo "</table>" >> pblist.html
		;;

	usergetstations)
		cat /dev/null > pblist.txt
		for (( i=0; i<$stationCount; i++ ))
		do
			tmp="station$i"
			echo "${!tmp}" >> pblist.txt
		done
		echo "</table>" >> pblist.html
		;;
	*)
		;;
esac

