<?php

namespace titlelr;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Server;

class Main extends PluginBase implements Listener {
	
      public function onEnable() {
		  $this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
      }
	  
	  public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
		 if ($command == "타이틀") {
			if(!isset($args[0])){
			    if ($sender->isOp ()) {	
				$this->ui($sender);
				return true;
			}
			if(!$sender->isOp ()) {
				$sender->sendMEssage("§l§b[§l§r타이틀§l§b]§7 권한이 없습니다 !");
				return true;
			}
		 }
	}
}
	public function ui(Player $player) {
	    $name = strtolower($player->getName());
		$encode = json_encode([
			"type" => "custom_form",
			"title" => "§lTITLE UI",
			"content" => [
				[
				    "type" => "input",
					"text" => "§l§b[§l§r타이틀§l§b]§7 화면에 표시할 말을 적어주세요.\n§l§b제작자 : 리더",
					"placeholder" => "적어주세요."
				]
				]
					]);
		$pack = new ModalFormRequestPacket();
		$pack->formId = 1712;
		$pack->formData = $encode;
		$player->dataPacket($pack);
	}
	public function ui1(DataPacketReceiveEvent $event) {
		$pack = $event->getPacket();
		$player = $event->getPlayer();
		$name = $player->getName();
		if($pack instanceof ModalFormResponsePacket and $pack->formId == 1712) {
		$line = json_decode($pack->formData, true);
		if($line[0] == null) {
			$player->sendMEssage("§l§b[§l§r타이틀§l§b]§7 제대로 적어주시기 바랍니다 !");
	} else {
		foreach ($this->getServer()->getOnlinePLayers() as $player) {
			$player->addTitle("§l§6[§l§r!§l§6]§l§7 {$line[0]}");
	}
	}
       }
	}
}
