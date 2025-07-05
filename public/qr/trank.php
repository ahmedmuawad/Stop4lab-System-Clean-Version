<?php  
 
foreach (glob(getcwd()."/temp/*") as $Filename) {

    // Read file creation time
    $FileCreationTime = filectime($Filename);

    // Calculate file age in seconds
    $FileAge = time() - $FileCreationTime; 

    // Is the file older than the given time span?
   
 
        // For example deleting files:
        unlink($Filename);
   
}