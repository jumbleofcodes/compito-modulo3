@extends('app')

@section('content')
        <nav class="navbar">
            <div class="navbar__inner">
                <span class="material-icons"  style="font-size:24px;">person</span>
                <label class="user"></label><br>

                <input class="_evt-new-post" style="background-color: #ff9757" onClick="window.location.href='/posts/create'" type="submit" value="Add new post">
                <input class="_evt-logout" style="background-color: #ff9757" type="submit" value="Logout">
            </div>
        </nav>
        <div class="feed-container">
            <div class="_evt-spinner loader">Loading...</div>
            <div class="feed"></div>
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
                        $(".user").append(`<label>${user}</label>`);
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
                                        <strong>${title}</strong><br>${description}
                                    </div>
                                    <div class="tagged-users">${users}</div>

                                    <div class="table-actions">
                                        <input class="_evt-edit-post-${item.id}" onClick="location.href='/posts/${item.id}/edit'" type="submit" value="Edit">
                                        <input class="_evt-destroy-post-${item.id}" type="submit" value="Delete">
                                    </div>
                                </div><br>
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
