<?php
namespace PF;
class BowlingGame
{
    private array $rolls = [];
    public function roll(int $score): void
    {
        $this->rolls[] = $score;
    }
    /**
     * @return int
     */
    public function getScore(): int
    {
        $score = 0;
        $roll = 0;
        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($roll)) { // is a strike
                $score += $this->getStrikeScore($roll);
                $roll++;
                continue;
            }
            if ($this->isSpare($roll)) {
                $score += $this->getSpareBonus($roll);
            }
            $score += $this->getFrameAmount($roll);
            $roll += 2;
        }
        return $score;
    }
    /**
     * @param int $roll
     * @return int
     */
    private function getFrameAmount(int $roll): int
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }
    /**
     * @param int $roll
     * @return bool
     */
    private function isSpare(int $roll): bool
    {
        return $this->getFrameAmount($roll) === 10;
    }
    /**
     * @param int $roll
     * @return int
     */
    private function getSpareBonus(int $roll): int
    {
        return $this->rolls[$roll + 2];
    }
    /**
     * @param int $roll
     * @return bool
     */
    private function isStrike(int $roll): bool
    {
        return $this->rolls[$roll] === 10;
    }
    /**
     * @param int $roll
     * @return int
     */
    private function getStrikeScore(int $roll): int
    {
        return 10 + $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }

}