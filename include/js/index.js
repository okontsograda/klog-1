



// If the forgot login link is clicked, change login form to style="display:none;"
// and set reset form to style="display:block"
$(document).ready(function() {
    $(".footer-link").click(function() {
        $("#loginForm, #resetForm").toggle();
    });

    $(".register").click(function() {
        $("#register, #loginForm").toggle();
    });
});



function switchPasswordReset() {
    var loginForm   = document.getElementById('loginForm');
    var resetForm   = document.getElementById('resetForm');

    if ( loginForm ) {
        console.log("login form is visible");
    } else {
        console.log("login form is NOT visible");
    }
}


const form          =   document.getElementById('login-form');
const errorDiv      =   document.getElementById('login-error-message');

const username      =   document.getElementById('username');
const password      =   document.getElementById('password');

form.addEventListener('submit', (e) => {
    let errorMessage = [];

    // Check if the password was entered and make sure it wasn't empty
    if ( password.value === '' || password === null ) {
        errorMessage.push("Please enter a password");
    } else {
        // Check if the password is shorter or equal to 6 characters
        if (password.value.length <= 6) {
            errorMessage.push("Password is too short");
        } else {
            // Check if the password is longer that 16 characters
            if ( password.value.length >= 16 ) {
                errorMessage.push("Passowrd is too long");
            }
        }
    }

    // If we have messages in the error dataset, then we'll add them to the corresponding div
    // to show on the login page and inform the user what needs to be done.
    if ( errorMessage.length > 0 ) {
        e.preventDefault();
        // Set the innerText of the div placeholder for the error message and join the messages
        // with a carraige return (new line)
        errorDiv.innerText = errorMessage.join('\n');
    }

});