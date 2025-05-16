<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Slike sa Tekstom i Dugmetom</title>
    <!-- Uključivanje Bootstrap CSS-a -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Uključivanje Font Awesome za ikone -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .image-container {
            position: relative;
        }
        .image-container img {
            width: 100%;
            height: auto;
        }
        .overlay-text {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Poluprovidna crna pozadina */
            color: white; /* Bela boja teksta */
            text-align: center;
            padding: 10px;
            font-size: 16px;
        }
        .button-container {
            text-align: center;
            margin-top: 10px;
        }
        
        /* Stilizacija za horizontalnu listu */
    .filter-list1 {
      display: flex;
    overflow-x: auto;
    padding: 10px 0;
    position: fixed;  /* Fiksira filter na vrhu */
    top: 0;
    left: 0;
    right: 0;
    background-color: #fff; /* Pozadina filtera */
    z-index: 1000; /* Povećavamo z-index kako bi bio iznad ostalog sadržaja */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Dodajemo senku ispod filtera */
    flex-shrink: 0; /* Obezbeđuje da traka ne bude stegnuta */
    height:135px;
    }
    
    .filter-list {
      display: flex;
    overflow-x: auto;
    padding: 10px 0;
    position: fixed;  /* Fiksira filter na vrhu */
    top: 0;
    left: 0;
    right: 0;
    background-color: #fff; /* Pozadina filtera */
    z-index: 1000; /* Povećavamo z-index kako bi bio iznad ostalog sadržaja */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Dodajemo senku ispod filtera */
    flex-shrink: 0; /* Obezbeđuje da traka ne bude stegnuta */
    }
    
    .filter-item {
      margin: 0 15px;
      text-align: center;
      cursor: pointer;
    }
    
    .filter-item-active {
          border: 2px solid #007bff;
          border-radius: 8px;
          box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
          transform: scale(0.97);
          transition: all 0.2s ease;
    }
    
    .filter-item:active img {
      transform: scale(0.95);
    }
    
    .filter-item img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 8px;
    }
    .filter-item p {
      margin-top: 5px;
      font-size: 14px;
      color: #333;
    }

    /* Stilizacija za sadržaj koji se filtrira */
    .content-item {
      display: none;
      padding: 20px;
      border: 1px solid #ddd;
      margin-bottom: 10px;
    }
    .show {
      display: block;
    }
    
    .body {
            margin: 0;
            font-family: Arial, sans-serif;
            margin-top: 125px;
        }
        .header {
            background-color: #2e8b57;
            color: white;
            padding: 15px;
            text-align: center;
        }
        
        
    #map {
        height: 100%;         /* Fiksna visina */
        width: 100%;           /* Ili fiksna širina po potrebi */
        overflow: hidden;      /* Sprečava prelivanje */
    }
    
    /* Traka koja se dodaje na dno diva */
    .drag-bar {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 20vw;  /* 20% širine ekrana */
        height: 10px;
        background-color: #333;
        cursor: ns-resize;
        border-radius: 5px;
        z-index:1000;
    }
    
    </style>
</head>
<body>
    
<?php
include "database.php";
     $sql = "SELECT * FROM vw_maplocationtypes_get ORDER BY ordering";
     $result = $conn-> query($sql);
?>
 
<div id="filterList1" class="filter-list1" style="max-height:135px;"> 
    <div id="filterList" class="filter-list" style="max-height:125px;">
        <?php while($red = $result->fetch_assoc()): ?>
            <div class="filter-item">
                <img id="<?php echo htmlspecialchars($red['image_Id']); ?>" src="<?php echo htmlspecialchars($red['icon_path']); ?>" alt="Kategorija">
                <p id="nameId"><?php echo htmlspecialchars($red['name']); ?></p>
                <p id="nameEngId" style="display:none;"><?php echo htmlspecialchars($red['name_eng']); ?></p>
                <p id="typeId" style="display:none;"><?php echo htmlspecialchars($red['type']); ?></p>
                <p id="categoryId" style="display:none;"><?php echo htmlspecialchars($red['id']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
    <div class="drag-bar"></div>
</div>

<?php
     include "database.php";
     $sql = "SELECT * FROM vw_locations_get";
     $result = $conn-> query($sql);
?>

<?php
// Povezivanje sa bazom podataka
include "database.php";

// Provera da li je konekcija uspela
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL upit za dobijanje koordinata centra mape
$sql = "SELECT latitude, longitude FROM vw_city_get"; // Uzima samo jedan red
$result = $conn->query($sql);

// Proveri da li postoji rezultat
if ($result->num_rows > 0) {
    // Uzimamo koordinate iz baze
    $row = $result->fetch_assoc();
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
} else {
    // Ako nema rezultata, postavimo defaultne koordinate
    $latitude = 45.0; // Default latituda
    $longitude = 19.0; // Default longitud
}

// Zatvori konekciju
$conn->close();
?>

<?php
// Povezivanje sa bazom podataka
include "database.php";

// Provera da li je konekcija uspela
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL upit za dobijanje koordinata iz baze
// Uzimamo latitudu i longitudu iz POINT tipa
$sql = "SELECT * FROM vw_locations_get"; // Uzima sve redove
$result = $conn->query($sql);

// Inicijalizacija niza za koordinate
$coordinates = [];

if ($result->num_rows > 0) {
    // Za svaki red dobijamo koordinate
    while($row = $result->fetch_assoc()) {
        $coordinates[] = [
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'id' => $row['id'],
            'name' => $row['name'],
            'path' => $row['path'],
            'locationTypeId' => $row['location_type_id'],
            'nameEng' => $row['name_eng'],
            'locationTypeIconPath' => $row['location_type_icon_path']
        ];
    }
} else {
    echo "No results found.";
}

// Zatvori konekciju
$conn->close();
?>

<!-- Prosledi PHP koordinate u JavaScript -->
<script>
    // PHP niz koordinata prosleđujemo u JavaScript
    var coordinates = <?php echo json_encode($coordinates); ?>;
</script>


<div id="map" style="position: fixed; left: 0; bottom: 0; right: 0;"></div>

<!-- Leaflet JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://unpkg.com/proj4@2.7.3/dist/proj4.js"></script>
  
  <?php
    // Uključi PHP kod za dobijanje koordinata
    // Koordinate dolaze iz PHP-a
    echo "<script>";
    echo "var latitude = " . $latitude . ";";
    echo "var longitude = " . $longitude . ";";
    echo "</script>";
    ?>
    
  <php
    // Uključi PHP kod za dobijanje koordinata
    // Koordinate dolaze iz PHP-a
    echo "<script>";
    echo "var coordinates = " . json_encode($coordinates) . ";";
    echo "</script>";
    ?>

 <script>
    // EPSG:3857 to EPSG:4326 conversion
    var proj3857 = 'EPSG:3857';
    var proj4326 = 'EPSG:4326';
    
    let urlParams = new URLSearchParams(window.location.search);
    
    var currentLanguage =  urlParams.get('language');
    var currentLocationType = 0;

    // Koristi Proj4js za konverziju iz EPSG:3857 u EPSG:4326
    var point4326 = proj4(proj3857, proj4326, [longitude, latitude]);

    // Point u EPSG:4326
    var lon = point4326[0]; // Longitude
    var lat = point4326[1]; // Latitude
    
    // Inicijalizuj mapu u Leaflet-u sa konvertovanim koordinatama
    var map = L.map('map').setView([lat, lon], 10);

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    map.attributionControl.remove();
    
    // Create a LayerGroup to store markers
    var markersLayer = L.layerGroup().addTo(map);
    
    const params = new URLSearchParams(window.location.search);
    const locationId = params.get('locationId');
    
    //showAllLocations(locationId);
    
    const draggableDiv = document.getElementById('filterList');
    const draggableDiv1 = document.getElementById('filterList1');

        let startY;
        let startHeight;
        let isDragging = false;

        // Promenjena minimalna visina na 20px
        let minHeight = 0;  // minimalna visina
        let maxHeight = 135;  // maksimalna visina

        // Funkcija koja upravlja povlačenjem za miš
        function onMouseDown(e) {
            startY = e.clientY;
            startHeight = parseInt(window.getComputedStyle(draggableDiv).height);
            isDragging = true;

            document.body.style.userSelect = 'none';
        }

        // Funkcija koja upravlja povlačenjem za dodir
        function onTouchStart(e) {
            startY = e.touches[0].clientY;
            startHeight = parseInt(window.getComputedStyle(draggableDiv).height);
            isDragging = true;

            document.body.style.userSelect = 'none';
        }

        // Funkcija koja prati pomeranje miša/dodira
        function onMouseMove(e) {
            if (!isDragging) return;

            const dy = e.clientY - startY;
            let newHeight = startHeight + dy;

            // Ograničavanje visine
            if (newHeight < minHeight) newHeight = minHeight;
            if (newHeight > maxHeight) newHeight = maxHeight;

            draggableDiv.style.height = newHeight + 'px';
            draggableDiv1.style.height = newHeight + 'px';
        }

        // Funkcija koja prati pomeranje dodira
        function onTouchMove(e) {
            if (!isDragging) return;

            const dy = e.touches[0].clientY - startY;
            let newHeight = startHeight + dy;

            // Ograničavanje visine
            if (newHeight < minHeight) newHeight = minHeight;
            if (newHeight > maxHeight) newHeight = maxHeight;

            draggableDiv.style.height = newHeight + 'px';
            draggableDiv1.style.height = newHeight + 'px';
        }

        // Funkcija koja završava povlačenje
        function onMouseUp() {
            isDragging = false;
            document.body.style.userSelect = '';
        }

        // Funkcija koja završava povlačenje za dodir
        function onTouchEnd() {
            isDragging = false;
            document.body.style.userSelect = '';
        }

        // Event listeneri za miš
        draggableDiv.addEventListener('mousedown', onMouseDown);
        draggableDiv1.addEventListener('mousedown', onMouseDown);
        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);

        // Event listeneri za mobilne uređaje
        draggableDiv.addEventListener('touchstart', onTouchStart);
        draggableDiv1.addEventListener('touchstart', onTouchStart);
        document.addEventListener('touchmove', onTouchMove);
        document.addEventListener('touchend', onTouchEnd);
    
 
    // Funkcija koja prikazuje alert sa nazivom kategorije
    document.querySelectorAll('.filter-item').forEach(item => {
      item.addEventListener('click', function() {
        const categoryName = this.querySelector('p').textContent; // Uzimamo naziv kategorije
        const typeName = this.querySelector('#typeId').textContent;
        const categoryId = this.querySelector('#categoryId').textContent;
        
        // Ukloni "active" sa svih
        document.querySelectorAll('.filter-item-active').forEach(el => el.classList.replace('filter-item-active','filter-item'));
        
        if (typeName != 'menu' || (typeName == 'menu' && (categoryName == 'Sve lokacije' || categoryName == 'All locations')))
        {
            // Dodaj "active" samo na kliknutu
            this.classList.add('filter-item-active');
        }
        
        if (typeName == 'menu' && (categoryName == 'SRB' || categoryName == 'ENG')){
            setCurrentLanguage();
        }
        else if (typeName == 'menu' && ((categoryName == 'Naslovna' || categoryName == 'Home') || (categoryName == 'Info'))){
            goToPage(categoryName);
        }
        else if (typeName == 'menu' && (categoryName == 'Sve lokacije' || categoryName == 'All locations')){
            currentLocationType = 0;
            showAllLocations(0);
        }
        else{
            currentLocationType = categoryId;
            filterLocations(categoryId);
        }
        
      });
    });
    
    function setCurrentLanguage(){
        document.querySelectorAll('[id="nameId"]').forEach(function(el) {
             if (el.style.display == 'none'){
                 el.style.display = 'block';
                 document.getElementById('ENGId').src = 'images/icons/GBR.svg';
                 currentLanguage = 'SRB';
             }
             else{
                 el.style.display = 'none';
                 document.getElementById('ENGId').src = 'images/icons/SRB.svg';
                 currentLanguage = 'ENG';
             }
        });
        
        document.querySelectorAll('[id="nameEngId"]').forEach(function(el) {
            if (el.style.display == 'none'){
                el.style.display = 'block';
            }
            else{
                el.style.display = 'none';
            }
        });
        
        translate();
    }
    
    function translate(){
        
        if (currentLanguage == 'SRB'){
            document.getElementById('ENGId').src = 'images/icons/GBR.svg';
            
            document.querySelectorAll('[id="nameEngId"]').forEach(function(el) {
                el.style.display = 'none';
            });
            
            document.querySelectorAll('[id="nameId"]').forEach(function(el) {
                el.style.display = 'block';
            });
        }
        else if (currentLanguage == 'ENG'){
            document.getElementById('ENGId').src = 'images/icons/SRB.svg';
            
            document.querySelectorAll('[id="nameEngId"]').forEach(function(el) {
                el.style.display = 'block';
            });
            
            document.querySelectorAll('[id="nameId"]').forEach(function(el) {
                el.style.display = 'none';
            });
        }
        
        if (currentLocationType == 0){
            showAllLocations(0);
        }
        else {
            filterLocations(currentLocationType);
        }
    }
    
    function goToPage(page){
        if (page == 'Home' || page == 'Naslovna' ){
            window.location.href = `index.php?language=${currentLanguage}`;
        }
        else if (page == 'Info' ){
            window.location.href = `Info.php?language=${currentLanguage}`;
        }
    }
    
    // Function to open the location in Google Maps
    function openInGoogleMaps(lat, lon) {
        // Construct the Google Maps URL
        var googleMapsUrl = `https://www.google.com/maps?q=${lat},${lon}`;

        // Open Google Maps in a new window/tab
        //window.open(googleMapsUrl);
        window.location.href = googleMapsUrl;
    }
    
    function filterLocations(locationTypeId){
        var navigationText = 'Navigacija';
        var moreDetails = 'Više detalja';
        
        if (currentLanguage == 'SRB'){
            srbDisplay = 'block';
            engDisplay = 'none';
        }
        else {
            srbDisplay = 'none';
            engDisplay = 'block'; 
            navigationText = 'Navigation';
            moreDetails = 'More details';
        }
        
        markersLayer.clearLayers();
        
        coordinates.forEach(function(coord) {
            if (locationTypeId == coord.locationTypeId){
                var point4326 = proj4(proj3857, proj4326, [Number(coord.longitude), Number(coord.latitude)]);
                
                var customIcon = L.icon({
                    iconUrl: coord.locationTypeIconPath, // relativna ili apsolutna putanja do slike
                    iconSize: [32, 32],       // veličina ikonice [širina, visina]
                    iconAnchor: [16, 32],     // tačka u ikoni koja "dodiruje" lokaciju na mapi
                    popupAnchor: [0, -32]     // pozicija popup-a u odnosu na ikonicu
                });
                
                var marker = L.marker([point4326[1], point4326[0]], { icon: customIcon }).addTo(markersLayer);
                marker.bindPopup('<div style="text-align:center;"><img src="'+ coord.path +'" alt="Image" style="width:150px;" /></div></br></br><h4 id="popupTextId" style="display:' + srbDisplay + ';text-align:center;">'+ coord.name +'</h4><h4 id="popupEngTextId" style="display:'+ engDisplay + '">'+ coord.nameEng + '</h4></br>' +
                '<button id="navigationButtonId" style="margin-left:10px;display:inline-fix;" onclick="openInGoogleMaps('+ point4326[1] +','+ point4326[0] +')">' + navigationText + '</button>' + 
                '<a id="moreDetailsButtonId" style="margin-left:10px;display:inline-fix;" href="locationDetails.php?locationId=' + coord.id + '&language='+ currentLanguage +'">' + moreDetails + '</a>');
            }
        });
    }
    
    function showAllLocations(locationId){
        var navigationText = 'Navigacija';
        var moreDetails = 'Više detalja';
        var locationDetailsPath = '/locationDetails.php';
        
        if (currentLanguage == 'SRB'){
            srbDisplay = 'block';
            engDisplay = 'none';
        }
        else {
            srbDisplay = 'none';
            engDisplay = 'block'; 
            navigationText = 'Navigation';
            moreDetails = 'More details';
        }
        
        markersLayer.clearLayers();
        
        coordinates.forEach(function(coord) {
            if (coord.id == locationId || locationId == 0){
                var point4326 = proj4(proj3857, proj4326, [Number(coord.longitude), Number(coord.latitude)]);
            
                var customIcon = L.icon({
                    iconUrl: coord.locationTypeIconPath, // relativna ili apsolutna putanja do slike
                    iconSize: [32, 32],       // veličina ikonice [širina, visina]
                    iconAnchor: [16, 32],     // tačka u ikoni koja "dodiruje" lokaciju na mapi
                    popupAnchor: [0, -32]     // pozicija popup-a u odnosu na ikonicu
                });
            
                var marker = L.marker([point4326[1], point4326[0]], { icon: customIcon }).addTo(markersLayer);
                marker.bindPopup('<div style="text-align:center;"><img src="'+ coord.path +'" alt="Image" style="width:150px;" /></div></br></br><h4 id="popupTextId" style="display:' + srbDisplay + ';text-align:center;">'+ coord.name +'</h4><h4 id="popupEngTextId" style="display:'+ engDisplay + '">'+ coord.nameEng + '</h4></br>' +
                '<button id="navigationButtonId" style="text-align:center;" onclick="openInGoogleMaps('+ point4326[1] +','+ point4326[0] +')">' + navigationText + '</button>' + 
                '<a id="moreDetailsButtonId" style="margin-left:10px;display:inline-fix;" href="locationDetails.php?locationId='+ coord.id +'&language=' + currentLanguage + '">' + moreDetails + '</a>');
            }
        });
    }
    
    function initialFunctions(){
        translate();
        showAllLocations(locationId);
    }
    
    window.onload = initialFunctions();
    
  </script>

<!-- Uključivanje Bootstrap JS-a i potrebnih skripti -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>