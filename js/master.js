(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());

//jquery v1.8.0 is included in this mess. Copyright 2012 jQuery Foundation and other contributors.
//like something you see, but can't read this unholy mess? drop me a line at (mif)[at](awe)[minus](schaffhausen)[dot](com)

var $windowpane = $(window);
var wpheight, wpwidth;
var $master;
var $left, $right;
var $syringe, $name;
var $title, titleheight = 0, titlequick, titlelarge;
var $content;
var reading = false, editing = false, hasbeenedited = false, newpost = false;
var lastpostis, titlequicker = false;
var $trial;
var $theSwitcher;
var trialcount = 0;
// var available = [] // STOP! DEFINED THROUGH PHP @ INDEX!
var thePosts = {};
var lookingat;
var mobileis = false;

$(document).ready(function(){
	wpheight = $windowpane.height();
	wpwidth = $windowpane.width();

	$master = $('#master');
	
	$left = $('#left');
	$right = $('#right');

	$title = $('#title');
	$syringe = $('#syringe');
	$name = $('#name');

	$trial = $('#trial');

	$content = $right.find('.content');

	$theSwitcher = $('#switch');

	if (!window.location.hash){
		reading = false;
		$master.addClass('start');
	}else{
		reading = true;
		$master.addClass('read');
	}

	console.log(document.cookie);

	if (document.cookie === 'blackwhite'){
		$master.removeClass('whiteblack')
		.addClass('blackwhite');
	}else{
		document.cookie = 'whiteblack';
	}
});

$windowpane.load(function(){
	if (reading){
		lookingat = parseInt(window.location.hash.split('!')[1]);
		if ((available.indexOf(lookingat) == -1) && (lookingat != 0)) lookingat = 'false';
		reading = true;
		$master.removeClass('wait start').addClass('go read');
		postload(lookingat);
		trialbind();
	}

	navload();

	if (wpwidth <= 480) mobileis = true;
});

$windowpane.hashchange(function(){
	lookingat = parseInt(window.location.hash.split('!')[1]);

	if ((available.indexOf(lookingat) == -1) && (lookingat != '0')) lookingat = 'false';

	if (!editing){
		if (window.location.hash) postload(lookingat);
		else postload(lastpostis);
	}else editload(lookingat);
});

function navload(){
	$.ajax({
		url:'php/nav.php'
	}).done(function(theNav){
		console.log(theNav);
		thePosts = theNav;
		$.each(theNav.posts, function(key, val){
			$title.prepend(
				'<div data-post="'+val.id+'">'+
					'<span>'+val.date+'</span>'+
					'<h2>'+val.title+'</h2>'+
				'</div>'
			);

			if ((key) == theNav.postcount-1){
				if (mobileis) mobileEnsure();
				else{
					$title.find('div').each(function(){
						titleheight += $(this).height();
					});
				}

				if (!reading) start_titleensure();
				else postpointer();
			}
		});
		lastpostis = parseInt(theNav.lastpost);
	});

	$syringe.on('click', function(){
		if (reading) window.location.hash = '!0';
	});

	$theSwitcher.find('.target').on('click', function(){
		if ($master.hasClass('whiteblack')){
			$master.removeClass('whiteblack').addClass('blackwhite');
			document.cookie = 'blackwhite';
		}else if ($master.hasClass('blackwhite')){
			$master.removeClass('blackwhite').addClass('whiteblack');
			document.cookie = 'whiteblack';
		}
		console.log(document.cookie);
		console.log('yeah!');
	})
}

function start_titleensure(){
	$master.removeClass('wait').addClass('go');

	$syringe.on('click', function(){
		if (!reading){
			$left.toggleClass('open');
			if ($left.hasClass('open')){
				if (mobileis){
					$title.css('height', titleheight);
					$right.css({ 'top' : titleheight+189 });
					$name.css({ 'top' : (titleheight+189) + (wpheight/4) });
					$theSwitcher.css({ 'top' : (titleheight+189) });
				}
			}else{
				if (!mobileis) $title.css({ 'height' : 0 });
				else{
					$title.css('height', 0);
					$right.css({ 'top' : '50%' });
					$name.css({ 'top' : '150%' });
					$theSwitcher.css({ 'top' : '50%' });
				}
			}
		}
	});

	$name.on('click', function(){
		if (!reading) window.location.hash = '!'+lastpostis;
	});

	postpointer();
	trialbind();
}

function mobileEnsure(){
	titleheight = $title.find('div').size() * 42;

	$title.on('click', function(){
		var $that = $(this);
		$that.toggleClass('open')
		if ($that.hasClass('open')){
			$left.css('height', titleheight+300);
			$right.css('top', titleheight+300);
			$theSwitcher.css({ 'top' : (titleheight+300) });
			console.log(titleheight)
		}else{
			$title.css('height', 0)
			$left.css('height', 300);
			$right.css('top', 300);
			$theSwitcher.css({ 'top' : 300 });
		}
	});

	$title.on('click', 'div', function(e){
		e.stopPropagation();

	})
}

function postpointer(){
	newpost = false;
	$title.on('click', 'div', function(){
		window.location.hash = '!'+$(this).data('post');
	});
}

function postload(er){
	if (!reading){
		$master.removeClass('start').addClass('read');
		reading = true;
	}

	$content.removeClass('ready');
	
	$content.find('*').not('#titleedit, #postedit').remove();
	$.ajax({
		url:'store/html/'+er+'.php',
		cache:false,
		type:'get'
	}).done(function(post){
		setTimeout(function(){
			$content.addClass('ready')
			.append(post);

			if (lookingat !== 0) window.document.title = 'in / ject // ' + thePosts.posts[(lookingat-1)].title;
			else window.document.title = 'in / ject';

			if (mobileis){
				$name.css('top', 100);
				$left.css('height', 300);
				$right.css('top', 300);
				$theSwitcher.css({ 'top' : 300 });
				$title.removeClass('open');
			}
		},500);
	});
}

function trialbind(){
	$name.on('dblclick', 'h1', function(){
		if (lookingat !== 'false'){
			if (reading){
				$master.addClass('editing');
				$trial.focus();
				$('#titleedit').css({ 'width' : $('.control').width() - 341 });
			}
			if (hasbeenedited) editload();
		}else alert("Whoa. \n\nYou're navigating into strange waters, good sir -- far stranger than you're prepared to handle. \n\nI'll tell you what's gonna happen here. You're gonna navigate yourself to a page that actually has content on it, and try this again.\n\nWe'll pretend this never happened.");
	});

	$trial.on({
		keydown:function(e){
			if (e.keyCode == 13){
				if (!hasbeenedited) linkup($(this).val());
				else editing = true;
			}
		},
		blur:function(){
			if (!editing) $master.removeClass('editing');
		}
	});
}

function linkup(tehcode){
	var coded = CryptoJS.SHA512(tehcode).toString();

	$.ajax({
		type: "POST",
		data:{pass:coded},
		url: "php/link.php",
	}).done(function(edit){
		trialcount++;
		if (edit.length > 30){
			$right.find('.edit').append(edit);
		}else{
			if (trialcount < 5) $trial.val('NOPE').get(0).type = 'text';
			else $trial.val('OK SERIOUSLY WHAT THE FUCK').get(0).type = 'text';
			setTimeout(function(){
				$trial.val('').get(0).type = 'password';
			},1500);
		}
	});
}




















