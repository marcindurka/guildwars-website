<?php if(!isset($_SESSION['is_logged_in'])):?>
    <div class="login-msg neutral-msg site background-default">
        Aby przeglądać zawartość tej strony musisz się zalogować!
    </div>
<?php else:
    $api = new apigw2();
    $uri = explode('/',$_SERVER['REQUEST_URI']);
    $slashes=count($uri)-1;
    //echo $slashes;
    $prefix=$uri[$slashes];
    if (($prefix!="account")&&
        ($prefix!="guild")&&
        ($prefix!="characters")&&
        ($prefix!="titles")):
    $prefix="account";  
    endif;
    //echo $prefix;
    $useraccount=$api->api("account", $_SESSION['user_data']['gw2id']);
?>
<div class="background-default site">
    <div class="profile-name">
        <span class="profile-name-span">Profil użytkownika <?php echo $_SESSION['user_data']['name'].' (' .$useraccount['name'].' )';?></span>
    </div>
    <nav class="nav-profile center">
        <ul class="nav-profile-ul">
            <li><a href="<?php echo ROOT_URL; ?>users/profile/account" <?php if($current_page=="profile"): echo 'class="current-page"'; endif;?>>Dane konta</a></li>
            <li><a href="<?php echo ROOT_URL; ?>users/profile/guild" <?php if($current_page=="guild"): echo 'class="current-page"'; endif;?>>Gildie</a></li>
            <li><a href="<?php echo ROOT_URL; ?>users/profile/characters" <?php if($current_page=="characters"): echo 'class="current-page"'; endif;?>>Postacie</a></li>
            <li><a href="<?php echo ROOT_URL; ?>users/profile/titles" <?php if($current_page=="titles"): echo 'class="current-page"'; endif;?>>Tytuły</a></li>
        </ul>
    </nav></br>  
<?php if ($prefix=="account"):?>
    <div class="profile-account">
        <table class="gw2-account center">
            <tr><th colspan="2">Informacje o koncie Guild Wars 2</th></tr>
            <tr><td>Account name </td><td><?php echo $useraccount['name'];?></td></tr>
            <tr><td>Home server</td><td>
                <?php 
                    $homeworld=$api->apiopen("worlds", $useraccount['world']);
                    echo $homeworld['name'];
                ?></td></tr>
            <tr><td>Age </td><td><?php echo $useraccount['age'];?></td></tr>
            <?php 
                $i=0;
                foreach ($useraccount['guilds'] as $guildid):
                    $guildname=$api->apiopen("guild",$guildid);
                    $i=$i+1;    
            ?>
                    <tr><td>Gildia nr <?php echo $i;?> </td><td><?php echo $guildname['name']." [".$guildname['tag']."]";?></td></tr>
            <?php endforeach;
                $i=0;
                foreach ($useraccount['guild_leader'] as $guildid):
                    $guildname=$api->apiopen("guild",$guildid);
                    $i=$i+1;   
            ?>  
                    <tr><td> Guild Master nr <?php echo $i; ?></td><td><?php echo $guildname['name']." [".$guildname['tag']."]"; ?></td>
            <?php endforeach; ?></tr>
            <tr><td> Created </td><td><?php echo $useraccount['created'];?></td></tr>
            <tr><td> Fractal level</td><td><?php echo $useraccount['fractal_level'];?></td> </tr>
            <tr><td> WvW rank </td><td><?php echo $useraccount['wvw_rank']; ?></td></tr>
            <tr><td> Daily AP</td><td><?php echo $useraccount['daily_ap'];?></td></tr>
            <tr><td> Commander</td><td><?php 
                    if ($useraccount['commander']==true):
                        echo "Tak"; 
                    else: 
                        echo "Nie";
                    endif;
                    ?></td></tr>
            <tr><td> Dostęp </td><td><?php echo $useraccount['access']; ?></td></tr>
            <tr><td> Postaci na koncie: </td><td>
                    <?php 
                        echo $characters=count($api->api("characters", $_SESSION['user_data']['gw2id']));
                    ?></td></tr>       
        </table>
    </div>
<?php elseif($prefix=="guild"): ?>
    <div class="profile-account">
        <table class="gw2-account center">
            <tr><th colspan="2">Twoje gildie</th></tr>
            <?php 
                $i=0;
                foreach ($useraccount['guilds'] as $guildid):
                    $guildname=$api->apiopen($prefix,$guildid);
                    $i=$i+1;    
            ?>
                    <tr><td>Gildia nr <?php echo $i;?> </td><td><?php echo $guildname['name']." [".$guildname['tag']."]";?></td></tr>
            <?php endforeach;
                $i=0;
                foreach ($useraccount['guild_leader'] as $guildid):
                    $guildname=$api->apiopen($prefix,$guildid);
                    $i=$i+1;   
            ?>  
                    <tr><td> Guild Master nr <?php echo $i; ?></td><td><?php echo $guildname['name']." [".$guildname['tag']."]"; ?></td>
            <?php endforeach; ?></tr>
        </table>
    </div>
<?php elseif($prefix=="characters"): ?>
    <div class="profile-account">
        <table class="gw2-account center">
            <tr><th colspan="2">Twoje postaci</th></tr>
            <?php 
            $characters=$api->api($prefix,$_SESSION['user_data']['gw2id']);
                $i=0;
                foreach ($characters as $charname):
                     $i=$i+1;   
            ?>
                    <tr><td><?php echo $i;?> </td><td><?php echo $charname;?></td></tr>
            <?php endforeach;?>
        </table>
    </div>
<?php elseif($prefix=="titles"): 
    $accounttitles=$api->api("account/".$prefix,$_SESSION['user_data']['gw2id']);
?>
    <div class="profile-account">
        <table class="gw2-account center">
            <tr><th colspan="2">Twoje tytuły <?php echo "(".count($accounttitles).")";?></th></tr>
            <?php 

                $i=0;
                foreach ($accounttitles as $titleid):
                    $title=$api->apiopen($prefix,$titleid);
                    $i=$i+1;    
            ?>
                    <tr><td><?php echo "#".$titleid;?> </td><td><?php echo $title['name'];?></td></tr>
            <?php endforeach;?>
                
        </table>
    </div>
<?php endif; ?> 
</div>
<?php endif;