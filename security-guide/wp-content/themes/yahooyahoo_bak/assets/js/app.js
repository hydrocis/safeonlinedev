///Swing with me.

// var banner = document.querySelector('.banner-wrapper');
//     // bannerImage = document.querySelector('.banner-wrapper .banner ._image');

// banner.addEventListener('mouseenter',function(e){
//   this.addEventListener('mousemove', function (e) {
//       var w = getComputedStyle(document.documentElement).width.slice(0, -2),
//           h = getComputedStyle(document.documentElement).height.slice(0, -2),
//           rx = (h / 2 - e.pageY) / 50,
//           ry = (w / 2 - e.pageX) / 100;

//       console.log('rx = ' + rx);
//       console.log('rx = ' + ry);

//       // banner.style.transform = 'rotateX(' + rx + 'deg) rotateY(' + -ry + 'deg)';
//       // bannerImage.style.transform = 'translate3d(' + ry * 2 + 'px, ' + rx * 2 + 'px, 0)\n scale(1.05)';
//       banner.style.transform = 'rotateX(' + rx + 'deg) rotateY(' + -ry + 'deg)';
//       banner.style.transform = 'translate3d(' + ry * 2 + 'px, ' + rx * 2 + 'px, 0)';
//   });

// });

//Initiate our animation zaddy - Scroll Reveal (https://github.com/jlmakes/scrollreveal)


(function($, root, undefined) {

    $(document).ready(function() {

        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 473.4885849793636
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 4.008530152163807,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": false,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
        var count_particles, stats, update;
        stats = new Stats;
        stats.setMode(0);
        stats.domElement.style.position = 'absolute';
        stats.domElement.style.left = '0px';
        stats.domElement.style.top = '0px';
        document.body.appendChild(stats.domElement);
        count_particles = $('.js-count-particles');
        update = function () {
            stats.begin();
            stats.end();
            if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
                count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
            }
            requestAnimationFrame(update);
        };
        requestAnimationFrame(update);;


    });

})(jQuery, this);



