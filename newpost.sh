#!/bin/sh
# Thanks to https://github.com/favrik/favrik.com/blob/master/newpost.sh
DRAFTDIR=./_drafts/
FILE=$DRAFTDIR$(date +%F)-$(echo $1 | tr [A-Z] [a-z] | gsed 's/ \|\./-/g').markdown
touch $FILE
echo "---\nlayout: post\ntitle: \"$1\"\ncategories: \nimage_url: \ndescription: \n---\n" > $FILE
vim $FILE
