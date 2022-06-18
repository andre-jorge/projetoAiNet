<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <title>CineMagic</title>
      <link href="{{asset("/css/styles.css")}}" rel="stylesheet" />
      <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
   </head>
   <body>
      <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
         <!-- Navbar Brand-->
         <img class="rounded" style="max-height: 50px; max-width: 50px;" src="/storage/CineMagic.png" alt="..." />
         <a class="navbar-brand ps-3" href="/">CineMagic</a>
         <!-- Sidebar Toggle-->
         <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
         <!-- Navbar-->
         <ul class="navbar-nav ms-auto">
            @if(Auth::guest() or Auth::user()->tipo == 'C')
            <li class="nav-item">
               <a id="cart-link" href="{{ route('carrinho.index') }}" class="trsn nav-link" title="View/Edit Cart">
                  @csrf                            
                  <!-- Authentication Links -->
                  <i class="fas fa-shopping-cart"></i>
                  <span id="nav-bar-cart">
                  <span class="cart-size"> 
                  {{ session()->get('countInt') ?? 0}}
                  </span> 
                  Bilhete(s) | € {{ number_format(session()->get('total'),2, '.', ',') ?? 0}}</span>
               </a>
            </li>
            @endif
            @guest
            @if (Route::has('login'))
            <li class="nav-item">
               <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @endif
            @if (Route::has('register'))
            <li class="nav-item">
               <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
            @endif
            @else 
            <li class="nav-item dropdown">
               <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
               {{ Auth::user()->name }}
               <img class="rounded" style="max-height: 25px; max-width: 25px;" src="/storage/fotos/{{ Auth::user()->foto_url ?? 'default-profile.png'}}" alt="..." />
               </a>
               <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  @if(Auth::user()->tipo == 'C' )
                  <a class="dropdown-item" href="{{ route('users.index' ) }}">
                  Dados Cliente 
                  {{-- {{ route('user.index', $userid=Auth::user()->id ) }} --}}
                  </a>
                  <a class="dropdown-item" href="{{ route('users.recibos') }}">
                  Historico de Recibos 
                  {{-- {{ route('users.recibos') }} --}}
                  </a> 
                  @endif    
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                  </form>
               </div>
            </li>
            @endguest
         </ul>
      </nav>
      <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
         <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
               <div class="nav">
                  <div class="sb-sidenav-menu-heading">Em Exibição</div>
                  <a class="nav-link" href="/">
                     <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                     Filmes em Exibição
                  </a>
                  @can('viewAny', App\Models\Filme::class)							
                  <!-- <div class="sb-sidenav-menu-heading">Estatisticas</div>
                     <a class="nav-link" href="index.html">
                         <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                         Estatisticas
                     </a> -->
                  <div class="sb-sidenav-menu-heading">Admin</div>
                  <a class="nav-link" href="{{route('filmes.admin')}}">
                     <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                     Filmes
                  </a>
                  <a class="nav-link" href="{{route('salas.index')}}">
                     <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                     Salas
                  </a>
                  <a class="nav-link" href="{{route('configuracao.index')}}">
                     <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                     Preço Bilhetes
                  </a>
                  <a class="nav-link" href="{{route('users.admin')}}">
                     <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                     Clientes
                  </a>
                  <a class="nav-link" href="{{route('users.funcionarios.index')}}">
                     <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                     Funcionarios
                  </a>
                  <a class="nav-link" href="{{route('pdf.indexRecibo')}}">
                     <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                     Recibos Clientes
                  </a>  
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Estatisticas
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                {{--<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Salas
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    
                                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="">Salas</a>
                                            <a class="nav-link" href="">Lugares</a>
                                        </nav>
                                    </div> 
                                    --}}
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Totais
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{route('estatisticas.totais.diarios')}}">Diario</a>
                                            <a class="nav-link" href="{{route('estatisticas.totais.mensal')}}">Mensal</a>
                                            <a class="nav-link" href="{{route('estatisticas.totais.anual')}}">Anual</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>                
                  @endcan
                  @can('viewFuncionario', App\Models\Filme::class)		
                  <div class="sb-sidenav-menu-heading">Funcionarios</div>
                  <a class="nav-link" href="{{route('sessoes.funcionario.index')}}">
                     <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                     Validar Sessões
                  </a>
                  <!-- <a class="nav-link" href="#">
                     <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                     Sessões Validadas
                  </a> -->
                  @endcan
               </div>
            </div>
            <div class="sb-sidenav-footer">
               <div class="small">Sobre Nós</div>
            </div>
         </nav>
      </div>
      <div id="layoutSidenav_content">
         <div class="left-content">
            @if (session('alert-msg'))
            <div class="alert alert-{{ session('alert-type') }}">
               <span class="closebtn"
                  onclick="this.parentElement.style.display='none';">&times;</span>
               <span>{{ session('alert-msg') }}</span>
            </div>
            @endif
            @yield('content')
            <!-- <footer class="py-4 bg-light mt-auto">
               <div class="container-fluid px-4">
                   <div class="d-flex align-items-center justify-content-between small">
                       <div class="text-muted">Copyright &copy; Your Website 2022</div>
                       <div>
                           <a href="#">Privacy Policy</a>
                           &middot;
                           <a href="#">Terms &amp; Conditions</a>
                       </div>
                   </div>
               </div>
               </footer> -->
         </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
      <script src="js/scripts.js"></script>
      @yield('footer-scripts')
   </body>
</html>