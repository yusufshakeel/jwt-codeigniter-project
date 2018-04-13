$(function () {

    // signup
    $("#signup").on("submit", function (e) {

        var formEl = $(this),
            data = {};

        data.email = $("#email").val();
        data.password = $("#password").val();
        data.firstname = $("#firstname").val();
        data.lastname = $("#lastname").val();

        $.ajax({
            url: 'user/signup',
            type: 'POST',
            data: JSON.stringify(data),
            success: function (data) {
                if (data.status === 'success') {
                    var html = "<div class='alert alert-success alert-dismissible fade show' role='alert'>" +
                        data.message +
                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
                        "<span aria-hidden='true'>&times;</span>" +
                        "</button>" +
                        "</div>";
                    $("#signup-msg").html(html);

                    formEl[0].reset();
                }
                else {
                    var html = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" +
                        data.message +
                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
                        "<span aria-hidden='true'>&times;</span>" +
                        "</button>" +
                        "</div>";
                    $("#signup-msg").html(html);
                }
            },
            error: function () {
            }
        });

        return false;
    });

    // login
    $("#login").on("submit", function (e) {

        var formEl = $(this),
            data = {};

        data.email = $("#login-email").val();
        data.password = $("#login-password").val();

        $.ajax({
            url: 'user/login',
            type: 'POST',
            data: JSON.stringify(data),
            success: function (data) {
                if (data.status === 'success') {
                    window.location = './profile?jwt=' + data.jwt;
                }
                else {
                    var html = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" +
                        data.message +
                        "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
                        "<span aria-hidden='true'>&times;</span>" +
                        "</button>" +
                        "</div>";
                    $("#login-msg").html(html);
                }
            },
            error: function () {
            }
        });

        return false;
    });
});