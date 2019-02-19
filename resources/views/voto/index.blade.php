@extends('template.usuario')
@section('titulo',"E-Voto")
@section('cuerpo')
    @component('componentes.usuario.cabecera')
    @endcomponent
    <div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="m-content">
                <div class="container">
                    <div class="row justify-content-center">
                        <menu-evoto></menu-evoto>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('componentes.usuario.pie')
    @endcomponent
@endsection