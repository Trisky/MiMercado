<html>
<body>
<div class="productsContainer">
    @foreach($products as $p)
        <p>===============</p>
        <div class="productTile">
            <p> producto:{{ $p->getTitle() }} </p>
            <p> precio: {{$p->getPrice()}}</p>
            <p> descripcion: {{$p->getDescription()}}</p>
            <p> estado: {{$p->getCondition()}}</p>
            <p> en venta?: {{$p->isProductEnabled()? 'si':'no'}}</p>
            <p> link: {{$p->getPermaLink()}}</p>
            @foreach($p->getPictures() as $i => $picture)
                <p>img{{$i}}: {{$picture}}</p>
            @endforeach
        </div>
    @endforeach
</div>

</body>
</html>
