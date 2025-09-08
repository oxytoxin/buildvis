import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/ProjectManager/**/*.php',
        './resources/views/filament/project-manager/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        "./resources/views/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/js/**/*.{js,jsx,ts,tsx}",
    ],
}
