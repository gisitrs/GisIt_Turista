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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
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
    .filter-list {
      /*display: flex;
      overflow-x: auto;
      margin-bottom: 20px;
      padding: 10px 0;*/
      
      display: flex;
      overflow-x: auto;
      padding: 10px 0;
      position: fixed;  /* Fiksira filter na vrhu */
      top: 0;  /* Na vrhu ekrana */
      left: 0;
      right: 0;
      background-color: #fff; /* Pozadina filtera */
      z-index: 1000; /* Povećavamo z-index kako bi bio iznad ostalog sadržaja */
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Dodajemo senku ispod filtera */
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
    
    </style>
</head>
<body>
    
<?php
include "database.php";
     $sql = "SELECT * FROM vw_locationtypes_get ORDER BY ordering";
     $result = $conn-> query($sql);
?>
    
<div id="filterList" class="filter-list">
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

<?php
include "database.php";
     $sql = "SELECT * FROM vw_locations_get";
     $result = $conn-> query($sql);
?>

<div class="container" style="margin-top:160px;">
    <div class="row">
        <?php while($red = $result->fetch_assoc()): ?>
            <div id="<?php echo htmlspecialchars($red['location_type_id'])."_location"; ?>" class="col-6 col-md-3 mb-4">
                <a href="#" onclick="goToPageDynamicPath('<?php echo htmlspecialchars($red['locationDetailsPath']); ?>')" class="d-block">
                    <div class="image-container">
                        <img src="<?php echo htmlspecialchars($red['path']); ?>" alt="Slika" class="img-fluid">
                        <div id="nameId" class="overlay-text"><?php echo htmlspecialchars($red['name']); ?></div>
                        <div id="nameEngId" class="overlay-text" style="display: none;"><?php echo htmlspecialchars($red['name_eng']); ?></div>
                    </div>
                </a>
            
            <div class="button-container">
                <a href="#" onclick="goToPageDynamicPath('Map.php?locationId=<?php echo htmlspecialchars($red['id']); ?>')" class="btn btn-primary">
                    <i class="fas fa-map-marker-alt"></i>
                </a>
            </div>
          </div>
        <?php endwhile; ?>
    </div>
</div>

 <script>
    // Uzmi filter listu
    const filterList = document.getElementById('filterList');
    
    let urlParams = new URLSearchParams(window.location.search);
    var currentLanguage =  urlParams.get('language');
    
    // Funkcija koja prati skrolovanje
    window.addEventListener('scroll', function() {
      // Uzmi poziciju filter liste u odnosu na vrh stranice
      const rect = filterList.getBoundingClientRect();
      
      // Ako filter lista izlazi iz vidnog polja, fiksiraj ga
      if (rect.top <= 0) {
        filterList.classList.add('fixed');  // Dodaj klasu za fiksiranje
      } else {
        filterList.classList.remove('fixed');  // Ukloni klasu kada filter nije više iznad
      }
    });
 
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
        else if (typeName == 'menu' && ((categoryName == 'Naslovna' || categoryName == 'Home') || (categoryName == 'Map' || categoryName == 'Mapa'))){
            goToPage(categoryName);
        }
        else if (typeName == 'menu' && (categoryName == 'Sve lokacije' || categoryName == 'All locations')){
            showAllLocations();
        }
        else{
            showHideDiv(categoryId);
        }
        
      });
    });
    
    function setCurrentLanguage(){
        document.querySelectorAll('[id="nameId"]').forEach(function(el) {
         if (el.style.display == 'none'){
             currentLanguage = 'SRB';
         }
         else{
             currentLanguage = 'ENG';
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
    }
    
    function goToPage(page){
        if (page == 'Home' || page == 'Naslovna' ){
            window.location.href = `index.php?language=${currentLanguage}`;
        }
        else if (page == 'Map' || page == 'Mapa' ){
            window.location.href = `Map.php?locationId=0&language=${currentLanguage}`;
        }
    }
    
    function goToPageDynamicPath(path){
         window.location.href = `${path}&language=${currentLanguage}`;
    }
    
    function showHideDiv(categoryId){
        let id = categoryId + "_location";
        
        document.querySelectorAll('[id*="_location"]').forEach(function(el) {
           if (el.id == id){
               el.style.display = 'block';
           }
           else {
               el.style.display = 'none';
           }
        });
    }
    
    function showAllLocations(){
        document.querySelectorAll('[id*="_location"]').forEach(function(el) {
           el.style.display = 'block';
        });
    }
    
    window.onload = translate();
    
  </script>

<!-- Uključivanje Bootstrap JS-a i potrebnih skripti -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
