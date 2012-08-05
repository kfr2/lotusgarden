---
layout: post
title: "Notational Notes"
categories: 
---
One of the tools I've been finding incredibly invaluable over the past few months is [nvALT](http://brettterpstra.com/project/nvalt/), a fork of the wonderful [Notational Velocity](http://notational.net).  This tool allows one to compose notes incredibly rapidly while providing a wonderful search tool to later find any note very easily.  Similarly, I've recently integrated [marked](http://markedapp.com/), a Markdown preview app, into this workflow to great success.  Overall, I am very pleased!  Nonetheless, as others have written about the merits of these applications, I will not go into any further detail as to why they are tools everyone should integrate into their workflows.

Recently, I was inspired by [Steven Frank's notes](http://stevenf.com/notes/) to figure out a way to easily convert my nvALT notes into some type of similar format for both myself and others.  Finding time this afternoon, I tinkered with Ruby and wrote [notational notes](https://github.com/kfr2/notational-notes), a simple script for converting text notes with Markdown syntax into a directory of HTML files.  Similarly, this directory contains an index.htm file that links to all the note files in this directory.

If interested, view my [notes](http://dl.dropbox.com/u/7030113/notes/index.htm).  Further improvements to output styling, etc are forth-coming!
