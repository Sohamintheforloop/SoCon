<?php
session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

$user_id=$_SESSION['user_id'];

include 'includes/header.php';
include 'includes/nav.php';
?>

<h2>SoCon</h2>

<div class="note">

<form
method="POST"
enctype="multipart/form-data">

<label>
Upload Map Image
</label>

<input
type="file"
id="mapUpload"
accept="image/*">

</form>

</div>

<div
id="mapContainer"
class="map-container">

<img
id="mapImage"
class="map-image">

</div>

<!-- Marker Popup -->

<div
id="markerPopup"
class="marker-popup"
style="display:none;">

<input
type="text"
id="markerTitle"
placeholder="Marker Title">

<textarea
id="markerNote"
placeholder="Marker Note">
</textarea>

<button onclick="saveMarker()">
Save Marker
</button>

</div>

<script>

const mapUpload =
document.getElementById("mapUpload");

const mapImage =
document.getElementById("mapImage");

const mapContainer =
document.getElementById("mapContainer");

const popup =
document.getElementById("markerPopup");

let currentX = 0;
let currentY = 0;

/* MAP PREVIEW */

mapUpload.addEventListener(
"change",
function(e){

const file =
e.target.files[0];

if(file){

const reader =
new FileReader();

reader.onload =
function(event){

mapImage.src =
event.target.result;

}

reader.readAsDataURL(file);

}

}
);

/* PLACE MARKER */

mapContainer.addEventListener(
"click",
function(e){

if(!mapImage.src) return;

const rect =
mapContainer.getBoundingClientRect();

currentX =
e.clientX - rect.left;

currentY =
e.clientY - rect.top;

/* marker preview */

const marker =
document.createElement("div");

marker.className =
"marker";

marker.style.left =
currentX + "px";

marker.style.top =
currentY + "px";

mapContainer.appendChild(marker);

/* popup */

popup.style.display =
"block";

popup.style.left =
(currentX + 20) + "px";

popup.style.top =
(currentY + 20) + "px";

}
);

/* SAVE MARKER */

function saveMarker(){

const title =
document.getElementById(
"markerTitle"
).value;

const note =
document.getElementById(
"markerNote"
).value;

fetch(
"save_marker.php",
{

method:"POST",

headers:{
"Content-Type":
"application/x-www-form-urlencoded"
},

body:

"x=" + currentX +

"&y=" + currentY +

"&title=" + encodeURIComponent(title) +

"&note=" + encodeURIComponent(note)

}

)
.then(response=>response.text())
.then(data=>{

popup.style.display="none";

document.getElementById(
"markerTitle"
).value="";

document.getElementById(
"markerNote"
).value="";

});

}

</script>

<?php include 'includes/footer.php'; ?>