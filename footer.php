<hr>

<footer>
SoCon |
Linux Apache MySQL PHP Project
</footer>

<script>
function toggleTheme(){

document.body.classList.toggle("dark");

if(
document.body.classList.contains("dark")
){
localStorage.setItem(
"theme",
"dark"
);
}
else{
localStorage.setItem(
"theme",
"light"
);
}

}

if(
localStorage.getItem("theme")==="dark"
){
document.body.classList.add(
"dark"
);
}
</script>
<script>

const particleContainer =
document.getElementById("particle-bg");

/* CREATE PARTICLES */

for(let i=0;i<90;i++){

const particle =
document.createElement("div");

particle.classList.add("particle");

const size =
Math.random()*5+2;

particle.style.width =
size + "px";

particle.style.height =
size + "px";

particle.style.left =
Math.random()*100 + "%";

particle.style.top =
Math.random()*100 + "%";

particle.style.animationDuration =
(Math.random()*18+12) + "s";

particle.style.animationDelay =
(Math.random()*8) + "s";

particle.style.opacity =
Math.random()*.8;

particleContainer.appendChild(particle);

}

/* CURSOR PARALLAX */

document.addEventListener(
"mousemove",
function(e){

const x =
(e.clientX/window.innerWidth-.5)*10;

const y =
(e.clientY/window.innerHeight-.5)*10;

particleContainer.style.transform =
`translate(${x}px, ${y}px)`;

}
);

</script>
</body>
</html>