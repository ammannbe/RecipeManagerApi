/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */
__webpack_require__(/*! ./toast.js */ "./resources/js/toast.js");

__webpack_require__(/*! ./form.js */ "./resources/js/form.js");

__webpack_require__(/*! ./noscript.js */ "./resources/js/noscript.js");

/***/ }),

/***/ "./resources/js/form.js":
/*!******************************!*\
  !*** ./resources/js/form.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var cssFormPath = '.form form';
  $(window).click(function () {
    $(cssFormPath + ' .js-dropdown').removeClass('show');
    $(cssFormPath + ' .js-dropdown').addClass('hidden');
  });
  $(cssFormPath + ' .js-dropdown li').click(function (event) {
    event.stopPropagation(); // Prevent hide on $(window).click
  });
  $(cssFormPath + ' .text-input').on('keyup', function () {
    var $listInput = $(this).siblings('.js-dropdown');

    if (!$.trim($(this).val())) {
      $listInput.addClass('hidden');
      $listInput.removeClass('show');
    } else {
      $listInput.removeClass('hidden');
      $listInput.addClass('show');
      var value = $(this).val().toLowerCase();
      $listInput.children('li').filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    }
  });
  $(cssFormPath + ' .js-dropdown li').click(function () {
    var $listInput = $(this).parent();
    var $textInput = $listInput.siblings('.text-input');
    $textInput.val($(this).text());
    $listInput.removeClass('show');
    $listInput.addClass('hidden');
  });
  $(cssFormPath + ' button.arrow-down').click(function (event) {
    event.preventDefault();
    event.stopPropagation(); // Prevent hide on $(window).click

    var $listInput = $(this).siblings('ul.js-dropdown');

    if ($listInput.is(':visible')) {
      $listInput.removeClass('show');
      $listInput.addClass('hidden');
    } else {
      $listInput.removeClass('hidden');
      $listInput.addClass('show');
    }

    $listInput.children('li').show(); // $listInput.toggle();
  });
});

/***/ }),

/***/ "./resources/js/noscript.js":
/*!**********************************!*\
  !*** ./resources/js/noscript.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('.noscript').remove();
});

/***/ }),

/***/ "./resources/js/toast.js":
/*!*******************************!*\
  !*** ./resources/js/toast.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('.toast .alert button').click(function () {
    $(this).parent().fadeOut('slow');
  });
});

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/benjamin/projects/Cookbook/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /home/benjamin/projects/Cookbook/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });