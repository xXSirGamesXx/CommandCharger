<?php
	
namespace xXSirGamesXx\CommandCharger;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as C;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener {
	const PREFIX = C::WHITE . "[" . C::RED . "CommandCharger" . C::WHITE . "] " . C::GREEN; 
		
		public function onLoad() {
		$this->getLogger()->info("Loading CommandCharger");
	}
	
	public function onEnable() { 
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("CommandCharger by xXSirGamesXx enabled!");
	}
	
	public function onDisable() { 
		$this->getLogger()->info("CommandCharger by xXSirGamesXx disabled!");
		$this->saveDefaultCnfig();
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
		if($cmd->getName() == "commandcharge") { 
			$sender->sendMessage(self::PREFIX . "CommandCharger by xXSirGamesXx.");
		}
	}
	public function onPCommand(PlayerCommandPreprocessEvent $e){
		$player = $e->getPlayer();
		$msg = $e->getMessage();
		$money = $this->api->myMoney($player);
		$cfg = $this->getConfig()->getAll();
		foreach($cfg["Commands"] as $c){
			if(!$player->hasPermission("cc.charge.avoid")){
				if(strtolower($msg) == $c["CMD"] and $this->api->myMoney($player) >= $c["Price"]){
					$player->sendMessage(self::PREFIX . "You have been charged " . C::YELLOW . $c["Price"] ."$" . C::GREEN . "For using " . $c["CMD"]);
					$this->api->reduceMoney($player, $c["Price"]);
				}else{
					$player->sendMessage(self::PREFIX . C::RED . "You do not have enough money for " . C::YELLOW . $c["CMD"]);
					$e->setCancelled(true);
				}
			}else{
				$player->sendMessage(self::PREFIX . "You were not charged for using " . C::AQUA . $c["CMD"]);
			}
		}
				
	}
}

