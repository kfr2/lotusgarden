---
layout: post
title: "Week 6: Imgur 'Mass' Uploader"
categories: potw
---
This week, I was highly interested in getting on the ball for my project from a few weeks ago, [EasyAww](/potw/2011/01/21/Week3-EasyAww.html).  Although I've been planning how to store a large number of cute images and their corresponding information, I have not had a lot of time to experiment with how to upload them en masse to [Imgur](http://imgur.com), the image host I've decided to go with for this project.  Having some spare time this morning and afternoon, I finally think I've reached a solution that will work for the time being.

Fortunately, Imgur has a fantastic [api](http://api.imgur.com) that is free to use for small, personal projects.  I didn't feel like messing with the OAuth-based authenticated api, so I opted instead to get a developer key for the anonymous version of the api.  Because I'm not particularly concerned with keeping the images I upload in a central album, anonymous usage will work just fine.  The only real limitation is the 50 images/hour upload maximum, but it won't be too difficult to get around this by running the upload script I'll shortly introduce on a cron job every couple of hours.  (Even then, I don't have a TON of images at the moment, so it'll only take a couple of hours to put them all onto imgur.)

Basically, the script I wanted to create needed to do two things:
1. Upload specified images to Imgur.
2. Save the resulting image hash and deletehash into a database for later use.

At the beginning of my quest, I wanted to write a Ruby script to do the uploading for me because it seemed like the necessary tools would be readily available.  Although it seemed like everything was working well, I eventually ran into large issues with Net::HTTP and Curb as decided to go a different route.

Fortunately, the api provides great [examples](http://api.imgur.com/examples#uploading_curl) and even complete [uploading tools](http://imgur.com/tools/) and I found a [bash script uploader](http://imgur.com/tools/imgurbash.sh) by [Bart Nagel](http://bartnagel.co.uk/) that works very well for my purposes.  I changed a few things but didn't do any major alterations:
1. Updated the script to use version 2 of the api.
2. Searched for image hash and deletehash instead of the link to the original image and delete page (since all the other necessary URIs can be generated form the image hash).
3. Instead of outputting to stdout and stderr, opted to output a sql insert statement that will be combined with another small script to add information to a sqlite database.

My version of the script is [available on GitHub](https://github.com/kfr2/potw/blob/master/imgurbash.sh).

Usage is pretty easy.  Modify the apikey variable towards the top of the file to reflect your own developer key.  After that, merely invoke the script:

`./imgurbash.sh file-to-upload`

My intention is to write a wrapper script in Ruby around this shell script that will manage the 50 uploads/hour limit, insert the resulting image information into the database, etc.  It shouldn't be too hard to achieve on your own, but feel free to [contact me](/about.htm) if you need help.

Until next time, Space Cowboy.
