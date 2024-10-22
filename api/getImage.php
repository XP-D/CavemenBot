<?php

function getImage($itemName) {
    switch (true) {
        case $itemName === 'Dirt':
            return 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/9/9b/Dirt_JE2_BE2.png/revision/latest?cb=20200309195232';
            break;
        
        case $itemName === 'Stone':
            return 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/1/10/Stone_JE6.png/revision/latest?cb=20200315184448';
            break;

        case $itemName === 'Coal':
            return 'https://static.wikia.nocookie.net/minecraft/images/a/a7/Coal.png/revision/latest/scale-to-width/360?cb=20200814153155';
            break;

        case $itemName === 'Iron':
            return 'https://minecraft.wiki/images/Iron_Ore_JE6_BE4.png?b1fb3';
            break;

        case $itemName === 'Daisy':
            return 'https://minecraft.wiki/images/Oxeye_Daisy_JE7_BE2.png?5d367';
            break;

        case $itemName === 'Gold':
            return 'https://minecraft.wiki/images/Gold_Ore_JE7_BE4.png?9817a';
            break;

        case $itemName === 'Cake':
            return 'https://minecraft.wiki/images/Cake_JE4.png?009f2';
            break;

        case $itemName === 'Diamond':
            return 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/a/ab/Diamond_JE3_BE3.png/revision/latest/thumbnail/width/360/height/360?cb=20230924193138';
            break;
        
        case $itemName === 'Fishing rod':
            return 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/7/7f/Fishing_Rod_JE2_BE2.png/revision/latest?cb=20200201063839';
            break;

        case $itemName === 'Iron ingot':
            return 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/6/64/Iron_Ingot_JE1.png/revision/latest?cb=20201014002107';
            break;

        case $itemName === 'Gold ingot':
            return 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/8/8a/Gold_Ingot_JE4_BE2.png/revision/latest?cb=20200224211607';
            break;

        case $itemName === 'Cooked cod':
            return 'https://minecraft.wiki/images/Cooked_Cod_JE4_BE3.png?b495d';
            break;

        case $itemName === 'Cooked salmon':
            return 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/2/2b/Cooked_Salmon_JE2_BE2.png/revision/latest?cb=20190403183831';
            break;

        case $itemName === 'Cod':
            return 'https://static.wikia.nocookie.net/minecraft-mob/images/3/3f/Cod_%28mob%29.png/revision/latest/scale-to-width-down/217?cb=20180223184055';
            break;

        case $itemName === 'Salmon':
            return 'https://media.forgecdn.net/avatars/thumbnails/614/871/256/256/637999288296950288.png1';
            break;

        case $itemName === 'Pufferfish':
            return 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/2/2e/Pufferfish_large.png/revision/latest?cb=20190924133041';
            break;

        case $itemName === 'Apple':
            return 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/a/af/Apple_JE3_BE3.png/revision/latest?cb=20200519232834';
            break;

        case $itemName === 'Sweet berries':
            return 'https://minecraft.wiki/images/Sweet_Berries_JE1_BE1.png?d29d1';
            break;

        case $itemName === 'Poppy':
            return 'https://minecraft.wiki/images/Poppy_JE8_BE2.png?10687';
            break;

        case $itemName === 'ERR':
            return 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/9/96/Dead_Bush_%28texture%29_JE1_BE1.png/revision/latest?cb=20200918200748';
            break;

        default:
            return 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/9/96/Dead_Bush_%28texture%29_JE1_BE1.png/revision/latest?cb=20200918200748';
            break;
    };
};