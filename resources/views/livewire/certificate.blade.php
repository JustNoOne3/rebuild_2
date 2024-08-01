<!DOCTYPE html>
<html lang="en">
<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/custom/cert.css') }}" rel="stylesheet">
    <title>Establishment Certificate</title>
    <style>    </style>
</head>
<body>
    <div class="cont-img container mx-auto">
        <img class="cert-img drop-shadow-2xl" src="{{asset('certs/est_cert.png')}}" alt="">
        <div class="text-div"  >
            <p class="est_name">{{$this->est_name}}</p>
            <p class="est_address">{{$this->est_address}}</p>
            <p class="est_certdate">Given this {{$this->day}}th day of {{$this->month}} {{$this->year}},<br> {{$this->province}}, {{$this->region}}.</p>
        </div>
    </div>
    @livewireScripts
    
</body>
</html>