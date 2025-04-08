$(document).ready(function () {

    $.validator.addMethod("PASSWORD", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/i.test(value);
    }, "Passwords are 8-16 characters with uppercase letters, lowercase letters and at least one number.");

    $('#registerForm').validate({ 
        rules: {
            firstName: {
                required: true
            },
            lastName: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: "required PASSWORD",

            confirmPassword: {
                required: true,
                minlength: 5,
                equalTo: "#password"
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