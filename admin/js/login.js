$(document).ready(function () {
    $('#loginForm').validate({ // initialize the plugin
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