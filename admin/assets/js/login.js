$(document).ready(function () {
    $('#loginForm').validate({ 
        rules: {
            email: {
                required: true,
                email: true
            },
            password:{
                required: true,
                minlength: 8
            }
        },
        messages: {
            email: {
                required: "Email is required",
                email: " Please enter valid email"
            },
            
        }
    });
});