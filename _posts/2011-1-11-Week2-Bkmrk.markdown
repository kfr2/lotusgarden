---
layout: post
title: "Week 2:  Bkmrk - Simple Web Bookmarks" 
category: potw
---
For the past several years, I've had an interest in public, taggable bookmarks.  They're incredibly useful because they allow you to easily find a specific document, video, etc you may remember _years_ after seeing the original.  Furthermore, they're also very nice because you can sort your links by intersections of various tags or ideas.  Common combinations of ideas are very interesting because they can provide an insight into your true interests which you may otherwise have never known.  Sites like [del.icio.us](http://del.icio.us) were integral part of my web life for a long time.

Needless to say, I was a bit bothered when rumors started of del.icio.us's inevitable demise.  Although I never used the service totally consistently (especially after Yahoo! bought it), I still really liked the simple interface and wealth of data it offered.  Articles on [Hacker News](http://news.ycombinator.com) discussed alternatives, but none except [Pinboard](http://pinboard.in/) looked particularly appealing.  Upon pondering, I came to the realization the reason I probably did not use del.icio.us as much as I could have was because of the social aspect of the service.  Although it's interesting and neat to see the commonality between interests of different users and track different trends through posted links, I sometimes like keeping interests to myself and stored in personal information managers versus allowing the entire web to access them.

To sate my appetite for a personal (yet web-accessible) bookmarks manager, I wrote [bkmrk](https://github.com/kfr2/bkmrk) over the course of a few days.  It's currently quite rough, but it works well enough for my day to day usage.  

Be warned, however:  it was my full intention for bkmrk to be a personal link manager, so it does not utilize many security precautions.  However, you might find it useful to use as an anonymous link sharing script for either the entire world or a small team of trusted individuals.  It's released under the [MIT Zero License](https://github.com/kfr2/bkmrk/raw/master/LICENSE), so do with it what you will.

Of course, it's still a work in progress.  The code is very ugly and inefficient at points, but such is the life of a work in progress.  It'll be quite interesting to see the state of it in a few months:  I intend to convert it fully to HTML5/CSS3 and eventually utilize jQuery to give it additional functionality.  One day, it may use local storage abilities to allow a user to save posts should he or she ever not have connection to wherever the script is stored.

If you have any suggestions or problems, [let me know](/about.html)!  
