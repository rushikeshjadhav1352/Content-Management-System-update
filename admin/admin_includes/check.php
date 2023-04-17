

<?php
 $dir = 'myDir';

 
 if ( !file_exists($dir) ) {
     mkdir ($dir, 0744);
 }

 file_put_contents ($dir.'/test.txt', 'Hello File');
 ?>