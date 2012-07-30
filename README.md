## What is WordPress TimeStack?

It's a tool for profiling WordPress development by time/mysql queries/memory usage. It supports multilevel operation based tracking of such metrics.

## Why use this over Xdebug (or something similar)?

TimeStack is made for WordPress specifically, this means auto hooking in to measure instances of `WP_Query`, `WP_HTTP`, `plugins_loaded` etc. It's not as advanced as a real PHP profiler, but it's "native" for WordPress.

## Why use this over the Debug Bar Profileing tab?

There are two main reasons this is better (objectivly of course ;) ) than the Profiling tab.

1. It is a seperate web app which means you get to see _all_ requests, not just pages you can access the Admin Bar (requests that cause redirects etc.).
2. TimeStack is multilevel, you have operations and events within other events. The Debug Bar gives you a single level rundown, TimeStack let's you drill down through operations.

## Screen Shots

![](https://dl.dropbox.com/u/238502/Captured/tuUpR.png)

![](https://dl.dropbox.com/u/238502/Captured/X4JMp.png)

![](https://dl.dropbox.com/u/238502/Captured/2VR8Y.png)

I also created a demo screencast with my awful voice (apologies) :) https://vimeo.com/46631839