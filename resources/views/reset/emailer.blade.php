<h1>~~~~~~~~~~~~~~~</h1>

<h2>###############</h2>
<br>
{{-- Intro Lines --}}
@foreach ($introLines as $line)
    line - {{ $line }}
@endforeach
<br>

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
    line - {{ $line }}
@endforeach



<br>

actionText - {{$actionText}}

<br>

actionUrl - {{ $actionUrl }}<br>


