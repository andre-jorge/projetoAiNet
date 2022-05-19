@extends('home')

@section('content')

<div class="card h-100">
    <div class="card-body p-10">
        <div class="text-center">
            @foreach ($Filme as $filme)
            <div class="card h-100">
                <!-- Product image-->
                <img class="card-img-top" src="/storage/cartazes/{{$filme->cartaz_url}}" alt="..." />
            </div>
            <h5 class="fw-bolder"><?= $filme->titulo ?></h5>
            @endforeach
            <table>
                @foreach ($listaSessoes as $sessao)
                <td>    
                    <h5 class="fw-bolder"><?= $sessao->data ?></h5>
                </td>
                @endforeach
            </table>  
        </div>
    </div>
</div>
@endsection