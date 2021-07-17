@extends('app')

@section('content')
    <div class="content">
        <input type="hidden" class="_evt-id" value="{{ $id }}">
        <div class="flex flex-col">
            <h2>Update</h2>
            <div class="custom-form">
                <label class="styled-label">
                    <small> Title</small>
                    <input class="_evt-post-title" type="text">
                </label><br>
                <label class="styled-label">
                    <small>Description</small>
                    <input class="_evt-post-description" type="text">
                </label>
            </div>
            <div class="flex w-full justify-end mt-4">
                <button class="_evt-save">Save</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {


            let postId = $('._evt-id').val();
            let $postTitle = $('._evt-post-title');
            let $postDescription = $('._evt-post-description');

            //Get post
            $.ajax({
                url: `http://localhost:80/api/v1/posts/${postId}`,
                method: 'GET',
                headers: {
                    "Accept": "application/json",
                    "Content-type": "application/json",
                    "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                },
                success: function (response) {
                    if (response.hasOwnProperty('data')) {
                        $postTitle.val(response.data.title)
                        $postDescription.val(response.data.description)
                    }
                },
                error: function (error) {
                    console.error(error)
                }
            });


            // Save event
            $('._evt-save').click(function () {
                $.ajax({
                    url: `http://localhost:80/api/v1/posts/${postId}`,
                    method: 'PATCH',
                    headers: {
                        "Accept": "application/json",
                        "Content-type": "application/json",
                        "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                    },
                    data: JSON.stringify({
                        title: $postTitle.val(),
                        description: $postDescription.val(),
                    }),
                    success: function (response) {
                        window.location.href = "/posts";
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });

        });
    </script>
@endsection


