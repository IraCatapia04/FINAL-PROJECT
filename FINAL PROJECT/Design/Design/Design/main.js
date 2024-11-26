document.addEventListener('DOMContentLoaded', fetchTeamMembers);
var slides = document.querySelectorAll('#slides .slide');
var currentSlide = 0;
var slideInterval = setInterval(nextSlide,2000);

function nextSlide() {
    slides[currentSlide].className = 'slide';
    currentSlide = (currentSlide+1)%slides.length;
    slides[currentSlide].className = 'slide showing';
}

function toggleContactForm() {
    const form = document.getElementById('contactForm');
    form.style.display = form.style.display === 'block' ? 'none' : 'block';
}
function validateSearch() {
    const query = document.getElementById('query').value.toLowerCase();
    const resultsContainer = document.getElementById('livesearch');
    resultsContainer.innerHTML = ''; 

    if (query.length === 0) {
        return;
    }
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "api.php?q=" + encodeURIComponent(query), true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const results = JSON.parse(xhr.responseText);
            if (results.length > 0) {
                results.forEach(member => {
                    resultsContainer.innerHTML += `
                        <div class='box'>
                            <img src='${member.image}' alt='${member.name}'>
                            <h3><a href='${member.link}'>${member.name}</a></h3>
                        </div>`;
                });
            } else {
                resultsContainer.innerHTML = "<p>No matching members found.</p>";
            }
        } else {
            resultsContainer.innerHTML = "<p>Error retrieving data.</p>";
        }
    };
    xhr.send();
}
function validateSearch() {
    const query = document.getElementById('query').value.trim();

    if (!query) {
        alert('Please enter a name to search.');
        return false; 

    searchTeam(); 
    return true;
    }

}
function searchTeam() {
    const queryInput = document.getElementById('query');
    const query = queryInput.value.toLowerCase();
    const errorDiv = document.getElementById('error'); 

    const teamMembers = [
        { name: 'Aaron Angelo Aquino', link: 'aaron/aaron.html' },
        { name: 'Aljon Nuestro', link: 'aljon/aljon.html' },
        { name: 'Jacob Alocon', link: 'jacob/jacob.html' },
        { name: 'Ira Christine Catapia', link: 'ira/ira.html' },
        { name: 'Rafael Cena', link: 'rafael/rafael.html' }
    ];
    errorDiv.innerHTML = '';
    const member = teamMembers.find(member => member.name.toLowerCase() === query);

    if (member) {
        
        window.location.href = member.link;
    } else {
        
        errorDiv.innerHTML = 'No team member found. Please try again.'; 
        queryInput.value = '';
        queryInput.focus();
    }

    return false; 
}


function fetchTeamMembers() {
    fetch('api.php')
        .then(response => response.json())
        .then(data => {
            const resultsContainer = document.getElementById('teamMembers');
            resultsContainer.innerHTML = '';
            
            data.forEach(member => {
                resultsContainer.innerHTML += `
                    <div class='box'>
                        <img src='${member.image}' alt='${member.name}'>
                        <h3><a href='${member.link}'>${member.name}</a></h3>
                        <p>${member.desc}</p>
                    </div>`;
            });
        })
        .catch(error => {
            console.error('Error fetching team members:', error);
        });
}

window.onload = function() {
    const username = getCookie('username');
    const hasSeenPopup = sessionStorage.getItem('hasSeenPopup');  

    console.log('Username cookie:', username);
    console.log('Has Seen Popup:', hasSeenPopup); 

    
    if (username && !hasSeenPopup) {
        const userLanguage = navigator.language || navigator.userLanguage; 
        let welcomeMessage;

        if (userLanguage.startsWith('es')) {  
            welcomeMessage = `¡Bienvenido, ${username}!`;
        } else {
            welcomeMessage = `Welcome, ${username}!`;  
        }

        document.getElementById('welcomeMessage').textContent = welcomeMessage;
        document.getElementById('welcomePopup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';

        
        sessionStorage.setItem('hasSeenPopup', 'true');
    }
};


function getCookie(name) {
    let cookieArr = document.cookie.split(';');
    for (let i = 0; i < cookieArr.length; i++) {
        let cookie = cookieArr[i].trim();
        if (cookie.startsWith(name + '=')) {
            return cookie.substring(name.length + 1);
        }
    }
    return null;
}


function closePopup() {
    document.getElementById('welcomePopup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}