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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/tinymce/plugins/lists/plugin.js":
/*!******************************************************!*\
  !*** ./node_modules/tinymce/plugins/lists/plugin.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/**
 * Copyright (c) Tiny Technologies, Inc. All rights reserved.
 * Licensed under the LGPL or a commercial license.
 * For LGPL see License.txt in the project root for license information.
 * For commercial licenses see https://www.tiny.cloud/
 *
 * Version: 5.6.0 (2020-11-18)
 */
(function () {
  'use strict';

  var global = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var noop = function noop() {};

  var constant = function constant(value) {
    return function () {
      return value;
    };
  };

  var not = function not(f) {
    return function (t) {
      return !f(t);
    };
  };

  var never = constant(false);
  var always = constant(true);

  var none = function none() {
    return NONE;
  };

  var NONE = function () {
    var eq = function eq(o) {
      return o.isNone();
    };

    var call = function call(thunk) {
      return thunk();
    };

    var id = function id(n) {
      return n;
    };

    var me = {
      fold: function fold(n, _s) {
        return n();
      },
      is: never,
      isSome: never,
      isNone: always,
      getOr: id,
      getOrThunk: call,
      getOrDie: function getOrDie(msg) {
        throw new Error(msg || 'error: getOrDie called on none.');
      },
      getOrNull: constant(null),
      getOrUndefined: constant(undefined),
      or: id,
      orThunk: call,
      map: none,
      each: noop,
      bind: none,
      exists: never,
      forall: always,
      filter: none,
      equals: eq,
      equals_: eq,
      toArray: function toArray() {
        return [];
      },
      toString: constant('none()')
    };
    return me;
  }();

  var some = function some(a) {
    var constant_a = constant(a);

    var self = function self() {
      return me;
    };

    var bind = function bind(f) {
      return f(a);
    };

    var me = {
      fold: function fold(n, s) {
        return s(a);
      },
      is: function is(v) {
        return a === v;
      },
      isSome: always,
      isNone: never,
      getOr: constant_a,
      getOrThunk: constant_a,
      getOrDie: constant_a,
      getOrNull: constant_a,
      getOrUndefined: constant_a,
      or: self,
      orThunk: self,
      map: function map(f) {
        return some(f(a));
      },
      each: function each(f) {
        f(a);
      },
      bind: bind,
      exists: bind,
      forall: bind,
      filter: function filter(f) {
        return f(a) ? me : NONE;
      },
      toArray: function toArray() {
        return [a];
      },
      toString: function toString() {
        return 'some(' + a + ')';
      },
      equals: function equals(o) {
        return o.is(a);
      },
      equals_: function equals_(o, elementEq) {
        return o.fold(never, function (b) {
          return elementEq(a, b);
        });
      }
    };
    return me;
  };

  var from = function from(value) {
    return value === null || value === undefined ? NONE : some(value);
  };

  var Optional = {
    some: some,
    none: none,
    from: from
  };

  var typeOf = function typeOf(x) {
    var t = _typeof(x);

    if (x === null) {
      return 'null';
    } else if (t === 'object' && (Array.prototype.isPrototypeOf(x) || x.constructor && x.constructor.name === 'Array')) {
      return 'array';
    } else if (t === 'object' && (String.prototype.isPrototypeOf(x) || x.constructor && x.constructor.name === 'String')) {
      return 'string';
    } else {
      return t;
    }
  };

  var isType = function isType(type) {
    return function (value) {
      return typeOf(value) === type;
    };
  };

  var isSimpleType = function isSimpleType(type) {
    return function (value) {
      return _typeof(value) === type;
    };
  };

  var isString = isType('string');
  var isArray = isType('array');
  var isBoolean = isSimpleType('boolean');
  var isFunction = isSimpleType('function');
  var isNumber = isSimpleType('number');
  var nativeSlice = Array.prototype.slice;
  var nativePush = Array.prototype.push;

  var map = function map(xs, f) {
    var len = xs.length;
    var r = new Array(len);

    for (var i = 0; i < len; i++) {
      var x = xs[i];
      r[i] = f(x, i);
    }

    return r;
  };

  var each = function each(xs, f) {
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];
      f(x, i);
    }
  };

  var filter = function filter(xs, pred) {
    var r = [];

    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];

      if (pred(x, i)) {
        r.push(x);
      }
    }

    return r;
  };

  var groupBy = function groupBy(xs, f) {
    if (xs.length === 0) {
      return [];
    } else {
      var wasType = f(xs[0]);
      var r = [];
      var group = [];

      for (var i = 0, len = xs.length; i < len; i++) {
        var x = xs[i];
        var type = f(x);

        if (type !== wasType) {
          r.push(group);
          group = [];
        }

        wasType = type;
        group.push(x);
      }

      if (group.length !== 0) {
        r.push(group);
      }

      return r;
    }
  };

  var foldl = function foldl(xs, f, acc) {
    each(xs, function (x) {
      acc = f(acc, x);
    });
    return acc;
  };

  var findUntil = function findUntil(xs, pred, until) {
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];

      if (pred(x, i)) {
        return Optional.some(x);
      } else if (until(x, i)) {
        break;
      }
    }

    return Optional.none();
  };

  var find = function find(xs, pred) {
    return findUntil(xs, pred, never);
  };

  var flatten = function flatten(xs) {
    var r = [];

    for (var i = 0, len = xs.length; i < len; ++i) {
      if (!isArray(xs[i])) {
        throw new Error('Arr.flatten item ' + i + ' was not an array, input: ' + xs);
      }

      nativePush.apply(r, xs[i]);
    }

    return r;
  };

  var bind = function bind(xs, f) {
    return flatten(map(xs, f));
  };

  var reverse = function reverse(xs) {
    var r = nativeSlice.call(xs, 0);
    r.reverse();
    return r;
  };

  var get = function get(xs, i) {
    return i >= 0 && i < xs.length ? Optional.some(xs[i]) : Optional.none();
  };

  var head = function head(xs) {
    return get(xs, 0);
  };

  var last = function last(xs) {
    return get(xs, xs.length - 1);
  };

  var _assign = function __assign() {
    _assign = Object.assign || function __assign(t) {
      for (var s, i = 1, n = arguments.length; i < n; i++) {
        s = arguments[i];

        for (var p in s) {
          if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
        }
      }

      return t;
    };

    return _assign.apply(this, arguments);
  };

  var cached = function cached(f) {
    var called = false;
    var r;
    return function () {
      var args = [];

      for (var _i = 0; _i < arguments.length; _i++) {
        args[_i] = arguments[_i];
      }

      if (!called) {
        called = true;
        r = f.apply(null, args);
      }

      return r;
    };
  };

  var DeviceType = function DeviceType(os, browser, userAgent, mediaMatch) {
    var isiPad = os.isiOS() && /ipad/i.test(userAgent) === true;
    var isiPhone = os.isiOS() && !isiPad;
    var isMobile = os.isiOS() || os.isAndroid();
    var isTouch = isMobile || mediaMatch('(pointer:coarse)');
    var isTablet = isiPad || !isiPhone && isMobile && mediaMatch('(min-device-width:768px)');
    var isPhone = isiPhone || isMobile && !isTablet;
    var iOSwebview = browser.isSafari() && os.isiOS() && /safari/i.test(userAgent) === false;
    var isDesktop = !isPhone && !isTablet && !iOSwebview;
    return {
      isiPad: constant(isiPad),
      isiPhone: constant(isiPhone),
      isTablet: constant(isTablet),
      isPhone: constant(isPhone),
      isTouch: constant(isTouch),
      isAndroid: os.isAndroid,
      isiOS: os.isiOS,
      isWebView: constant(iOSwebview),
      isDesktop: constant(isDesktop)
    };
  };

  var firstMatch = function firstMatch(regexes, s) {
    for (var i = 0; i < regexes.length; i++) {
      var x = regexes[i];

      if (x.test(s)) {
        return x;
      }
    }

    return undefined;
  };

  var find$1 = function find$1(regexes, agent) {
    var r = firstMatch(regexes, agent);

    if (!r) {
      return {
        major: 0,
        minor: 0
      };
    }

    var group = function group(i) {
      return Number(agent.replace(r, '$' + i));
    };

    return nu(group(1), group(2));
  };

  var detect = function detect(versionRegexes, agent) {
    var cleanedAgent = String(agent).toLowerCase();

    if (versionRegexes.length === 0) {
      return unknown();
    }

    return find$1(versionRegexes, cleanedAgent);
  };

  var unknown = function unknown() {
    return nu(0, 0);
  };

  var nu = function nu(major, minor) {
    return {
      major: major,
      minor: minor
    };
  };

  var Version = {
    nu: nu,
    detect: detect,
    unknown: unknown
  };

  var detect$1 = function detect$1(candidates, userAgent) {
    var agent = String(userAgent).toLowerCase();
    return find(candidates, function (candidate) {
      return candidate.search(agent);
    });
  };

  var detectBrowser = function detectBrowser(browsers, userAgent) {
    return detect$1(browsers, userAgent).map(function (browser) {
      var version = Version.detect(browser.versionRegexes, userAgent);
      return {
        current: browser.name,
        version: version
      };
    });
  };

  var detectOs = function detectOs(oses, userAgent) {
    return detect$1(oses, userAgent).map(function (os) {
      var version = Version.detect(os.versionRegexes, userAgent);
      return {
        current: os.name,
        version: version
      };
    });
  };

  var UaString = {
    detectBrowser: detectBrowser,
    detectOs: detectOs
  };

  var contains = function contains(str, substr) {
    return str.indexOf(substr) !== -1;
  };

  var normalVersionRegex = /.*?version\/\ ?([0-9]+)\.([0-9]+).*/;

  var checkContains = function checkContains(target) {
    return function (uastring) {
      return contains(uastring, target);
    };
  };

  var browsers = [{
    name: 'Edge',
    versionRegexes: [/.*?edge\/ ?([0-9]+)\.([0-9]+)$/],
    search: function search(uastring) {
      return contains(uastring, 'edge/') && contains(uastring, 'chrome') && contains(uastring, 'safari') && contains(uastring, 'applewebkit');
    }
  }, {
    name: 'Chrome',
    versionRegexes: [/.*?chrome\/([0-9]+)\.([0-9]+).*/, normalVersionRegex],
    search: function search(uastring) {
      return contains(uastring, 'chrome') && !contains(uastring, 'chromeframe');
    }
  }, {
    name: 'IE',
    versionRegexes: [/.*?msie\ ?([0-9]+)\.([0-9]+).*/, /.*?rv:([0-9]+)\.([0-9]+).*/],
    search: function search(uastring) {
      return contains(uastring, 'msie') || contains(uastring, 'trident');
    }
  }, {
    name: 'Opera',
    versionRegexes: [normalVersionRegex, /.*?opera\/([0-9]+)\.([0-9]+).*/],
    search: checkContains('opera')
  }, {
    name: 'Firefox',
    versionRegexes: [/.*?firefox\/\ ?([0-9]+)\.([0-9]+).*/],
    search: checkContains('firefox')
  }, {
    name: 'Safari',
    versionRegexes: [normalVersionRegex, /.*?cpu os ([0-9]+)_([0-9]+).*/],
    search: function search(uastring) {
      return (contains(uastring, 'safari') || contains(uastring, 'mobile/')) && contains(uastring, 'applewebkit');
    }
  }];
  var oses = [{
    name: 'Windows',
    search: checkContains('win'),
    versionRegexes: [/.*?windows\ nt\ ?([0-9]+)\.([0-9]+).*/]
  }, {
    name: 'iOS',
    search: function search(uastring) {
      return contains(uastring, 'iphone') || contains(uastring, 'ipad');
    },
    versionRegexes: [/.*?version\/\ ?([0-9]+)\.([0-9]+).*/, /.*cpu os ([0-9]+)_([0-9]+).*/, /.*cpu iphone os ([0-9]+)_([0-9]+).*/]
  }, {
    name: 'Android',
    search: checkContains('android'),
    versionRegexes: [/.*?android\ ?([0-9]+)\.([0-9]+).*/]
  }, {
    name: 'OSX',
    search: checkContains('mac os x'),
    versionRegexes: [/.*?mac\ os\ x\ ?([0-9]+)_([0-9]+).*/]
  }, {
    name: 'Linux',
    search: checkContains('linux'),
    versionRegexes: []
  }, {
    name: 'Solaris',
    search: checkContains('sunos'),
    versionRegexes: []
  }, {
    name: 'FreeBSD',
    search: checkContains('freebsd'),
    versionRegexes: []
  }, {
    name: 'ChromeOS',
    search: checkContains('cros'),
    versionRegexes: [/.*?chrome\/([0-9]+)\.([0-9]+).*/]
  }];
  var PlatformInfo = {
    browsers: constant(browsers),
    oses: constant(oses)
  };
  var edge = 'Edge';
  var chrome = 'Chrome';
  var ie = 'IE';
  var opera = 'Opera';
  var firefox = 'Firefox';
  var safari = 'Safari';

  var unknown$1 = function unknown$1() {
    return nu$1({
      current: undefined,
      version: Version.unknown()
    });
  };

  var nu$1 = function nu$1(info) {
    var current = info.current;
    var version = info.version;

    var isBrowser = function isBrowser(name) {
      return function () {
        return current === name;
      };
    };

    return {
      current: current,
      version: version,
      isEdge: isBrowser(edge),
      isChrome: isBrowser(chrome),
      isIE: isBrowser(ie),
      isOpera: isBrowser(opera),
      isFirefox: isBrowser(firefox),
      isSafari: isBrowser(safari)
    };
  };

  var Browser = {
    unknown: unknown$1,
    nu: nu$1,
    edge: constant(edge),
    chrome: constant(chrome),
    ie: constant(ie),
    opera: constant(opera),
    firefox: constant(firefox),
    safari: constant(safari)
  };
  var windows = 'Windows';
  var ios = 'iOS';
  var android = 'Android';
  var linux = 'Linux';
  var osx = 'OSX';
  var solaris = 'Solaris';
  var freebsd = 'FreeBSD';
  var chromeos = 'ChromeOS';

  var unknown$2 = function unknown$2() {
    return nu$2({
      current: undefined,
      version: Version.unknown()
    });
  };

  var nu$2 = function nu$2(info) {
    var current = info.current;
    var version = info.version;

    var isOS = function isOS(name) {
      return function () {
        return current === name;
      };
    };

    return {
      current: current,
      version: version,
      isWindows: isOS(windows),
      isiOS: isOS(ios),
      isAndroid: isOS(android),
      isOSX: isOS(osx),
      isLinux: isOS(linux),
      isSolaris: isOS(solaris),
      isFreeBSD: isOS(freebsd),
      isChromeOS: isOS(chromeos)
    };
  };

  var OperatingSystem = {
    unknown: unknown$2,
    nu: nu$2,
    windows: constant(windows),
    ios: constant(ios),
    android: constant(android),
    linux: constant(linux),
    osx: constant(osx),
    solaris: constant(solaris),
    freebsd: constant(freebsd),
    chromeos: constant(chromeos)
  };

  var detect$2 = function detect$2(userAgent, mediaMatch) {
    var browsers = PlatformInfo.browsers();
    var oses = PlatformInfo.oses();
    var browser = UaString.detectBrowser(browsers, userAgent).fold(Browser.unknown, Browser.nu);
    var os = UaString.detectOs(oses, userAgent).fold(OperatingSystem.unknown, OperatingSystem.nu);
    var deviceType = DeviceType(os, browser, userAgent, mediaMatch);
    return {
      browser: browser,
      os: os,
      deviceType: deviceType
    };
  };

  var PlatformDetection = {
    detect: detect$2
  };

  var mediaMatch = function mediaMatch(query) {
    return window.matchMedia(query).matches;
  };

  var platform = cached(function () {
    return PlatformDetection.detect(navigator.userAgent, mediaMatch);
  });

  var detect$3 = function detect$3() {
    return platform();
  };

  var compareDocumentPosition = function compareDocumentPosition(a, b, match) {
    return (a.compareDocumentPosition(b) & match) !== 0;
  };

  var documentPositionContainedBy = function documentPositionContainedBy(a, b) {
    return compareDocumentPosition(a, b, Node.DOCUMENT_POSITION_CONTAINED_BY);
  };

  var ELEMENT = 1;

  var fromHtml = function fromHtml(html, scope) {
    var doc = scope || document;
    var div = doc.createElement('div');
    div.innerHTML = html;

    if (!div.hasChildNodes() || div.childNodes.length > 1) {
      console.error('HTML does not have a single root node', html);
      throw new Error('HTML must have a single root node');
    }

    return fromDom(div.childNodes[0]);
  };

  var fromTag = function fromTag(tag, scope) {
    var doc = scope || document;
    var node = doc.createElement(tag);
    return fromDom(node);
  };

  var fromText = function fromText(text, scope) {
    var doc = scope || document;
    var node = doc.createTextNode(text);
    return fromDom(node);
  };

  var fromDom = function fromDom(node) {
    if (node === null || node === undefined) {
      throw new Error('Node cannot be null or undefined');
    }

    return {
      dom: node
    };
  };

  var fromPoint = function fromPoint(docElm, x, y) {
    return Optional.from(docElm.dom.elementFromPoint(x, y)).map(fromDom);
  };

  var SugarElement = {
    fromHtml: fromHtml,
    fromTag: fromTag,
    fromText: fromText,
    fromDom: fromDom,
    fromPoint: fromPoint
  };

  var is = function is(element, selector) {
    var dom = element.dom;

    if (dom.nodeType !== ELEMENT) {
      return false;
    } else {
      var elem = dom;

      if (elem.matches !== undefined) {
        return elem.matches(selector);
      } else if (elem.msMatchesSelector !== undefined) {
        return elem.msMatchesSelector(selector);
      } else if (elem.webkitMatchesSelector !== undefined) {
        return elem.webkitMatchesSelector(selector);
      } else if (elem.mozMatchesSelector !== undefined) {
        return elem.mozMatchesSelector(selector);
      } else {
        throw new Error('Browser lacks native selectors');
      }
    }
  };

  var eq = function eq(e1, e2) {
    return e1.dom === e2.dom;
  };

  var regularContains = function regularContains(e1, e2) {
    var d1 = e1.dom;
    var d2 = e2.dom;
    return d1 === d2 ? false : d1.contains(d2);
  };

  var ieContains = function ieContains(e1, e2) {
    return documentPositionContainedBy(e1.dom, e2.dom);
  };

  var contains$1 = function contains$1(e1, e2) {
    return detect$3().browser.isIE() ? ieContains(e1, e2) : regularContains(e1, e2);
  };

  var is$1 = is;
  var global$1 = tinymce.util.Tools.resolve('tinymce.dom.RangeUtils');
  var global$2 = tinymce.util.Tools.resolve('tinymce.dom.TreeWalker');
  var global$3 = tinymce.util.Tools.resolve('tinymce.util.VK');
  var keys = Object.keys;

  var each$1 = function each$1(obj, f) {
    var props = keys(obj);

    for (var k = 0, len = props.length; k < len; k++) {
      var i = props[k];
      var x = obj[i];
      f(x, i);
    }
  };

  var objAcc = function objAcc(r) {
    return function (x, i) {
      r[i] = x;
    };
  };

  var internalFilter = function internalFilter(obj, pred, onTrue, onFalse) {
    var r = {};
    each$1(obj, function (x, i) {
      (pred(x, i) ? onTrue : onFalse)(x, i);
    });
    return r;
  };

  var filter$1 = function filter$1(obj, pred) {
    var t = {};
    internalFilter(obj, pred, objAcc(t), noop);
    return t;
  };

  var Global = typeof window !== 'undefined' ? window : Function('return this;')();

  var name = function name(element) {
    var r = element.dom.nodeName;
    return r.toLowerCase();
  };

  var type = function type(element) {
    return element.dom.nodeType;
  };

  var isType$1 = function isType$1(t) {
    return function (element) {
      return type(element) === t;
    };
  };

  var isElement = isType$1(ELEMENT);

  var rawSet = function rawSet(dom, key, value) {
    if (isString(value) || isBoolean(value) || isNumber(value)) {
      dom.setAttribute(key, value + '');
    } else {
      console.error('Invalid call to Attribute.set. Key ', key, ':: Value ', value, ':: Element ', dom);
      throw new Error('Attribute value was not simple');
    }
  };

  var setAll = function setAll(element, attrs) {
    var dom = element.dom;
    each$1(attrs, function (v, k) {
      rawSet(dom, k, v);
    });
  };

  var clone = function clone(element) {
    return foldl(element.dom.attributes, function (acc, attr) {
      acc[attr.name] = attr.value;
      return acc;
    }, {});
  };

  var parent = function parent(element) {
    return Optional.from(element.dom.parentNode).map(SugarElement.fromDom);
  };

  var children = function children(element) {
    return map(element.dom.childNodes, SugarElement.fromDom);
  };

  var child = function child(element, index) {
    var cs = element.dom.childNodes;
    return Optional.from(cs[index]).map(SugarElement.fromDom);
  };

  var firstChild = function firstChild(element) {
    return child(element, 0);
  };

  var lastChild = function lastChild(element) {
    return child(element, element.dom.childNodes.length - 1);
  };

  var before = function before(marker, element) {
    var parent$1 = parent(marker);
    parent$1.each(function (v) {
      v.dom.insertBefore(element.dom, marker.dom);
    });
  };

  var append = function append(parent, element) {
    parent.dom.appendChild(element.dom);
  };

  var before$1 = function before$1(marker, elements) {
    each(elements, function (x) {
      before(marker, x);
    });
  };

  var append$1 = function append$1(parent, elements) {
    each(elements, function (x) {
      append(parent, x);
    });
  };

  var remove = function remove(element) {
    var dom = element.dom;

    if (dom.parentNode !== null) {
      dom.parentNode.removeChild(dom);
    }
  };

  var clone$1 = function clone$1(original, isDeep) {
    return SugarElement.fromDom(original.dom.cloneNode(isDeep));
  };

  var deep = function deep(original) {
    return clone$1(original, true);
  };

  var shallowAs = function shallowAs(original, tag) {
    var nu = SugarElement.fromTag(tag);
    var attributes = clone(original);
    setAll(nu, attributes);
    return nu;
  };

  var mutate = function mutate(original, tag) {
    var nu = shallowAs(original, tag);
    before(original, nu);
    var children$1 = children(original);
    append$1(nu, children$1);
    remove(original);
    return nu;
  };

  var global$4 = tinymce.util.Tools.resolve('tinymce.dom.DOMUtils');
  var global$5 = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var matchNodeName = function matchNodeName(name) {
    return function (node) {
      return node && node.nodeName.toLowerCase() === name;
    };
  };

  var matchNodeNames = function matchNodeNames(regex) {
    return function (node) {
      return node && regex.test(node.nodeName);
    };
  };

  var isTextNode = function isTextNode(node) {
    return node && node.nodeType === 3;
  };

  var isListNode = matchNodeNames(/^(OL|UL|DL)$/);
  var isOlUlNode = matchNodeNames(/^(OL|UL)$/);
  var isOlNode = matchNodeName('ol');
  var isListItemNode = matchNodeNames(/^(LI|DT|DD)$/);
  var isDlItemNode = matchNodeNames(/^(DT|DD)$/);
  var isTableCellNode = matchNodeNames(/^(TH|TD)$/);
  var isBr = matchNodeName('br');

  var isFirstChild = function isFirstChild(node) {
    return node.parentNode.firstChild === node;
  };

  var isTextBlock = function isTextBlock(editor, node) {
    return node && !!editor.schema.getTextBlockElements()[node.nodeName];
  };

  var isBlock = function isBlock(node, blockElements) {
    return node && node.nodeName in blockElements;
  };

  var isBogusBr = function isBogusBr(dom, node) {
    if (!isBr(node)) {
      return false;
    }

    return dom.isBlock(node.nextSibling) && !isBr(node.previousSibling);
  };

  var isEmpty = function isEmpty(dom, elm, keepBookmarks) {
    var empty = dom.isEmpty(elm);

    if (keepBookmarks && dom.select('span[data-mce-type=bookmark]', elm).length > 0) {
      return false;
    }

    return empty;
  };

  var isChildOfBody = function isChildOfBody(dom, elm) {
    return dom.isChildOf(elm, dom.getRoot());
  };

  var shouldIndentOnTab = function shouldIndentOnTab(editor) {
    return editor.getParam('lists_indent_on_tab', true);
  };

  var getForcedRootBlock = function getForcedRootBlock(editor) {
    var block = editor.getParam('forced_root_block', 'p');

    if (block === false) {
      return '';
    } else if (block === true) {
      return 'p';
    } else {
      return block;
    }
  };

  var getForcedRootBlockAttrs = function getForcedRootBlockAttrs(editor) {
    return editor.getParam('forced_root_block_attrs', {});
  };

  var createTextBlock = function createTextBlock(editor, contentNode) {
    var dom = editor.dom;
    var blockElements = editor.schema.getBlockElements();
    var fragment = dom.createFragment();
    var blockName = getForcedRootBlock(editor);
    var node, textBlock, hasContentNode;

    if (blockName) {
      textBlock = dom.create(blockName);

      if (textBlock.tagName === blockName.toUpperCase()) {
        dom.setAttribs(textBlock, getForcedRootBlockAttrs(editor));
      }

      if (!isBlock(contentNode.firstChild, blockElements)) {
        fragment.appendChild(textBlock);
      }
    }

    if (contentNode) {
      while (node = contentNode.firstChild) {
        var nodeName = node.nodeName;

        if (!hasContentNode && (nodeName !== 'SPAN' || node.getAttribute('data-mce-type') !== 'bookmark')) {
          hasContentNode = true;
        }

        if (isBlock(node, blockElements)) {
          fragment.appendChild(node);
          textBlock = null;
        } else {
          if (blockName) {
            if (!textBlock) {
              textBlock = dom.create(blockName);
              fragment.appendChild(textBlock);
            }

            textBlock.appendChild(node);
          } else {
            fragment.appendChild(node);
          }
        }
      }
    }

    if (!blockName) {
      fragment.appendChild(dom.create('br'));
    } else {
      if (!hasContentNode) {
        textBlock.appendChild(dom.create('br', {
          'data-mce-bogus': '1'
        }));
      }
    }

    return fragment;
  };

  var DOM = global$4.DOM;

  var splitList = function splitList(editor, ul, li) {
    var removeAndKeepBookmarks = function removeAndKeepBookmarks(targetNode) {
      global$5.each(bookmarks, function (node) {
        targetNode.parentNode.insertBefore(node, li.parentNode);
      });
      DOM.remove(targetNode);
    };

    var bookmarks = DOM.select('span[data-mce-type="bookmark"]', ul);
    var newBlock = createTextBlock(editor, li);
    var tmpRng = DOM.createRng();
    tmpRng.setStartAfter(li);
    tmpRng.setEndAfter(ul);
    var fragment = tmpRng.extractContents();

    for (var node = fragment.firstChild; node; node = node.firstChild) {
      if (node.nodeName === 'LI' && editor.dom.isEmpty(node)) {
        DOM.remove(node);
        break;
      }
    }

    if (!editor.dom.isEmpty(fragment)) {
      DOM.insertAfter(fragment, ul);
    }

    DOM.insertAfter(newBlock, ul);

    if (isEmpty(editor.dom, li.parentNode)) {
      removeAndKeepBookmarks(li.parentNode);
    }

    DOM.remove(li);

    if (isEmpty(editor.dom, ul)) {
      DOM.remove(ul);
    }
  };

  var outdentDlItem = function outdentDlItem(editor, item) {
    if (is$1(item, 'dd')) {
      mutate(item, 'dt');
    } else if (is$1(item, 'dt')) {
      parent(item).each(function (dl) {
        return splitList(editor, dl.dom, item.dom);
      });
    }
  };

  var indentDlItem = function indentDlItem(item) {
    if (is$1(item, 'dt')) {
      mutate(item, 'dd');
    }
  };

  var dlIndentation = function dlIndentation(editor, indentation, dlItems) {
    if (indentation === 'Indent') {
      each(dlItems, indentDlItem);
    } else {
      each(dlItems, function (item) {
        return outdentDlItem(editor, item);
      });
    }
  };

  var getNormalizedPoint = function getNormalizedPoint(container, offset) {
    if (isTextNode(container)) {
      return {
        container: container,
        offset: offset
      };
    }

    var node = global$1.getNode(container, offset);

    if (isTextNode(node)) {
      return {
        container: node,
        offset: offset >= container.childNodes.length ? node.data.length : 0
      };
    } else if (node.previousSibling && isTextNode(node.previousSibling)) {
      return {
        container: node.previousSibling,
        offset: node.previousSibling.data.length
      };
    } else if (node.nextSibling && isTextNode(node.nextSibling)) {
      return {
        container: node.nextSibling,
        offset: 0
      };
    }

    return {
      container: container,
      offset: offset
    };
  };

  var normalizeRange = function normalizeRange(rng) {
    var outRng = rng.cloneRange();
    var rangeStart = getNormalizedPoint(rng.startContainer, rng.startOffset);
    outRng.setStart(rangeStart.container, rangeStart.offset);
    var rangeEnd = getNormalizedPoint(rng.endContainer, rng.endOffset);
    outRng.setEnd(rangeEnd.container, rangeEnd.offset);
    return outRng;
  };

  var global$6 = tinymce.util.Tools.resolve('tinymce.dom.DomQuery');

  var getParentList = function getParentList(editor, node) {
    var selectionStart = node || editor.selection.getStart(true);
    return editor.dom.getParent(selectionStart, 'OL,UL,DL', getClosestListRootElm(editor, selectionStart));
  };

  var isParentListSelected = function isParentListSelected(parentList, selectedBlocks) {
    return parentList && selectedBlocks.length === 1 && selectedBlocks[0] === parentList;
  };

  var findSubLists = function findSubLists(parentList) {
    return global$5.grep(parentList.querySelectorAll('ol,ul,dl'), function (elm) {
      return isListNode(elm);
    });
  };

  var getSelectedSubLists = function getSelectedSubLists(editor) {
    var parentList = getParentList(editor);
    var selectedBlocks = editor.selection.getSelectedBlocks();

    if (isParentListSelected(parentList, selectedBlocks)) {
      return findSubLists(parentList);
    } else {
      return global$5.grep(selectedBlocks, function (elm) {
        return isListNode(elm) && parentList !== elm;
      });
    }
  };

  var findParentListItemsNodes = function findParentListItemsNodes(editor, elms) {
    var listItemsElms = global$5.map(elms, function (elm) {
      var parentLi = editor.dom.getParent(elm, 'li,dd,dt', getClosestListRootElm(editor, elm));
      return parentLi ? parentLi : elm;
    });
    return global$6.unique(listItemsElms);
  };

  var getSelectedListItems = function getSelectedListItems(editor) {
    var selectedBlocks = editor.selection.getSelectedBlocks();
    return global$5.grep(findParentListItemsNodes(editor, selectedBlocks), function (block) {
      return isListItemNode(block);
    });
  };

  var getSelectedDlItems = function getSelectedDlItems(editor) {
    return filter(getSelectedListItems(editor), isDlItemNode);
  };

  var getClosestListRootElm = function getClosestListRootElm(editor, elm) {
    var parentTableCell = editor.dom.getParents(elm, 'TD,TH');
    var root = parentTableCell.length > 0 ? parentTableCell[0] : editor.getBody();
    return root;
  };

  var findLastParentListNode = function findLastParentListNode(editor, elm) {
    var parentLists = editor.dom.getParents(elm, 'ol,ul', getClosestListRootElm(editor, elm));
    return last(parentLists);
  };

  var getSelectedLists = function getSelectedLists(editor) {
    var firstList = findLastParentListNode(editor, editor.selection.getStart());
    var subsequentLists = filter(editor.selection.getSelectedBlocks(), isOlUlNode);
    return firstList.toArray().concat(subsequentLists);
  };

  var getSelectedListRoots = function getSelectedListRoots(editor) {
    var selectedLists = getSelectedLists(editor);
    return getUniqueListRoots(editor, selectedLists);
  };

  var getUniqueListRoots = function getUniqueListRoots(editor, lists) {
    var listRoots = map(lists, function (list) {
      return findLastParentListNode(editor, list).getOr(list);
    });
    return global$6.unique(listRoots);
  };

  var lift2 = function lift2(oa, ob, f) {
    return oa.isSome() && ob.isSome() ? Optional.some(f(oa.getOrDie(), ob.getOrDie())) : Optional.none();
  };

  var fromElements = function fromElements(elements, scope) {
    var doc = scope || document;
    var fragment = doc.createDocumentFragment();
    each(elements, function (element) {
      fragment.appendChild(element.dom);
    });
    return SugarElement.fromDom(fragment);
  };

  var fireListEvent = function fireListEvent(editor, action, element) {
    return editor.fire('ListMutation', {
      action: action,
      element: element
    });
  };

  var isSupported = function isSupported(dom) {
    return dom.style !== undefined && isFunction(dom.style.getPropertyValue);
  };

  var internalSet = function internalSet(dom, property, value) {
    if (!isString(value)) {
      console.error('Invalid call to CSS.set. Property ', property, ':: Value ', value, ':: Element ', dom);
      throw new Error('CSS value must be a string: ' + value);
    }

    if (isSupported(dom)) {
      dom.style.setProperty(property, value);
    }
  };

  var set = function set(element, property, value) {
    var dom = element.dom;
    internalSet(dom, property, value);
  };

  var joinSegment = function joinSegment(parent, child) {
    append(parent.item, child.list);
  };

  var joinSegments = function joinSegments(segments) {
    for (var i = 1; i < segments.length; i++) {
      joinSegment(segments[i - 1], segments[i]);
    }
  };

  var appendSegments = function appendSegments(head$1, tail) {
    lift2(last(head$1), head(tail), joinSegment);
  };

  var createSegment = function createSegment(scope, listType) {
    var segment = {
      list: SugarElement.fromTag(listType, scope),
      item: SugarElement.fromTag('li', scope)
    };
    append(segment.list, segment.item);
    return segment;
  };

  var createSegments = function createSegments(scope, entry, size) {
    var segments = [];

    for (var i = 0; i < size; i++) {
      segments.push(createSegment(scope, entry.listType));
    }

    return segments;
  };

  var populateSegments = function populateSegments(segments, entry) {
    for (var i = 0; i < segments.length - 1; i++) {
      set(segments[i].item, 'list-style-type', 'none');
    }

    last(segments).each(function (segment) {
      setAll(segment.list, entry.listAttributes);
      setAll(segment.item, entry.itemAttributes);
      append$1(segment.item, entry.content);
    });
  };

  var normalizeSegment = function normalizeSegment(segment, entry) {
    if (name(segment.list) !== entry.listType) {
      segment.list = mutate(segment.list, entry.listType);
    }

    setAll(segment.list, entry.listAttributes);
  };

  var createItem = function createItem(scope, attr, content) {
    var item = SugarElement.fromTag('li', scope);
    setAll(item, attr);
    append$1(item, content);
    return item;
  };

  var appendItem = function appendItem(segment, item) {
    append(segment.list, item);
    segment.item = item;
  };

  var writeShallow = function writeShallow(scope, cast, entry) {
    var newCast = cast.slice(0, entry.depth);
    last(newCast).each(function (segment) {
      var item = createItem(scope, entry.itemAttributes, entry.content);
      appendItem(segment, item);
      normalizeSegment(segment, entry);
    });
    return newCast;
  };

  var writeDeep = function writeDeep(scope, cast, entry) {
    var segments = createSegments(scope, entry, entry.depth - cast.length);
    joinSegments(segments);
    populateSegments(segments, entry);
    appendSegments(cast, segments);
    return cast.concat(segments);
  };

  var composeList = function composeList(scope, entries) {
    var cast = foldl(entries, function (cast, entry) {
      return entry.depth > cast.length ? writeDeep(scope, cast, entry) : writeShallow(scope, cast, entry);
    }, []);
    return head(cast).map(function (segment) {
      return segment.list;
    });
  };

  var isList = function isList(el) {
    return is$1(el, 'OL,UL');
  };

  var hasFirstChildList = function hasFirstChildList(el) {
    return firstChild(el).map(isList).getOr(false);
  };

  var hasLastChildList = function hasLastChildList(el) {
    return lastChild(el).map(isList).getOr(false);
  };

  var isIndented = function isIndented(entry) {
    return entry.depth > 0;
  };

  var isSelected = function isSelected(entry) {
    return entry.isSelected;
  };

  var cloneItemContent = function cloneItemContent(li) {
    var children$1 = children(li);
    var content = hasLastChildList(li) ? children$1.slice(0, -1) : children$1;
    return map(content, deep);
  };

  var createEntry = function createEntry(li, depth, isSelected) {
    return parent(li).filter(isElement).map(function (list) {
      return {
        depth: depth,
        dirty: false,
        isSelected: isSelected,
        content: cloneItemContent(li),
        itemAttributes: clone(li),
        listAttributes: clone(list),
        listType: name(list)
      };
    });
  };

  var indentEntry = function indentEntry(indentation, entry) {
    switch (indentation) {
      case 'Indent':
        entry.depth++;
        break;

      case 'Outdent':
        entry.depth--;
        break;

      case 'Flatten':
        entry.depth = 0;
    }

    entry.dirty = true;
  };

  var cloneListProperties = function cloneListProperties(target, source) {
    target.listType = source.listType;
    target.listAttributes = _assign({}, source.listAttributes);
  };

  var cleanListProperties = function cleanListProperties(entry) {
    entry.listAttributes = filter$1(entry.listAttributes, function (_value, key) {
      return key !== 'start';
    });
  };

  var closestSiblingEntry = function closestSiblingEntry(entries, start) {
    var depth = entries[start].depth;

    var matches = function matches(entry) {
      return entry.depth === depth && !entry.dirty;
    };

    var until = function until(entry) {
      return entry.depth < depth;
    };

    return findUntil(reverse(entries.slice(0, start)), matches, until).orThunk(function () {
      return findUntil(entries.slice(start + 1), matches, until);
    });
  };

  var normalizeEntries = function normalizeEntries(entries) {
    each(entries, function (entry, i) {
      closestSiblingEntry(entries, i).fold(function () {
        if (entry.dirty) {
          cleanListProperties(entry);
        }
      }, function (matchingEntry) {
        return cloneListProperties(entry, matchingEntry);
      });
    });
    return entries;
  };

  var Cell = function Cell(initial) {
    var value = initial;

    var get = function get() {
      return value;
    };

    var set = function set(v) {
      value = v;
    };

    return {
      get: get,
      set: set
    };
  };

  var parseItem = function parseItem(depth, itemSelection, selectionState, item) {
    return firstChild(item).filter(isList).fold(function () {
      itemSelection.each(function (selection) {
        if (eq(selection.start, item)) {
          selectionState.set(true);
        }
      });
      var currentItemEntry = createEntry(item, depth, selectionState.get());
      itemSelection.each(function (selection) {
        if (eq(selection.end, item)) {
          selectionState.set(false);
        }
      });
      var childListEntries = lastChild(item).filter(isList).map(function (list) {
        return parseList(depth, itemSelection, selectionState, list);
      }).getOr([]);
      return currentItemEntry.toArray().concat(childListEntries);
    }, function (list) {
      return parseList(depth, itemSelection, selectionState, list);
    });
  };

  var parseList = function parseList(depth, itemSelection, selectionState, list) {
    return bind(children(list), function (element) {
      var parser = isList(element) ? parseList : parseItem;
      var newDepth = depth + 1;
      return parser(newDepth, itemSelection, selectionState, element);
    });
  };

  var parseLists = function parseLists(lists, itemSelection) {
    var selectionState = Cell(false);
    var initialDepth = 0;
    return map(lists, function (list) {
      return {
        sourceList: list,
        entries: parseList(initialDepth, itemSelection, selectionState, list)
      };
    });
  };

  var outdentedComposer = function outdentedComposer(editor, entries) {
    var normalizedEntries = normalizeEntries(entries);
    return map(normalizedEntries, function (entry) {
      var content = fromElements(entry.content);
      return SugarElement.fromDom(createTextBlock(editor, content.dom));
    });
  };

  var indentedComposer = function indentedComposer(editor, entries) {
    var normalizedEntries = normalizeEntries(entries);
    return composeList(editor.contentDocument, normalizedEntries).toArray();
  };

  var composeEntries = function composeEntries(editor, entries) {
    return bind(groupBy(entries, isIndented), function (entries) {
      var groupIsIndented = head(entries).map(isIndented).getOr(false);
      return groupIsIndented ? indentedComposer(editor, entries) : outdentedComposer(editor, entries);
    });
  };

  var indentSelectedEntries = function indentSelectedEntries(entries, indentation) {
    each(filter(entries, isSelected), function (entry) {
      return indentEntry(indentation, entry);
    });
  };

  var getItemSelection = function getItemSelection(editor) {
    var selectedListItems = map(getSelectedListItems(editor), SugarElement.fromDom);
    return lift2(find(selectedListItems, not(hasFirstChildList)), find(reverse(selectedListItems), not(hasFirstChildList)), function (start, end) {
      return {
        start: start,
        end: end
      };
    });
  };

  var listIndentation = function listIndentation(editor, lists, indentation) {
    var entrySets = parseLists(lists, getItemSelection(editor));
    each(entrySets, function (entrySet) {
      indentSelectedEntries(entrySet.entries, indentation);
      var composedLists = composeEntries(editor, entrySet.entries);
      each(composedLists, function (composedList) {
        fireListEvent(editor, indentation === 'Indent' ? 'IndentList' : 'OutdentList', composedList.dom);
      });
      before$1(entrySet.sourceList, composedLists);
      remove(entrySet.sourceList);
    });
  };

  var selectionIndentation = function selectionIndentation(editor, indentation) {
    var lists = map(getSelectedListRoots(editor), SugarElement.fromDom);
    var dlItems = map(getSelectedDlItems(editor), SugarElement.fromDom);
    var isHandled = false;

    if (lists.length || dlItems.length) {
      var bookmark = editor.selection.getBookmark();
      listIndentation(editor, lists, indentation);
      dlIndentation(editor, indentation, dlItems);
      editor.selection.moveToBookmark(bookmark);
      editor.selection.setRng(normalizeRange(editor.selection.getRng()));
      editor.nodeChanged();
      isHandled = true;
    }

    return isHandled;
  };

  var indentListSelection = function indentListSelection(editor) {
    return selectionIndentation(editor, 'Indent');
  };

  var outdentListSelection = function outdentListSelection(editor) {
    return selectionIndentation(editor, 'Outdent');
  };

  var flattenListSelection = function flattenListSelection(editor) {
    return selectionIndentation(editor, 'Flatten');
  };

  var global$7 = tinymce.util.Tools.resolve('tinymce.dom.BookmarkManager');
  var DOM$1 = global$4.DOM;

  var createBookmark = function createBookmark(rng) {
    var bookmark = {};

    var setupEndPoint = function setupEndPoint(start) {
      var offsetNode, container, offset;
      container = rng[start ? 'startContainer' : 'endContainer'];
      offset = rng[start ? 'startOffset' : 'endOffset'];

      if (container.nodeType === 1) {
        offsetNode = DOM$1.create('span', {
          'data-mce-type': 'bookmark'
        });

        if (container.hasChildNodes()) {
          offset = Math.min(offset, container.childNodes.length - 1);

          if (start) {
            container.insertBefore(offsetNode, container.childNodes[offset]);
          } else {
            DOM$1.insertAfter(offsetNode, container.childNodes[offset]);
          }
        } else {
          container.appendChild(offsetNode);
        }

        container = offsetNode;
        offset = 0;
      }

      bookmark[start ? 'startContainer' : 'endContainer'] = container;
      bookmark[start ? 'startOffset' : 'endOffset'] = offset;
    };

    setupEndPoint(true);

    if (!rng.collapsed) {
      setupEndPoint();
    }

    return bookmark;
  };

  var resolveBookmark = function resolveBookmark(bookmark) {
    function restoreEndPoint(start) {
      var container, offset, node;

      var nodeIndex = function nodeIndex(container) {
        var node = container.parentNode.firstChild,
            idx = 0;

        while (node) {
          if (node === container) {
            return idx;
          }

          if (node.nodeType !== 1 || node.getAttribute('data-mce-type') !== 'bookmark') {
            idx++;
          }

          node = node.nextSibling;
        }

        return -1;
      };

      container = node = bookmark[start ? 'startContainer' : 'endContainer'];
      offset = bookmark[start ? 'startOffset' : 'endOffset'];

      if (!container) {
        return;
      }

      if (container.nodeType === 1) {
        offset = nodeIndex(container);
        container = container.parentNode;
        DOM$1.remove(node);

        if (!container.hasChildNodes() && DOM$1.isBlock(container)) {
          container.appendChild(DOM$1.create('br'));
        }
      }

      bookmark[start ? 'startContainer' : 'endContainer'] = container;
      bookmark[start ? 'startOffset' : 'endOffset'] = offset;
    }

    restoreEndPoint(true);
    restoreEndPoint();
    var rng = DOM$1.createRng();
    rng.setStart(bookmark.startContainer, bookmark.startOffset);

    if (bookmark.endContainer) {
      rng.setEnd(bookmark.endContainer, bookmark.endOffset);
    }

    return normalizeRange(rng);
  };

  var listToggleActionFromListName = function listToggleActionFromListName(listName) {
    switch (listName) {
      case 'UL':
        return 'ToggleUlList';

      case 'OL':
        return 'ToggleOlList';

      case 'DL':
        return 'ToggleDLList';
    }
  };

  var isCustomList = function isCustomList(list) {
    return /\btox\-/.test(list.className);
  };

  var listState = function listState(editor, listName, activate) {
    var nodeChangeHandler = function nodeChangeHandler(e) {
      var inList = findUntil(e.parents, isListNode, isTableCellNode).filter(function (list) {
        return list.nodeName === listName && !isCustomList(list);
      }).isSome();
      activate(inList);
    };

    var parents = editor.dom.getParents(editor.selection.getNode());
    nodeChangeHandler({
      parents: parents
    });
    editor.on('NodeChange', nodeChangeHandler);
    return function () {
      return editor.off('NodeChange', nodeChangeHandler);
    };
  };

  var updateListStyle = function updateListStyle(dom, el, detail) {
    var type = detail['list-style-type'] ? detail['list-style-type'] : null;
    dom.setStyle(el, 'list-style-type', type);
  };

  var setAttribs = function setAttribs(elm, attrs) {
    global$5.each(attrs, function (value, key) {
      elm.setAttribute(key, value);
    });
  };

  var updateListAttrs = function updateListAttrs(dom, el, detail) {
    setAttribs(el, detail['list-attributes']);
    global$5.each(dom.select('li', el), function (li) {
      setAttribs(li, detail['list-item-attributes']);
    });
  };

  var updateListWithDetails = function updateListWithDetails(dom, el, detail) {
    updateListStyle(dom, el, detail);
    updateListAttrs(dom, el, detail);
  };

  var removeStyles = function removeStyles(dom, element, styles) {
    global$5.each(styles, function (style) {
      var _a;

      return dom.setStyle(element, (_a = {}, _a[style] = '', _a));
    });
  };

  var getEndPointNode = function getEndPointNode(editor, rng, start, root) {
    var container = rng[start ? 'startContainer' : 'endContainer'];
    var offset = rng[start ? 'startOffset' : 'endOffset'];

    if (container.nodeType === 1) {
      container = container.childNodes[Math.min(offset, container.childNodes.length - 1)] || container;
    }

    if (!start && isBr(container.nextSibling)) {
      container = container.nextSibling;
    }

    while (container.parentNode !== root) {
      if (isTextBlock(editor, container)) {
        return container;
      }

      if (/^(TD|TH)$/.test(container.parentNode.nodeName)) {
        return container;
      }

      container = container.parentNode;
    }

    return container;
  };

  var getSelectedTextBlocks = function getSelectedTextBlocks(editor, rng, root) {
    var textBlocks = [],
        dom = editor.dom;
    var startNode = getEndPointNode(editor, rng, true, root);
    var endNode = getEndPointNode(editor, rng, false, root);
    var block;
    var siblings = [];

    for (var node = startNode; node; node = node.nextSibling) {
      siblings.push(node);

      if (node === endNode) {
        break;
      }
    }

    global$5.each(siblings, function (node) {
      if (isTextBlock(editor, node)) {
        textBlocks.push(node);
        block = null;
        return;
      }

      if (dom.isBlock(node) || isBr(node)) {
        if (isBr(node)) {
          dom.remove(node);
        }

        block = null;
        return;
      }

      var nextSibling = node.nextSibling;

      if (global$7.isBookmarkNode(node)) {
        if (isTextBlock(editor, nextSibling) || !nextSibling && node.parentNode === root) {
          block = null;
          return;
        }
      }

      if (!block) {
        block = dom.create('p');
        node.parentNode.insertBefore(block, node);
        textBlocks.push(block);
      }

      block.appendChild(node);
    });
    return textBlocks;
  };

  var hasCompatibleStyle = function hasCompatibleStyle(dom, sib, detail) {
    var sibStyle = dom.getStyle(sib, 'list-style-type');
    var detailStyle = detail ? detail['list-style-type'] : '';
    detailStyle = detailStyle === null ? '' : detailStyle;
    return sibStyle === detailStyle;
  };

  var applyList = function applyList(editor, listName, detail) {
    if (detail === void 0) {
      detail = {};
    }

    var rng = editor.selection.getRng();
    var listItemName = 'LI';
    var root = getClosestListRootElm(editor, editor.selection.getStart(true));
    var dom = editor.dom;

    if (dom.getContentEditable(editor.selection.getNode()) === 'false') {
      return;
    }

    listName = listName.toUpperCase();

    if (listName === 'DL') {
      listItemName = 'DT';
    }

    var bookmark = createBookmark(rng);
    global$5.each(getSelectedTextBlocks(editor, rng, root), function (block) {
      var listBlock;
      var sibling = block.previousSibling;

      if (sibling && isListNode(sibling) && sibling.nodeName === listName && hasCompatibleStyle(dom, sibling, detail)) {
        listBlock = sibling;
        block = dom.rename(block, listItemName);
        sibling.appendChild(block);
      } else {
        listBlock = dom.create(listName);
        block.parentNode.insertBefore(listBlock, block);
        listBlock.appendChild(block);
        block = dom.rename(block, listItemName);
      }

      removeStyles(dom, block, ['margin', 'margin-right', 'margin-bottom', 'margin-left', 'margin-top', 'padding', 'padding-right', 'padding-bottom', 'padding-left', 'padding-top']);
      updateListWithDetails(dom, listBlock, detail);
      mergeWithAdjacentLists(editor.dom, listBlock);
    });
    editor.selection.setRng(resolveBookmark(bookmark));
  };

  var isValidLists = function isValidLists(list1, list2) {
    return list1 && list2 && isListNode(list1) && list1.nodeName === list2.nodeName;
  };

  var hasSameListStyle = function hasSameListStyle(dom, list1, list2) {
    var targetStyle = dom.getStyle(list1, 'list-style-type', true);
    var style = dom.getStyle(list2, 'list-style-type', true);
    return targetStyle === style;
  };

  var hasSameClasses = function hasSameClasses(elm1, elm2) {
    return elm1.className === elm2.className;
  };

  var shouldMerge = function shouldMerge(dom, list1, list2) {
    return isValidLists(list1, list2) && hasSameListStyle(dom, list1, list2) && hasSameClasses(list1, list2);
  };

  var mergeWithAdjacentLists = function mergeWithAdjacentLists(dom, listBlock) {
    var sibling, node;
    sibling = listBlock.nextSibling;

    if (shouldMerge(dom, listBlock, sibling)) {
      while (node = sibling.firstChild) {
        listBlock.appendChild(node);
      }

      dom.remove(sibling);
    }

    sibling = listBlock.previousSibling;

    if (shouldMerge(dom, listBlock, sibling)) {
      while (node = sibling.lastChild) {
        listBlock.insertBefore(node, listBlock.firstChild);
      }

      dom.remove(sibling);
    }
  };

  var updateList = function updateList(editor, list, listName, detail) {
    if (list.nodeName !== listName) {
      var newList = editor.dom.rename(list, listName);
      updateListWithDetails(editor.dom, newList, detail);
      fireListEvent(editor, listToggleActionFromListName(listName), newList);
    } else {
      updateListWithDetails(editor.dom, list, detail);
      fireListEvent(editor, listToggleActionFromListName(listName), list);
    }
  };

  var toggleMultipleLists = function toggleMultipleLists(editor, parentList, lists, listName, detail) {
    if (parentList.nodeName === listName && !hasListStyleDetail(detail)) {
      flattenListSelection(editor);
    } else {
      var bookmark = createBookmark(editor.selection.getRng(true));
      global$5.each([parentList].concat(lists), function (elm) {
        updateList(editor, elm, listName, detail);
      });
      editor.selection.setRng(resolveBookmark(bookmark));
    }
  };

  var hasListStyleDetail = function hasListStyleDetail(detail) {
    return 'list-style-type' in detail;
  };

  var toggleSingleList = function toggleSingleList(editor, parentList, listName, detail) {
    if (parentList === editor.getBody()) {
      return;
    }

    if (parentList) {
      if (parentList.nodeName === listName && !hasListStyleDetail(detail) && !isCustomList(parentList)) {
        flattenListSelection(editor);
      } else {
        var bookmark = createBookmark(editor.selection.getRng(true));
        updateListWithDetails(editor.dom, parentList, detail);
        var newList = editor.dom.rename(parentList, listName);
        mergeWithAdjacentLists(editor.dom, newList);
        editor.selection.setRng(resolveBookmark(bookmark));
        fireListEvent(editor, listToggleActionFromListName(listName), newList);
      }
    } else {
      applyList(editor, listName, detail);
      fireListEvent(editor, listToggleActionFromListName(listName), parentList);
    }
  };

  var toggleList = function toggleList(editor, listName, detail) {
    var parentList = getParentList(editor);
    var selectedSubLists = getSelectedSubLists(editor);
    detail = detail ? detail : {};

    if (parentList && selectedSubLists.length > 0) {
      toggleMultipleLists(editor, parentList, selectedSubLists, listName, detail);
    } else {
      toggleSingleList(editor, parentList, listName, detail);
    }
  };

  var DOM$2 = global$4.DOM;

  var normalizeList = function normalizeList(dom, ul) {
    var sibling;
    var parentNode = ul.parentNode;

    if (parentNode.nodeName === 'LI' && parentNode.firstChild === ul) {
      sibling = parentNode.previousSibling;

      if (sibling && sibling.nodeName === 'LI') {
        sibling.appendChild(ul);

        if (isEmpty(dom, parentNode)) {
          DOM$2.remove(parentNode);
        }
      } else {
        DOM$2.setStyle(parentNode, 'listStyleType', 'none');
      }
    }

    if (isListNode(parentNode)) {
      sibling = parentNode.previousSibling;

      if (sibling && sibling.nodeName === 'LI') {
        sibling.appendChild(ul);
      }
    }
  };

  var normalizeLists = function normalizeLists(dom, element) {
    global$5.each(global$5.grep(dom.select('ol,ul', element)), function (ul) {
      normalizeList(dom, ul);
    });
  };

  var findNextCaretContainer = function findNextCaretContainer(editor, rng, isForward, root) {
    var node = rng.startContainer;
    var offset = rng.startOffset;

    if (isTextNode(node) && (isForward ? offset < node.data.length : offset > 0)) {
      return node;
    }

    var nonEmptyBlocks = editor.schema.getNonEmptyElements();

    if (node.nodeType === 1) {
      node = global$1.getNode(node, offset);
    }

    var walker = new global$2(node, root);

    if (isForward) {
      if (isBogusBr(editor.dom, node)) {
        walker.next();
      }
    }

    while (node = walker[isForward ? 'next' : 'prev2']()) {
      if (node.nodeName === 'LI' && !node.hasChildNodes()) {
        return node;
      }

      if (nonEmptyBlocks[node.nodeName]) {
        return node;
      }

      if (isTextNode(node) && node.data.length > 0) {
        return node;
      }
    }
  };

  var hasOnlyOneBlockChild = function hasOnlyOneBlockChild(dom, elm) {
    var childNodes = elm.childNodes;
    return childNodes.length === 1 && !isListNode(childNodes[0]) && dom.isBlock(childNodes[0]);
  };

  var unwrapSingleBlockChild = function unwrapSingleBlockChild(dom, elm) {
    if (hasOnlyOneBlockChild(dom, elm)) {
      dom.remove(elm.firstChild, true);
    }
  };

  var moveChildren = function moveChildren(dom, fromElm, toElm) {
    var node;
    var targetElm = hasOnlyOneBlockChild(dom, toElm) ? toElm.firstChild : toElm;
    unwrapSingleBlockChild(dom, fromElm);

    if (!isEmpty(dom, fromElm, true)) {
      while (node = fromElm.firstChild) {
        targetElm.appendChild(node);
      }
    }
  };

  var mergeLiElements = function mergeLiElements(dom, fromElm, toElm) {
    var listNode;
    var ul = fromElm.parentNode;

    if (!isChildOfBody(dom, fromElm) || !isChildOfBody(dom, toElm)) {
      return;
    }

    if (isListNode(toElm.lastChild)) {
      listNode = toElm.lastChild;
    }

    if (ul === toElm.lastChild) {
      if (isBr(ul.previousSibling)) {
        dom.remove(ul.previousSibling);
      }
    }

    var node = toElm.lastChild;

    if (node && isBr(node) && fromElm.hasChildNodes()) {
      dom.remove(node);
    }

    if (isEmpty(dom, toElm, true)) {
      dom.$(toElm).empty();
    }

    moveChildren(dom, fromElm, toElm);

    if (listNode) {
      toElm.appendChild(listNode);
    }

    var contains = contains$1(SugarElement.fromDom(toElm), SugarElement.fromDom(fromElm));
    var nestedLists = contains ? dom.getParents(fromElm, isListNode, toElm) : [];
    dom.remove(fromElm);
    each(nestedLists, function (list) {
      if (isEmpty(dom, list) && list !== dom.getRoot()) {
        dom.remove(list);
      }
    });
  };

  var mergeIntoEmptyLi = function mergeIntoEmptyLi(editor, fromLi, toLi) {
    editor.dom.$(toLi).empty();
    mergeLiElements(editor.dom, fromLi, toLi);
    editor.selection.setCursorLocation(toLi);
  };

  var mergeForward = function mergeForward(editor, rng, fromLi, toLi) {
    var dom = editor.dom;

    if (dom.isEmpty(toLi)) {
      mergeIntoEmptyLi(editor, fromLi, toLi);
    } else {
      var bookmark = createBookmark(rng);
      mergeLiElements(dom, fromLi, toLi);
      editor.selection.setRng(resolveBookmark(bookmark));
    }
  };

  var mergeBackward = function mergeBackward(editor, rng, fromLi, toLi) {
    var bookmark = createBookmark(rng);
    mergeLiElements(editor.dom, fromLi, toLi);
    var resolvedBookmark = resolveBookmark(bookmark);
    editor.selection.setRng(resolvedBookmark);
  };

  var backspaceDeleteFromListToListCaret = function backspaceDeleteFromListToListCaret(editor, isForward) {
    var dom = editor.dom,
        selection = editor.selection;
    var selectionStartElm = selection.getStart();
    var root = getClosestListRootElm(editor, selectionStartElm);
    var li = dom.getParent(selection.getStart(), 'LI', root);

    if (li) {
      var ul = li.parentNode;

      if (ul === editor.getBody() && isEmpty(dom, ul)) {
        return true;
      }

      var rng_1 = normalizeRange(selection.getRng());
      var otherLi_1 = dom.getParent(findNextCaretContainer(editor, rng_1, isForward, root), 'LI', root);

      if (otherLi_1 && otherLi_1 !== li) {
        editor.undoManager.transact(function () {
          if (isForward) {
            mergeForward(editor, rng_1, otherLi_1, li);
          } else {
            if (isFirstChild(li)) {
              outdentListSelection(editor);
            } else {
              mergeBackward(editor, rng_1, li, otherLi_1);
            }
          }
        });
        return true;
      } else if (!otherLi_1) {
        if (!isForward && rng_1.startOffset === 0 && rng_1.endOffset === 0) {
          editor.undoManager.transact(function () {
            flattenListSelection(editor);
          });
          return true;
        }
      }
    }

    return false;
  };

  var removeBlock = function removeBlock(dom, block, root) {
    var parentBlock = dom.getParent(block.parentNode, dom.isBlock, root);
    dom.remove(block);

    if (parentBlock && dom.isEmpty(parentBlock)) {
      dom.remove(parentBlock);
    }
  };

  var backspaceDeleteIntoListCaret = function backspaceDeleteIntoListCaret(editor, isForward) {
    var dom = editor.dom;
    var selectionStartElm = editor.selection.getStart();
    var root = getClosestListRootElm(editor, selectionStartElm);
    var block = dom.getParent(selectionStartElm, dom.isBlock, root);

    if (block && dom.isEmpty(block)) {
      var rng = normalizeRange(editor.selection.getRng());
      var otherLi_2 = dom.getParent(findNextCaretContainer(editor, rng, isForward, root), 'LI', root);

      if (otherLi_2) {
        editor.undoManager.transact(function () {
          removeBlock(dom, block, root);
          mergeWithAdjacentLists(dom, otherLi_2.parentNode);
          editor.selection.select(otherLi_2, true);
          editor.selection.collapse(isForward);
        });
        return true;
      }
    }

    return false;
  };

  var backspaceDeleteCaret = function backspaceDeleteCaret(editor, isForward) {
    return backspaceDeleteFromListToListCaret(editor, isForward) || backspaceDeleteIntoListCaret(editor, isForward);
  };

  var backspaceDeleteRange = function backspaceDeleteRange(editor) {
    var selectionStartElm = editor.selection.getStart();
    var root = getClosestListRootElm(editor, selectionStartElm);
    var startListParent = editor.dom.getParent(selectionStartElm, 'LI,DT,DD', root);

    if (startListParent || getSelectedListItems(editor).length > 0) {
      editor.undoManager.transact(function () {
        editor.execCommand('Delete');
        normalizeLists(editor.dom, editor.getBody());
      });
      return true;
    }

    return false;
  };

  var _backspaceDelete = function backspaceDelete(editor, isForward) {
    return editor.selection.isCollapsed() ? backspaceDeleteCaret(editor, isForward) : backspaceDeleteRange(editor);
  };

  var setup = function setup(editor) {
    editor.on('keydown', function (e) {
      if (e.keyCode === global$3.BACKSPACE) {
        if (_backspaceDelete(editor, false)) {
          e.preventDefault();
        }
      } else if (e.keyCode === global$3.DELETE) {
        if (_backspaceDelete(editor, true)) {
          e.preventDefault();
        }
      }
    });
  };

  var get$1 = function get$1(editor) {
    return {
      backspaceDelete: function backspaceDelete(isForward) {
        _backspaceDelete(editor, isForward);
      }
    };
  };

  var open = function open(editor) {
    var dom = editor.dom;
    var currentList = getParentList(editor);

    if (!isOlNode(currentList)) {
      return;
    }

    editor.windowManager.open({
      title: 'List Properties',
      body: {
        type: 'panel',
        items: [{
          type: 'input',
          name: 'start',
          label: 'Start list at number',
          inputMode: 'numeric'
        }]
      },
      initialData: {
        start: dom.getAttrib(currentList, 'start') || '1'
      },
      buttons: [{
        type: 'cancel',
        name: 'cancel',
        text: 'Cancel'
      }, {
        type: 'submit',
        name: 'save',
        text: 'Save',
        primary: true
      }],
      onSubmit: function onSubmit(api) {
        var data = api.getData();
        editor.undoManager.transact(function () {
          dom.setAttrib(getParentList(editor), 'start', data.start === '1' ? '' : data.start);
        });
        api.close();
      }
    });
  };

  var queryListCommandState = function queryListCommandState(editor, listName) {
    return function () {
      var parentList = editor.dom.getParent(editor.selection.getStart(), 'UL,OL,DL');
      return parentList && parentList.nodeName === listName;
    };
  };

  var register = function register(editor) {
    editor.on('BeforeExecCommand', function (e) {
      var cmd = e.command.toLowerCase();

      if (cmd === 'indent') {
        indentListSelection(editor);
      } else if (cmd === 'outdent') {
        outdentListSelection(editor);
      }
    });
    editor.addCommand('InsertUnorderedList', function (ui, detail) {
      toggleList(editor, 'UL', detail);
    });
    editor.addCommand('InsertOrderedList', function (ui, detail) {
      toggleList(editor, 'OL', detail);
    });
    editor.addCommand('InsertDefinitionList', function (ui, detail) {
      toggleList(editor, 'DL', detail);
    });
    editor.addCommand('RemoveList', function () {
      flattenListSelection(editor);
    });
    editor.addCommand('mceListProps', function () {
      open(editor);
    });
    editor.addQueryStateHandler('InsertUnorderedList', queryListCommandState(editor, 'UL'));
    editor.addQueryStateHandler('InsertOrderedList', queryListCommandState(editor, 'OL'));
    editor.addQueryStateHandler('InsertDefinitionList', queryListCommandState(editor, 'DL'));
  };

  var setupTabKey = function setupTabKey(editor) {
    editor.on('keydown', function (e) {
      if (e.keyCode !== global$3.TAB || global$3.metaKeyPressed(e)) {
        return;
      }

      editor.undoManager.transact(function () {
        if (e.shiftKey ? outdentListSelection(editor) : indentListSelection(editor)) {
          e.preventDefault();
        }
      });
    });
  };

  var setup$1 = function setup$1(editor) {
    if (shouldIndentOnTab(editor)) {
      setupTabKey(editor);
    }

    setup(editor);
  };

  var register$1 = function register$1(editor) {
    var exec = function exec(command) {
      return function () {
        return editor.execCommand(command);
      };
    };

    if (!editor.hasPlugin('advlist')) {
      editor.ui.registry.addToggleButton('numlist', {
        icon: 'ordered-list',
        active: false,
        tooltip: 'Numbered list',
        onAction: exec('InsertOrderedList'),
        onSetup: function onSetup(api) {
          return listState(editor, 'OL', api.setActive);
        }
      });
      editor.ui.registry.addToggleButton('bullist', {
        icon: 'unordered-list',
        active: false,
        tooltip: 'Bullet list',
        onAction: exec('InsertUnorderedList'),
        onSetup: function onSetup(api) {
          return listState(editor, 'UL', api.setActive);
        }
      });
    }
  };

  var register$2 = function register$2(editor) {
    var listProperties = {
      text: 'List properties...',
      icon: 'ordered-list',
      onAction: function onAction() {
        return open(editor);
      },
      onSetup: function onSetup(api) {
        return listState(editor, 'OL', function (active) {
          return api.setDisabled(!active);
        });
      }
    };
    editor.ui.registry.addMenuItem('listprops', listProperties);
    editor.ui.registry.addContextMenu('lists', {
      update: function update(node) {
        var parentList = getParentList(editor, node);
        return isOlNode(parentList) ? ['listprops'] : [];
      }
    });
  };

  function Plugin() {
    global.add('lists', function (editor) {
      if (editor.hasPlugin('rtc', true) === false) {
        setup$1(editor);
        register(editor);
      }

      register$1(editor);
      register$2(editor);
      return get$1(editor);
    });
  }

  Plugin();
})();

/***/ }),

/***/ 4:
/*!************************************************************!*\
  !*** multi ./node_modules/tinymce/plugins/lists/plugin.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Programming\work_projects\regent\node_modules\tinymce\plugins\lists\plugin.js */"./node_modules/tinymce/plugins/lists/plugin.js");


/***/ })

/******/ });