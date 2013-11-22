(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());

//jquery v1.8.0 is included in this mess. Copyright 2012 jQuery Foundation and other contributors.
//like something you see, but can't read this unholy mess? drop me a line at (mif)[at](awe)[minus](schaffhausen)[dot](com)

var $windowpane = $(window)
var wpheight, wpwidth
var $master;
var $left, $right;
var $syringe, $name
var $title, titleheight, titlequick, titlelarge;
var $content
var reading = false, editing = false, hasbeenedited = false, newpost = false;
var lastpostis, titlequicker = false;
var $trial;
var trialcount = 0;
// var available = [] // STOP! DEFINED THROUGH PHP @ INDEX!
var lookingat;
var r_syringe;
var svg_attr_white = {'fill':'#fff', 'stroke':'none'}

$(document).ready(function(){
	svg_activate();
	wpheight = $windowpane.height()
	wpwidth = $windowpane.width()

	$master = $('#master')
	
	$left = $('#left')
	$right = $('#right')

	$title = $('#title')
	$syringe = $('#syringe')
	$name = $('#name')

	$trial = $('#trial')

	$content = $right.find('.content')

	if (!window.location.hash){
		reading = false
		$master.addClass('start')
	}else{
		reading = true;
		$master.addClass('read')
	}	
})

$windowpane.load(function(){
	navload()
	if (reading){
		lookingat = parseInt(window.location.hash.split('!')[1]);
		console.log(available)
		console.log(available.indexOf(lookingat))
		console.log(lookingat)
		if ((available.indexOf(lookingat) == -1) && (lookingat != 0)) lookingat = 'false';
		reading = true;
		$master.removeClass('wait start').addClass('go read')
		postload(lookingat)
		trialbind()
	}
	$content.enscroll();
	$title.enscroll();
})

$windowpane.hashchange(function(){
	lookingat = parseInt(window.location.hash.split('!')[1]);

	if ((available.indexOf(lookingat) == -1) && (lookingat != '0')) lookingat = 'false';

	if (!editing){
		if (window.location.hash) postload(lookingat)
		else postload(lastpostis)		
	}else editload(lookingat)
})

function navload(){
	console.log(lookingat)
	$.ajax({
		url:'php/nav.php'
	}).done(function(nav){
		console.log(nav)
		$.each(nav.posts, function(key, val){
			$title.prepend(
				'<div data-post="'+val.id+'">'+
					'<span>'+val.date+'</span>'+
					'<h2>'+val.title+'</h2>'+
				'</div>'
			)

			if ((key) == nav.postcount-1){
				if (!reading) start_titleensure();
				else postpointer()
			}
		})
		lastpostis = parseInt(nav.lastpost);
	})

	$syringe.on('click', function(){
		if (reading) window.location.hash = '!0';
	})
}

function start_titleensure(){
	titleheight = $title.height()
	$master.removeClass('wait').addClass('go')
	
	if (titleheight <= (wpheight - 190)){
		titlelarge = false
		$title.css({
			'max-height': titleheight,
			'overflow':'hidden'
		})
	}else{
		titlelarge = true
		$title.css({
			'max-height': (wpheight - 190),
			'overflow':'scroll'
		})
	}

	$left.on({
		mouseenter:function(){
			if (!reading){
				clearTimeout(titlequick)
				titlequicker = true;
				if (!titlelarge){
					$syringe.css('margin-top',-(titleheight+126)/2)
					// $syringe.css('margin-top', -((wpheight-(titleheight+126))/2))
					$title.css({
						// 'margin-top': titleheight*.25,
						'margin-top': -((titleheight+126)/2)+126,
						'height':titleheight,
						'opacity':1
					})
				}else{
					$syringe.css('top',95)
					$title.css('top', 189)
				}
			}
		}
	})

	$right.on({
		mouseenter:function(){
			if ((!reading) && (titlequicker)){
				titlequick = setTimeout(function(){
					titlequicker = false;
					$syringe.css('margin-top', -63)
					$title.css({
						'margin-top': 0,
						'height':0,
						'opacity':0
					})
				},2000)
			}	
		}
	})

	$name.on('click', function(){
		if (!reading){
			postload(lastpostis)
		}
	})

	postpointer();
	trialbind()
}

function postpointer(){
	newpost = false;
	$title.on('click', 'div', function(){
		window.location.hash = '!'+$(this).data('post')
	})
}

function postload(er){
	if (!reading){
		$master.removeClass('start').addClass('read')
		reading = true;
	}

	console.log(er)

	$content.removeClass('ready')
	
	$content.find('*').not('#titleedit, #postedit').remove()
	console.log(lookingat)
	$.ajax({
		url:'store/html/'+er+'.php',
		cache:false,
		type:'get'
	}).done(function(post){
		setTimeout(function(){
			$content.addClass('ready')
			.append(post)
		},500)
	})
}

function trialbind(){
	$name.on('dblclick', 'h1', function(){
		if (lookingat !== 'false'){
			if (reading){
				$master.addClass('editing')
				r_syringe.attr(svg_attr_white)
				$trial.focus()
			}
			if (hasbeenedited) editload();
		}else alert("Whoa. \n\nYou're navigating into strange waters, good sir -- far stranger than you're prepared to handle. \n\nI'll tell you what's gonna happen here. You're gonna navigate yourself to a page that actually has content on it, and try this again.\n\nWe'll pretend this never happened.")
	})

	$trial.on({
		keydown:function(e){
			if (e.keyCode == 13){
				if (!hasbeenedited) linkup($(this).val());
				else editing = true;
			}
		},
		blur:function(){
			if (!editing){
				$master.removeClass('editing')
				r_syringe.attr(svg_attr_dark)
			}
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
			$right.find('.edit').append(edit)
		}else{
			if (trialcount < 5) $trial.val('NOPE').get(0).type = 'text';
			else $trial.val('OK SERIOUSLY WHAT THE FUCK').get(0).type = 'text';
			setTimeout(function(){
				$trial.val('').get(0).type = 'password';
			},1500)
		}
	})
}

function svg_activate(){
	var svg_syringe = "M61.361,122.723C27.526,122.723,0,95.196,0,61.361S27.526,0,61.361,0s61.361,27.526,61.361,61.361S95.196,122.723,61.361,122.723z M61.361,3C29.181,3,3,29.181,3,61.361s26.181,58.361,58.361,58.361s58.361-26.181,58.361-58.361S93.542,3,61.361,3z M90.184,36.122l-6.617,6.617l-4.162-4.162l6.617-6.617L90.184,36.122z M85.303,25.943l-1.654,1.654l10.896,10.898l1.656-1.655L85.303,25.943z M51.301,68.625l-5.104,5.104l2.217,2.218l5.105-5.104L51.301,68.625z M26.523,96.779l20.367-20.368l-1.158-1.158l-18.541,18.54L26.523,96.779z M48.525,63.863l9.756,9.755l3.033-3.032l-6.041-6.041c-0.271-0.271-0.271-0.709,0-0.979c0.27-0.271,0.709-0.271,0.979-0.001l6.041,6.041l4.047-4.045l-6.041-6.041c-0.271-0.271-0.271-0.709,0-0.979c0.27-0.271,0.709-0.271,0.979,0l6.041,6.041l4.045-4.046l-6.041-6.041c-0.27-0.271-0.27-0.709,0-0.979c0.271-0.27,0.709-0.271,0.98,0l6.041,6.041l4.045-4.046l-6.041-6.041c-0.27-0.27-0.27-0.708,0-0.979c0.271-0.271,0.709-0.271,0.98,0l6.041,6.041l8-8.001l-9.754-9.755L48.525,63.863z";
	
	r_syringe = Raphael('syringe', 126, 126).path(svg_syringe).attr(svg_attr_dark)

	var svg_save = "M32.5,1.069c-17.331,0-31.431,14.1-31.431,31.431s14.1,31.431,31.431,31.431s31.431-14.1,31.431-31.431S49.831,1.069,32.5,1.069z M36.466,50.75h-7.932v-4.189h7.932V50.75z M36.466,43.561h-7.932v-4.068h7.932V43.561z M36.466,25.637v10.855h-7.932V25.637h-2.611l6.578-11.387l6.576,11.387H36.466z";
	var svg_add = "M32.5,1.069C15.169,1.069,1.069,15.169,1.069,32.5c0,17.332,14.1,31.432,31.431,31.432s31.431-14.1,31.431-31.432C63.931,15.169,49.831,1.069,32.5,1.069z M47.416,35H35v12.416h-5V35H17.585v-5H30V17.584h5V30h12.416V35z";
	var svg_delete = "M32.5,1.069c-17.331,0-31.431,14.1-31.431,31.43c0,17.332,14.1,31.432,31.431,31.432s31.431-14.1,31.431-31.432C63.931,15.169,49.831,1.069,32.5,1.069z M44.814,41.28l-3.535,3.535L32.5,36.036l-8.779,8.777l-3.535-3.535l8.779-8.779l-8.779-8.777l3.535-3.535l8.779,8.779l8.779-8.781l3.535,3.535l-8.779,8.779L44.814,41.28z";
	var svg_return = "M32.5,63.931c17.331,0,31.431-14.1,31.431-31.431S49.831,1.069,32.5,1.069S1.069,15.169,1.069,32.5S15.169,63.931,32.5,63.931z M28.534,39.363V14.25h7.932v25.113h2.611L32.499,50.75l-6.576-11.387H28.534z";

	var r_save = Raphael("save", 68, 68).path(svg_save).attr(svg_attr_dark);
	var r_add = Raphael("new", 68, 68).path(svg_add).attr(svg_attr_dark);
	var r_delete = Raphael("delete", 68, 68).path(svg_delete).attr(svg_attr_dark);
	var r_return = Raphael("return", 68, 68).path(svg_return).attr(svg_attr_dark);
}
























