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
		$this->saveDefaultConfig();
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
		if($cmd->getName() === "commandcharger"){
			if(!$sender->hasPermission("cc.cmd")){
				$sender->sendMessage(self::PREFIX . "You dont have permission to use /cc");
				return true;
			}
			if(count($args) === 0){
				$sender->sendMessage(self::PREFIX . "/cc help");
			}
			switch(strtolower($args[0])){
				case 'help':
					$sender->sendMessage(C::GREEN . "----==" . C::WHITE . "[" . C::RED . "CommandCharger" . C::WHITE . "]" . C::GREEN . "==----");
					$sender->sendMessage(C::GREEN . "/cc help" . C::WHITE . "CC Help page.");
				return true;
					break;
				case 'info':
					$sender->sendMessage(self::PREFIX . "CommandCharger by xXSirGamesXx");
					break;
			}
		}
	}
	public function onPCommand(PlayerCommandPreprocessEvent $e){
		$player = $e->getPlayer();
		$msg = $e->getMessage();
		$money = EconomyAPI::getInstance()->myMoney($player);
		$cfg = $this->getConfig()->getAll();
		foreach($cfg["Commands"] as $c){
			if(!$player->hasPermission("cc.charge.avoid")){
				if(strtolower($msg) == $c['CMD']){
					if(EconomyAPI::getInstance()->myMoney($player) >= $c['Price']){
						$player->sendMessage(self::PREFIX . "You have been charged " . C::YELLOW . $c["Price"] ."$" . C::GREEN . "For using " . $c["CMD"]);
						EconomyAPI::getInstance()->reduceMoney($player, $c['Price']);
					}else{
						$player->sendMessage(C::PREFIX . "You dont have enough money for this command.");
						$e->setCancelled(true);
					}
				}else{
				return true;
				}
			}
		}
				
	}
}

