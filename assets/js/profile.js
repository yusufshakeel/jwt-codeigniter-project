/*!
 * Author: Yusuf Shakeel
 * Date: 13-April-2018 Fri
 * Version: 1.0
 *
 * File: profile.js
 * Description: This file contains the profile related js code.
 */
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

                    var jwt_payload = data.jwt_payload;

                    data = data.data;

                    var html =
                        "<p>ID: " + data.id + "</p>" +
                        "<p>Email: " + data.email + "</p>" +
                        "<p>First name: " + data.firstname + "</p>" +
                        "<p>Last name: " + data.lastname + "</p>" +
                        "<p>Created: " + data.created + "</p>" +
                        "<p>Last modified: " + data.lastmodified + "</p>" +
                        "<hr>" +
                        "<p>JWT Payload</p>" +
                        "<pre>" + JSON.stringify(jwt_payload, null, 2) + "</pre>" +
                        "<p>JWT Issued At: " + (new Date(jwt_payload.iat * 1000)) + "</p>" +
                        "<p>JWT Expiration Time: " + (new Date(jwt_payload.exp * 1000)) + "</p>";
                    $("#result").html(html);

                    var showAfterTSeconds = Number((jwt_payload.exp * 1000) - new Date().getTime());

                    setTimeout(function () {
                        var html = "<p class='alert alert-danger'>JWT Expired!</p>" +
                            "<p>Click the button below to return to home page.</p>" +
                            "<p>If you reload this page you will not see the profile detail as JWT has expired.</p>" +
                            "<a class='btn btn-primary' href='./'>Back to home</a> " +
                            "<a class='btn btn-outline-primary' href='./profile?jwt=" + jwt + "'>Reload</a> ";

                        $("#result").append(html);
                    }, showAfterTSeconds);
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