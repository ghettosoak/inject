<h5>24.08.12</h5><h1>Deep linking with AJAX</h1><p>deep linking with ajax content</p>

<p>I've been building a site that relies heavily upon ajax calls through jquery's superb .load() function, but as the developer, I've only been using it as I intended it to be used: perhaps not as the end user might like to use it. this problem comes in the form of using the browser's navigation to get about the site, rather than the buttons I've lovingly fashioned at the top. in a perfect world, the user would navigate about the site as I bloody well want them to – but, of course, it's not a perfect world. and, as I am the slightest bit stubborn and have decided to build the buttons with divs instead of list items and anchors, the site does not automatically pass a location to the url. never you fear – a little bit of javascript will come to the rescue – but not without first the slightest bit of frustrating research.</p>

<p>I refer to the throngs of (here) useless javascript deep-linking-in-ajax libraries, such as jquery history, reallysimplehistory, jquery address, and most notably Ben Alman's back button and query library, which he affectionately refers to as BBQ. I have every confidence that all of these are infinitely useful when anchors are employed – but have proven themselves utterly worthless. not to mention Alman's "BARBECUE LOL GET IT?!!?" rhetoric is unfalteringly obnoxious, particularly when I'm just trying to add a pinch of functionality to my damn site.</p>

<p>but I digress. after trying to implement all of the plugins mentioned above without any shred of success, but getting a fairly good handle on the problem that I was attempting to accomplish, I found that, much to occam's delight, the simplest solution is by far the most elegant:</p>

<p>when you press the back button on a normal site, the url changes accordingly, and you are promptly redirected to another site. if you should like to bookmark where you were, the precise location of the site is entered into your browser's history for later retrieval. this is normal. but for a page that uses ajax to get around, pressing the back button (if it's even available to be pressed) simply reloads the page, as the address is nothing more than the default page; and attempting to recall a specific state of the site through the site's root url is obviously an exercise in futility.</p>

<p>to solve this, when every tab is clicked, simply pass HTML5's brand new</p>

<pre><code>window.location.hash = "#pagetitle";
</code></pre>

<p>on every state change initiator to append, quite elegantly, a location for the respective page you wish to link to. this state change convinces your browser that a state has changed: which can then be returned to by adding the listener and then whatever code you use to get to the content in question:</p>

<pre><code>$(window).bind('hashchange', function() {
    if (window.location.hash == "#pagetitle"){
        //do actions to get back to pagetitle
    }
}
</code></pre>

<p>which will promptly enable the full functionality of the browser's back button. to enable deep linking, simply include the if statement in the document.ready():</p>

<pre><code>$(document).ready(function(){
    if (window.location.hash == "#pagetitle"){
        //do actions to get back to pagetitle
    }
});
</code></pre>

<p>and once the page loads with the appropriate hash, your page will point directly to the content you'd like it to. nice!</p>

<p>NB, I have nothing but the utmost respect for Ben Alman. he is unquestionably a giant upon whose shoulders I should like to one day stand.</p>
