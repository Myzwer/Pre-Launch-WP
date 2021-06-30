module.exports = {
    // This is where we set Tailwind's Purge feature. Basically here we tell tailwind to look for any classes not listed
    // in the files below, and purge everything else out.
    // In this case, we want any top level php files (all of our wp theme files) as well as any source js.
    purge: [
        '*.php',
        './assets/src/js/*.js',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            /* How to Add custom Colors
             * Give your color a name, make it something that makes sense.
             * If you aren't going to use the colors below, delete them.
             *
             * Default is the normal base color.
             * Light / Dark are variants within the same palette
             * Classes are named text-CLASSNAME
             *
             * */
            blue: {
                light: '#6495ED', //text-blue-light
                DEFAULT: '#0047AB', //text-blue
                dark: '#00008B', //text-blue-dark
                100: '#ff0000', //text-blue-100
            },
            pink: {
                light: '#ff7ce5',
                DEFAULT: '#ff49db',
                dark: '#ff16d1',
            },
            gray: {
                darkest: '#1f2d3d',
                dark: '#3c4858',
                DEFAULT: '#c0ccda',
                light: '#e0e6ed',
                lightest: '#f9fafc',
            },
            white: {
                DEFAULT: '#ffffff',
            },
            black: {
                DEFAULT: '#000000',
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
