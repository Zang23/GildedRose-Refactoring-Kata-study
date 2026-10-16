<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{

    public function testConjuredItemLosesTwoQualityPointsBeforeExpiration(): void{

        $items = [new Item('Conjured Mana Cake', 3, 10)];
        $app = new GildedRose($items);
        $app->updateQuality();

        $this->assertSame(2, $items[0]->sellIn);
        $this->assertSame(8, $items[0]->quality);

    }

    public function testConjuredItemLosesQualityAfterExpiration(): void{

        $items = [new Item('Conjured Mana Cake', 0, 10)];
        $app = new GildedRose($items);
        $app->updateQuality();

        $this->assertSame(-1, $items[0]->sellIn);
        $this->assertSame(6, $items[0]->quality);
    }   
    

    public function testNormalItemLosesQuality(): void{

        $items = [new Item('Normal Sword', 3, 10)];
        $app = new GildedRose($items);
        $app->updateQuality();

        $this->assertSame(2, $items[0]->sellIn);
        $this->assertSame(9, $items[0]->quality);
    }

    public function testNormalItemLosesTwoQualityPointsAfterExpiration(): void{

        $items = [new Item('Normal Sword', 0, 10)];
        $app = new GildedRose($items);
        $app->updateQuality();

        $this->assertSame(-1, $items[0]->sellIn); 
        $this->assertSame(8, $items[0]->quality);
    }

    public function testQualityMinZero(): void{

        $items = [new Item('Normal Sword', 2, 0)];
        $app = new GildedRose($items);
        $app->updateQuality();

        $this->assertSame(1, $items[0]->sellIn);
        $this->assertSame(0, $items[0]->quality);

    }

    public function testQualityMaxAgedBrie(): void{

        $items = [new Item('Aged Brie', 5, 50)];
        $app = new GildedRose($items);
        $app->updateQuality();

        $this->assertSame(4, $items[0]->sellIn);
        $this->assertSame(50, $items[0]->quality);

    }

    public function testQualityPassesExpired(): void{

        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', -1, 34)];
        $app = new GildedRose($items);
        $app->updateQuality();

        $this->assertSame(-2, $items[0]->sellIn);
        $this->assertSame(0, $items[0]->quality);

    }

    public function testQualitySulfuras(): void {

        $items = [new Item('Sulfuras, Hand of Ragnaros', 5, 80)];
        $app = new GildedRose($items);
        $app->updateQuality();


        $this->assertSame(5, $items[0]->sellIn);
        $this->assertSame(80, $items[0]->quality);
    }

    public function testQualityEnchantedSixDaysBeforeExpired(): void{

        $items = [new Item('Enchanted Ring', 7, 35)];
        $app = new GildedRose($items);
        $app->updateQuality();

        $this->assertSame(6, $items[0]->sellIn);
        $this->assertSame(36, $items[0]->quality);
        
    }

    
    public function testQualityEnchantedFiveDaysBeforeExpired(): void{

        $items = [new Item('Enchanted Ring', 5, 35)];
        $app = new GildedRose($items);
        $app->updateQuality();

        $this->assertSame(4, $items[0]->sellIn);
        $this->assertSame(38, $items[0]->quality);
        
    }

    
    public function testQualityEnchantedAfterExpired(): void{

        $items = [new Item('Enchanted Ring', 0, 35)];
        $app = new GildedRose($items);
        $app->updateQuality();

        $this->assertSame(-1, $items[0]->sellIn);
        $this->assertSame(0, $items[0]->quality);
        
    }

}
