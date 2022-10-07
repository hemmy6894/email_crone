<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emails</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            margin-top: 20px;
        }

        .chat-online {
            color: #34ce57
        }

        .chat-offline {
            color: #e4606d
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            max-height: 800px;
            overflow-y: scroll
        }

        .chat-message-left,
        .chat-message-right {
            display: flex;
            flex-shrink: 0
        }

        .chat-message-left {
            margin-right: auto
        }

        .chat-message-right {
            flex-direction: row-reverse;
            margin-left: auto
        }

        .py-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .flex-grow-0 {
            flex-grow: 0 !important;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }
    </style>
</head>

<body>

    <main class="content">
        <div class="container p-0">

            <h1 class="h3 mb-3">Messages</h1>

            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-lg-5 col-xl-3 border-right">

                        <div class="px-4 d-none d-md-block">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control my-3 searching" placeholder="Search...">
                                </div>
                            </div>
                        </div>
                        <div class="emails"></div>
                        <hr class="d-block d-lg-none mt-1 mb-0">
                    </div>
                    <div class="col-12 col-lg-7 col-xl-9 results"></div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        $(document).on("click", ".sendMessage", function() {
            var data = {
                message: $(this).siblings(".message").val(),
                email: $(this).siblings(".mail").val(),
            }
            $.ajax({
                url: "{{ route('post-email') }}",
                type: 'POST',
                data: data,
                success: function(response) {
                    $(".class_"+$(this).siblings(".mail").val()).click();
                }
            })
        });
    </script>
    <script>
        function clicked(link) {
            $.ajax({
                url: link,
                type: 'GET',
                success: function(response) {
                    $(".results").html(response);
                }
            })
        }

        function getEmails(data = {}) {
            link = "{{ route('mails') }}";
            $.ajax({
                url: link,
                type: 'GET',
                data: data,
                success: function(response) {
                    $(".emails").html(response);
                    $(".first_convo").click();
                }
            })
        }

        $(".searching").on("input", function() {
            var search = $(this).val();
            getEmails({
                search: search
            });
        });

        $(document).ready(function() {
            getEmails();
        });
    </script>
</body>

</html>