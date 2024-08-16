// scripts.js
document.getElementById('registration-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    let valid = true;
    let errorMessage = '';

    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (username.length < 3) {
        valid = false;
        errorMessage += 'Username must be at least 3 characters long.\n';
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        valid = false;
        errorMessage += 'Please enter a valid email address.\n';
    }

    if (password.length < 6) {
        valid = false;
        errorMessage += 'Password must be at least 6 characters long.\n';
    }

    if (valid) {
        this.submit();
    } else {
        alert(errorMessage);
    }
});

// scripts.js
document.addEventListener('DOMContentLoaded', function() {
    fetch('get_recipes.php')
        .then(response => response.json())
        .then(recipes => {
            const recipeList = document.getElementById('recipe-list');
            recipes.forEach(recipe => {
                const recipeDiv = document.createElement('div');
                recipeDiv.className = 'recipe';
                recipeDiv.innerHTML = `
                    <h2>${recipe.title}</h2>
                    <p>${recipe.ingredients}</p>
                    <p>${recipe.instructions}</p>
                `;
                recipeList.appendChild(recipeDiv);
            });
        });
});
