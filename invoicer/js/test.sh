#!/bin/bash
cd /var/www/dskmn/invoicer/invoicer/css
find -type d | while read directory
do
  echo "processing: ${directory#"./"}"
  cd "/var/www/dskmn/invoicer/invoicer/css/${directory#"./"}"
	for FILE in `ls *.js`
		do
		  java -jar ~/yuicompressor/yuicompressor-2.4.8.jar --type css -o "mini_$FILE" "$FILE"
		  mv "mini_$FILE" "$FILE"
		done
done
