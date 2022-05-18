@extends('home')

@section('content')
<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
    <div class="col mb-5">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="text-center" name="sess" id="idSess">
                    @foreach ($listaFilmes as $sess)
                        <option value="{{$sess->id}}" {{$filmes->id == $sess->id ? 'selected' : ''}}>
                            {{$sess->data}} - {{$sess->horario_inicio}}
                        </option>
                    @endforeach
                    
                </div>
            </div>
            <!-- Product actions-->
            
        </div>
        </div>
    </div>
    <div>
</div>
@endsection