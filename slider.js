/*jquery slider https://github.com/yui5m/jquery-slider*/
//次スライド移動関数
next = function(wrap, speed = 'fast') {
	var done = false;
	wrap.children().each(function() {
		if (10 < $(this).position().left) {
			wrap.animate({
				scrollLeft: wrap.scrollLeft() + $(this).position().left
			}, speed);
			done = true;
			return false;
		}
	});
	if (!done) {
		wrap.animate({
			scrollLeft: 0
		}, speed);
	}
}
//前スライド移動関数
prev = function(wrap, speed = 'fast') {
	$(wrap.children().get().reverse()).each(function() {
		if (-10 > $(this).position().left) {
			wrap.animate({
				scrollLeft: wrap.scrollLeft() + $(this).position().left
			}, speed);
			return false;
		}
	});
}
//次ボタン
$('.pre>i:last-of-type').on('click', function() {
	event.preventDefault();
	next($(this).prev());
});
//前ボタン
$('.pre>i:first-of-type').on('click', function() {
	event.preventDefault();
	prev($(this).next());
});
//ページングボタン
$('.nate>i').on('click', function() {
	$(this).closest('.pre').find('.wrap').animate({
		scrollLeft: $(this).closest('.pre').find('.wrap').scrollLeft() + $(this).closest('.pre').find('.wrap>*').eq($(this).index()).position().left
	}, 'fast');
});
//タッチ操作関連
let startx;
let endx;
let hisx;
let scstart;
let time = 2000;
$('.wrap').each(function(i, o) {
	let wrap = $(this);
	//自動スライド関連
	let timeout;
	timeout = setTimeout(function() {
		next(wrap)
	}, time);
	wrap.on('scroll', function() {
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			next(wrap)
		}, time);
		wrap.closest('.pre').find('.nate>i').removeClass('now');
		wrap.closest('.pre').find('.nate>i').eq(Math.floor(wrap.scrollLeft() / (wrap.width()))).addClass('now');
	});
	wrap.bind('touchstart', function() {
		scstart = wrap.scrollLeft();
		startx = event.changedTouches[0].pageX;
		hisx = [];
	});
	wrap.bind('touchmove', function() {
		event.preventDefault();
		endx = event.changedTouches[0].pageX;
		hisx.unshift(endx);
		if (2 < hisx.length)
			hisx.pop();
		wrap.scrollLeft(startx - endx + scstart);
	});
	wrap.bind('touchend', function() {
		var leftx = hisx[1] - hisx[0];
		var rightx = hisx[0] - hisx[1];
		var scend = wrap.scrollLeft();
		var conhalf = $(this).width() / 2;
		if (0 < endx - startx) {
			if (conhalf < endx - startx) {
				prev(wrap);
			} else {
				if (20 < rightx) {
					prev(wrap, rightx * 3);
				} else {
					next(wrap);
				}
			}
		}
		if (0 < startx - endx) {
			if (conhalf < startx - endx) {
				next(wrap);
			} else {
				if (20 < leftx) {
					next(wrap, leftx * 3);
				} else {
					prev(wrap);
				}
			}
		}
	});
});
