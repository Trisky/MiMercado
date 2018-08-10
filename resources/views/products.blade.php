<html>
<head>
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <link rel="script" href="{{ URL::asset('js/app.js') }}">
</head>
<body>

<div class="productsContainer">
    @foreach($products as $p)
        <div class="card p-3 m-3" style="width: 18rem;">
            <img class="card-img-top" src="{{$p->getFirstpicture()}}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{ $p->getTitle() }}</h5>
                <p class="card-text"><span class="font-weight-bold">${{$p->getPrice()}}</span> | {{$p->getShortDescription()}}</p>
                <a href="{{$p->getPermaLink()}}" class="btn btn-primary">Ver en Mercado Libre</a>
            </div>
        </div>
        {{--<div class="productTile">--}}
            {{--<p> producto:{{ $p->getTitle() }} </p>--}}
            {{--<p> precio: {{$p->getPrice()}}</p>--}}
            {{--<p> descripcion: {{$p->getDescription()}}</p>--}}
            {{--<p> estado: {{$p->getCondition()}}</p>--}}
            {{--<p> en venta?: {{$p->isProductEnabled()? 'si':'no'}}</p>--}}
            {{--<p> link: {{$p->getPermaLink()}}</p>--}}
            {{--@foreach($p->getPictures() as $i => $picture)--}}
                {{--<p>img{{$i}}: {{$picture}}</p>--}}
            {{--@endforeach--}}
        {{--</div>--}}
    @endforeach
</div>

</body>
</html>
