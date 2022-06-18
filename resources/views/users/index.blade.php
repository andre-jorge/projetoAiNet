@extends('home')

@section('content')  

<div class="card-header"><h3 class="text-center font-weight-light my-4">Dados Cliente</h3></div> 
    <div class="card-body">
            <form  enctype="multipart/form-data" action="{{route('users.edit')}}" method="GET">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="name" id="name" type="select" value="{{$clientes->name}}" placeholder="Nome">
                        @error('titulo')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idTitulo">Nome</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="nif" id="nif" type="select" value="{{$clientes->Cliente->nif}}" placeholder="NIF">
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idTitulo">NIF</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="tipo_pagamento" id="tipo_pagamento">
                                <option value="NENHUM" @if($clientes->Cliente->tipo_pagamento == null) selected @endif>NENHUM</option>
                                <option value="MBWAY" @if($clientes->Cliente->tipo_pagamento == 'MBWAY') selected @endif>MBWAY</option>
                                <option value="VISA" @if($clientes->Cliente->tipo_pagamento == 'VISA') selected @endif>VISA</option>
                                <option value="PAYPAL" @if($clientes->Cliente->tipo_pagamento == 'PAYPAL') selected @endif>PAYPAL</option>
                        </select>
                        @error('dados_pagamento')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="filme_id">Modo Pagamento Default</label> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="foto_url" id="foto_url" type="file" value="{{$clientes->foto_url}}" placeholder="Foto">
                        @error('foto_url')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="foto_url">Foto/Avatar</label>
                    </div>
                </div>
            </div>            
            <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                    @if (Route::has('password.request'))
                        <a class="btn btn-primary" href="{{ route('password.request') }}">
                            {{ __('Alterar Password') }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="mt-4 mb-0">
                <div class="d-grid">
                    <button class="btn btn-primary btn-block" type="submit">Concluido</button>
                </div> 
                </form>
            </div>          
        </div>
    </div>
     

@endsection