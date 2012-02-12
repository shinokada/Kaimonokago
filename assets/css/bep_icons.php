<?php
    // Only include header if we are not processing the file for the cache
    if( ! isset($cache_output))
	{
        header('content-type:text/css');
	}

    // Create path to icons dir
    $path = dirname(dirname(__FILE__)) . "/icons/";

    // Only if we can open the dir procede
    if ($dp = opendir($path))
    {
        // Foreach file in the dir
        while (FALSE !== ($file = readdir($dp)))
        {
            // If the file is not a pointer back to the parent dir
            if ($file != '.' OR $file != '..')
            {
                // And its an image file
                $file_e = explode('.',$file);
                if ( ($file_e[1] == 'png') or ($file_e[1] == 'gif') )
                {
                    // Print css rule
                    print ".icon_" . $file_e[0] . " { padding: 1px 0 1px 25px; background: url(../icons/" . $file . ") no-repeat 0px 50%;}\n";
                }
            }
        }
        closedir($dp);
    }
?>