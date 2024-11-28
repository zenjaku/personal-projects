const browserSync = require("browser-sync").create();

browserSync.init({
    proxy: "localhost:3001",
    files: ["*.php", "pages/*.php", "components/*.php", "css/*.css", "js/*.js"],
    notify: true,
    port: 3000,
});
