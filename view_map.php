<?php
session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

$map_id=$_GET['id'];

$map=$conn->query(
"SELECT * FROM game_maps
WHERE id='$map_id'"
)->fetch_assoc();

$markers=$conn->query(
"SELECT * FROM map_markers
WHERE map_id='$map_id'"
);

include 'includes/header.php';
include 'includes/nav.php';
?>

<h2>
<?php echo $map['map_name']; ?>
</h2>

<div
id="mapContainer"
class="map-container">

<img
src="uploads/<?php
echo $map['map_image'];
?>"

id="mapImage"

class="map-image">

<?php while($marker=$markers->fetch_assoc()){ ?>

<div
class="marker"

style="
left:
<?php echo $marker['marker_x']; ?>px;

top:
<?php echo $marker['marker_y']; ?>px;
"

onclick="
showMarker(
`<?php echo addslashes($marker['marker_title']); ?>`,
`<?php echo addslashes($marker['marker_note']); ?>`
)
">

</div>

<?php } ?>

</div>

<!-- CREATE POPUP -->

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

<!-- VIEW POPUP -->

<div
id="viewPopup"
class="marker-popup"
style="display:none;">

<h3 id="viewTitle"></h3>

<p id="viewNote"></p>

<button
onclick="
document.getElementById(
'viewPopup'
).style.display='none'
">

Close

</button>

</div>

<script>

const mapContainer =
document.getElementById(
"mapContainer"
);

const popup =
document.getElementById(
"markerPopup"
);

let currentX=0;
let currentY=0;

/* CREATE MARKER */

mapContainer.addEventListener(
"click",
function(e){

if(e.target.classList.contains(
"marker"
)) return;

const rect=
mapContainer.getBoundingClientRect();

currentX=
e.clientX-rect.left;

currentY=
e.clientY-rect.top;

popup.style.display="block";

popup.style.left=
(currentX+20)+"px";

popup.style.top=
(currentY+20)+"px";

}
);

/* SAVE */

function saveMarker(){

const title=
document.getElementById(
"markerTitle"
).value;

const note=
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

"x="+currentX+

"&y="+currentY+

"&title="+encodeURIComponent(title)+

"&note="+encodeURIComponent(note)+

"&map_id=<?php echo $map_id; ?>"

}

)
.then(response=>response.text())
.then(data=>{

location.reload();

});

}

/* VIEW MARKER */

function showMarker(title,note){

document.getElementById(
"viewTitle"
).innerText=title;

document.getElementById(
"viewNote"
).innerText=note;

document.getElementById(
"viewPopup"
).style.display="block";

}

</script>

<?php include 'includes/footer.php'; ?>