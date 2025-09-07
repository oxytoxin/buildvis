import preset from "../../../../vendor/filament/filament/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./app/Filament/Store/**/*.php",
        "./resources/views/filament/store/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./resources/views/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/js/**/*.{js,jsx,ts,tsx}",
    ],
};
