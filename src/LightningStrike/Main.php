<?php

namespace LightningStrike;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
class Main extends PluginBase implements Listener{
    /** @var Config */
    private $lightning;
    public function onLoad(){
      $this->getLogger()->info(TextFormat::AQUA."Preparing For StartUp... STAND BY");
    }
    public function onEnable(){
      $this->saveDefaultConfig();
      $this->lightning = $this->getConfig()->getAll();
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      $this->getLogger()->info(TextFormat::GREEN."LIGHTNING DEATH RUNNING");
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
    /**
     * @param PlayerDeathEvent $e
     */
    public function onDeath(PlayerDeathEvent $e){
      $p = $e->getEntity();
      if($p instanceof Player && ($this->lightning["death"]["enabled"] === true) && $p->hasPermission("lightningstrike.death")){
        $this->addStrike($p,$this->lightning["death"]["height"]);
      }
    }
    /**
     * @param PlayerJoinEvent $e
     */
    public function onJoin(PlayerJoinEvent $e){
      $e = $e->getPlayer();
      if(($this->lightning["join"]["enabled"] === true) && $p->hasPermission("lightningstrike.join")){
        $this->addStrike($p,$this->lightning["join"]["height"]);
      }
    }
    /**
     * @param PlayerQuitEvent $e
     */
    public function onQuit(PlayerQuitEvent $e){
      $e = $e->getPlayer();
      if(($this->lightning["quit"]["enabled"] === true) && $p->hasPermission("lightningstrike.quit")){
        $this->addStrike($p,$this->lightning["quit"]["height"]);
      }
    }
}
