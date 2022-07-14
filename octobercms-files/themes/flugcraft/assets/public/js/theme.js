(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/public/js/theme"],{

/***/ "./assets/resources/js/bootstrap.js":
/*!******************************************!*\
  !*** ./assets/resources/js/bootstrap.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// ---
// Initialize jQuery globally
window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"); // Required for OctoberCMS AJAX framework
// Initialize UIkit globally

window.UIkit = __webpack_require__(/*! uikit */ "./node_modules/uikit/dist/js/uikit.js");
window.UIkit.use(__webpack_require__(/*! uikit/dist/js/uikit-icons */ "./node_modules/uikit/dist/js/uikit-icons.js")); // Adds support for UIkit iconography

/***/ }),

/***/ "./assets/resources/js/theme.js":
/*!**************************************!*\
  !*** ./assets/resources/js/theme.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// ---
__webpack_require__(/*! ./bootstrap */ "./assets/resources/js/bootstrap.js");
/* YOUR CODE HERE */


function showNavigationHoverEffect(id) {
  alert("Hello World");
}

/***/ }),

/***/ "./assets/resources/scss/theme.scss":
/*!******************************************!*\
  !*** ./assets/resources/scss/theme.scss ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*******************************************************************************!*\
  !*** multi ./assets/resources/js/theme.js ./assets/resources/scss/theme.scss ***!
  \*******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/matthew/Developer/flugcraft/octobercms-files/themes/flugcraft/assets/resources/js/theme.js */"./assets/resources/js/theme.js");
module.exports = __webpack_require__(/*! /Users/matthew/Developer/flugcraft/octobercms-files/themes/flugcraft/assets/resources/scss/theme.scss */"./assets/resources/scss/theme.scss");


/***/ })

},[[0,"/public/js/manifest","/public/js/vendor"]]]);