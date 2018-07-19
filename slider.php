<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=n">
		<title>Nightly site</title>
    <style>
      html{
        height: 100%;
      }
      #wrap{
        overflow: scroll;
        position: relative;
        height: 100%;
      }
      #wrap::-webkit-scrollbar{
        display: none;
      }
      #wrap>div{
        height: 100%;
        width: 100%;
        position: absolute;
        background: red;
      }
      #wrap>div:nth-child(2) {
        top: 0;
        left: 200%;
        background: green;
      }
      #wrap>div:last-child{
        top: 0;
        left: 100%;
        background: blue;
      }
    </style>
	</head>
  <body>
    <div id="wrap">
      <div></div><div></div><div></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script>
	/*jquery slider https://github.com/yui5m/jquery-slider*/
	let startx;
	let endx;
	let hisx;
	let scstart;
	$('#wrap').each(function() {
		let wrap = $(this);
		wrap.bind('touchstart', function() {
			scstart = wrap.scrollLeft();
			startx = event.changedTouches[0].pageX;
			hisx = [];
		});
		wrap.bind('touchmove', function() {
			event.preventDefault();
			endx = event.changedTouches[0].pageX;
			hisx.unshift(endx);
			if(2<hisx.length) hisx.pop();
			wrap.scrollLeft(startx - endx + scstart);
		});
		wrap.bind('touchend', function() {
			var leftx=hisx[1]-hisx[0];
			var rightx=hisx[0]-hisx[1];
			var scend=wrap.scrollLeft();
			$(wrap.children('img').get().reverse()).each(function() {
				if($(this).position().left<0) {
					if(-$(this).position().left<$(this).width()/2) {
						wrap.animate({scrollLeft: scend+$(this).position().left}, 'fast');
						console.log('back');
					} else {
						wrap.animate({scrollLeft: scend+$(this).next().position().left}, 'fast');
						console.log('next');
					}
					return false;
				}
			});
		});
	});
    </script>
  </body>
</html>
