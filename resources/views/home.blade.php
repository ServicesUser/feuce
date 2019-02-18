@extends('template.usuario')
@section('titulo',"Ingresar")
@section('cuerpo')
    @component('componentes.usuario.cabecera')
    @endcomponent
    <div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="m-content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">Dashboard</div>

                                <div class="card-body">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    You are logged in!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('componentes.usuario.pie')
    @endcomponent
@endsection
