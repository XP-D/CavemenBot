<?php

function apiGet() {
    $apiRes = array(
        'ItemName'=>'',
        'itemDesc'=>'',
        'itemImage'=>'',
        'itemRarity'=>'',
        'itemColor'=>''
    );

    $rand = rand(0, 100);

    switch (true) {

        case $rand <= 1:
            $apiRes['itemName'] = 'Poppy';
            $apiRes['itemDesc'] = 'You can give this to someone special!';
            $apiRes['itemImage'] = 'https://minecraft.wiki/images/Poppy_JE8_BE2.png?10687';
            $apiRes['itemRarity'] = 'Mythical';
            $apiRes['itemColor'] = '0xd10000';

            return $apiRes;
            break;

        case $rand <= 2:
            $apiRes['itemName'] = 'Diamond';
            $apiRes['itemDesc'] = 'NO WAYYYYYY!';
            $apiRes['itemImage'] = 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/a/ab/Diamond_JE3_BE3.png/revision/latest/thumbnail/width/360/height/360?cb=20230924193138';
            $apiRes['itemRarity'] = 'Legendary';
            $apiRes['itemColor'] = '0x47eaff';

            return $apiRes;
            break;

        case $rand <= 3:
            $apiRes['itemName'] = 'Cake';
            $apiRes['itemDesc'] = 'Someone is about to blow candles!';
            $apiRes['itemImage'] = 'https://minecraft.wiki/images/Cake_JE4.png?009f2';
            $apiRes['itemRarity'] = 'Rare';
            $apiRes['itemColor'] = '0xffcca6';

            return $apiRes;
            break;


        case $rand <= 4:
            $apiRes['itemName'] = 'Gold';
            $apiRes['itemDesc'] = 'I AM RICH!';
            $apiRes['itemImage'] = 'https://minecraft.wiki/images/Gold_Ore_JE7_BE4.png?9817a';
            $apiRes['itemRarity'] = 'Rare';
            $apiRes['itemColor'] = '0xffd447';

            return $apiRes;
            break;

        case $rand <= 5:
            $apiRes['itemName'] = 'Daisy';
            $apiRes['itemDesc'] = 'Hmm, I am sure I can give this to someone!';
            $apiRes['itemImage'] = 'https://minecraft.wiki/images/Oxeye_Daisy_JE7_BE2.png?5d367';
            $apiRes['itemRarity'] = 'Rare';
            $apiRes['itemColor'] = '0xffffdb';

            return $apiRes;
            break;

        case $rand <= 7:
            $apiRes['itemName'] = 'Fishing rod';
            $apiRes['itemDesc'] = 'Oh wow, Now you can fish!';
            $apiRes['itemImage'] = 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/7/7f/Fishing_Rod_JE2_BE2.png/revision/latest?cb=20200201063839';
            $apiRes['itemRarity'] = 'Epic';
            $apiRes['itemColor'] = '0x4f3e2f';

            return $apiRes;
            break;

        case $rand <= 10:
            $apiRes['itemName'] = 'Furnace';
            $apiRes['itemDesc'] = 'Smells like ore in here, let us smelt some more!';
            $apiRes['itemImage'] = 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/9/98/Furnace_%28S%29_BE2.png/revision/latest/scale-to-width/360?cb=20210111064348';
            $apiRes['itemRarity'] = 'Epic';
            $apiRes['itemColor'] = '0x545454';

            return $apiRes;
            break;

        case $rand <= 20:
            $apiRes['itemName'] = 'Iron';
            $apiRes['itemDesc'] = 'This looks so shiney!';
            $apiRes['itemImage'] = 'https://minecraft.wiki/images/Iron_Ore_JE6_BE4.png?b1fb3';
            $apiRes['itemRarity'] = 'Uncommon';
            $apiRes['itemColor'] = '0xc4c4c4';

            return $apiRes;
            break;

        case $rand <= 35:
            $apiRes['itemName'] = 'Coal';
            $apiRes['itemDesc'] = 'This will come in handy!';
            $apiRes['itemImage'] = 'https://static.wikia.nocookie.net/minecraft/images/a/a7/Coal.png/revision/latest/scale-to-width/360?cb=20200814153155';
            $apiRes['itemRarity'] = 'Common';
            $apiRes['itemColor'] = '0x402d2d';

            return $apiRes;
            break;

        case $rand <= 37:
            $apiRes['itemName'] = 'Apple';
            $apiRes['itemDesc'] = 'Newton?!';
            $apiRes['itemImage'] = 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/a/af/Apple_JE3_BE3.png/revision/latest?cb=20200519232834';
            $apiRes['itemRarity'] = 'Common';
            $apiRes['itemColor'] = '0x9e0000';

            return $apiRes;
            break;

        case $rand <= 40:
            $apiRes['itemName'] = 'Sweet berries';
            $apiRes['itemDesc'] = 'Damn it, I wanted blueberry!';
            $apiRes['itemImage'] = 'https://minecraft.wiki/images/Sweet_Berries_JE1_BE1.png?d29d1';
            $apiRes['itemRarity'] = 'Common';
            $apiRes['itemColor'] = '0x9e0000';

            return $apiRes;
            break;

        case $rand <= 45:
            $apiRes['itemName'] = 'Stone';
            $apiRes['itemDesc'] = 'ooo, we are getting closer!';
            $apiRes['itemImage'] = 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/1/10/Stone_JE6.png/revision/latest?cb=20200315184448';
            $apiRes['itemRarity'] = 'Common';
            $apiRes['itemColor'] = '0x6b6b6b';

            return $apiRes;
            break;


        default:
            $apiRes['itemName'] = 'Dirt';
            $apiRes['itemDesc'] = 'Good old dirt block!';
            $apiRes['itemImage'] = 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/9/9b/Dirt_JE2_BE2.png/revision/latest?cb=20200309195232';
            $apiRes['itemRarity'] = 'Common';
            $apiRes['itemColor'] = '0x402d2d';

            return $apiRes;
            break;
    };
};

function getFish() {
    $apiRes = array(
        'ItemName'=>'',
        'itemDesc'=>'',
        'itemImage'=>'',
        'itemColor'=>''
    );

    $rand = rand(0, 4 - 1);

    switch (true) {

        case $rand <= 1:
            $apiRes['itemName'] = 'Cod';
            $apiRes['itemDesc'] = 'Sounds fishy...';
            $apiRes['itemImage'] = 'https://static.wikia.nocookie.net/minecraft-mob/images/3/3f/Cod_%28mob%29.png/revision/latest/scale-to-width-down/217?cb=20180223184055';
            $apiRes['itemColor'] = '0xc7ad95';

            return $apiRes;
            break;

        case $rand <= 2:
            $apiRes['itemName'] = 'Salmon';
            $apiRes['itemDesc'] = 'That is a nice color';
            $apiRes['itemImage'] = 'https://media.forgecdn.net/avatars/thumbnails/614/871/256/256/637999288296950288.png';
            $apiRes['itemColor'] = '0xdb8686';

            return $apiRes;
            break;

        case $rand <= 3:
            $apiRes['itemName'] = 'Pufferfish';
            $apiRes['itemDesc'] = 'Yooo, that is spiky!';
            $apiRes['itemImage'] = 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/2/2e/Pufferfish_large.png/revision/latest?cb=20190924133041';
            $apiRes['itemColor'] = '0xffc670';

            return $apiRes;
            break;
    }
};