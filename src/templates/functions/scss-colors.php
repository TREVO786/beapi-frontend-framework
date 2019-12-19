<?php
/**
 * @ignore
 */
function color_box($color_name,$color_hex){
	echo '<div class="color__col">
			<div class="color__box" style="background:'.$color_hex.'">Aa<span>Aa</span></div>
			<div class="color__name">'.$color_name.'</div>
			<div class="color__hex">'.$color_hex.'</div>
			
		 </div>';
}

/**
 * @ignore
 */
function grab_color($fileName,$path){
	$file = dirname( __FILE__ ) . '/'.$path.$fileName;
	$str = file_get_contents($file);
	$re = '/\$([^:]*):([^;]*);/i';
	preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
	if($matches){
		echo '<div class="color__grid">';
		foreach ($matches as $match){
			color_box($match[1],$match[2]);
		}
		echo '</div>';
	};
}
