<script>
	var $titleedit, $postedit
	console.log('yeah!')
	editing = true;
	hasbeenedited = true;
	$trial.fadeOut(250,function(){
		$('.control').fadeIn(250);
	})

	$titleedit = $right.find('#titleedit')
	$postedit = $content.find('#postedit')

	$content.removeClass('ready')

	// setTimeout(function(){
	// 	// $content.find('*').not('#titleedit, #postedit').remove()
	// 	editload()
	// },500)

	setTimeout(editload, 500)

	function editload(){
		console.log(lookingat)
		if (!newpost){
			$content.find('*').not('#titleedit, #postedit').remove()
			$('#titleedit, #postedit').empty()
			$.ajax({
				url:'php/editpost.php',
				data:{
					post:lookingat
				}
			}).done(function(post){
				$titleedit.html(post.title)
				$master.addClass('nowediting')
			})

			$.ajax({
				url:'store/md/'+lookingat+'.md',
				cache:false,
				type:'get'
			}).done(function(post){
				$postedit.html(post)
				$content.addClass('ready')
			})
		}
	}

	$('#save').on('click', function(){
		$.ajax({
			type: "POST",
			url:'php/save.php',
			data:{
				isnew:newpost,
				post:lookingat,
				title:($titleedit.val()),
				body:($postedit.val())
			}
		}).done(function(date){
			if (newpost){
				$title.prepend(
					'<div data-post="'+lookingat+'">'+
						'<span>'+date+'</span>'+
						'<h2>'+$titleedit.val()+'</h2>'+
					'</div>'
				)
			}
		})
	})

	$('#new').on('click', function(){
		$titleedit.html('')
		$postedit.html('')
		available.push(lastpostis+1)
		window.location.hash = '!'+(lastpostis+1)
		newpost = true;
	})

	$('#delete').on('click', function(){
		if (!$(this).hasClass('really')) $(this).addClass('really')
		else{
			$.ajax({
				type: "POST",
				url:'php/delete.php',
				data:{
					post:lookingat
				}
			}).done(function(){
				$titleedit.html('')
				$postedit.html('')
				$title.find('div[data-post="'+lookingat+'"]').remove()
				window.location.hash = '';
				$(this).removeClass('really')
			})
		}
	})

	$('#return').on('click', function(){
		$titleedit.html('')
		$postedit.html('')
		$master.removeClass('editing nowediting')
		r_syringe.attr(svg_attr_dark)
		postload(lookingat)
		editing = false;
	})

</script>

















