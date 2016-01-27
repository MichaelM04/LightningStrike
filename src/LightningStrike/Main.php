<?php

namespace LightningStrike;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
class LightningStrike extends PluginBase implements Listener{
    /** @var Config */
    private $lightning;
    public function onLoad(){
      $this->getLogger()->info(TextFormat::AQUA."Preparing For StartUp... STAND BY");
    }
    public function onEnable(){
      $this->getLogger()->info(TextFormat::GREEN."Lightning Strike RUNNING Made By MichaelM04");
    }
    /**
     * @param Player $p
     * @param $height
     */
    public function addStrike(Player $p, $height){

$level = $p->getLevel();

$light = new AddEntityPacket();

$light->type = 93;

$light->eid = Entity::$entityCount++;

$light->metadata = array();

$light->speedX = 0;

$light->speedY = 0;

$light->speedZ = 0;

$light->yaw = $p->getYaw();

$light->pitch = $p->getPitch();

$light->x = $p->x;

$light->y = $p->y+$height;

$light->z = $p->z;

Server::broadcastPacket($level->getPlayers(),$light);

   }
    public function onJoin(PlayerJoinEvent $e){
	$p = $e->getPlayer();
	$light = new AddEntityPacket();
        $light->type = 93;
        $light->eid = Entity::$entityCount++;
        $light->metadata = array();
        $light->speedX = 0;
        $light->speedY = 0;
        $light->speedZ = 0;
        $light->yaw = $p->getYaw();
        $light->pitch = $p->getPitch();
        $light->x = $p->x;
        $light->y = $p->y;
        $light->z = $p->z;

Server::broadcastPacket($level->getPlayers(),$light);
    	
    }

    public function onDeath(PlayerDeathEvent $e){

$p = $e->getEntity();

if($p instanceof Player && ($this->lightning["death"]["enabled"] === true) && $p->haspermission("lightningstrike.death)){

$this->addStrike($p,$this->lightning["death"]["height"]);
    }
  }
}
