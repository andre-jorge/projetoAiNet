@extends('home')

@section('content')
<?php
$url = $FilmeDetalhes->trailer_url;
preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
$idmatches = $matches[1];
$width = '800px';
$height = '450px'; ?>

<div class="float-right">
<a class="btn btn-success" href="{{route('sessoes.index')}}">
<svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
</svg>
    <span id="items-in-cart">0</span> items in cart
</a>
</div>

  <div class="card h-300">
    <div class="text-center">
      <div class="card flex-md-row mb-4 box-shadow h-md-250">
        <img class="card-img-right flex-auto d-none d-md-block" src="/storage/cartazes/{{$FilmeDetalhes->cartaz_url}}" alt="Thumbnail [200x250]" style="width: 300px; height: 450px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22200%22%20height%3D%22250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20200%20250%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_180e6792552%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A13pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_180e6792552%22%3E%3Crect%20width%3D%22200%22%20height%3D%22250%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2256.1953125%22%20y%3D%22131%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
          <div class="card-body d-flex flex-column align-items-start">
            <h3 class="mb-0"><strong><h1 class="card-title"><?= $FilmeDetalhes->titulo ?></h1></strong></h3>
              <div class="mb-1 text-muted">Ano: <?= $FilmeDetalhes->ano ?></div>
              <div class="mb-1 text-muted">Genero: <?= $FilmeDetalhes->nome ?></div>
              <div class="mb-1 text-muted">Sumario: <?= $FilmeDetalhes->sumario ?></div>  
          </div>
      </div>     
      <h4>TRAILER</h4>
      <div class="text-center">
        <iframe id="ytplayer" type="text/html" width="<?php echo $width ?>" height="<?php echo $height ?>"
            src="https://www.youtube.com/embed/<?php echo $idmatches ?>?rel=0&showinfo=0&color=white&iv_load_policy=3"
            frameborder="0" allowfullscreen></iframe> 
      </div>
      <div class="text-center">
          <table class="table">
              <thead>
                  <tr>
                    <th scope="col">Dia Sessao</th>
                    <th scope="col">Hora</th>
                    <th scope="col">sala_id</th>
                    <th scope="col">Lugares Ocupados</th>
                    <th scope="col">Total Capacidade Sala</th>
                    <th scope="col">Comprar</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($sessoesFilme as $sessao)
                  <tr>
                    <td name="datafilme" value="<?= $sessao->data ?>"><?= $sessao->data ?></td>
                    <td name="horainicio" value="<?= $sessao->horario_inicio ?>"><?= $sessao->horario_inicio ?></td>
                    <td><?= $sessao->nome ?></td>
                    <td> 
                    @php echo App\Http\Controllers\SessoesController::ContaBilhetes($FilmeDetalhes->id,$sessao->data,$sessao->horario_inicio);  @endphp
                    </td>
                    <td>80</td>
                    <td><input type="number" value="0" min="0" max="50">
                    <button class="add-to-cart" type="submit" href="{{route('cart.index')}}" class="btn btn-sm btn-outline-secondary" 
                            data-id="{{$sessao->id}}" data-name="{{$sessao->filme_id}}" data-price="{{$sessao->sala_id}}">Add to Cart</button></td>
                  </tr>
                  @endforeach
              </tbody>
              
      </div>
                  
  </div>
    </div>

@endsection
@section('footer-scripts')
<script>
    $(document).ready(function() {

        window.cart = <?php echo json_encode($cart) ?>;

        updateCartButton();

        $('.add-to-cart').on('click', function(event){

            var cart = window.cart || [];
            cart.push({'id':$(this)data('id'), 'name':$(this).data('name'), 'price':$(this).data('price'), 'qty':$(this).prev('input').val()});
            window.cart = cart;

            $.ajax('/store/add-to-cart', {
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", "cart":cart},
                success: function (data, status, xhr) {

                }
            });

            updateCartButton();
        });
    })

    function updateCartButton() {

        var count = 0;
        window.cart.forEach(function (item, i) {

            count += Number(item.qty);
        });

        $('#items-in-cart').html(count);
    }
</script>
@endsection