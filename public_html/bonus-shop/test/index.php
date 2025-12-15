<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("test");

use Lab\Helpers\UsersHelpers as Users;
use Lab\Helpers\IblockHelpers as IH;


?>
<?php
$jsonMufUsers = '
[
 {
  "№": 1,
  "ФИО": "Попова Анастасия Александровна",
  "E-mail": "PopovaAA3@mos.ru"
 },
 {
  "№": 2,
  "ФИО": "Фролова  Екатерина Борисовна",
  "E-mail": "FrolovaEB1@mos.ru"
 },
 {
  "№": 3,
  "ФИО": "Анурова Майя Александровна",
  "E-mail": "AnurovaMA@mos.ru"
 },
 {
  "№": 4,
  "ФИО": "Анисимова  Анна Олеговна",
  "E-mail": "anisimovaao@mos.ru"
 },
 {
  "№": 5,
  "ФИО": "Аржанова Анастасия Дмитриевна",
  "E-mail": "arzhanovaad@mos.ru"
 },
 {
  "№": 6,
  "ФИО": "Асонова Софья Олеговна",
  "E-mail": "AsonovaSO@mos.ru"
 },
 {
  "№": 7,
  "ФИО": "Белов Илья Игоревич",
  "E-mail": "belovii@mos.ru"
 },
 {
  "№": 8,
  "ФИО": "Богодухова Снежана Григорьевна",
  "E-mail": "BogodukhovaSG@mos.ru"
 },
 {
  "№": 9,
  "ФИО": "Большова Мария Павловна",
  "E-mail": "BolshovaMP@mos.ru"
 },
 {
  "№": 10,
  "ФИО": "Бородовская София Максимовна",
  "E-mail": "BorodovskayaSM@mos.ru"
 },
 {
  "№": 11,
  "ФИО": "Василов Владислав Васильевич",
  "E-mail": "VasilovVV@mos.ru"
 },
 {
  "№": 12,
  "ФИО": "Виноградова Евгения Юрьевна",
  "E-mail": "VinogradovaEY2@mos.ru"
 },
 {
  "№": 13,
  "ФИО": "Восканянц Наталья Евгеньевна",
  "E-mail": "VoskanyantsNE@mos.ru"
 },
 {
  "№": 14,
  "ФИО": "Григорьева Дарья  Сергеевна",
  "E-mail": "grigorevads@mos.ru"
 },
 {
  "№": 15,
  "ФИО": "Грошева Анастасия Владимировна",
  "E-mail": "GroshevaAV2@mos.ru"
 },
 {
  "№": 16,
  "ФИО": "Демидова Евгения Анатольевна",
  "E-mail": "demidovaea3@mos.ru"
 },
 {
  "№": 17,
  "ФИО": "Емельянова Анастасия Владимировна",
  "E-mail": "EmelyanovaAV5@mos.ru"
 },
 {
  "№": 18,
  "ФИО": "Забадаев Илья Вячеславович",
  "E-mail": "ZabadaevIV@mos.ru"
 },
 {
  "№": 19,
  "ФИО": "Замыслова Елена Михайловна",
  "E-mail": "ZamyslovaEM@mos.ru"
 },
 {
  "№": 20,
  "ФИО": "Заренкова Анфиса ",
  "E-mail": "ZarenkovaA@mos.ru"
 },
 {
  "№": 21,
  "ФИО": "Золотарев Александр Викторович",
  "E-mail": "ZolotarevAV4@mos.ru"
 },
 {
  "№": 22,
  "ФИО": "Зырянова Марина Александровна",
  "E-mail": "ZyryanovaMA@mos.ru"
 },
 {
  "№": 23,
  "ФИО": "Ибраимова Лейла Эскендеровна",
  "E-mail": "IbraimovaLE@mos.ru"
 },
 {
  "№": 24,
  "ФИО": "Каргина Анастасия Алексеевна",
  "E-mail": "KarginaAA1@mos.ru"
 },
 {
  "№": 25,
  "ФИО": "Картузов Илья Евгеньевич",
  "E-mail": "KartuzovIE@mos.ru"
 },
 {
  "№": 26,
  "ФИО": "Кисленко Оксана Васильевна",
  "E-mail": "kislenkoov@mos.ru"
 },
 {
  "№": 27,
  "ФИО": "Клюкина Дарья Сергеевна",
  "E-mail": "KlyukinaDS@mos.ru"
 },
 {
  "№": 28,
  "ФИО": "Коняева Ксения Сергеевна",
  "E-mail": "KonyaevaKS@mos.ru"
 },
 {
  "№": 29,
  "ФИО": "Копцева Кристина Алексеевна",
  "E-mail": "koptsevaka@mos.ru"
 },
 {
  "№": 30,
  "ФИО": "Королева Ирина Андреевна",
  "E-mail": "KorolevaIA13@mos.ru"
 },
 {
  "№": 31,
  "ФИО": "Косолобенкова Ирина Александровна",
  "E-mail": "KosolobenkovaIA@mos.ru"
 },
 {
  "№": 32,
  "ФИО": "Крамских Артем  Петрович",
  "E-mail": "kramskikhap@mos.ru"
 },
 {
  "№": 33,
  "ФИО": "Куприянова  Елена Геннадьевна",
  "E-mail": "KupriyanovaEG@mos.ru"
 },
 {
  "№": 34,
  "ФИО": "Курилкина Ольга Сергеевна",
  "E-mail": "KurilkinaOS@mos.ru"
 },
 {
  "№": 35,
  "ФИО": "Лащевская  Екатерина Владимировна",
  "E-mail": "laschevskayaev@mos.ru"
 },
 {
  "№": 36,
  "ФИО": "Лёвкина Евгения Сергеевна",
  "E-mail": "LevkinaES@mos.ru"
 },
 {
  "№": 37,
  "ФИО": "Левшина Юлия Сергеевна",
  "E-mail": "LevshinaYS@mos.ru"
 },
 {
  "№": 38,
  "ФИО": "Литвинова Полина Григорьевна",
  "E-mail": "LitvinovaPG@mos.ru"
 },
 {
  "№": 39,
  "ФИО": "Май Екатерина Алексеевна",
  "E-mail": "MayEA@mos.ru"
 },
 {
  "№": 40,
  "ФИО": "Матвеева Инна Александровна",
  "E-mail": "MatveevaIA3@mos.ru"
 },
 {
  "№": 41,
  "ФИО": "Матюхин Кирилл Игоревич",
  "E-mail": "MatyukhinKI@mos.ru"
 },
 {
  "№": 42,
  "ФИО": "Мещерякова Наталия Игоревна",
  "E-mail": "mescheryakovani2@mos.ru"
 },
 {
  "№": 43,
  "ФИО": "Мостовая Олеся Юрьевна",
  "E-mail": "MostovayaOY@mos.ru"
 },
 {
  "№": 44,
  "ФИО": "Нестеренко Анастасия Вячеславовна",
  "E-mail": "NesterenkoAV2@mos.ru"
 },
 {
  "№": 45,
  "ФИО": "Нычкин Антон Александрович",
  "E-mail": "NychkinAA@mos.ru"
 },
 {
  "№": 46,
  "ФИО": "Перевозная Александра Владимировна",
  "E-mail": "PerevoznayaAV@mos.ru"
 },
 {
  "№": 47,
  "ФИО": "Переход Артур Анатольевич",
  "E-mail": " PerekhodAA@mos.ru"
 },
 {
  "№": 48,
  "ФИО": "Посуненко Анна Игоревна",
  "E-mail": "posunenkoai@mos.ru"
 },
 {
  "№": 49,
  "ФИО": "Пыткова Маргарита Викторовна",
  "E-mail": "PytkovaMV@mos.ru"
 },
 {
  "№": 50,
  "ФИО": "Родариева Лариса Витальева",
  "E-mail": "rodarievalv@mos.ru"
 },
 {
  "№": 51,
  "ФИО": "Роменская Яна Сергеевна",
  "E-mail": "RomenskayaYS@mos.ru"
 },
 {
  "№": 52,
  "ФИО": "Рябова Наталья Леонидовна",
  "E-mail": "RyabovaNL@mos.ru"
 },
 {
  "№": 53,
  "ФИО": "Свидерская Екатерина Алексеевна",
  "E-mail": "SviderskayaEA@mos.ru"
 },
 {
  "№": 54,
  "ФИО": "Селезнева Елена Анатольевна",
  "E-mail": "SeleznevaEA2@mos.ru"
 },
 {
  "№": 55,
  "ФИО": "Семенихина Анна Александровна",
  "E-mail": "SemenikhinaAA1@mos.ru"
 },
 {
  "№": 56,
  "ФИО": "Семенова Алина Аразовна",
  "E-mail": "SemenovaAA23@mos.ru"
 },
 {
  "№": 57,
  "ФИО": "Сергеева Анна Владимировна",
  "E-mail": "SergeevaAV17@mos.ru"
 },
 {
  "№": 58,
  "ФИО": "Сопелева Елена Александровна",
  "E-mail": "SopelevaEA@mos.ru"
 },
 {
  "№": 59,
  "ФИО": "Степанько Анастасия Вячеславовна",
  "E-mail": "stepankoav@mos.ru"
 },
 {
  "№": 60,
  "ФИО": "Ткачев Егор Дмитриевич",
  "E-mail": "TkachevED@mos.ru"
 },
 {
  "№": 61,
  "ФИО": "Удалов Кирилл Александрович",
  "E-mail": "UdalovKA@mos.ru"
 },
 {
  "№": 62,
  "ФИО": "Федин Андрей Николаевич",
  "E-mail": "FedinAN@mos.ru"
 },
 {
  "№": 63,
  "ФИО": "Цапковский Иван Валерьевич",
  "E-mail": "TsapkovskijIV@mos.ru"
 },
 {
  "№": 64,
  "ФИО": "Чернышева Екатерина Васильевна",
  "E-mail": "ChernyshevaEV3@mos.ru"
 },
 {
  "№": 65,
  "ФИО": "Шейко Елена Александровна",
  "E-mail": "SheykoEA1@mos.ru"
 },
 {
  "№": 66,
  "ФИО": "Шмакова Нина Сергеевна",
  "E-mail": "ShmakovaNS1@mos.ru"
 },
 {
  "№": 67,
  "ФИО": "Шмелева Марина Олеговна",
  "E-mail": "ShmelevaMO@mos.ru"
 },
 {
  "№": 68,
  "ФИО": "Щербатюк Мария Дмитриевна",
  "E-mail": "ScherbatyukMD@mos.ru"
 },
 {
  "№": 69,
  "ФИО": "Яковлева Мария Игоревна",
  "E-mail": "yakovlevami1@mos.ru"
 }
]
';
$strMuf = '[
  {
  "№": 1,
  "ФИО": "Попова Анастасия Александровна",
  "E-mail": "PopovaAA3@mos.ru"
 },
 {
  "№": 2,
  "ФИО": "Фролова  Екатерина Борисовна",
  "E-mail": "FrolovaEB1@mos.ru"
 },
 {
  "№": 3,
  "ФИО": "Анурова Майя Александровна",
  "E-mail": "AnurovaMA@mos.ru"
 }  
    ]';
?>
<?php $arMufUsers = json_decode($jsonMufUsers, true);
//pretty_print($arMufUsers);

$arMuf = json_decode($strMuf, true);

//=======АНО=================================================================
//$arUsersAno = json_decode(file_get_contents('jsonUsersAno.json'));
//pretty_print($arUsersAno);
function addUsersAno($arUsersAno)
{
    foreach ($arUsersAno as $userFields) {
        $userFields=(array)$userFields;
        $lastName = $userFields['Фамилия'];
        $firstName = $userFields['Имя'];
        $Email = $userFields['E-Mail'];
        $newUser = [
            'LOGIN' => $Email,
            'EMAIL' => $Email,
            'PASSWORD' => '12345678',
            'NAME' => $firstName,
            'LAST_NAME' => $lastName,
            // 'PHONE_NUMBER' => '+79991234567', // Дополнительное поле
            // 'WORK_COMPANY' => 'Тестовая компания',
        ];
        $arRes = Users::registerUserWithGroup($newUser, 16);
        if ($arRes['success']) {
            echo "ID созданного пользователя: " . $arRes['userId'];
        } else {
            echo "Ошибка: " . $arRes['message'];
        }
    }
}
//addUsersAno($arUsersAno);
//=====================================================

$arPtoperties = IH::getPropsListIblock();
pretty_print($arPtoperties);

?>


<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>