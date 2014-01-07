<div><h5>19.10.12</h5><h1>Pretty little user agent</h1></div><p>many people who are far smarter than I have paved the way for proper mobile development, but I've come across a tiny, almost minuscule caveat that definitely needs to be paid attention to when sniffing for mobile browsers. I've always liked this:</p>

<pre><code>if (navigator.userAgent.match(/iPad/i)){
    do stuff here
}
</code></pre>

<p>and of course, you can add other user agents to the string with the or logical operator</p>

<pre><code>if (navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/iPhone/i)){
    do stuff here
}
</code></pre>

<p>but sweet baby jesus, that's ugly. you mean to tell me that, every time I want to execute something special for my mobile users, I've got to write this whole damn thing out? christ. here's another idea:</p>

<pre><code>var mobilepliers = false;

$(document).ready(function(){
    if (navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/iPhone/i)) mobilepliers = true;
});
</code></pre>

<p>hi, cousin Sterling! remember when you referred to your unborn sister as drillbit? that still gets me every time, even fifteen(?) years later, and that strange humor has permeated to my coding practices, resulting in all things strange when it comes to variable names. :) anyways, by assigning a simple boolean to our lovely user agent sniffer, we can make our code just the slightest bit nicer to look at. done, and done.</p>

<p>but it's not that simple, unfortunately. normally, when I'd use my sniffer, i'd place it as close to global as I can, wrapping the sniffer around entire blocks of code. do this with our boolean however, and you'll quickly find that your mobile-only code is no longer working, even if you've spoofed the user agent in your browser. why is this, you may be asking? well, it's all a matter of timing: when we set our boolean to true on document.ready, we're running that code a hair of a second after the rest of the javascript document is done compiling. it worked when it was ugly, because the user agent was already set when the browser got around to loading the javascript document, so whenever javascript asked the browser what its user agent was, the browser always had an answer for it. but, because we're relegating this to our boolean now, and because it's just a boolean, document.ready isn't going to happen until after everything (as in, javascript, too) is loaded, and thus, the boolean is going to remain false until it's too late. go ahead, check it out in your console: you'll see that it's true, but your code won't work all the same. the solution to this? check against your boolean programmatically, on click and hover events and in functions instantiated after document.ready. like this!</p>

<pre><code>$(".something").click(function(){
    if (mobilepliers) dosomething();
});
</code></pre>

<p>now, we'll get the result we're looking for, because the event is being raised well after the boolean has been properly set. it's kind of a shift in thinking, but it does mean nicer, more linear code in the long run, and we're treating the document.ready like the bootstrap that it ought to be!</p>
