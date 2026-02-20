<!DOCTYPE html>
<html>
<head>
<title>Global Language Academy</title>

<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#0f172a,#1e3a8a);
}

/* MAIN CARD */
.wrapper{
width:950px;
background:linear-gradient(135deg,#1e40af,#2563eb);
border-radius:25px;
box-shadow:0 20px 50px rgba(0,0,0,0.35);
overflow:hidden;
animation:fade 1s ease;
}

/* HEADER */
.navbar{
padding:22px 35px;
color:white;
font-size:22px;
font-weight:600;
letter-spacing:1px;
}

/* HERO */
.hero{
display:flex;
align-items:center;
padding:50px;
color:white;
}

/* TEXT */
.text{
flex:1;
animation:slideLeft 1s ease;
}

.text h1{
font-size:42px;
margin-bottom:15px;
line-height:1.2;
}

.text p{
opacity:0.9;
margin-bottom:25px;
font-size:16px;
}

.btn{
background:white;
color:#1e3a8a;
padding:13px 30px;
border-radius:30px;
text-decoration:none;
display:inline-block;
font-weight:600;
transition:0.3s;
}

.btn:hover{
background:#f1f5f9;
transform:translateY(-3px);
}

/* ANIMATION */
.animasi{
flex:1;
text-align:center;
animation:float 4s ease-in-out infinite;
}

/* ANIMATION KEYFRAMES */
@keyframes fade{
from{opacity:0; transform:translateY(40px);}
to{opacity:1; transform:translateY(0);}
}

@keyframes slideLeft{
from{opacity:0; transform:translateX(-50px);}
to{opacity:1; transform:translateX(0);}
}

@keyframes float{
0%{transform:translateY(0);}
50%{transform:translateY(-18px);}
100%{transform:translateY(0);}
}

</style>
</head>

<body>

<div class="wrapper">

<div class="navbar">
GLOBAL LANGUAGE ACADEMY 🌍
</div>

<div class="hero">

<div class="text">
<h1>Belajar Bahasa Dunia 🌎</h1>
<p>
Kursus Bahasa Jepang 🇯🇵, Korea 🇰🇷, Spanyol 🇪🇸, Inggris 🇬🇧 dan lainnya.  
Sistem modern untuk Admin, Mentor & Siswa.
</p>

<a href="<?= base_url('login') ?>" class="btn">
Mulai Sekarang
</a>
</div>

<div class="animasi">

<lottie-player
src="https://assets2.lottiefiles.com/packages/lf20_zrqthn6o.json"
background="transparent"
speed="1"
style="width:340px;height:340px;"
loop
autoplay>
</lottie-player>

</div>

</div>

</div>

</body>
</html>
