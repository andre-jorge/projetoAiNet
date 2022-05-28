<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    </head>
    <body>
    
    <div src="/storage/cartazes/{{$bilhete->Sessao->Filmes->cataz_url}}">
        <h5>Data Recibo: {{$bilhete->Recibo->data}}</h5>
        <h5>NIF: {{$bilhete->Recibo->nif}}</h5>
        <h5>NomeCliente: {{$bilhete->Recibo->nome_cliente}}</h5>
        <h5>Sala: {{$bilhete->Sessao->Salas->nome}}</h5>
        <h5>Data Sessão: {{$bilhete->Sessao->data}}</h5>
        <h5>Filme: {{$bilhete->Sessao->Filmes->titulo}}</h5>
        <h5>Fila: {{$bilhete->Lugar->fila}}</h5>
        <h5>Posição: {{$bilhete->Lugar->posicao}}</h5>
        <h5>{{$bilhete->preco_sem_iva}}</h5>    
    </div> 
    </body>
</html>
