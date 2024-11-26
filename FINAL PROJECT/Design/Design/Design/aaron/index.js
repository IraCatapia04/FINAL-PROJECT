document.addEventListener("DOMContentLoaded", () => {
    const iconLinks = document.querySelectorAll('.icon-container a');
    iconLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            const confirmAction = confirm("Are you sure you want to click this link?");  
            if (!confirmAction) {
                event.preventDefault();
            }
        });
    });
});
