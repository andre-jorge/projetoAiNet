@extends('home')
@section('content')
<div>
  <p>
        <form action="{{ route('carrinho.destroy') }}" method="POST">
            @csrf
            @method("DELETE")
            <input type="submit" value="Apagar carrinho">
        </form>
  </p>
  <p>
        <form action="{{ route('carrinho.store') }}" method="POST">
            @csrf
            <input type="submit" value="Confirmar carrinho">
        </form>
  </p>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Quantity</th>
            <th>Data</th>
            <th>Horario</th>
            <th>Sala ID</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($carrinho as $row)
    <tr>
        <td>{{ $row['qtd'] }} </td>
        <td>{{ $row['data'] }} </td>
        <td>{{ $row['horario_inicio'] }} </td>
        <td>{{ $row['sala_id'] }} </td>
        <td>
            <form action="{{route('carrinho.update_sessao', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="1">
                <input type="submit" value="Increment">
            </form>
        </td>
        <td>
            <form action="{{route('carrinho.update_sessao', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="-1">
                <input type="submit" value="Decrement">
            </form>
        </td>
        <td>
            <form action="{{route('carrinho.destroy_sessao', $row['id'])}}" method="POST">
                @csrf
                @method('delete')
                <input type="submit" value="Remove">
            </form>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>

@endsection
