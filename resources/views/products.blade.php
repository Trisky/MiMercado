<html>
<body>
<div class="productsContainer">
    @foreach($products as $p)
        <p>===============</p>
        <div class="productTile">
            <p> producto:{{ $p->getTitle() }} </p>
            <p> precio: {{$p->getPrice()}}</p>
        </div>
    @endforeach
</div>

</body>
</html>
