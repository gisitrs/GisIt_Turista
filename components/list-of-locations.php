<?php
     include "database.php";
     $sql = "SELECT * FROM vw_locations_get";
     $result = $conn-> query($sql);
     $klase = "col-6 col-md-3 mb-4";
                      
     if ($result-> num_rows > 0)
     {
        while ($row = $result-> fetch_assoc())
        {
            echo "<div class=".$klase.">".
                     "<a class="."d-block".">".
                         "<div class="."image-container".">".
                             "<img src=".$row['path']." alt="."Slika 1"." class="."img-fluid".">".
                             "<div class="."overlay-text".">Kratak tekst za Sliku 1</div>".
                         "</div>".
                      "</a>".
                 "</div>";
        }
     }
     else {
            echo "0 results";
          }
                      
     $conn-> close();
?>