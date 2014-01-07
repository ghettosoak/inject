<div><h5>24.08.12</h5><h1>Achieving motion blur in the browser</h1></div><p>I like rulers. always have. damn handy things, they are – especially for those of us who work primarily on the web. of course, the age old joke of 'take a screen shot of the spider chasing your mouse cursor' is immediately conjured up – who, then, would possibly need a ruler on a screen? I know. I get it. but have you ever tried to count 476 pixels? after about three, you want to punch someone.</p>

<p>for this deceptively simple task, I've always turned to Free Ruler. it's free, and it does the job remarkably well: dimensions, movability, scalability. however, it does not support lion. too bad, so sad. so after a little digging around, I've found an adobe AIR app called 'Pixus' which does just about everything Free Ruler does, and perhaps a little better now that it has a lower bounding box (be honest: how awesome would it be if rulers in real life were square instead of linear? think about it). it may very well be the first adobe AIR app that I don't hate, and it's now a proud member of my toolbox. however, there's one feature that got me thinking a little further.</p>

<p>the options menu. yes, I'm the guy who always checks the options menu first before diving into a video game. it's lame, I know. I like knowing what I'm up against logistically. so sue me. as for the options menu in Pixus however, the author has included a lovely motion blur when changing between categories. completely unnecessary, but a nice treat on my robust machine, and definitely something that I'd like to incorporate in the things I do on the web. but how?</p>

<p>of course, there's a few options (ha ha) already out there, most notably Marcell Jusztin's Floating boxes. and it should be noted that Mr. Jusztin is enormously talented, and will undoubtedly find his way on my highly esteemed 'people I think are awesome' list. but not here. his is responsive to the mouse and the mouse only – still, nothing short of incredible! – but not what I want. the motion blur here should take place all at once, perhaps on several objects as a part of navigation. so all in all, a little bit less complex than his solution. ; ) after carefully examining Pixus's motion blur, I noticed that it blurs the content first, then rushes it away to replace it with other rushing content, which is thereby un-blurred. simple, right?</p>

<p>fortunately, some good people have already paved the way for animatable blurring. Edwin Martin (http://www.bitstorm.org/jquery/shadow-animation/) has the animation of CSS3's box shadow all locked up, and Alex Peattie (http://www.alexpeattie.com/projects/animate-textshadow/) has animated the text-shadow CSS3 property. both are incredulously lovely. as Mr. Peattie has demonstrated, when the color of the text is set to transparent and the blur of the text shadow is set to zero, the shadow effectively becomes the text (this important, we'll see why momentarily).</p>

<pre><code>    text-shadow: #aaa 0 0 0;
    color:transparent;
</code></pre>

<p>his code fits right into the jQuery syntax, so the quick animation can be set as a callback after quickly executing the blur. and of course, the blur can be quickly un-blurred as a callback. the whole thing is as simple as this:</p>

<pre><code>    $(".test").click(function(){
        $(".test p").animate({textShadow: "#aaa 0 0 5px"}, 80, function(){
            $(".test").animate({left:-300}, 200, function(){
                $(".test p").animate({textShadow: "#aaa 0 0 0"}, 80);
            });
        }); 
    });
</code></pre>

<p>and voila, you have motion blur! the text shadow and text color is a bit backwards, but if you try to fade the color to rgba(0,0,0,0) or something like that via Edwin Martin's color animate (http://www.bitstorm.org/jquery/color-animation/) (yes, he rules that hard), it'll slow things down terribly, and ruin your effect. for things that aren't text, include Mr. Martin's box shadow, and your site will be whipping around with abandon in no time at all.</p>
