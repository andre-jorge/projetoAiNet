@extends('home')

@section('content')
<form action="{{ route('sessoes.admin.store') }}" id="sessoes-form" method="POST">
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Criar Sessao</h3></div>
    <div class="card-body">
    @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="nome" id="idnome" type="text" value="{{old('nome')}}" placeholder="Nome Sala"> 
                        @error('nome')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idnome">Nome Sala</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="nome" id="idnome" type="text" value="{{old('nome')}}" placeholder="Nome Sala"> 
                        @error('nome')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idnome">Nome Sala</label>
                    </div>
                </div>
            </div>  
            <div class="mt-4 mb-0">
                <div class="d-grid">
                    <button class="btn btn-primary btn-block" type="submit">Criar Sala</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- <div class="bt-area">
        <button type="submit" class="bt">Criar</button>
        <button type="reset" class="bt">Apagar</button>
    </div> -->
@endsection
