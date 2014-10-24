$(function(){
	var _SlideshowTransitions = [
	{$Duration:500,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}},
	{$Duration:500,$Delay:30,$Cols:8,$Rows:4,$Clip:15,$Formation:$JssorSlideshowFormations$.$FormationSwirl,$Easing:$JssorEasing$.$EaseInQuad},
	{$Duration:500,x:0.2,$Delay:40,$Cols:12,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInOutExpo,$Opacity:$JssorEasing$.$EaseInOutQuad},$Opacity:2,$Outside:true,$Round:{$Top:0.5}},
	{$Duration:500,y:-1,$Cols:12,$Formation:$JssorSlideshowFormations$.$FormationStraight,$ChessMode:{$Column:12}},
	{$Duration:600,x:1,y:1,$Delay:50,$Cols:8,$Rows:4,$SlideOut:true,$Reverse:true,$Formation:$JssorSlideshowFormations$.$FormationSwirl,$Assembly:513,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Top:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2},
	{$Duration:500,x:-1,y:0.5,$Delay:60,$Cols:8,$Rows:4,$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationCross,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseLinear,$Top:$JssorEasing$.$EaseOutWave},$Round:{$Top:1.5}}
	];
	var slider_options = {
		$AutoPlay : true,
		$AutoPlayInterval : 2000,
		$DragOrientation : 0,
		$SlideshowOptions : {
			$Class: $JssorSlideshowRunner$,
			$Transitions: _SlideshowTransitions,
			$TransitionsOrder: 1,
			$ShowLink: true,
		},
		$ArrowKeyNavigation : true,
		$BulletNavigatorOptions: {
			$Class: $JssorBulletNavigator$,
			$ChanceToShow: 2,
			$SpacingX : 10
			//$AutoCenter : 1,
		},
		$CaptionSliderOptions : {
			$Class: $JssorCaptionSlider$,
			$PlayInMode: 1,
			$PlayOutMode: 3 
		}
	};
	var index_slider = new $JssorSlider$('index_slider', slider_options);
});
