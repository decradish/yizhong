function pro_open(obj){
	$(obj).toggleClass('product_more_png_open');
	$(obj).parent().parent().siblings().toggleClass('hidden');
}

$(function() {
	var oDenom = $('ul.denomination')
	oDenom.find('li').click(function(event) {
		var oThis = $(this),
			iMoney = oThis.text(),
			oMoney = $('#money')
		oThis
			.siblings().removeClass('current').end()
			.addClass('current')
		oMoney.text(iMoney)
	});

	var oIconTd = $('td.icon_td')
	oIconTd.find('img').click(function(event) {
		var oThis = $(this)

		oThis
			.siblings().removeClass('current').end()
			.addClass('current')
	});
});