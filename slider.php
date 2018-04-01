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
      let startx;
      let endx;
      let hisx;
      let scstart;
      $('#wrap').bind('touchstart', function() {
        scstart = $('#wrap').scrollLeft();
        startx = event.changedTouches[0].pageX;
        hisx = [];
      });
      $('#wrap').bind('touchmove', function(e) {
        e.preventDefault();
        endx = event.changedTouches[0].pageX;
        hisx.unshift(endx);
        if(2<hisx.length) hisx.pop();
        $('#wrap').scrollLeft(startx - endx + scstart);
      });
      $('#wrap').bind('touchend', function() {
        var leftx=hisx[1]-hisx[0];
        var rightx=hisx[0]-hisx[1];
        var scend=$('#wrap').scrollLeft();
        if(scend<$('#wrap').width()/2) {
          if(leftx<=10 || isNaN(leftx))
            $('#wrap').animate({scrollLeft: 0}, 'fast');
          if(leftx>10)
            $('#wrap').animate({scrollLeft: $('#wrap').width()}, 3000/leftx);
        }
        if($('#wrap').width()/2<scend && scend<$('#wrap').width()*1.5) {
          if((rightx<=10 && leftx<=10) || isNaN(rightx) || isNaN(leftx))
            $('#wrap').animate({scrollLeft: $('#wrap').width()}, 'fast');
          if(rightx>10)
            $('#wrap').animate({scrollLeft: 0}, 3000/rightx);
          if(leftx>10)
            $('#wrap').animate({scrollLeft: $('#wrap').width()*2}, 3000/leftx);
        }
        if($('#wrap').width()*1.5<scend) {
          if(rightx<=10 || isNaN(rightx))
            $('#wrap').animate({scrollLeft: $('#wrap').width()*2}, 'fast');
          if(rightx>10)
            $('#wrap').animate({scrollLeft: $('#wrap').width()}, 3000/rightx);
        }
      });
    </script>
  </body>
</html>
