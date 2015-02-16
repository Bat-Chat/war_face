$(function() {
	$('#preloader').hide();
	
	$('.players > a').click(function() {
		if ($(this).hasClass('active'))
		{
			$(this).removeClass('active');
		}
		else
		{
			$('.players > a.active').removeClass('active');
			$(this).addClass('active');
		}
		
		return false;
	});
	
	$('.players + a.play').click(function() {
		if ( ! $('.players > a.active').length)
		{
			alert('Вы не выбрали персонажа для игры!');
		}
		else
		{
			window.location.href = '?page=join';
		}
		
		return false;
	});
});

function vote(soc)
{
	switch (soc)
	{
		case 'vk':
			if (!$.cookie('vk_vote'))
			{
				$.cookie('vk_vote', '1');
				$.cookie('vk_count', parseInt($.cookie('vk_count')) + 1);
				$('#vk_counter').text($.cookie('vk_count'));
				alert("Ваш голос принят!");
			}
			else
			{
				alert("Вы уже отдали голос!");
			}
			break;
		case 'ok':
			if (!$.cookie('ok_vote'))
			{
				$.cookie('ok_vote', '1');
				$.cookie('ok_count', parseInt($.cookie('ok_count')) + 1);
				$('#ok_counter').text($.cookie('ok_count'));
				alert("Ваш голос принят!");
			}
			else
			{
				alert("Вы уже отдали голос!");
			}
			break;
		case 'fb':
			if (!$.cookie('fb_vote'))
			{
				$.cookie('fb_vote', '1');
				$.cookie('fb_count', parseInt($.cookie('fb_count')) + 1);
				$('#fb_counter').text($.cookie('fb_count'));
				alert("Ваш голос принят!");
			}
			else
			{
				alert("Вы уже отдали голос!");
			}
			break;
		case 'mra':
			if (!$.cookie('mra_vote'))
			{
				$.cookie('mra_vote', '1');
				$.cookie('mra_count', parseInt($.cookie('mra_count')) + 1);
				$('#mra_counter').text($.cookie('mra_count'));
				alert("Ваш голос принят!");
			}
			else
			{
				alert("Вы уже отдали голос!");
			}
			break;
		case 'twit':
			if (!$.cookie('twit_vote'))
			{
				$.cookie('twit_vote', '1');
				$.cookie('twit_count', parseInt($.cookie('twit_count')) + 1);
				$('#twit_counter').text($.cookie('twit_count'));
				alert("Ваш голос принят!");
			}
			else
			{
				alert("Вы уже отдали голос!");
			}
	}
}