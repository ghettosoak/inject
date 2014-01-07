<div><h5>16.10.12</h5><h1>Fun with fixed position elements</h1></div><p><a href="http://jqueryfordesigners.com/fixed-floating-elements/" target="_blank" class="external">http://jqueryfordesigners.com/fixed-floating-elements/</a></p>

<p>I'm developing a site at the moment that, due a touch of oversight by the designer (not me), is without a proper navigation during the vast majority of the experience of the single page layout: suggesting instead that the user traverse the entire length of the site when in fact, he may only need to jump between points. after a bit of discussion with a friend at my agency, we decided that the best way to go about this is to have the navigation follow the user wherever he goes, so that the aforementioned jumping around suddenly becomes super simple. thanks to Ariel Felser's wondrous jquery scroll to plugin(http://flesler.blogspot.ch/2007/10/jqueryscrollto.html), we can move about the single page in a sexy, fluid manner best befitting the sites namesake of 'flow productions'; and more importantly, return a hard scrollTop number that we can manipulate. this, of course, isn't the first time something like this has been executed, as noted in the above linked article: apple has employed this with their shopping cart on their site. however, an important note that said article fails to mention is elegance in code. just in spitting out the scrollTop numbers to the console, I can see that executing something every time the user scrolls the page gets very expensive very quickly, especially if there are other things going on deeper in the background. the tutorial gets it right by recommending that the fixed attribute be added by way of adding a predefined CSS class instead of programmatically through jquery's .css(); but it's doing so every time the page is moved past a certain point:</p>

<pre><code>$(document).ready(function () {  
  var top = $('#comment').offset().top - parseFloat($('#comment').css('marginTop').replace(/auto/, 0));
  $(window).scroll(function (event) {
    // what the y position of the scroll is
    var y = $(this).scrollTop();

    // whether that's below the form
    if (y &gt;= top) {
      // if so, ad the fixed class
      $('#comment').addClass('fixed');
    } else {
      // otherwise remove it
      $('#comment').removeClass('fixed');
    }
  });
});
</code></pre>

<p>therefore, I suggest adding a quick, cheap boolean to make sure the code is instantiated only once, thus leaving precious memory to be delegated elsewhere:</p>

<pre><code>var $windowpane = $(window);
var $top = $('.top');
var $left = $('.left');
var dft;
var toptagged = lefttagged = false;

$windowpane.scroll(function(){
    dft = $windowpane.scrollTop();
    if (dft &gt;= 35 &amp;&amp; !toptagged){
        toptagged = !(toptagged);
        $top.addClass('topfixed');
    }
    if (dft &lt; 35 &amp;&amp; toptagged){
        toptagged = !(toptagged);
        $top.removeClass('topfixed');
    }

    if (dft &gt;= 356 &amp;&amp; !lefttagged){
        lefttagged = !(lefttagged);
        $left.addClass('leftfixed');
    }
    if (dft &lt; 356 &amp;&amp; lefttagged){
        lefttagged = !(lefttagged);
        $left.removeClass('leftfixed');
    }
});
</code></pre>

<p>remember to set your oft-queried elements into a variable to keep things even lighter, and you've got a solution that is so smooth, it's scary.</p>
