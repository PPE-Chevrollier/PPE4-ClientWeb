$(document).ready(function()
{
	function changerEtoiles(val)
	{
		for (var i = 1; i <= 5; i++)
		{
			if (i <= val)
				$('#vote_' + i).attr('src', '/images/etoile2.png');
			else
				$('#vote_' + i).attr('src', '/images/etoile1.png');
		}
	}
	
	$('#vote').val(0);
	
	$('.vote').click(function()
	{
		$('#vote').val($(this).attr('id').substring(5));
	});
	$('.vote').mouseover(function()
	{
		changerEtoiles($(this).attr('id').substring(5));
	});
	
	$('.vote').mouseleave(function()
	{
		changerEtoiles($('#vote').val());
	});
});