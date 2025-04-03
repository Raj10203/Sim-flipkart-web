$(document).ready(function () {
    $.validator.addMethod("PASSWORD",function(value,element){
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/i.test(value);
    },"Passwords are 8-16 characters with uppercase letters, lowercase letters and at least one number.");

    $('#loginForm').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true
            },
            password: "required PASSWORD",
        },
        messages: {
            email: {
                required: "Email is required",
                email: " Please enter valid email"
            },
            password: {
                required: "Password can not be empty",
                pattern: "Password must have at least one uppercase, lowercase, number and special character!",
                minlength: "Password must have minimum 8 character",
                maxlength: "Password must have maximum 64 character",
            }
        }
    });
});