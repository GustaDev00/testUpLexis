@extends('layouts.app')

@section('content')
<div class="container">
    @if ($boolean)
    @foreach ($data as $total)
    <div class="card mb-3">
        <div class="row align-items-center d-flex justify-content-flex-center">
            <div class="col">
                <img src="{{ $total->img_veiculo }}" class="rounded w-50 m-3" alt="{{ $total->nome_veiculo }}">
            </div>
            <div class="col">
                <h2 class="mr-4 mt-4"><a href="{{ $total->link }}">{{ $total->nome_veiculo }}</a></h2>
                <dl class="row mt-2">
                    <dt class="col-sm-3">Ano: </dt>
                    <dd class="col-sm-9">{{ $total->ano }}</dd>

                    <dt class="col-sm-3">Combustível: </dt>
                    <dd class="col-sm-9">{{ $total->combustivel }}</dd>

                    <dt class="col-sm-3">Portas: </dt>
                    <dd class="col-sm-9">{{ $total->portas }}</dd>

                    <dt class="col-sm-3">Quilometragem: </dt>
                    <dd class="col-sm-9">{{ $total->quilometragem }}</dd>

                    <dt class="col-sm-3">Câmbio: </dt>
                    <dd class="col-sm-9">{{ $total->cambio }}</dd>

                    <dt class="col-sm-3">Cor: </dt>
                    <dd class="col-sm-9">{{ $total->cor }}</dd>
            </dl>
            </div>
        </div>
    </div>
    @endforeach

    @else
    <script>
        alert("Não foi encontrado");
    </script>
    @endif

</div>
@endsection
