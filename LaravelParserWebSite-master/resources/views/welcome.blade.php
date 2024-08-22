<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars of Kolesa</title>
</head>
<body>
    <h1>{{ $pageTitle }}</h1>

    <ul>
        @foreach ($allCars as $car)
            <li>
                <strong>Марка:</strong> {{ $car['make'] }}<br>
                <strong>Цена:</strong> {{ $car['price'] }}<br>
                <strong>Краткое  описание:</strong> {{ $car['description'] }}<br>
            </li>
        @endforeach
    </ul>
</body>
</html>
