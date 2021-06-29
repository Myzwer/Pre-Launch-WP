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
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
