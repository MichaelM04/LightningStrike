<?php

namespace LightningOnDeath;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
class Main extends PluginBase implements Listener{

public function onLoad(){
  $this->getLogger()->info("Preparing For StartUp STAND BY"); //Useless
}

public function onEnable(){
  $this->getServer()->getPluginManager()->registerEvents($this, $this);
  $this->getLogger()->info("LIGHTNING STRIKES ARE READY!");
}
    public function PlayerJoin(PlayerJoinEvent $e){
        $p = $e->getPlayer();
        $level = $p->getLevel();
        $light = new AddEntityPacket();
        $light->type = 93;
        $light->eid = Entity::$entityCount++;
        $light->metadata = array();
        $light->speedX = 0;
        $light->speedY = 0;
        $light->speedZ = 0;
        $light->x = $p->x;
        $light->y = $p->y;
        $light->z = $p->z;
        foreach($level->getPlayers() as $pl){
        $pl->dataPacket($light);
        }
    }

public function onDeath(PlayerDeathEvent $ent){

  $player = $ent->getEntity();
  $lightningdeathstrike = new AddEntityPacket();
  $lightningdeathstrike->type = 93;
  $lightningdeathstrike->eid = Entity::$entityCount++;
  $lightningdeathstrike->metadata = array();
  $lightningdeathstrike->speedX = 0;
  $lightningdeathstrike->speedY = 0;
  $lightningdeathstrike->speedZ = 0;
  $lightningdeathstrike->x = $player->x;
  $lightningdeathstrike->y = $player->y;
  $lightningdeathstrike->z = $player->z;
  $player->dataPacket($lightningdeathstrike);
  }
}
