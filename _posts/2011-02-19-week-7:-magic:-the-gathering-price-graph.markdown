---
layout: post
title: "Week 7:  Magic: the Gathering Price Graph"
categories: potw
---
This week, I have decided to write a small script that uses the Magic price information I've been scraping from the [Magic Online Traders League](http://www.magictraders.com/) for the past few months.  Furthermore, experiments with jQuery were in order.  

On my playground site, you'll find a very rough outline of that which will eventually become Magically.US, an easy way to maintain your MTG inventory and track its change in value over time.  Right now, not much exists besides random thoughts and this week's project, a [Magic card price search](http://playground.triageworks.net/magic/search.htm) and graphing tool.  Simply enter the card whose information you'd like to see, select the appropriate name in the autocomplete section that will appear, and click display data.  In a second or so, a canvas-based graph will be generated thanks to the amazing [bluff javascript graph generator](http://bluff.jcoglan.com/).  jQuery is used to load a table in the background (which is currently hidden with the style display:none) and bluff uses this information to generate the graph on the page.  Furthermore, you can change the graph's theme and convert the canvas graph to a png thanks to [canvas2image](http://www.nihilogic.dk/labs/canvas2image/).

It's still very rough around the edges, but I was very pleased with how the pieces all seemed to fit together.  In the future, web applications seem to be the way most information will be processed and I hope to be a part of that in one form or another!  I'm not sure exactly what I intend to complete during this upcoming week, but you'll see soon enough.  Until then, take care.
