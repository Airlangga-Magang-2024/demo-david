<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class ShopProduct extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function getNavigationLabel(): string
    {
        return 'Products';
    }



    public static function getNavigationGroup(): ?string
    {
        return 'Shop';
    }



    





}
