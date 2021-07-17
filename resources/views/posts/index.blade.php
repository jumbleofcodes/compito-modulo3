@extends('app')

@section('content')
    <nav class="navbar">
        <div class="navbar__inner">
            <div class="user"></div>
            <button class="_evt-new-post" onClick="window.location.href='/posts/create'">Add new post</button>
            <button class="_evt-logout">Logout</button>
        </div>

    </nav>
    <div class="external-container">
        <div class="_evt-spinner loader">Loading...</div>
        <div class="feed">
        </div>
    </div>

    <script>
        $(document).ready(function () {

            let $spinner = $('._evt-spinner');

            //Get username
            $.ajax({
                url: 'http://localhost:80/api/v1/user',
                method: 'GET',
                headers: {
                    "Accept": "application/json",
                    "Content-type": "application/json",
                    "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                },
                success: function (response) {
                    if (response.hasOwnProperty('data')){
                        let user = response.data.name;
                        $(".user").append(`<div> ${user} </div>`);
                    }
                },
                error: function (error) {
                    console.error(error);
                }
            });

            //Get posts
            $.ajax({
                url: 'http://localhost:80/api/v1/posts',
                method: 'GET',
                headers: {
                    "Accept": "application/json",
                    "Content-type": "application/json",
                    "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                },
                success: function (response) {
                    if (response.hasOwnProperty('data')) {
                        response.data.forEach(function (item) {
                            let title = item.title;
                            let description = item.description != null ? item.description : '' ;
                            let users = '';
                            if(item.tagged_users != null) {
                                users = "Tags: ";
                                item.tagged_users.forEach(function (user){
                                    users = users + user.name + " ";
                                });
                            }

                            $("._evt-logout").show();

                            $('.feed').append(`
                                <div class="card">
                                    <div class="post-content">
                                        <strong>${title}</strong><br>
                                        ${description}
                                    </div>
                                    <div class="tagged-users">
                                        ${users}
                                    </div>
                                    <div class="button-container">
                                        <button class="_evt-edit-post-${item.id}" onClick="location.href='/posts/${item.id}/edit'">Edit</button>
                                        <button class="_evt-destroy-post-${item.id}">Delete</button>
                                    </div><br>
                                </div>
                            `);

                            $spinner.hide()

                            // Delete post event
                            $(`._evt-destroy-post-${item.id}`).click(function () {
                                $.ajax({
                                    url: `http://localhost:80/api/v1/posts/${item.id}`,
                                    method: 'DELETE',
                                    headers: {
                                        "Accept": "application/json",
                                        "Content-type": "application/json",
                                        "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                                    },
                                    success: function (response) {
                                        $spinner.hide()
                                        window.location = "posts";
                                    },
                                    error: function (error) {
                                        alert("Cannot delete this post!");
                                    }
                                });
                            });

                        });
                    }
                },
                error: function (error) {
                    console.error(error);
                }
            });

            //Logout event
            $("._evt-logout").click(function () {
                $.ajax({
                    url: 'http://localhost:80/api/v1/logout',
                    method: 'POST',
                    headers: {
                        "Accept": "application/json",
                        "Content-type": "application/json",
                        "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                    },
                    success: function (response) {
                        window.localStorage.removeItem('access_token');
                        window.location = "login";
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });

        });
    </script>

@endsection
