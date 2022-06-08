@extends('home')
@section('content')
<input type="hidden" name="quantidade" value="{{$total=0}}">
<input type="hidden" name="quantidade" value="{{$quantidade=0}}">

<body class="bg-light" data-new-gr-c-s-check-loaded="14.1062.0" data-gr-ext-installed="">
<div class="container">
  <div class="py-5 text-center">
    {{--<img class="d-block mx-auto mb-4" src="/docs/4.5/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
    --}}<h2>Checkout</h2>
    <p class="lead">Preencha os campos abaixo para finalizar a compra dos seus Bilhetes</p>
  </div>

  <div class="row">
    <div class="col-md-6 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Carrinho Compras</span>
        <span class="badge badge-secondary badge-pill">3</span>
      </h4>
      <ul class="list-group mb-3">
      @foreach ($carrinho as $row)
      
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">{{ \Illuminate\Support\Str::limit($row['filme'], 15, $end='...') }}</h6>
            <h8 class="my-0">Lugar: {{ $row['lugar'] }} | </h8>
            <h8 class="my-0"> Fila:{{ $row['fila'] }}</h8>
            <br>
            <small class="text-muted">{{ $row['data'] }}</small>
            <small class="text-muted">{{ $row['horario_inicio'] }}</small>
            <br>
            <small class="text-muted">{{ $row['sala_id'] }}</small>
            <br>
            
          </div>
          <span class="text-muted">{{ $row['qtd'] }}</span>
          <span class="text-muted">{{ $row['preco'] }}</span>
          
          <span class="text-muted">
          <form action="{{route('carrinho.destroy_sessao', $row['qtd'])}}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="eleminar" id="eleminar" value="{{$row['qtd']}}" value="Remover">
                <input class="rounded" type="submit" value="Remover">
            </form>
          </span>
        </li>
        <input type="hidden" name="quantidade" value="{{$total = $total+$row['qtd']*$row['preco']}}">
        <input type="hidden" name="quantidade" value="{{$quantidade = $quantidade+$row['qtd']}}">
        @endforeach
        <div class="text-right">
          <h3 class="my-0">Total C/IVA: {{ $total }} </h3>
        </div>
      </ul>
      
    </div>
    <div class="col-md-6 order-md-1">
        <hr class="mb-4">
        <h4 class="mb-3">Pagamento</h4>

        <script>
            function show1(){
              document.getElementById('credit').style.display ='show;';
              document.getElementById('mbway').style.display ='none;';
              document.getElementById('paypal').style.display ='none;';
            }
            document.getElementById("paymentMethod").addEventListener("click", credit);
        </script>

        <!-- ESCOLHER METODO DE PAGAMENTO -->
        <div class="d-block my-3"> 
            <div class="custom-control custom-radio">
              <!-- <input type="radio" id="credit" name="paymentMethod"  value="credit" checked > -->
              <input type="radio" id="paymentMethod" name="paymentMethod" value="credit" onclick="show1(this)">
              <label class="custom-control-label" for="credit">Cartao Crédito</label>
            </div>
            <div class="custom-control custom-radio">
              <input type="radio" id="paymentMethod" name="paymentMethod" value="mbway"  >
              <label class="custom-control-label" for="debit">MBWAY</label>
            </div>
            <div class="custom-control custom-radio">
              <input type="radio" id="paymentMethod" name="paymentMethod" value="paypal"  >
              <label class="custom-control-label" for="paypal">PayPal</label>
            </div>
        </div>
        <!-- FIM ESCOLHER METODO DE PAGAMENTO -->
        
        
       
        <form action="{{ route('carrinho.store') }}" method="POST">
          @csrf
          
          <div id="credit">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cc-name">Nome Cartão Credito</label>
                <input type="text" class="form-control" name="cc-name" id="cc-name" placeholder="" required="">
                <small class="text-muted">Nome completo</small>
                <div class="invalid-feedback">
                  Nome do cartão obrigatorio
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="cc-number">Numero Cartão Credito</label>
                <input type="text" class="form-control" name="cc-number" id="cc-number" placeholder="" required="">
                <div class="invalid-feedback">
                  Numero do cartão obrigatorio
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="cc-expiration">Expiration</label>
                <input type="text" class="form-control" name="cc-expiration" id="cc-expiration" placeholder="" required="">
                <div class="invalid-feedback">
                  Data de Expiração obrigatoria
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="cc-cvv">CVV</label>
                <input type="text" class="form-control" name="cc-cvv" id="cc-cvv" placeholder="" required="">
                <div class="invalid-feedback">
                  CVV obrigatorio
                </div>
              </div>
            </div>
          </div>
          

          <div id="mbway">
            <p> CAMPO MBWAY</p>
          </div>
          
          <div id="paypal">
            <p> CAMPO PAYPAL</p>
          </div>

         

           

          
          
         
          <hr class="mb-10">
          <div class="row">
            <div class="col-md-3 mb-3">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Checkout</button>
              </form>
            </div>
            <div class="col-md-5 mb-3">
            <form action="{{ route('carrinho.destroy') }}" method="POST">
                @csrf
                @method("DELETE")
                <button class="btn btn-primary btn-lg btn-block" type="submit">Remover Tudo</button>
            </form>
          </form>

          

        </div>
    </div>
  </div>
</div>
  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">© 2022 CineMagic</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="form-validation.js"></script>

        

</body>




{{--<span class="text-muted">
          <form action="{{route('carrinho.update_sessao', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="1">
                <input class="rounded" type="submit" value="+1">
            </form>
          </span>
          <span class="text-muted">
          <form action="{{route('carrinho.update_sessao', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="-1">
                <input class="rounded" type="submit" value="-1">
            </form>
          </span>--}}



{{--
<div class="row mb-3">
    <div class="col-md-6" style="width: 500px;">
        <form action="{{ route('carrinho.destroy') }}" method="POST">
            @csrf
            @method("DELETE")
            <input type="submit" value="Apagar carrinho">
        </form>
    </div>   
    <div class="col-md-6" style="width: 500px;">
        <form action="{{ route('carrinho.store') }}" method="POST">
            @csrf
            <input type="submit" value="Confirmar carrinho">
        </form>
        </div>
</div>  
<div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Filme</th>
            <th>Quantidade</th>
            <th>Data</th>
            <th>Horario</th>
            <th>Sala ID</th>
            <th>Preço S/Iva</th>
            <th>Preço Total S/Iva</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($carrinho as $row)
    <tr>
        <td>{{ $row['filme'] }} </td>
        <td>{{ $row['qtd'] }} </td>
        <td>{{ $row['data'] }} </td>
        <td>{{ $row['horario_inicio'] }} </td>
        <td>{{ $row['sala_id'] }} </td>
        <td>{{ $row['preco'] }} </td>
        
        
        <td>
            <form action="{{route('carrinho.update_sessao', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="1">
                <input type="submit" value="Adicionar">
            </form>
        </td>
        <td>
            <form action="{{route('carrinho.update_sessao', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="-1">
                <input type="submit" value="Remover">
            </form>
        </td>
        <td>
            <form action="{{route('carrinho.destroy_sessao', $row['id'])}}" method="POST">
                @csrf
                @method('delete')
                <input type="submit" value="Remover Tudo">
            </form>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>
--}}
@endsection


