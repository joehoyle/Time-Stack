Warning, Alpha version!!

## What is WordPress TimeStack?

It's a tool for profiling WordPress development by time/mysql queries/memory usage. It supports multilevel operation based tracking of such metrics.

## Why use this over Xdebug (or something similar)?

TimeStack is made for WordPress specifically, this means auto hooking in to measure instances of `WP_Query`, `WP_HTTP`, `plugins_loaded` etc. It's not as advanced as a real PHP profiler, but it's "native" for WordPress.

## Why use this over the Debug Bar Profiling tab?

There are two main reasons this is better (objectively of course ;) ) than the Profiling tab.

1. It is a separate web app which means you get to see _all_ requests, not just pages you can access the Admin Bar (requests that cause redirects etc.).
2. TimeStack is multilevel, you have operations and events within other events. The Debug Bar gives you a single level rundown, TimeStack let's you drill down through operations.

## Screen Shots

![](https://dl.dropbox.com/u/238502/Captured/tuUpR.png)

![](https://dl.dropbox.com/u/238502/Captured/X4JMp.png)

![](https://dl.dropbox.com/u/238502/Captured/2VR8Y.png)

I also created a demo screencast with my awful voice (apologies) :) https://vimeo.com/46631839

## How do I get this to work?

You need to install the TimeStack Plugin (https://github.com/joehoyle/Time-Stack-Plugin) plugin on your WordPress site, and be running a persistant object cache. If you don't know what that is, TimeStack may not be the tool for you ;) Kidding, but I don;t have time to write all those instructions yet.

## How do I track operations in my code?

This is probably the most important part. TimeStack is really for you own custom code, not 3rd party code. TimeStack has 2 tracking metrics: `operations` and `events`. An operation encapsulates code, an event just sets a time stamp for that point in the code. In the above screenshots `wp_head` and `template_redirect` are events. We use actions so they can potentially be left in the code when not running the TimeStack Plugin.

To track an operation:

```PHP
do_action( 'start_operation', 'Call Twitter' );

$twitter_api->get_results( 's=foo' );

do_action( 'end_operation', 'Call Twitter' );
```

Operations are multilevel so tracking `operations` within other `operations` is fine.

To track an event:

```PHP 
do_action( 'add_event', 'Below Footer' );
```
