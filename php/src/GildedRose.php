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

    public function updateQuality(): void{

        foreach ($this->items as $item) {

            //Qualidade por dia
            
            if($item->name != 'Sulfuras, Hand of Ragnaros'){

                $item->sellIn --;

                //Itens que ficam melhores conforme o tempo
                if($item->name == 'Aged Brie' or $item->name == 'Backstage passes to a TAFKAL80ETC concert'){
                     
                    if($item->name == 'Backstage passes to a TAFKAL80ETC concert'){
        
                        if($item->sellIn < 0){
                            $item->quality = 0;
                        }else if($item->quality < 50){
                            if($item->sellIn > 10){
                            $item->quality ++;                    
                            }else if($item->sellIn >= 6 and $item->sellIn <= 10){
                                $item->quality += 2;
                            }else if($item->sellIn >=0 and $item->sellIn <= 5 ){
                                $item->quality += 3;
                            }
                        }

                    }else{
                    
                        if($item-> quality < 50){
                            if($item->sellIn < 0){
                            $item->quality += 2;   
                            }else{
                                $item->quality++;
                            }
                        }
                    }

                }else if($item->name == 'Conjured Mana Cake'){
                    //itens conjurados

                    if($item->quality > 0){
                        if($item->sellIn < 0){
                            $item->quality -= 4;
                        }else{
                            $item->quality -= 2;
                        }
                    }

                }else{
                    //itens normais
                    if($item->quality > 0){
                        if($item->sellIn < 0){
                            $item->quality -=2;
                        }else{
                            $item->quality --;
                        }

                    }

                }
                $item->quality = min(50, max(0, $item->quality));

            }            
        }
    }
}
