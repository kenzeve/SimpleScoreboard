<?php

declare(strict_types=1);

namespace kenzeve;

use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;

class Scoreboard{

    public const OBJECTIVE_NAME = "SimpleScoreboard";

    private Player $player;
    private bool $created = false;

    public function __construct(Player $player){
        $this->player = $player;
    }

    public function create(string $title) : void{
        if($this->created){
            $this->remove();
        }

        $pk = new SetDisplayObjectivePacket();
        $pk->displaySlot = "sidebar";
        $pk->objectiveName = self::OBJECTIVE_NAME;
        $pk->displayName = $title;
        $pk->criteriaName = "dummy";
        $pk->sortOrder = 0;

        $this->player->getNetworkSession()->sendDataPacket($pk);

        $this->created = true;
    }

    public function remove() : void{
        if(!$this->created){
            return;
        }

        $pk = new RemoveObjectivePacket();
        $pk->objectiveName = self::OBJECTIVE_NAME;
        $this->player->getNetworkSession()->sendDataPacket($pk);

        $this->created = false;
    }

    public function setLine(int $score, string $message) : void{
        if(!$this->created){
            return;
        }

        if($score > 15 || $score < 1){
            return;
        }

        $entry = new ScorePacketEntry();
        $entry->objectiveName = self::OBJECTIVE_NAME;
        $entry->type = $entry::TYPE_FAKE_PLAYER;
        $entry->customName = $message;
        $entry->score = $score;
        $entry->scoreboardId = $score;

        $pk = new SetScorePacket();
        $pk->type = $pk::TYPE_CHANGE;
        $pk->entries[] = $entry;

        $this->player->getNetworkSession()->sendDataPacket($pk);
    }
}