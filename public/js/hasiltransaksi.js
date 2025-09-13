function goHome() {
    window.location.href = "/dashboard";
}

function viewHistory() {
    window.location.href = "/riwayatuser";
}

// Animasi masuk & suara sukses & confetti
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.container').classList.add('animate-fade-in-up');
    var audio = document.getElementById('success-audio');
    var btn = document.getElementById('play-sound-btn');

    // Coba autoplay, jika gagal coba lagi pada event user pertama
    function tryPlayAudio() {
        if (audio) {
            audio.volume = 0.8;
            audio.play().then(() => {
                if (btn) btn.style.display = 'none';
            }).catch(function() {
                if (btn) btn.style.display = 'block';
                var playOnUser = function() {
                    audio.play();
                    if (btn) btn.style.display = 'none';
                    window.removeEventListener('click', playOnUser);
                    window.removeEventListener('touchstart', playOnUser);
                };
                window.addEventListener('click', playOnUser);
                window.addEventListener('touchstart', playOnUser);
            });
        }
    }
    tryPlayAudio();

    if (btn) {
        btn.onclick = function() {
            audio.play();
            btn.style.display = 'none';
        };
    }

    // Confetti animasi sederhana
    function confettiBurst() {
        const canvas = document.getElementById('confetti-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        const colors = ['#22c55e','#4ade80','#facc15','#38bdf8','#f472b6','#f87171'];
        let confettis = [];
        for(let i=0;i<80;i++){
            confettis.push({
                x: Math.random()*canvas.width,
                y: Math.random()*-canvas.height,
                r: Math.random()*6+4,
                d: Math.random()*80+40,
                color: colors[Math.floor(Math.random()*colors.length)],
                tilt: Math.random()*10-10
            });
        }
        let angle = 0;
        function draw() {
            ctx.clearRect(0,0,canvas.width,canvas.height);
            for(let i=0;i<confettis.length;i++){
                let c = confettis[i];
                ctx.beginPath();
                ctx.ellipse(c.x, c.y, c.r, c.r*0.6, c.tilt, 0, 2*Math.PI);
                ctx.fillStyle = c.color;
                ctx.fill();
            }
            update();
        }
        function update() {
            angle += 0.01;
            for(let i=0;i<confettis.length;i++){
                let c = confettis[i];
                c.y += (Math.cos(angle+c.d)+1+c.r/2)/2;
                c.x += Math.sin(angle)*2;
                c.tilt += Math.sin(angle)/2;
                if(c.y > canvas.height){
                    c.x = Math.random()*canvas.width;
                    c.y = Math.random()*-20;
                }
            }
        }
        let frame = 0;
        function animate() {
            draw();
            frame++;
            if(frame < 120) requestAnimationFrame(animate);
            else ctx.clearRect(0,0,canvas.width,canvas.height);
        }
            animate();
        }
        confettiBurst();
    });