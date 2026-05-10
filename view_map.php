<?php
session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: dashboard.php");
    exit();
}

$map_id=$_GET['id'];

$map=$conn->query(
"SELECT * FROM game_maps
WHERE id='$map_id'"
)->fetch_assoc();

if(!$map){
    header("Location: dashboard.php");
    exit();
}

$markers=$conn->query(
"SELECT * FROM map_markers
WHERE map_id='$map_id'"
);

include 'includes/header.php';
include 'includes/nav.php';
?>

<h2>
<?php echo htmlspecialchars($map['map_name']); ?>
</h2>

<div
id="mapContainer"
class="map-container">

<img
src="uploads/<?php echo $map['map_image']; ?>"
id="mapImage"
class="map-image">

<!-- MARKERS -->

<?php while($marker=$markers->fetch_assoc()){ ?>

<div
class="marker"

style="
left:<?php echo $marker['marker_x']; ?>%;
top:<?php echo $marker['marker_y']; ?>%;
"

onclick="
event.stopPropagation();

showMarker(
<?php echo $marker['id']; ?>,
`<?php echo addslashes($marker['marker_title']); ?>`,
`<?php echo addslashes($marker['marker_note']); ?>`
)
">

</div>

<?php } ?>

</div>

<!-- CREATE MARKER POPUP -->

<div
id="markerPopup"
class="marker-popup"
style="display:none;">

<h3>Create Marker</h3>

<input
type="text"
id="markerTitle"
placeholder="Marker Title">

<textarea
id="markerNote"
placeholder="Marker Note"></textarea>

<div class="actions">

<button onclick="saveMarker()">
Save Marker
</button>

<button onclick="closeCreatePopup()">
Cancel
</button>

</div>

</div>

<!-- VIEW MARKER POPUP -->

<div
id="viewPopup"
class="marker-popup"
style="display:none;">

<h3 id="viewTitle"></h3>

<p id="viewNote"></p>

<div class="actions">

<button id="editBtn">
Edit
</button>

<button id="deleteBtn">
Delete
</button>

<button onclick="closeViewPopup()">
Close
</button>

</div>

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

const viewPopup =
document.getElementById(
"viewPopup"
);

let currentX=0;
let currentY=0;

/* =========================
   CREATE MARKER
========================= */

mapContainer.addEventListener(
"click",
function(e){

if(
e.target.classList.contains(
"marker"
)
) return;

const rect =
mapContainer.getBoundingClientRect();

currentX =

(
(e.clientX - rect.left)
/
rect.width
) * 100;

currentY =

(
(e.clientY - rect.top)
/
rect.height
) * 100;

/* popup positioning */

popup.style.display="block";

popup.style.left=
e.pageX + "px";

popup.style.top=
e.pageY + "px";

}
);

/* =========================
   SAVE MARKER
========================= */

function saveMarker(){

const title =
document.getElementById(
"markerTitle"
).value;

const note =
document.getElementById(
"markerNote"
).value;

if(title.trim()===""){
    alert("Marker title required");
    return;
}

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

/* =========================
   VIEW MARKER
========================= */

function showMarker(id,title,note){

viewPopup.style.display="block";

viewPopup.style.left="50%";

viewPopup.style.top="50%";

viewPopup.style.transform=
"translate(-50%,-50%)";

document.getElementById(
"viewTitle"
).innerText=title;

document.getElementById(
"viewNote"
).innerText=note;

/* EDIT */

document.getElementById(
"editBtn"
).onclick=function(){

const newTitle =
prompt(
"Edit Title",
title
);

if(newTitle===null) return;

const newNote =
prompt(
"Edit Note",
note
);

if(newNote===null) return;

fetch(
"edit_marker.php",
{

method:"POST",

headers:{
"Content-Type":
"application/x-www-form-urlencoded"
},

body:

"id="+id+

"&title="+encodeURIComponent(newTitle)+

"&note="+encodeURIComponent(newNote)

}

)
.then(response=>response.text())
.then(data=>{

location.reload();

});

};

/* DELETE */

document.getElementById(
"deleteBtn"
).onclick=function(){

if(
confirm(
"Delete this marker?"
)
){

fetch(
"delete_marker.php",
{

method:"POST",

headers:{
"Content-Type":
"application/x-www-form-urlencoded"
},

body:
"id="+id

}

)
.then(response=>response.text())
.then(data=>{

location.reload();

});

}

};

}

/* =========================
   CLOSE POPUPS
========================= */

function closeCreatePopup(){

popup.style.display="none";

document.getElementById(
"markerTitle"
).value="";

document.getElementById(
"markerNote"
).value="";

}

function closeViewPopup(){

viewPopup.style.display="none";

}

/* =========================
   ESC KEY CLOSE
========================= */

document.addEventListener(
"keydown",
function(e){

if(e.key==="Escape"){

closeCreatePopup();

closeViewPopup();

}

}
);

</script>

<?php include 'includes/footer.php'; ?>