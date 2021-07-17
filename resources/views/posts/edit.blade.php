@extends('app')

@section('content')
    <div class="content shadow bg-white rounded-lg h-18">
        <input type="hidden" class="_evt-id" value="{{ $id }}">
        <div class="flex flex-col">
            <h2>Edit post</h2>
            <div class="custom-form">
                <label class="styled-label">
                    <small> Title</small>
                    <textarea class="_evt-post-title" style="resize: none"></textarea>
                </label>
                <label class="styled-label">
                    <small>Description</small>

                    <textarea class="_evt-post-description" style="resize: vertical" rows="5"> </textarea>
                </label>
            </div>
            <div class="table-actions">
                <input class="_evt-back" type="submit" value="Back">
                <input class="_evt-save" type="submit" value="Save">
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {


            let postId = $('._evt-id').val();
            let $postTitle = $('._evt-post-title');
            let $postDescription = $('._evt-post-description');

            $("._evt-back").click(function () {
                window.location = '/posts';
            });

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


