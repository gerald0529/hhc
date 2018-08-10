//品牌翻转

var turn = function(target, time, opts) {

	target.find('a').hover(function() {

		$(this).find('img').stop().animate(opts[0], time, function() {

			$(this).hide().next().show();

			$(this).next().animate(opts[1], time);

		});

	}, function() {

		$(this).find('.info').animate(opts[0], time, function() {

			$(this).hide().prev().show();

			$(this).prev().animate(opts[1], time);

		});

	});

}

var verticalOpts = [{
	'width': 0
}, {
	'width': '180px'
}];

turn($('#vertical'), 100, verticalOpts);

var horizontalOpts = [{
	'height': 0,
	'top': '120px'
}, {
	'height': '50px',
	'top': 0
}];

turn($('#horizontal'), 100, horizontalOpts);