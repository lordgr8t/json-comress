<?php


$yourData = [
    "users" => []
];

// Генерируем 10000 пользователей для тестирования
for ($i = 1; $i <= 10000; $i++) {
    $yourData["users"][] = [
        "id" => $i,
        "name" => "User $i",
        "email" => "user$i@example.com",
        "age" => rand(18, 70),
        "address" => [
            "street" => "Street " . rand(1, 100),
            "city" => "City " . rand(1, 50),
            "country" => "Country " . rand(1, 10)
        ],
        "isActive" => rand(0, 1) === 1,
        "registrationDate" => date('Y-m-d', strtotime("-" . rand(0, 365) . " days"))
    ];
}

// Преобразование данных в формат JSON
$data = json_encode($yourData);

// Сохранение исходного JSON в файл
$filePath = 'data.json';
file_put_contents($filePath, $data);

// Получение размера исходного файла
$originalSize = filesize($filePath);
echo "Размер исходного файла: " . $originalSize . " байт\n";
echo "<br>";
echo "<br>";

// Сжатие данных
$compressedData = gzencode($data);

// Сохранение сжатых данных в файл
$compressedFilePath = 'data.json.gz';
file_put_contents($compressedFilePath, $compressedData);

// Получение размера сжатого файла
$compressedSize = filesize($compressedFilePath);
echo "Размер сжатого файла: " . $compressedSize . " байт\n";
echo "<br>";
echo "<br>";

// Вычисление степени сжатия
$compressionRatio = round((1 - ($compressedSize / $originalSize)) * 100, 2);
echo "Сжатие: " . $compressionRatio . "%\n";
echo "<br>";
echo "<br>";

// Чтение из сжатого файла
$compressedDataFromFile = file_get_contents($compressedFilePath);

// Декодирование и распаковка данных
$decodedData = gzdecode($compressedDataFromFile);
$yourDataAfterDecode = json_decode($decodedData, true); // true для получения массива вместо объекта

echo "<br>";
echo "<br>";

// Вывод кусочка JSON (чтобы убедиться, что с ним всё ок)
echo "\nДекодированные данные:\n";
print_r(array_slice($yourDataAfterDecode["users"], 0, 5));

?>
