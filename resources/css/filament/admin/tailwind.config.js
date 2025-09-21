import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Clusters/Addresses/**/*.php',
        './resources/views/filament/clusters/addresses/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        "./resources/views/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/js/**/*.{js,jsx,ts,tsx}",
    ],
}
