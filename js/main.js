$(function() {
	var oDenom = $('ul.denomination')
	oDenom.find('li').click(function(event) {
		var oThis = $(this)
		oThis
			.siblings().removeClass('current').end()
			.addClass('current')
	});
});