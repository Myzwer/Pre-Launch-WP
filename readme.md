# Wordpress Pre-Launch 🚀

![WebPack 5.44.0](https://img.shields.io/badge/WebPack-5.44.0-brightgreen)
![Babel 7.14.6](https://img.shields.io/badge/Babel-7.14.6-brightgreen)
![BrowserSync 2.27.4](https://img.shields.io/badge/BrowserSync-2.27.4-brightgreen)
![PostCSS 8.3.5](https://img.shields.io/badge/PostCSS-8.3.5-brightgreen)
![Tailwind 3.1.3](https://img.shields.io/badge/Tailwind-2.2.4-brightgreen)

Wordpress Pre-Launch is a VERY beginnger friendly wordpress template built on webpack. It makes use of webpack, Babel, Sass, Tailwind, Browsersync, PostCSS, ESLint, Stylelint, Prettier and more. And if you have no idea what any of that is, then this is the template for you.
***
# Table of Contents: 
**Main**
1. [Features and Benefits](#features-and-benefits)
2. [Project Requirements](#requirements)

**2 Types of People**
1. [I Know What I'm Doing](#section-1-i-know-what-im-doing)
2. [Lol I Have No Idea What I'm Doing](#section-2-lol-i-have-no-idea-what-im-doing)

**What does this do?**
1. Nothing yet here.

**How to do all things**
1. [Adding Custom Fonts](#how-to-add-fonts-to-your-project)  
2. [Navbar](#navbar---headerphp)  
***

## Features and Benefits
**General**

- [**Webpack.**](https://classic.yarnpkg.com/en/package/webpack) Built on webpack, this template allows for a modern development workflow + a production ready build.
- **Minification.** Complete with webpack's native features and CSSNano, this gets your CSS and JS files smaller than things in 40 degree water.
- [**Prettier.**](https://prettier.io/) An opinionated code formatter. It automagically formats all your code on save so that it always looks the same. This forces everyone's code to look the same, so no more arguing about tabs vs spaces.
- [**BrowserSync.**](https://browsersync.io/) Browsersync synchronises browsers, URLs, interactions and code changes across devices and automatically refreshes all the browsers on all devices on changes. If you have never used this it'll blow your mind.
- [**Sourcemaps.**]() Webpack generates sourcemaps for all js and css files. This helps with debugging simply because when you don't have them enabled your code hides from you like slenderman.
- Configuration. All of the config files have been neatly organized into /webpack to keep them out of the way of the main files. Webpack.config being the exception.

**CSS**

- [**PostCSS.**](http://postcss.org/) PostCSS allows for some code to be injected after the fact, most noteably...
- [**Autoprefixer.**](https://github.com/postcss/autoprefixer) Remember those CSS vendor prefixes you didn't add? Well autoprefixer has you covered.
- [**TailwindCSS.**](https://tailwindcss.com/) Tailwind is the CSS framework all the kids are tweeting about. If you aren't familiar, it basically generates like 4.8 million CSS classes so you never have to write CSS again. And it cleans up after itself, which is nice.
- [**Sass.**](https://webpack.js.org/loaders/sass-loader/) Technicaly SCSS. But we call it sass. Compiles Sass down into CSS so browsers can read it.

**JS**

- [**BabelJS.**](https://babeljs.io/) Allows you to use next gen Javascript by transpiling it (dumbing it down) to something IE 4 can understand (that claim isn't tested).

## Requirements

- [Node.js](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [NPM](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [Yarn](https://classic.yarnpkg.com/en/docs/install/#mac-stable)

---
<img src = "https://i.imgflip.com/5gak9s.jpg" width= 50%; alt = "How do you do fellow coders?">

# Section 1: I Know What I'm Doing.

You've got it then. 

```bash
# 1-- Set up a local instance of Worpress in Local or something.
# 2-- Clone this into your themes folder (as a new theme)

$ git clone https://github.com/Myzwer/Pre-Launch-WP.git

# 2-- Edit the BrowserSync settings in `webpack.config.js`. Ya can't miss it.
# 3-- Install yarn and all the project dependencies

$ yarn install

# 4-- Run a command and start making some magic.
yarn dev
yarn dev:watch
yarn prod
yarn prod:watch
```

# Section 2: Lol I have no idea what I'm doing.

Good. You're like me. This guide aims to be pretty extensive, so buckle up. Some of this might already be up and running on your machine, and that's great, but this guide assumes you are starting from scratch. If you haven't gathered it already, I have a pretty unique sense of humor, but hopefully it makes this more fun to read. Or maybe Comedy Central will give me a call if this doesn't work out.

Couple Notes before we start:

- I am developing on a MacBook Pro running Catalina. If you are developing on a mac, everything should be the same, but Windows users might have other issues. At this time I do not have the bandwidth to check for issues / incompatibilities on windows. Sorry. :(
- If the rest of this seems hella incomplete, it probably is. I am currently pushing new commits pretty frequently, and so guides will come with that.
- While the aim of this guide is to help users get set up as much as possible, I am not going to cover how to build out a complete theme in WordPress. The goal is to get you from 0 to a working template, then run on your own. I will happily link resources on how to do things when appropriate.

**This is still a work in progress. I plan to write a lot more, but it's going to be as I go. The template is usable, but the readme is still under construction. 🚧 Bear with me as this is updated.**

***
***
# How To Add Fonts To Your Project
### Google Fonts
1. Go to https://fonts.google.com/
2. Pick a font family that you like, and select a few styles. (as a note, the more files you choose the slower the site will be. So only pick ones you need to use)
3. Under "use on the web" section, make sure < link > is selected, and look at the code that is generated. It should look _something_ like this: 
```
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
```
4. Copy the link from the 3rd block, minus the &display=swap. In the example above, it would be this:
```css
https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400
```
5. Navigate to functions.php, specifically the fonts part.
6. Drop in this code:
```php
wp_register_style( 'FONTNAME_font', 'FONTLINK' );
wp_enqueue_style('FONTNAME_font');
```
7. Name it whatever where FONTNAME_font is (it doesn't matter what you call it, but it does make sense to name it the fontname for ease of reference later), and add the link to FONTLINK. So to complete our example:
```php
wp_register_style( 'roboto_font', 'https://fonts.googleapis.com/css2?familY=Roboto:ital,wght@0,400;0,500;0,700;1,400' );
wp_enqueue_style('roboto_font');
```
8. Go back to google, copy the font family section and you can begin using it in your CSS!
9. (optional) If you are still using tailwind, go into tailwind.config.js and update the fontFamily section. This is already done for you so you should be able to easily swap out my code for your new font code.
```css
fontFamily: {
       'myfontname': ['Roboto', 'sans-serif'], // text-roboto
      }
  ```
---
### Custom Fonts
1. Purchase or download font files. They will most likely come as .otf or .ttf or something like that. It doesn't matter which you use. 
2. Go to [Transfonter](https://transfonter.org/) and select the fontses you want to include. The more files you include the slower your website will be, so only get the ones you need. Bigger is not always better. Girls do care about the [size of your megapixel.](https://youtu.be/eg8u_Q1tNlo?t=22)
3. Upload the font files to the site.
4. You do not need to adjust any settings on the bottom section unless you want to.
5. Download your @font-face kit zip file with new fonts!
6. Upzip. 😉
7. You don't need demo.html, though can see what your fonts looks like on a page if you load it up. 
8. Copy all .woff and .woff2 files into ./assets/src/webfonts in the wordpress project. You can delete any existing files that you no longer need including the gitkeep file.
9. Open up stylesheet.css, copy all the code out of it, and paste that into fonts.css. (.assets/src/sass/fonts/)
10. Lastly, you'll need to tell your fonts where they can find the woff files. This means adding ``../../webfonts/`` to the beginnging of all of your URL's.
```css
font-family: "MYFONT";
  src: url("../../webfonts/MYFONT.woff2") format("woff2"),
    url("../../webfonts/MYFONT.woff") format("woff");
  font-weight: 900;
  font-style: normal;
  font-display: swap;
```
11. Once added, if you have prettier and stylelint up and running, both of those will throw errors, so hop over to iterm and type ``yarn stylelint`` to get it fixed. 
12. Once linked like this, you are free to use your new font families! The name is whatever fontfamily is called. In the above example (where I showed linking) MYFONT would be the name you'd use. 
13. (optional) If you are still using tailwind, go into tailwind.config.js and update the fontFamily section. This is already done for you so you should be able to easily swap out my code for your new font code.
```css
fontFamily: {
       'myfontname': ['Bleeding Cowboy', 'serif'], // text-bleeding-cowboy
      }
  ```
# Navbar - Header.php
<img src = "https://i.imgflip.com/5ku7z5.jpg" width= 50%; alt = "What the hell happened here?">

So if you've never had the pleasure of creating a navbar before, it's a tossup between creating one and getting waterboarded for me. They are miserable to deal with for a couple reasons. They are already finicky enough without introducing wordpress into the mixture. 

Wait, what do you mean "in wordpress"? I mean that your navbar isn't much good if the URL's are only work on local or production, but not both. Or if the user can't go in and edit a link like they wanted to. So we build it In wordpress, meaning we use php to generate the navbar code on the server side, rather than a whole bunch of HTML. However, wordpress has a very specific way of outputing code, and it is without fail NEVER the code you needed it to be. So we use a custom navwalker to fix this. 

That sounds complicated. It was, luckily it's done for you. The navbar is plug and play as is, right now. 

*** IMPORTANT NOTE: THIS NAVBAR DOES NOT USE TAILWIND SO REMOVING TAILWIND FROM THE PROJECT WILL NOT EFFECT IT. ***

### **I just want to use the navbar as is.**
Great! You can swap the logo out in `header.php` and edit the links in WP admin. Happy coding!

### **Ok so I like it, but I wanna tweak some things.**
Well, head over to `/assets/src/sass/components/_navbar.scss`. Notice at the top there's some SCSS variables with comments. These are some "hotfix" style things you can edit such as width, height, breakpoint, colors, etc. If you can't accomplish what you are looking to do via those, you'll need to jump into the code to make your changes. I've commented as well as I can for you. Happy Coding!

### **Nah I've got my own navbar, can I use that?**
Sure. It's your project and I didn't include malware with this install to tell me whether you tampered with the navbar or not. To get rid of it and add your own:
1. Delete everything out of `/assets/src/sass/components/_navbar.scss`. I don't see a reason why you wouldn't just replace it with your new css, but if you want to delete the file you can.
2. Delete all the code in `header.php` FROM `<section class="navigation">` through `</section>`. Leave the rest alone.
3. You might need to edit functions.php as well, depending on to what extext you are pruging the navbar. 

Good luck with your own navbar! I'd recommend you follow this pattern but it really up to you. Again, malware free over here.
1. Get the navbar working independent of your project, in codepen or something. Eliminates a lot of "is this not working because the code is wrong or because the project is messing it up?"
2. Import it in, and get it working static. meaning no php, none of that. Once you see that the navbar is working perfectly...
3. Convert it to wordpress. How to do that is beyond the scope of this readme, but there are plenty of resources online to help. Don't fall into the trap of saying you don't need to convert it. You do. It'll save you and your clients a headache in the future. 
- https://www.wpbeginner.com/beginners-guide/how-to-add-navigation-menu-in-wordpress-beginners-guide/
- https://css-tricks.com/the-wordpress-nav-walker-class-a-guided-var_dump/
Happy coding!


# Footer - Footer.php
Footers. Are they as bad as navbars? No. Are they at least easy to work with? Also no. Much like headers, they are already finicky enough without creating them in wordpress.

Wait, what do you mean "in wordpress"? I mean instead of a bunch of HTML that probably consists of `<footer>` and `<ul>` and such, you have a block of php that renders out some of the footer. Unlike the navbar, only part of the footer will be generated by Wordpress, namely because there is more to a footer than links. However, the links will be generated from Wordpress. We do it this way for a few reasons:
1. Your footer isn't much good if the URL's are only work on local or production, but not both. When PHP can't change them dynamically, you have to pick one or the other. 
2. Ideally your end user (client) would be able to change thier own footer and not need you to update it for them right? And even if they don't want to do that, it'll be a quick change. Like that magic act. 

So when we build this in wordpress, it is giong to generate some classes. However, unlike the navbar, we can use the CSS to work with these, as I've done here. The footer is set up and ready to go. It will need edited to make sure it looks the way you like, and adjustments for size will need to be made.

**IMPORTANT NOTE: THIS NAVBAR DOES NOT USE TAILWIND SO REMOVING TAILWIND FROM THE PROJECT WILL NOT EFFECT IT.**

### **I just want to use the footer as is.**
Good. She's a beaut, Clark. You'll need to make a few adjustments. 
1. Go to footer.php. 
2. Update the logo, then adjust the scss to make the image look good and feel spaced right.
3. Update the phone number and name.
4. Change the links in WP admin.
5. Update the company text and copyright
6. Change the socials and add / remove any ones you do / don't need. 
7. Don't change anything else, you'll break stuff you don't mean to. 

### **Ok so I like it, but I wanna tweak some things.**
Doesn't surprise me. The nature of the way it was built means that you'll probably have to do some light editing even if you want to keep it the same.  Anyway to edit it just navigate to `/assets/src/sass/components/_footer.scss` and start changing things. I've commented as well as I can. Good luck and Happy Coding!

### **Nah I've got my own footer, can I use that?**
Figures 🙄. Do what you must. 
1. Delete everything out of `/assets/src/sass/components/_navbar.scss`. I don't see a reason why you wouldn't just replace it with your new css, but if you want to delete the file you can.
2. Delete all the code in `footer.php` FROM the end of the opening php on line 12 to `<?php wp_footer(); ?>`. MAKE SURE YOU DON'T DELETE THAT, WORDPRESS NEEDS IT TO WORK. 
3. You might need to edit functions.php as well (the menus section), depending on to what extent you are purging the navbar. 

Good luck with your own footer! I'd recommend you follow this pattern but it really up to you. 
1. Get the footer working independent of your project, in codepen or something. Eliminates a lot of "is this not working because the code is wrong or because the project is messing it up?"
2. Import it in, and get it working static. meaning no php, none of that. Once you see that the navbar is working perfectly...
3. Convert it to wordpress. How to do that is beyond the scope of this readme, but there are plenty of resources online to help. Don't fall into the trap of saying you don't need to convert it. You do. It'll save you and your clients a headache in the future. 

Happy coding!