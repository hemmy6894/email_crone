<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emails</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="row">
        <div class="col-4 bg-secondary h100">
            <ul class="list-group">
                @foreach($charts as $chart)
                    @php($url = route("single_mail",["mail" => $chart->OriginalMail]))
                    <li class="list-group-item" onclick="clicked('{{ $url }}')">
                        {{ $chart->OriginalMail }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-8 bg-primary h100 results"></div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        function clicked(link){
            $.ajax(
                {
                    url : link,
                    type: 'GET',
                    success: function(response) {
                        $(".results").html(response);
                    }
                }
            )
        }
    </script>
</body>
</html>