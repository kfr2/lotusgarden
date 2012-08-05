---
layout: post
title: "Week 4:  Prefixer" 
category: potw
---
This summer, I'd love to acquire an internship (or similar role in other projects) that allows me to work with a team because, although I'm relatively comfortable developing by myself, I feel learning the ability to work with others can help me achieve the next level of development-fu.  Although I don't know *exactly* where I would like to help, I've been looking through various postings on sites like [Hacker News](http://news.ycombinator.com/jobs) to see which postings look promising for a tinkerer like myself.  Although my dream of acquiring a position in one of the awesome companies fostered by YCombinator et al might be a bit lofty, I figure there's no harm in trying!  At the very least, applications for various companies or startups often involve solving a nifty puzzle, so I'm all for that. :)

The [software engineering internship](http://jobs.justin.tv/software-engineer-intern.html) at [justin.tv](http://justin.tv) has a set of interesting problems to tackle as part of its application process.  For this week's project, I decided to figure out how to solve [technical challenge 2](http://www.justin.tv/problems/prefixer), an infix to prefix arithmetic expression converter.  This challenge was particularly exciting to me because I have a secret obsession with scheme (more on that another day) and feel it would be beneficial to convert the masses to the computational love that is prefix notation.  (For the uninformed, prefix notation looks like + 3 2 instead of 3 + 2).

`USAGE:  ./prefixer (-r) INFIX_FILE`

You can download [prefixer on github](https://github.com/kfr2/potw/blob/master/prefixer/prefixer).

Basically, the script (currently written in php) turns the content of INFIX_FILE into an array of characters and processes groups of numbers according to the orders of operation.  (Please -Excuse- My Dear Aunt Sally! ...It's not her fault she's a gambler...)  Furthermore, it reduces the expression as much as possible if the -r flag is used.  My current checking is a bit lazy and won't use the distributive property (when non-numeric characters are multiplied, like 3 * (3 + y)), but I figured I'd save that for prefixer 2.0.

My current solution is written in php, although I may extend my knowledge of ruby or python by rewriting it in one or both of those so-called "better" languages.  (I don't necessarily disagree - I merely find php convenient for hacking together prototypes because I currently know it better than other scripting languages.)  I'm not sure when I'll submit my application to justin.tv,but I imagine it might be in a couple of weeks or so after I tighten up this challenge submission.  It looks like an *amazing* place at which to spend a summer so I want to present myself in as best a light as possible.

Although I wouldn't necessarily mind traveling to the west coast, especially considering it is where many startup/internship positions are located, I also wouldn't mind staying a bit closer to home.  If you know of any interesting positions located more towards the east (or in general!), I would appreciate it if you'd [send me information about them](/about.html).  Thanks!
