<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            //Qualidade por dia

            if ($item->name === 'Sulfuras, Hand of Ragnaros') {
                continue;
            }

            $item->sellIn--;

            $this->updateItem($item);

            $item->quality = min(50, max(0, $item->quality));
        }
    }

    private function updateItem(Item $item): void
    {
        $increase = 0;

        if ($item->name === 'Aged Brie') {
            if ($item->quality < 50) {
                if ($item->sellIn < 0) {
                    $item->quality += 2;
                } else {
                    $item->quality++;
                }
            }

            return;
        }

        if ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
            if ($item->sellIn < 0) {
                $item->quality = 0;
            } elseif ($item->quality < 50) {
                if ($item->sellIn > 10) {
                    $item->quality++;
                } elseif ($item->sellIn >= 6 and $item->sellIn <= 10) {
                    $item->quality += 2;
                } elseif ($item->sellIn >= 0 and $item->sellIn <= 5) {
                    $item->quality += 3;
                }
            }

            return;
        }

        if ($item->name === 'Conjured Mana Cake') {
            if ($item->quality > 0) {
                if ($item->sellIn < 0) {
                    $item->quality -= 4;
                } else {
                    $item->quality -= 2;
                }
            }

            return;
        }

        if ($item->name === 'Enchanted Ring') {
            if ($item->sellIn > 0) {
                $increase = 1;

                if ($item->sellIn <= 5) {
                    $increase = 3;
                }
            } else {
                $item->quality = 0;
                return;
            }

            $item->quality = min(50, $item->quality + $increase);

            return;
        }

        if ($item->quality > 0) {
            if ($item->sellIn < 0) {
                $item->quality -= 2;
            } else {
                $item->quality--;
            }
        }
    }
}
