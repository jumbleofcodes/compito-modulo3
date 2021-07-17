@extends('app')

@section('content')
    <div class="external-container">
        <div class="card">
            <h2>Create new post</h2>
            <div class="post-content">
                <small>Title</small>
                <input type="text" class="_evt-post-title" placeholder="The title is important">

                <small>Description</small>
                <input type="text" class="_evt-post-description" placeholder="Write here anything you want :)">
            </div>

            <div class="button-container">
                <button class="_evt-save">Submit</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("._evt-back").show();
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
            // Back to previous page
            $("._evt-back").click(function () {
                window.location.href = '/posts';
            });
        });
    </script>

@endsection
