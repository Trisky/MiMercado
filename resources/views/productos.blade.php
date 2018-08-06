<html>
<body>
@foreach($productos as $p)
    <p> producto:{{ $p->title }} </p>
    <p> precio: {{$p->price}}</p>
@endforeach
</body>
</html>