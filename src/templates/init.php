<?php
require( dirname( __FILE__ ) . '/functions/_init.php' );
function includeWithVariables($filePath, $variables = array(), $print = true)
{
    $output = NULL;
    if(file_exists($filePath)){
        // Extract the variables to a local namespace
        extract($variables);

        // Start output buffering
        ob_start();

        // Include the template file
        include $filePath;

        // End buffering and return its contents
        $output = ob_get_clean();
    }
    if ($print) {
        print $output;
    }
    return $output;
}

/*
 * the_icon
 */

$the_iconStorage = array();

function get_the_icon($fileName,$path = 'assets/img/icons/') {
    global $the_iconStorage;
    $keyExists = array_key_exists($path.$fileName, $the_iconStorage);

    if ( $keyExists) {
        $output = '<svg class="icon icon-'.$fileName.'" aria-hidden="true" role="img">
                     <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-'.$fileName.'"></use>
                   </svg>';
    }

    else {
        $svg = '<svg class="icon icon-'.$fileName.'"';

        if (!$keyExists) {
            $svg .= '" id="icon-'.$fileName.'"';
            $the_iconStorage[$path.$fileName] = $fileName;
        }

        $output = file_get_contents(dirname( __FILE__ ) . '/'.$path.$fileName.'.svg');
        $output = preg_replace('/<svg/', $svg, $output);
    }
    return $output;
}

function  the_icon($fileName, $path = 'assets/img/icons/'){
    echo get_the_icon($fileName, $path);
}

?>
