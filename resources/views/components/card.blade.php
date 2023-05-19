{{-- <div {{$attributes->merge([
'class'=> 'container tile tile-body bg-light border border-dark-subtle rounded p-6 m-4'])}} 
class="card">
    <div class="card-header">{{ $header }}</div> 

    <div class="card-body">
       {{$slot}}
    </div>
</div> --}}

<div class="card text-dark bg-light my-4 p-5 rounded border border-dark-subtle">
    {{$slot}}
</div>

