let open = document.getElementById("menu");
let close = document.getElementById("close");
let box = document.getElementById("box");
    
open.onclick = function(){
    box.classList.add("menu-open");
}
close.onclick = function(){
    box.classList.remove("menu-open");
}
        function showMenu() {
            document.querySelector('.navgation ul').classList.add('show');
            document.querySelector('#menu').style.display = 'none';
            document.querySelector('#close').style.display = 'block';
        }

        function closeMenu() {
            document.querySelector('.navgation ul').classList.remove('show');
            document.querySelector('#menu').style.display = 'block';
            document.querySelector('#close').style.display = 'none';
        }
    // Function to handle the fade-in animation
    function fadeIn(element) {
        element.style.opacity = 0;
        let opacity = 0;
        const interval = setInterval(function() {
            if (opacity < 1) {
                opacity += 0.1;
                element.style.opacity = opacity;
            } else {
                clearInterval(interval);
            }
        }, 50);
    }

    // Trigger fade-in animation for features section
    const featuresSection = document.getElementById("features");
    fadeIn(featuresSection);

    // Trigger fade-in animation for courses section
    const coursesSection = document.getElementById("Courses");
    fadeIn(coursesSection);
	
    // Smooth scrolling effect for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

