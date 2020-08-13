<?php

use PF\BowlingGame;

require_once 'src/BowlingGame.php';
class BowlingGameTest  extends \PHPUnit\Framework\TestCase
{
    // test{methodName}_{conditions}_{expectedResult}
    public function testGetScore_withAll0_resultIs0()
    {
        $game = new BowlingGame();
        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }
        $result = $game->getScore();
        self::assertEquals(0, $result);
    }
    public function testGetScore_withAll1_resultIs20()
    {
        $game = new BowlingGame();
        for ($i = 0; $i < 20; $i++) {
            $game->roll(1);
        }
        $result = $game->getScore();
        self::assertEquals(20, $result);
    }
    public function testGetScore_withASpare_returnsScoreWithSpareBonus()
    {
        $game = new BowlingGame();
        $game->roll(3);
        $game->roll(7);
        $game->roll(5);
        for ($i = 0; $i < 17; $i++) {
            $game->roll(1);
        }
        // 3 + 7 + 5 + 5 + 17 = 37
        $result = $game->getScore();
        self::assertEquals(37, $result);
    }
     public function testGetScore_withAStrike_returnsScoreWithStrikeBonus()
    {
        $game = new BowlingGame();
        $game->roll(10);
        $game->roll(4);
        $game->roll(4);
        for ($i = 0; $i < 16; $i++) {   //jo pirmaja freimā bija 1, otrajā 2 metieni. paliek 8 freimi (=16 metieni)
            $game->roll(1);
        }
        // 10 + 4 + 4 + 4 + 4 + 16
        $result = $game->getScore();
        self::assertEquals(42, $result);
    }

    public function testGetScore_withAllStrikes_returnsScoreWithAPerfectGame()
    {
        $game = new BowlingGame();
        for ($i = 0; $i < 10; $i++) {
            $game->roll(10);
        }
        $result = $game->getScore();
        self::assertEquals(300, $result);
    }
}