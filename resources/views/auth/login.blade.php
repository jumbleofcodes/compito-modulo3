@extends('app')

@section('content')
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
        <div class="mb-4">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
                Email
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="email"
                   type="text" value="admin@admin.it" placeholder="Email">
        </div>
        <div class="mb-6">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3"
                   id="password" value="password" type="password" placeholder="******************">
        </div><br>
        <div class="flex items-center justify-between">
            <button class="_evt-button-login"
                    type="button">
                Log in
            </button>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            const access_token = window.localStorage.getItem('access_token')

            if (access_token) {
                $.ajax({
                    url: 'http://localhost:80/api/v1/user',
                    method: 'GET',
                    headers: {
                        "Accept": "application/json",
                        "Content-type": "application/json",
                        "Authorization": `Bearer ${access_token}`,
                    },

                    success: function (response) {
                        // Check if has data
                        if (response.hasOwnProperty('data')) {
                            window.location = "posts";
                        }
                    },
                    error: function (error) {
                        window.localStorage.removeItem('access_token')
                    }
                });
            }

            // Attach login button event
            $("._evt-button-login").click(function () {
                let email = $("#email").val().trim();
                let password = $("#password").val().trim();

                let dataObject = {
                    email: email,
                    password: password
                };

                if (email !== "" && password !== "") {
                    $.ajax({
                        url: 'http://localhost:80/api/v1/login',
                        method: 'POST',
                        headers: {
                            "Accept": "application/json",
                            "Content-type": "application/json",
                        },
                        data: JSON.stringify(dataObject),
                        success: function (response) {
                            // Check if has data
                            if (response.hasOwnProperty('data')) {
                                window.localStorage.setItem('access_token', response.data.access_token)
                                window.location = "posts";
                            }
                        },
                        error: function (error) {
                            console.error(error)
                        }
                    });
                }
            });
        });
    </script>
@endsection


