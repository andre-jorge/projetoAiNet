@extends('home')

@section('content')
<html>
    <head>
    <link href="{{asset("/css/lugares.css")}}" rel="stylesheet" />

        <script>
            var EMPTY = 0; // Still available for reservation and purchase.
            var RESERVED = 1; // reserved but not yet paid for.
            var BOUGHT = 2; // bought and paid for.

            const alfabeto = new Map();
                alfabeto.set('A',0);
                alfabeto.set('B',1);
                alfabeto.set('C',2);
                alfabeto.set('D',3);
                alfabeto.set('E',4);
                alfabeto.set('F',5);
                alfabeto.set('G',6);
                alfabeto.set('H',7);
                alfabeto.set('I',9);
                alfabeto.set('J',10);
                alfabeto.set('K',11);
                alfabeto.set('L',12);
                alfabeto.set('M',13);
                alfabeto.set('N',14);

                var lugares = JSON.parse("{{ json_encode($lugaresOcupados) }}");

            

            function Point(x,y) {
                return { X: x, Y: y }
            }
            function Size(w,h) {
                return {Width: w, Height: h}
            }
            function Rectangle(left,top,width,height) {
                return {TopLeft: Point(left,top), Size: Size(width,height)}
            }
            function seatColorFromSeatStatus(seatStatus) {
                switch(seatStatus) {
                    case EMPTY: return "white";
                    case RESERVED: return "green";
                    case BOUGHT: return "red";
                    default: return "black"; // Invalid value...
                }
            }
            function mapSeatStatusToSeatColor(seats)
            {
                var result = {};
                for(seat in seats) {
                    result[seat] = seatColorFromSeatStatus(seats[seat])
                }
                return result;
            }
            function seatKeyFromPosition(row,col) {
                return JSON.stringify([row,col]);
            }
            function seatRowFromKey(key) {
                return (JSON.parse(key))[0];
            }
            function seatColFromKey(key) {
                return (JSON.parse(key)[1]);
            }
            function getSeatInfo(nrows,ncolumns) {
                var result = { NRows: nrows, NColumns: ncolumns, Seats : {} };
                
                for(row = 0; row < nrows; row++) {
                    for( col = 0; col < ncolumns; col++ ) {                    
                        if(alfabeto.get('lugares') == row && lugares == col ){
                            result.Seats[seatKeyFromPosition(row ,(col-1))] = EMPTY
                        }
                        else{
                            result.Seats[seatKeyFromPosition(row ,(col))] = EMPTY
                        }                     
                        
                        
                    }
                }

                
                //result.Seats[seatKeyFromPosition(0,0)] = RESERVED;
                //result.Seats[seatKeyFromPosition(0,1)] = RESERVED;
                //result.Seats[seatKeyFromPosition(1,3)] = BOUGHT;
                //Valida tenho de dar reservado
                return result;
            }
            function renderSeat(ctx,r,fillColor) {
                var backup = ctx.fillStyle;
                ctx.strokeStyle = "blue";
                ctx.rect(r.TopLeft.X+2,r.TopLeft.Y+2,r.Size.Width-4,r.Size.Height-4);
                ctx.stroke();
                ctx.fillStyle = fillColor;
                ctx.fillRect(r.TopLeft.X+3,r.TopLeft.Y+3,r.Size.Width-5,r.Size.Height-5);
                ctx.fillStyle = backup;
            }
            function renderSeatplan(seatInfo) {
                var nrows = seatInfo.NRows;
                var ncolumns = seatInfo.NColumns;
                var seatColors = mapSeatStatusToSeatColor(seatInfo.Seats)
                var canvas = document.getElementById("seatplan");
                var ctx = canvas.getContext("2d");

                var borderWidth = 10;
                var rcContent = Rectangle(
                    borderWidth
                    , borderWidth
                    , canvas.width - 2 * borderWidth
                    , canvas.height - 2 * borderWidth
                );
                var szCell = Size(
                    Math.floor(rcContent.Size.Width / (ncolumns + 1))
                    , Math.floor(rcContent.Size.Height / (nrows + 1))
                );
                ctx.font = "30px Arial";

               

                for(row = -1; row < nrows; row++) {
                    for(col = -1; col < ncolumns; col++ ) {
                        var r = Rectangle(
                            rcContent.TopLeft.X + szCell.Width * (col+1)
                            ,rcContent.TopLeft.Y + szCell.Height * (row+1)
                            ,szCell.Width
                            ,szCell.Height
                            );
                        var center = Point(szCell.Width / 2, szCell.Height / 2);
                        if (row == -1 && col == -1) {
                            // nothing to render.
                        }
                        else if(row == -1){
                            // render column headers as numbers...
                            ctx.fillStyle = "black";
                            ctx.textAlign = "center";
                            ctx.fillText((col+1).toString(),r.TopLeft.X+center.X,r.TopLeft.Y+center.Y+6);
                        }
                        else if(col == -1){
                            // render row header
                            ctx.fillStyle = "black";
                            ctx.textAlign = "center";
                            ctx.fillText(String.fromCharCode(65 + row),r.TopLeft.X+center.X+4,r.TopLeft.Y+center.Y+6);
                        }
                        else
                        {
                            // render seat
                            renderSeat(ctx,r,seatColors[seatKeyFromPosition(row,col)]);
                        }
                    }
                }
            }
        </script>
    </head>
    
    <body onload="renderSeatplan(getSeatInfo({{$num_filas}},{{$num_pos}}));">
        <div class="container text-center">
            <h3 class="align-middle"><strong><h1 class="align-middle">Plano da Sala</h1></strong></h3>
        
        <div class="container text-center">
            <p><h4 class="align-middle" style="border-style: solid">Tela</h4>
            <canvas id="seatplan" width="640" height="480"></canvas>   
        </div>
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" action="{{ route('carrinho.store_sessao', $sessao)}}" method="POST">
        @csrf    
        <div class="row mb-2">
            <div class="col-sm-4 col-md-4">
                <!-- STRING -->
                <h5 class="align-middle"><strong><h5 class="align-middle">Lugar</h1></strong></h3>
            <!-- STRING --> 
            </div>
            <div class="col-sm-4 col-md-4">
                <!-- Tipo -->
                <select class="form-select" aria-label=".form-select-sm example" name="idlugar">
                    @foreach ($lugares as $lugar)
                        <option value="{{ $lugar->id }}">{{ $lugar->fila }} - {{$lugar->posicao}}</option>
                    @endforeach
                </select>
                <!-- Tipo -->
            </div> 
            <div class="col-sm-4 col-md-4 .ml-md-auto" >
                <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Adicionar ao Carrinho</button>
            </div>
        </div>
    </form>
    <a id="cart-link" href="{{ route('carrinho.index') }}" class="trsn nav-link" title="View/Edit Cart">Ir para o Carrinho</a>
    </body>
</html>
@endsection