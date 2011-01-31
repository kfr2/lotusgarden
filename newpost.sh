#!/bin/sh
# Thanks to https://github.com/favrik/favrik.com/blob/master/newpost.sh
DRAFTDIR=./_drafts/
FILE=$DRAFTDIR$(date +%F)-$(echo $1 | tr [A-Z] [a-z] | sed 's/ \|\./-/g').markdown
touch $FILE
echo -e "---\nlayout: post\ntitle: \"$1\"\ncategories: \n---\n" > $FILE
vim $FILE
