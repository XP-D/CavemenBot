<?php

require __DIR__ . '/vendor/autoload.php';
include 'loadToken.php';
include 'api/api.php';
include 'api/getImage.php';
include 'database/setItem.php';
include 'database/getItem.php';
include 'database/validateUser.php';
include 'database/giveItem.php';
include 'database/smeltItem.php';
include 'database/eatItem.php';



use Discord\Discord;
use Discord\Parts\Embed\Embed;
use Discord\WebSockets\Event;
use Discord\WebSockets\Intents;
use Discord\Parts\Channel\Message;

$discord = new Discord([
    'token' => loadToken(),
    'intents' => Intents::getDefaultIntents() | Intents::GUILD_MEMBERS,
]);

$discord->on('ready', function($discord) {
    echo "\n\nBot powered up!\n\n";

    $discord->on(Event::MESSAGE_CREATE, function(Message $message, Discord $discord) {
        if ($message->author->bot) {
            return;
        };

        $commandContent = strtolower($message->content);
        $authorUsername = $message->author->username;
        global $conn;

        // Cmine Command

        if ($commandContent === 'cmine') {
            $itemData = apiGet();
            $embed = new Embed($discord);
            $embed->setTitle($authorUsername.' found a '.$itemData['itemName'].'!');
            $embed->setDescription($itemData['itemDesc']);
            $embed->setImage($itemData['itemImage']);
            $embed->setColor($itemData['itemColor']);
            $embed->setFooter($itemData['itemRarity']);
            $embed->setTimestamp(time());
            $message->channel->sendEmbed($embed);
            
            $itemName = $itemData['itemName'];
            setItem($authorUsername, $itemName);
            return;
        };

        // Cfish Command

        if ($commandContent === 'cfish') {
            if (getItem($authorUsername, 'Fishing rod') === 0) {
                $embed = new Embed($discord);
                $embed->setTitle("Error!");
                $embed->setDescription("You need a fishing rod!");
                $embed->setFooter('Requested by '.$authorUsername);
                $embed->setTimestamp(time());
                $embed->setColor(0xff1100);
                $embed->setImage('https://static.wikia.nocookie.net/minecraft_gamepedia/images/9/96/Dead_Bush_%28texture%29_JE1_BE1.png/revision/latest?cb=20200918200748');
                $message->channel->sendEmbed($embed);
                return;
            } else {
            $itemData = getFish();
            $embed = new Embed($discord);
            $embed->setTitle($authorUsername.' caught a '.$itemData['itemName'].'!');
            $embed->setDescription($itemData['itemDesc']);
            $embed->setImage($itemData['itemImage']);
            $embed->setColor($itemData['itemColor']);
            $embed->setFooter("blublbublublub");
            $embed->setTimestamp(time());
            $message->channel->sendEmbed($embed);
            
            $itemName = $itemData['itemName'];
            setItem($authorUsername, $itemName);
            return;
            };
        };

        // Cinv command

        if ($commandContent === 'cinv') {
            $embed = new Embed($discord);
            $embed->setTitle($authorUsername."'s Inventory");
            $embed->setDescription("
            
                **<:blocks:1297308825594101771> ┆ Blocks**
                <:dirt:1296932147093049395> **`Dirt     ".getItem($authorUsername, 'Dirt')."x`**
                <:stone:1296932168542720010> **`Stone   ".getItem($authorUsername, 'Stone')."x`**
                <:iron:1296932191992807435> **`Iron     ".getItem($authorUsername, 'Iron')."x`**
                <:gold:1296932202705326151> **`Gold     ".getItem($authorUsername, 'Gold')."x`**

                **<:tolls:1297615557972983840> ┆ Tools**
                <:furnace:1297611381931245573> **`Furnace   ".getItem($authorUsername, 'Furnace')."x`**
                <:fishing_rod:1297614225677750392> **`Fishing rod   ".getItem($authorUsername, 'Fishing Rod')."x`**


                **<:ores:1297308834712522772> ┆ Ores**
                <:coal:1296932179363889153> **`Coal     ".getItem($authorUsername, 'Coal')."x`**
                <:iron_ingot:1297609994300293261> **`Iron Ingot     ".getItem($authorUsername, 'Iron Ingot')."x`**
                <:gold_ingot:1297610005335379988> **`Gold Ingot     ".getItem($authorUsername, 'Gold Ingot')."x`**
                <:diamond:1296932213941866589> **`Diamond   ".getItem($authorUsername, 'Diamond')."x`**


                **<:fish:1297691173376495716> ┆ Food**
                <:cod:1297690524043575297> **`Cod     ".getItem($authorUsername, 'Cod')."x`**
                <:salmon:1297690513717071943> **`Salmon     ".getItem($authorUsername, 'Salmon')."x`**
                <:pufferfish:1297690503462125628> **`Pufferfish     ".getItem($authorUsername, 'Pufferfish')."x`**
                <:cooked_cod:1297699673234083900> **`Cooked cod     ".getItem($authorUsername, 'Cooked cod')."x`**
                <:cooked_salmon:1297699662756577371> **`Cooked salmon     ".getItem($authorUsername, 'Cooked salmon')."x`**
                <:apple:1297717800403603557> **`Apple     ".getItem($authorUsername, 'Apple')."x`**
                <:sweet_berries:1297717790068707329> **`Sweet berries     ".getItem($authorUsername, 'Sweet berries')."x`**
                <:cake:1297312328093663292> **`Cake     ".getItem($authorUsername, 'Cake')."x`**


                **<:obtainables:1297308843684139039> ┆ Obtainables**
                <:poppy:1296954406859964446> **`Poppy   ".getItem($authorUsername, 'Poppy')."x`**
                <:daisy:1297313939004199004> **`Daisy   ".getItem($authorUsername, 'Daisy')."x`**

                ");
            $embed->setFooter('Requested by '.$authorUsername);
            $embed->setTimestamp(time());
            $embed->setColor(0x212121);
            $message->channel->sendEmbed($embed);
            return;
        }

        // Cinv {User} Command

        if (preg_match('/^cinv\s+(\S+)/', strtolower($message->content), $matches)) {
            
            $username = $matches[1];

            if (validateUser($username)) {
                $embed = new Embed($discord);
                $embed->setTitle("Error!");
                $embed->setDescription("This username is not in our database!");
                $embed->setFooter('Requested by '.$authorUsername);
                $embed->setTimestamp(time());
                $embed->setColor(0xff0000);
                $embed->setImage(getImage('ERR'));
                $message->channel->sendEmbed($embed);
                return;
            } else {
                $embed = new Embed($discord);
                $embed->setTitle($username."'s Inventory");
                $embed->setDescription("
            
                **<:blocks:1297308825594101771> ┆ Blocks**
                <:dirt:1296932147093049395> **`Dirt     ".getItem($authorUsername, 'Dirt')."x`**
                <:stone:1296932168542720010> **`Stone   ".getItem($authorUsername, 'Stone')."x`**
                <:iron:1296932191992807435> **`Iron     ".getItem($authorUsername, 'Iron')."x`**
                <:gold:1296932202705326151> **`Gold     ".getItem($authorUsername, 'Gold')."x`**

                **<:tolls:1297615557972983840> ┆ Tools**
                <:furnace:1297611381931245573> **`Furnace   ".getItem($authorUsername, 'Furnace')."x`**
                <:fishing_rod:1297614225677750392> **`Fishing rod   ".getItem($authorUsername, 'Fishing Rod')."x`**


                **<:ores:1297308834712522772> ┆ Ores**
                <:coal:1296932179363889153> **`Coal     ".getItem($authorUsername, 'Coal')."x`**
                <:iron_ingot:1297609994300293261> **`Iron Ingot     ".getItem($authorUsername, 'Iron Ingot')."x`**
                <:gold_ingot:1297610005335379988> **`Gold Ingot     ".getItem($authorUsername, 'Gold Ingot')."x`**
                <:diamond:1296932213941866589> **`Diamond   ".getItem($authorUsername, 'Diamond')."x`**


                **<:fish:1297691173376495716> ┆ Food**
                <:cod:1297690524043575297> **`Cod     ".getItem($authorUsername, 'Cod')."x`**
                <:salmon:1297690513717071943> **`Salmon     ".getItem($authorUsername, 'Salmon')."x`**
                <:pufferfish:1297690503462125628> **`Pufferfish     ".getItem($authorUsername, 'Pufferfish')."x`**
                <:cooked_cod:1297699673234083900> **`Cooked cod     ".getItem($authorUsername, 'Cooked cod')."x`**
                <:cooked_salmon:1297699662756577371> **`Cooked salmon     ".getItem($authorUsername, 'Cooked salmon')."x`**
                <:apple:1297717800403603557> **`Apple     ".getItem($authorUsername, 'Apple')."x`**
                <:sweet_berries:1297717790068707329> **`Sweet berries     ".getItem($authorUsername, 'Sweet berries')."x`**
                <:cake:1297312328093663292> **`Cake     ".getItem($authorUsername, 'Cake')."x`**


                **<:obtainables:1297308843684139039> ┆ Obtainables**
                <:poppy:1296954406859964446> **`Poppy   ".getItem($authorUsername, 'Poppy')."x`**
                <:daisy:1297313939004199004> **`Daisy   ".getItem($authorUsername, 'Daisy')."x`**

                ");
                $embed->setFooter('Requested by '.$authorUsername);
                $embed->setTimestamp(time());
                $embed->setColor(0x212121);
                $message->channel->sendEmbed($embed);
                return;
            };

            
        }

        // Cgive command

        if (preg_match('/^cgive\s+(\S+)\s+(.+)/', strtolower($message->content), $matches)) {
            $reciverUser = $matches[1];
            $recivedItem = ucfirst(strtolower($matches[2]));

            // Check if author has enough items
            $authorItemAmount = getItem($authorUsername, $recivedItem);
            if ($authorItemAmount === '0') {
                $embed = new Embed($discord);
                $embed->setTitle('Error!');
                $embed->setDescription("You don't have enough `".$recivedItem."`");
                $embed->setTimestamp(time());
                $embed->setFooter('Requested by '.$authorUsername);
                $embed->setImage(getImage('ERR'));
                $embed->setColor(0xff0000);
                $message->channel->sendEmbed($embed);
                return;
                exit();
                die();
            } else {
                giveItem($authorUsername, $recivedItem, $reciverUser);

                $embed = new Embed($discord);
                $embed->setTitle($authorUsername." gave ". $reciverUser . " " . $recivedItem . "!");
                $embed->setDescription("You gave 1x `". $recivedItem ."` to " . $reciverUser);
                $embed->setImage(getImage($recivedItem));
                $embed->setTimestamp(time());
                $embed->setColor(0x212121);
                $message->channel->sendEmbed($embed);
            };
            
        }

        // Cmelt command

        if (preg_match('/^cmelt\s+(.+)/i', strtolower($message->content), $matches)) {
            $furnaceItem = ucfirst(strtolower($matches[1]));
        
            $authorItemAmount = getItem($authorUsername, $furnaceItem);
            $authorCoalAmount = getItem($authorUsername, 'Coal');
            if ($authorItemAmount === '0') {
                $embed = new Embed($discord);
                $embed->setTitle('Error!');
                $embed->setDescription("You don't have enough `".$furnaceItem."` to smelt");
                $embed->setTimestamp(time());
                $embed->setFooter('Requested by '.$authorUsername);
                $embed->setImage(getImage('ERR'));
                $embed->setColor(0xff0000);
                $message->channel->sendEmbed($embed);
                return;
                exit();
                die();
            } elseif ($authorCoalAmount === '0') {
                $embed = new Embed($discord);
                $embed->setTitle('Error!');
                $embed->setDescription("You don't have enough `Coal` to smelt");
                $embed->setTimestamp(time());
                $embed->setFooter('Requested by '.$authorUsername);
                $embed->setImage(getImage('ERR'));
                $embed->setColor(0xff0000);
                $message->channel->sendEmbed($embed);
                return;
                exit();
                die();
            } else {
                if (!in_array($furnaceItem, ['Iron', 'Gold'])) {
                    $embed = new Embed($discord);
                    $embed->setTitle('Error!');
                    $embed->setDescription("You can't smelt `".$furnaceItem."`");
                    $embed->setTimestamp(time());
                    $embed->setFooter('Requested by '.$authorUsername);
                    $embed->setImage(getImage('ERR'));
                    $embed->setColor(0xff0000);
                    $message->channel->sendEmbed($embed);
                    return;
                    exit();
                    die();
                } else {
                    if ($furnaceItem === 'Iron') {
                        smeltItem($authorUsername, $furnaceItem);

                        $embed = new Embed($discord);
                        $embed->setTitle('Smelted '.$furnaceItem.'!');
                        $embed->setDescription("Took 1x `Coal` for smelting");
                        $embed->setTimestamp(time());
                        $embed->setFooter('Smelted by '.$authorUsername);
                        $embed->setImage(getImage('Iron ingot'));
                        $embed->setColor(0xd6d6d6);
                        $message->channel->sendEmbed($embed);
                        return;
                    } else {
                        smeltItem($authorUsername, $furnaceItem);

                        $embed = new Embed($discord);
                        $embed->setTitle('Smelted '.$furnaceItem.'!');
                        $embed->setDescription("Took 1x `Coal` for smelting");
                        $embed->setTimestamp(time());
                        $embed->setFooter('Smelted by '.$authorUsername);
                        $embed->setImage(getImage('Gold ingot'));
                        $embed->setColor(0xffd000);
                        $message->channel->sendEmbed($embed);
                        return;
                    }
                    
                }
            };
        }

        // Ccook command

        if (preg_match('/^ccook\s+(.+)/i', strtolower($message->content), $matches)) {
            $furnaceItem = ucfirst(strtolower($matches[1]));
        
            $authorItemAmount = getItem($authorUsername, $furnaceItem);
            $authorCoalAmount = getItem($authorUsername, 'Coal');
            if ($authorItemAmount === '0') {
                $embed = new Embed($discord);
                $embed->setTitle('Error!');
                $embed->setDescription("You don't have enough `".$furnaceItem."` to smelt");
                $embed->setTimestamp(time());
                $embed->setFooter('Requested by '.$authorUsername);
                $embed->setImage(getImage('ERR'));
                $embed->setColor(0xff0000);
                $message->channel->sendEmbed($embed);
                return;
                exit();
                die();
            } elseif ($authorCoalAmount === '0') {
                $embed = new Embed($discord);
                $embed->setTitle('Error!');
                $embed->setDescription("You don't have enough `Coal` to smelt");
                $embed->setTimestamp(time());
                $embed->setFooter('Requested by '.$authorUsername);
                $embed->setImage(getImage('ERR'));
                $embed->setColor(0xff0000);
                $message->channel->sendEmbed($embed);
                return;
                exit();
                die();
            } else {
                if (!in_array($furnaceItem, ['Cod', 'Salmon'])) {
                    $embed = new Embed($discord);
                    $embed->setTitle('Error!');
                    $embed->setDescription("You can't cook `".$furnaceItem."`");
                    $embed->setTimestamp(time());
                    $embed->setFooter('Requested by '.$authorUsername);
                    $embed->setImage(getImage('ERR'));
                    $embed->setColor(0xffffff);
                    $message->channel->sendEmbed($embed);
                    return;
                    exit();
                    die();
                } else {
                    if ($furnaceItem === 'Cod') {
                        smeltItem($authorUsername, $furnaceItem);

                        $embed = new Embed($discord);
                        $embed->setTitle('Cooked '.$furnaceItem.'!');
                        $embed->setDescription("Took 1x `Coal` for cooking");
                        $embed->setTimestamp(time());
                        $embed->setFooter('Cooked by '.$authorUsername);
                        $embed->setImage(getImage('Cooked cod'));
                        $embed->setColor(0xc7ad95);
                        $message->channel->sendEmbed($embed);
                        return;
                    } else {
                        smeltItem($authorUsername, $furnaceItem);

                        $embed = new Embed($discord);
                        $embed->setTitle('Cooked '.$furnaceItem.'!');
                        $embed->setDescription("Took 1x `Coal` for cooking");
                        $embed->setTimestamp(time());
                        $embed->setFooter('Cooked by '.$authorUsername);
                        $embed->setImage(getImage('Cooked salmon'));
                        $embed->setColor(0xdb8686);
                        $message->channel->sendEmbed($embed);
                        return;
                    }
                }
            };
        }

        // Ceat command

        if (preg_match('/^ceat\s+(.+)/i', strtolower($message->content), $matches)) {
            $eatenItem = ucfirst(strtolower($matches[1]));
        
            $authorItemAmount = getItem($authorUsername, $eatenItem);
            if ($authorItemAmount === '0') {
                $embed = new Embed($discord);
                $embed->setTitle('Error!');
                $embed->setDescription("You don't have enough `".$eatenItem."` to Eat");
                $embed->setTimestamp(time());
                $embed->setFooter('Requested by '.$authorUsername);
                $embed->setImage(getImage('ERR'));
                $embed->setColor(0xff0000);
                $message->channel->sendEmbed($embed);
                return;
                exit();
                die();
            } else {
                if (!in_array($eatenItem, ['Cooked cod', 'Cooked salmon', 'Cake', 'Apple', 'Sweet berries', 'Cod', 'Salmon', 'Pufferfish']) || getItem($authorUsername, $eatenItem) === 0) {
                    $embed = new Embed($discord);
                    $embed->setTitle('Error!');
                    $embed->setDescription("You can't eat or have far too less `".$eatenItem."`!");
                    $embed->setTimestamp(time());
                    $embed->setFooter('Requested by '.$authorUsername);
                    $embed->setImage(getImage('ERR'));
                    $embed->setColor(0xffffff);
                    $message->channel->sendEmbed($embed);
                    return;
                    exit();
                    die();
                } else {
                    if ($eatenItem === 'Cod') {
                        eatItem($authorUsername ,$eatenItem);
                        $embed = new Embed($discord);
                        $embed->setTitle($authorUsername.' ate '.strtolower($eatenItem).'!');
                        $embed->setDescription("Eww, that was flipping raw!!!");
                        $embed->setTimestamp(time());
                        $embed->setFooter('Eaten by '.$authorUsername);
                        $embed->setImage(getImage('Cod'));
                        $embed->setColor(0xc7ad95);
                        $message->channel->sendEmbed($embed);
                        return;
                    } elseif ($eatenItem === 'Cooked cod') {
                        eatItem($authorUsername ,$eatenItem);
                        $embed = new Embed($discord);
                        $embed->setTitle($authorUsername.' ate '.strtolower($eatenItem).'!');
                        $embed->setDescription("Ahh yess, That was very good");
                        $embed->setTimestamp(time());
                        $embed->setFooter('Eaten by '.$authorUsername);
                        $embed->setImage(getImage('Cooked cod'));
                        $embed->setColor(0xdb8686);
                        $message->channel->sendEmbed($embed);
                        return;
                    } elseif ($eatenItem === 'Salmon') {
                        eatItem($authorUsername ,$eatenItem);
                        $embed = new Embed($discord);
                        $embed->setTitle($authorUsername.' ate '.strtolower($eatenItem).'!');
                        $embed->setDescription("Eww, that was flipping raw!!!");
                        $embed->setTimestamp(time());
                        $embed->setFooter('Eaten by '.$authorUsername);
                        $embed->setImage(getImage('Salmon'));
                        $embed->setColor(0xdb8686);
                        $message->channel->sendEmbed($embed);
                        return;
                    } elseif ($eatenItem === 'Cooked salmon') {
                        eatItem($authorUsername ,$eatenItem);
                        $embed = new Embed($discord);
                        $embed->setTitle($authorUsername.' ate '.strtolower($eatenItem).'!');
                        $embed->setDescription("Ahh yess, That was very good");
                        $embed->setTimestamp(time());
                        $embed->setFooter('Eaten by '.$authorUsername);
                        $embed->setImage(getImage('Cooked salmon'));
                        $embed->setColor(0xdb8686);
                        $message->channel->sendEmbed($embed);
                        return;
                    } elseif ($eatenItem === 'Pufferfish') {
                        $rand = rand(0, 1);

                        if ($rand === 1) {
                            eatItem($authorUsername ,$eatenItem);
                            $embed = new Embed($discord);
                            $embed->setTitle($authorUsername.' ate a '.strtolower($eatenItem).'!');
                            $embed->setDescription("AHHHH I GOT POISONED!!!");
                            $embed->setTimestamp(time());
                            $embed->setFooter('Eaten by '.$authorUsername);
                            $embed->setImage(getImage('Pufferfish'));
                            $embed->setColor(0x477000);
                            $message->channel->sendEmbed($embed);
                            return;
                        } else {
                            eatItem($authorUsername ,$eatenItem);
                            $embed = new Embed($discord);
                            $embed->setTitle($authorUsername.' ate a '.strtolower($eatenItem).'!');
                            $embed->setDescription("Eww, that was flipping raw!!!");
                            $embed->setTimestamp(time());
                            $embed->setFooter('Eaten by '.$authorUsername);
                            $embed->setImage(getImage('Pufferfish'));
                            $embed->setColor(0xffdb3b);
                            $message->channel->sendEmbed($embed);
                            return;
                        }
                    } elseif ($eatenItem === 'Cake') {
                        eatItem($authorUsername ,$eatenItem);
                        $embed = new Embed($discord);
                        $embed->setTitle($authorUsername.' ate a '.strtolower($eatenItem).'!');
                        $embed->setDescription("Ahh yess, That was very good");
                        $embed->setTimestamp(time());
                        $embed->setFooter('Eaten by '.$authorUsername);
                        $embed->setImage(getImage('Cake'));
                        $embed->setColor(0xdb8686);
                        $message->channel->sendEmbed($embed);
                        return;
                    } elseif ($eatenItem === 'Apple') {
                        eatItem($authorUsername ,$eatenItem);
                        $embed = new Embed($discord);
                        $embed->setTitle($authorUsername.' ate an '.strtolower($eatenItem).'!');
                        $embed->setDescription("Ahh yess, That was very good");
                        $embed->setTimestamp(time());
                        $embed->setFooter('Eaten by '.$authorUsername);
                        $embed->setImage(getImage('Apple'));
                        $embed->setColor(0xdb8686);
                        $message->channel->sendEmbed($embed);
                        return;
                    } elseif ($eatenItem === 'Sweet berries') {
                        eatItem($authorUsername ,$eatenItem);
                        $embed = new Embed($discord);
                        $embed->setTitle($authorUsername.' ate '.strtolower($eatenItem).'!');
                        $embed->setDescription("Ahh yess, That was very good");
                        $embed->setTimestamp(time());
                        $embed->setFooter('Eaten by '.$authorUsername);
                        $embed->setImage(getImage('Sweet berries'));
                        $embed->setColor(0xdb8686);
                        $message->channel->sendEmbed($embed);
                        return;
                    }
                }
            };
        }

        // Help command

        if ($commandContent === 'chelp') {
            $embed = new Embed($discord);
            $embed->setTitle("Bot Commands");
            $embed->setDescription("
            
            **:robot: ┆ Bot Prefix**
            **`c`**
            *example: chelp*

            **:pick: ┆ Mine Items**
            **`cmine`**
            *mine a random block*
            **Hey ".$authorUsername.", Get started using this command! :up_arrow:**

            **:backpack: ┆ Check status**
            *view your inventory*
            **`cinv`**
            **`cinv {user}`**
            *example: cinv desiignerr*

            **:palm_up_hand: ┆ Give Items**
            *give other users items*
            **`cgive`**
            **`cgive {user} {item_name}`**
            *example: cgive desiignerr poppy*

            **<:furnace:1297611381931245573> ┆ Furnace Commansd**
            *use the furnace item*
            **`cmelt`**
            **`cmelt {item_name}`**
            *example: cmelt iron*
            **`ccook`**
            **`ccook {item_name}`**
            *example: ccook salmon*
            
            **<:fishing_rod:1297614225677750392> ┆ Fishing rod Commands**
            *use the fishing rod item*
            **`cfish`**

            **:apple: ┆ Eating**
            *eat edible items*
            **`ceat`**
            **`ceat {item_name}`**
            *example: ceat salmon*

            **:dizzy: ┆ Bot Support**
            *Bot invite link*
            **`cinvite`**

            *Vote for the bot!*
            **`cvote`**

            **:memo: ┆ Credits**
            **`Bot Developer` @desiignerr**
            **`Bot Hoster` @basilisk**
            **`Bot Language` php**
            **`Bot Version` v1.0**
            **`Bot Database` MySQL**
            
            ");
            $embed->setFooter('Requested by '.$authorUsername);
            $embed->setTimestamp(time());
            $embed->setColor(0x1c1c1c);
            $message->channel->sendEmbed($embed);
            return;
        }

        if ($commandContent === 'cinvite') {
            $message->channel->sendMessage('https://discord.com/oauth2/authorize?client_id=1296894207750967419');
            return;
        }

        if ($commandContent === 'cvote') {
            $message->channel->sendMessage('https://discord.com/oauth2/authorize?client_id=1296894207750967419');
            return;
        }
    });
});

$discord->run();