@extends('app')

@section('content')

    <div class="content">
        <div class="flex flex-col">
            <h2>New post</h2>
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
                <input class="_evt-save" type="submit" value="Post it!">
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {

            $("._evt-back").click(function () {
                window.location = '/posts';
            });

            // Save new post event
            $("._evt-save").click(function () {
                $.ajax({
                    url: 'http://localhost:80/api/v1/posts',
                    method: 'POST',
                    headers: {
                        "Accept": "application/json",
                        "Content-type": "application/json",
                        "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                    },
                    data: JSON.stringify({
                        title: $("._evt-post-title").val(),
                        description: $("._evt-post-description").val(),
                    }),
                    success: function (response) {
                        window.location.href = '/posts';
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });

        });
    </script>

@endsection
