const instance = new Typewriter('#typewriter', {
    
    loop: true,
    strings: ['Web Developer', 'Graphics Designer', 'SEO Expert'],
    autoStart: true,
});

// Cookie Section

document.getElementById('cookieClose').addEventListener('click', displayCookieModal);

function displayCookieModal(){
    document.getElementById('cookieModal').style.display='none';
}