import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Clusters/ShopProduct/**/*.php',
        './resources/views/filament/clusters/shop-product/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
