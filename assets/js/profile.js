$(function () {

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    var jwt = getParameterByName('jwt');
    console.log(jwt);

    if (jwt !== null) {

        // fetch data
        $.ajax({
            url: './user/get',
            type: 'GET',
            data: {
                jwt: jwt
            },
            success: function (data) {

                console.log(data);

                if (data.status === 'success') {

                    data = data.data;

                    var html =
                        "<p>ID: " + data.id + "</p>" +
                        "<p>Email: " + data.email + "</p>" +
                        "<p>First name: " + data.firstname + "</p>" +
                        "<p>Last name: " + data.lastname + "</p>" +
                        "<p>Created: " + data.created + "</p>" +
                        "<p>Last modified: " + data.lastmodified + "</p>";
                    $("#result").html(html);
                }
                else {
                    var html = "<p class='alert alert-danger'>" + data.status + ": " + data.message + "</p>";
                    $("#result").html(html);
                }
            }
        });

    } else {
        $("#result").html("<p class='alert alert-danger'>error: JWT Missing</p>");
    }
});