<?php

function include_template($template, $vars_array)
{
    extract($vars_array);
    ob_start();
    require_once $template;
    $content=ob_get_clean();

return $content;
}

?>