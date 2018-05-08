<div class="gw2api-box site">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="get-api-key">
            <div class="message site">
                <?php Messages::display(); ?>
            </div>
            
            <label>Twój klucz API: </label>
            <input type='text' name='userapikey' value="<?php echo $_SESSION['user_data']['gw2id']?>">
            <input name="updateapikey" type=submit value="Aktualizuj klucz API"/>
            <input name="updateapikey" type=submit value="Usuń klucz API"/>
        </div>
    </form>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        
    </form>
    <label >Klucz API można wygenerować na tej stronie 
        <a href='https://account.arena.net/applications' target='_blank' class='arenanet_link'>https://account.arena.net/applications</a>
    </label>
    <br/>
    <?php
    $api = new apigw2();
    $apikeyinfo= $api->validate_apikey($_SESSION['user_data']['gw2id']);
    //echo "tradingpost ".$apikeyinfo['tradingpost']."<br/>";
    ?>
    <div class="api-permissions">
        <div>
            Name: <?php echo $apikeyinfo['name'];?>
        </div>
        <ul class="center">
            <li>
                <?php if ($apikeyinfo['account']==true):?>
                Account: <div class="icon-ok"></div>
                <?php else: ?>
                Account: <div class="icon-block"></div>
                <?php endif; ?>
            </li>
            <li>
                <?php if ($apikeyinfo['inventories']==true):?>
                Inventories: <div class="icon-ok"></div>
                <?php else: ?>
                Inventories: <div class="icon-block"></div>
                <?php endif; ?>
            </li>
            <li>
                <?php if ($apikeyinfo['characters']==true):?>
                Characters: <div class="icon-ok"></div>
                <?php else: ?>
                Characters: <div class="icon-block"></div>
                <?php endif; ?>
            </li>
            <li>
                <?php if ($apikeyinfo['tradingpost']==true):?>
                Tradingpost: <div class="icon-ok"></div>
                <?php else: ?>
                Tradingpost: <div class="icon-block"></div>
                <?php endif; ?>
            </li>
            <li>
                <?php if ($apikeyinfo['wallet']==true):?>
                Wallet: <div class="icon-ok"></div>
                <?php else: ?>
                Wallet: <div class="icon-block"></div>
                <?php endif; ?>
            </li>
            <li>
                <?php if ($apikeyinfo['unlocks']==true):?>
                Unlocks: <div class="icon-ok"></div>
                <?php else: ?>
                Unlocks: <div class="icon-block"></div>
                <?php endif; ?>
            </li>
            <li>
                <?php if ($apikeyinfo['pvp']==true):?>
                PvP: <div class="icon-ok"></div>
                <?php else: ?>
                PvP: <div class="icon-block"></div>
                <?php endif; ?>
            </li>
            <li>
                <?php if ($apikeyinfo['builds']==true):?>
                Builds: <div class="icon-ok"></div>
                <?php else: ?>
                Builds: <div class="icon-block"></div>
                <?php endif; ?>
            </li>
            <li>
                <?php if ($apikeyinfo['progression']==true):?>
                Progression: <div class="icon-ok"></div>
                <?php else: ?>
                Progression: <div class="icon-block"></div>
                <?php endif; ?>
            </li>
            <li>
                <?php if ($apikeyinfo['guilds']==true):?>
                Guilds: <div class="icon-ok"></div>
                <?php else: ?>
                Guilds: <div class="icon-block"></div>
                <?php endif; ?>
            </li>
        </ul>
    </div>
    
    
    
  

</div>
