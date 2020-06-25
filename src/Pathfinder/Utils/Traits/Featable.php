<?php

namespace Pathfinder\Utils\Traits;

use \Pathfinder\Feat\Feat;

trait Featable
{
	private $feats = [];
	
	public function getFeats(): array
    {
        return $this->feats;
    }

    public function hasFeat(Feat $featClass): bool
    {
        return $this->hasFeats([$featClass]);
    }

    public function hasFeats(array $feats): bool
    {
        return count($this->searchFeats($feats)) == count($feats);
    }

    public function searchFeats(array $feats): array
    {
        $filteredFeats = array_filter($feats, function (Feat $featClass) {

            $filteredFeat = array_filter($this->feats, function (Feat $feat) use ($featClass) {
                return get_class($featClass) === get_class($feat);
            });

            return count($filteredFeat) > 0;
        });

        return $filteredFeats;
    }

    public function addFeat(Feat $feat): void
    {
        if (! $feat->checkRequirements($this))
            throw new \Exception("{$this->getName()} doesn't meet the requirements for feat ('{$feat->getName()}')", 1);
            
        array_push($this->feats, $feat);
    }
}