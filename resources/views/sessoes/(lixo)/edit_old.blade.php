@extends('home')

@section('content')

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Num. Recibo</th>
                    <th scope="col">Num. Cliente</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Filme</th>
                    <th scope="col">Sala</th>
                    <th scope="col">Data</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Fila</th>
                    <th scope="col">Posição</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($todasSessoes as $sessao)
                <form action="{{ route('sessoes.update', $sessao->bil) }}" id="salas-form" method="POST">
                    @csrf
                    @method('PUT')
                 
                <tr>
                    <td><?= $sessao->recibo_id ?></td>
                    <td><?= $sessao->horario_inicio ?></td>
                    <td><?= $sessao->estado ?></td>
                    <td><?= $sessao->filme_id ?></td>
                    <td><?= $sessao->nome ?></td>
                    <td><?= $sessao->data ?></td>
                    <td><?= $sessao->horario_inicio ?></td>
                    <td><?= $sessao->fila ?></td>
                    <td><?= $sessao->posicao ?></td>
                    <td>
                        <form type="post" action="{{ route('sessoes.update', $sessao->bil) }}">
                            <input type="submit"  class="btn btn-success btn-sm" value="Validar">
                        </form> 
                    </td>
                </tr>
                </form>
                @endforeach
            </tbody>
        </table>
        
           
@endsection