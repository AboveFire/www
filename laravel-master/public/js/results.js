//quand tu t'appelle " " sa crash
//tu peux avoir des emotes dans ton nom
$number = 0;
var $_GET = {};
$(document).ready(function(){
	$.post("ssresults", {action: 'addten',number: $number, _token:tokenMobile}, function(data){
		$obj = JSON.parse(data);
		for ($key = $obj.length-1; $key >= 1; $key--) {
			$class_home = "imgEven";
			$class_visitor = "imgEven";
			if($obj[$key].point_home > $obj[$key].point_visitor){
				$class_home = "imgWin";
				$class_visitor = "imgLose";
			}else if($obj[$key].point_home < $obj[$key].point_visitor){
				$class_home = "imgLose";
				$class_visitor = "imgWin";
			}
			$('#image').append("<li>"
			+'<span class="date">' + $obj[$key].date.slice(0, -3).replace(" ", '<span class="space"></span>') + "</span><br />"
			+'<span class="cote">( ' + $obj[$key].cote + " )</span><br />"
			+'<span class="group"><img class="' + $class_home + ' home" src="' + $obj[$key].image_home + '" onerror="this.src=\'{{{ asset(\'images/profile.png\') }}}\'" alt="image" />'
			+'<span class="point phome">' + $obj[$key].point_home + "</span></span>"
			+'<span class="group"><img class="' + $class_visitor + ' visitor" src="' + $obj[$key].image_visitor + '" onerror="this.src=\'{{{ asset(\'images/profile.png\') }}}\'" alt="image" />'
			+'<span class="point pvisitor">' + $obj[$key].point_visitor + "</span></span>"
			+'</li><hr class="black" />');
		}
		$key = 0;
		$class_home = "imgEven";
		$class_visitor = "imgEven";
		if($obj[$key].point_home > $obj[$key].point_visitor){
			$class_home = "imgWin";
			$class_visitor = "imgLose";
		}else if($obj[$key].point_home < $obj[$key].point_visitor){
			$class_home = "imgLose";
			$class_visitor = "imgWin";
		}
		$('#image').append("<li>"
		+'<span class="date">' + $obj[$key].date.slice(0, -3).replace(" ", '<span class="space"></span>') + "</span><br />"
		+'<span class="cote">( ' + $obj[$key].cote + " )</span><br />"
		+'<span class="group"><img class="' + $class_home + ' home" src="' + $obj[$key].image_home + '" onerror="this.src=\'{{{ asset(\'images/profile.png\') }}}\'" alt="image" />'
		+'<span class="point phome">' + $obj[$key].point_home + "</span></span>"
		+'<span class="group"><img class="' + $class_visitor + ' visitor" src="' + $obj[$key].image_visitor + '" onerror="this.src=\'{{{ asset(\'images/profile.png\') }}}\'" alt="image" />'
		+'<span class="point pvisitor">' + $obj[$key].point_visitor + "</span></span>"
		+'</li>');
		$('#image').append('<hr />');
		$number+=1;
		addten(true);
	});
	$( window ).scroll(function() {
		if($(window).scrollTop() + $(window).height() == $(document).height()) {
		       addten(true);
		}
	});
});

function adjustScroll($offset){
	$( window ).scrollTop($(window)[0].scrollHeight - $offset);
}

function addten($adjust){
	$.post("ssresults", {action: 'addten',number: $number, _token:tokenMobile}, function(data){
		$obj = JSON.parse(data);
		for ($key = $obj.length-1; $key >= 1; $key--) {
			$class_home = "imgEven";
			$class_visitor = "imgEven";
			if($obj[$key].point_home > $obj[$key].point_visitor){
				$class_home = "imgWin";
				$class_visitor = "imgLose";
			}else if($obj[$key].point_home < $obj[$key].point_visitor){
				$class_home = "imgLose";
				$class_visitor = "imgWin";
			}
			$('#image').append("<li>"
			+'<span class="date">' + $obj[$key].date.slice(0, -3).replace(" ", '<span class="space"></span>') + "</span><br />"
			+'<span class="cote">( ' + $obj[$key].cote + " )</span><br />"
			+'<span class="group"><img class="' + $class_home + ' home" src="' + $obj[$key].image_home + '" onerror="this.src=\'{{{ asset(\'images/profile.png\') }}}\'" alt="image" />'
			+'<span class="point phome">' + $obj[$key].point_home + "</span></span>"
			+'<span class="group"><img class="' + $class_visitor + ' visitor" src="' + $obj[$key].image_visitor + '" onerror="this.src=\'{{{ asset(\'images/profile.png\') }}}\'" alt="image" />'
			+'<span class="point pvisitor">' + $obj[$key].point_visitor + "</span></span>"
			+'</li><hr class="black" />');
		}
		$key = 0;
		$class_home = "imgEven";
		$class_visitor = "imgEven";
		if($obj[$key].point_home > $obj[$key].point_visitor){
			$class_home = "imgWin";
			$class_visitor = "imgLose";
		}else if($obj[$key].point_home < $obj[$key].point_visitor){
			$class_home = "imgLose";
			$class_visitor = "imgWin";
		}
		$('#image').append("<li>"
		+'<span class="date">' + $obj[$key].date.slice(0, -3).replace(" ", '<span class="space"></span>') + "</span><br />"
		+'<span class="cote">( ' + $obj[$key].cote + " )</span>" +
				"<br />"
		+'<span class="group"><img class="' + $class_home + ' home" src="' + $obj[$key].image_home + '" onerror="this.src=\'{{{ asset(\'images/profile.png\') }}}\'" alt="image" />'
		+'<span class="point phome">' + $obj[$key].point_home + "</span></span>"
		+'<span class="group"><img class="' + $class_visitor + ' visitor" src="' + $obj[$key].image_visitor + '" onerror="this.src=\'{{{ asset(\'images/profile.png\') }}}\'" alt="image" />'
		+'<span class="point pvisitor">' + $obj[$key].point_visitor + "</span></span>"
		+'</li>');
		$('#image').append('<hr />');
		$number+=1;
	});
	$number+=1;
}
