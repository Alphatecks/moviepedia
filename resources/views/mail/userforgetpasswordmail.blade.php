<!DOCTYPE html>
<html>

<body>
    <h1>{{ $mailData['subject'] }}</h1>

    <p>{{ $mailData['message'] }}</p>

     <p> {{$mailData['token']}} </p>

    <p>Thank you</p>
</body>

</html>
