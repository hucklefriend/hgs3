/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!********************************************!*\
  !*** ./resources/js/network/background.js ***!
  \********************************************/
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * 奥にあるネットワークイメージ
 */
var NetworkBackground = /*#__PURE__*/function () {
  /**
   * コンストラクタ
   */
  function NetworkBackground(canvas) {
    _classCallCheck(this, NetworkBackground);

    this.canvas = canvas;
    this.context = this.canvas.getContext('2d');
    this.balls = []; // 背景用の点の生成

    this.generate();
  }
  /**
   * ウィンドウサイズ変更イベント
   *
   * @param left
   * @param top
   */


  _createClass(NetworkBackground, [{
    key: "changeWindowSize",
    value: function changeWindowSize(left, top) {
      this.canvas.style.left = left;
      this.canvas.style.top = top;
    }
  }, {
    key: "scroll",
    value: function scroll(mainScroll, top) {
      this.canvas.style.top = top - mainScroll / 15 + 'px';
    }
  }, {
    key: "goTop",
    value: function goTop(time, top) {
      if (time > 500) {
        this.canvas.style.top = top + 'px';
      } else {
        var now = parseInt(this.canvas.style.top);
        var distance = (now - top) * (time / 500);
        this.canvas.style.top = now - distance + 'px';
      }
    }
    /**
     * 描画
     */

  }, {
    key: "draw",
    value: function draw() {
      var _this = this;

      this.context.clearRect(0, 0, this.canvas.width, this.canvas.height); // 背景の描画

      var centerX = 500;
      var centerY = 500;
      this.context.save();
      this.context.strokeStyle = 'rgba(60, 90, 180, 0.2)';
      this.context.lineWidth = 2;
      this.balls.forEach(function (ball) {
        var x = centerX + ball.x;
        var y = centerY + ball.y;

        var grad = _this.context.createRadialGradient(x, y, 2, x, y, 10);

        grad.addColorStop(0, 'rgba(77, 80, 192,0.7)');
        grad.addColorStop(0.5, 'rgba(60, 90, 180,0.1)');
        grad.addColorStop(1, 'rgba(50, 100, 170,0)');
        _this.context.fillStyle = grad;

        _this.context.beginPath();

        _this.context.arc(x, y, 20, 0, Math.PI * 2, true);

        _this.context.fill();

        ball.relations.forEach(function (idx) {
          _this.context.beginPath();

          _this.context.moveTo(_this.balls[idx].x + centerX, _this.balls[idx].y + centerY);

          _this.context.lineTo(x, y);

          _this.context.closePath();

          _this.context.stroke();
        });
      });
      this.context.restore();
    }
    /**
     * ランダムでボールを生成
     */

  }, {
    key: "generate",
    value: function generate() {
      // 中央に偏るように、全体を配置
      var no = 0;
      var maxItemNum = 50;
      var x = 0;
      var y = 0; // 最初の40個は中央に

      for (no; no <= maxItemNum; no++) {
        if (no < 20) {
          x = Math.random() * 300 - 150;
          y = Math.random() * 300 - 150;
        } else if (no < 40) {
          x = Math.random() * 700 - 350;
          y = Math.random() * 700 - 350;
        } else {
          x = Math.random() * 980 - 440;
          y = Math.random() * 980 - 440;
        }

        var relations = [];
        var num = Math.floor(Math.random() * 2) + 1;

        for (var i = 0; i < num; i++) {
          relations.push(Math.floor(Math.random() * (maxItemNum - 1)));
        }

        this.balls.push({
          x: x,
          y: y,
          relations: relations
        });
      }
    }
  }]);

  return NetworkBackground;
}();
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!***************************************!*\
  !*** ./resources/js/network/image.js ***!
  \***************************************/
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * 手前側のメインネットワークイメージ
 */
var NetworkImage = /*#__PURE__*/function () {
  function NetworkImage() {
    _classCallCheck(this, NetworkImage);

    this.canvas = document.getElementById('network-image-canvas');
    this.context = this.canvas.getContext('2d');
  }

  _createClass(NetworkImage, [{
    key: "changeWindowSize",
    value: function changeWindowSize(left, top) {
      this.canvas.style.left = left;
      this.canvas.style.top = top;
    }
  }, {
    key: "scroll",
    value: function scroll(mainScroll, top) {
      this.canvas.style.top = top - mainScroll / 8 + 'px';
    }
  }, {
    key: "goTop",
    value: function goTop(time, top) {
      if (time > 500) {
        this.canvas.style.top = top + 'px';
      } else {
        var now = parseInt(this.canvas.style.top);
        var distance = (now - top) * (time / 500);
        this.canvas.style.top = now - distance + 'px';
      }
    }
  }, {
    key: "clearRect",
    value: function clearRect() {
      this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }
  }, {
    key: "draw",
    value: function draw(itemManager) {
      this.clearRect();
      this.context.save();
      var act, chd, gchd, grad; // 現役ループ

      for (act = 0; act < itemManager.activeGeneration.length; act++) {
        var actItem = itemManager.activeGeneration[act]; // 現役

        var children = itemManager.activeGeneration[act].children; // 子ループ

        for (chd = 0; chd < children.length; chd++) {
          var chdItem = children[chd]; // 子
          // 現役から子への線を引く

          this.context.strokeStyle = 'rgba(255, 255, 255, 0.4)';
          this.context.lineWidth = 3;
          this.context.beginPath();
          this.context.moveTo(actItem.position.x, actItem.position.y);
          this.context.lineTo(chdItem.position.x, chdItem.position.y);
          this.context.closePath();
          this.context.stroke();

          if (chdItem.children.length > 0) {
            // 孫がおる
            // 孫ループ
            for (gchd = 0; gchd < chdItem.children.length; gchd++) {
              var gradItem = chdItem.children[gchd]; // 子から孫への線を引く
              // 孫から背景への線を描く

              this.context.strokeStyle = 'rgba(60, 90, 180, 0.5)';
              this.context.lineWidth = 1; // 孫から背景への線を描画
              //Object.keys(items).forEach((key) => {
              //items[key].drawChildToBackgroundBallLine(this.context);
              //});
              // 孫の球体を描く

              grad = this.context.createRadialGradient(gradItem.position.x, gradItem.position.y, 2, gradItem.position.x, gradItem.position.y, 15);
              grad.addColorStop(0, 'white');
              grad.addColorStop(1, 'rgba(50, 100, 170, 0)');
              this.context.fillStyle = grad;
              this.context.beginPath();
              this.context.arc(gradItem.position.x, gradItem.position.y, 5, 0, Math.PI * 2, true);
              this.context.fill();
            }
          } else {// 孫いない
            // 背景への線を描画
          } // 子の球体を描く


          grad = this.context.createRadialGradient(chdItem.position.x, chdItem.position.y, 5, chdItem.position.x, chdItem.position.y, 10);
          grad.addColorStop(0, 'white');
          grad.addColorStop(0.5, 'rgba(255, 255, 255, 0.7)');
          grad.addColorStop(0.7, 'rgba(255, 255, 255, 0.1)');
          grad.addColorStop(1, 'rgba(50, 100, 170, 0)');
          this.context.fillStyle = grad;
          this.context.beginPath();
          this.context.arc(chdItem.position.x, chdItem.position.y, 10, 0, Math.PI * 2, true);
          this.context.fill();
        } // 現役の球体を描く


        grad = this.context.createRadialGradient(actItem.position.x, actItem.position.y, 5, actItem.position.x, actItem.position.y, 10);
        grad.addColorStop(0, 'white');
        grad.addColorStop(0.5, 'rgba(255, 255, 255, 0.7)');
        grad.addColorStop(0.7, 'rgba(255, 255, 255, 0.1)');
        grad.addColorStop(1, 'rgba(50, 100, 170, 0)');
        this.context.fillStyle = grad;
        this.context.beginPath();
        this.context.arc(actItem.position.x, actItem.position.y, 10, 0, Math.PI * 2, true);
        this.context.fill();

        if (act > 0) {// TODO 現役同士で線をつなぐ？
        }
      }

      this.context.restore();
    }
  }]);

  return NetworkImage;
}();
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**************************************!*\
  !*** ./resources/js/network/item.js ***!
  \**************************************/
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var NetworkItem = /*#__PURE__*/function () {
  function NetworkItem(manager) {
    _classCallCheck(this, NetworkItem);

    this.manager = manager;
    this.id = null;
    this.dom = null;
    this.parent = null;
    this.positionSetting = null;
    this.position = {
      x: 0,
      y: 0
    };
    this.animationStatus = null;
    this.children = [];
    this.backgroundBalls = [];
    this.originalSize = null;
  }

  _createClass(NetworkItem, [{
    key: "load",
    value: function load(data) {
      this.id = data.id;
      this.dom = document.getElementById(data.id);

      if (data.hasOwnProperty('parentId')) {
        this.parent = this.manager.getItem(data.parentId);
      } // 幅と高さを設定


      this.originalSize = this.dom.getBoundingClientRect(); // 幅と高さをセットしておかないと、拡大縮小アニメーションができない

      this.dom.style.width = this.originalSize.width + 'px';
      this.dom.style.height = this.originalSize.height + 'px'; // ここでclosedをセットしないと、幅と高さが取れない

      this.dom.classList.add('closed');
      this.setupPosition(data.position); // とりあえずここで配置設定
      // 親のオフセットの場合、親が先に設定されてないといけない

      this.setPosition();
    }
  }, {
    key: "appear",
    value: function appear() {
      var _this = this;

      this.dom.classList.remove('closed');
      this.dom.classList.add('active');
      this.dom.classList.add('appear'); // 1秒後にappearとclosedを消去しとく

      setTimeout(function () {
        _this.dom.classList.remove('appear');
      }, 500);
    }
  }, {
    key: "disappear",
    value: function disappear() {
      var _this2 = this;

      this.dom.classList.add('disappear'); // 1秒後にappearとclosedを消去しとく

      setTimeout(function () {
        _this2.dom.classList.add('closed');

        _this2.dom.classList.remove('disappear');
      }, 500);
    }
  }, {
    key: "openMain",
    value: function openMain() {
      this.dom.classList.add('openMain');
    }
  }, {
    key: "closeMain",
    value: function closeMain() {
      var _this3 = this;

      this.dom.classList.remove('closed');
      this.dom.classList.add('closeMain');
      setTimeout(function () {
        _this3.dom.classList.remove('openMain');

        _this3.dom.classList.remove('closeMain');
      }, 500);
    }
  }, {
    key: "open",
    value: function open() {}
  }, {
    key: "close",
    value: function close() {}
  }, {
    key: "dispose",
    value: function dispose() {
      this.dom.parentNode.removeChild(this.dom); // HTML上から削除

      this.manager = null;
      this.data = null;
      this.dom = null;
      this.id = null;
      this.positionSetting = null;
      this.position = null;
      this.parent = null;
      this.offset = null;
      this.animationStatus = null;
      this.originalSize = null;
      this.children = null;
      this.backgroundBalls = null;
    }
  }, {
    key: "draw",
    value: function draw() {// 親からの線は親が引いてくれる
      // 自分の球を描画
      // 自分から子への線を引く
    }
  }, {
    key: "setupPosition",
    value: function setupPosition(data) {
      var _this4 = this;

      if (data.type === 'fixed') {
        // 配置固定
        this.positionSetting = {
          x: data.position.x,
          y: data.position.y
        };

        this.setPosition = function () {
          _this4.setPos(_this4.positionSetting.x, _this4.positionSetting.y);
        };
      } else if (data.type === 'parent') {
        // 自分の親からのオフセット
        this.positionSetting = {
          offset: {
            x: data.offset.x,
            y: data.offset.y
          }
        };

        this.setPosition = function () {
          _this4.setPosParentOffset();
        };
      }
    }
  }, {
    key: "setPos",
    value: function setPos(x, y) {
      this.dom.style.left = x - this.originalSize.width / 2 + 'px';
      this.dom.style.top = y - this.originalSize.height / 2 + 'px';
      this.position.x = x;
      this.position.y = y;
    }
  }, {
    key: "setPosParentOffset",
    value: function setPosParentOffset() {
      var x = this.parent.position.x + this.positionSetting.offset.x;
      var y = this.parent.position.y + this.positionSetting.offset.y;
      this.setPos(x, y);
    }
  }, {
    key: "setPosTargetOffset",
    value: function setPosTargetOffset() {
      var x = this.positionSetting.target.position.x + this.positionSetting.offset.x;
      var y = this.positionSetting.target.position.y + this.positionSetting.offset.y;
      this.setPos(x, y);
    }
  }]);

  return NetworkItem;
}();
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*********************************************!*\
  !*** ./resources/js/network/itemManager.js ***!
  \*********************************************/
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var NetworkItemManager = /*#__PURE__*/function () {
  function NetworkItemManager(network, data) {
    _classCallCheck(this, NetworkItemManager);

    this.network = network;
    this.data = data;
    this.items = {}; // 全アイテム

    this.activeGeneration = []; // 世代別に並べた時の現役世代のみ

    this.mainItemId = '';
    this.ready = false;
  }

  _createClass(NetworkItemManager, [{
    key: "load",
    value: function load() {
      var _this = this;

      this.data.forEach(function (itemData) {
        // HTML追加
        _this.network.itemArea.insertAdjacentHTML('beforeend', itemData.dom); // インスタンスだけ先に作る


        _this.items[itemData.id] = new NetworkItem(_this);
      }); // もっかいループ

      this.data.forEach(function (itemData) {
        _this.items[itemData.id].load(itemData);

        if (itemData.hasOwnProperty('parentId') && itemData.parentId !== null) {
          // 誰かの子なので親にリンク
          _this.items[itemData.parentId].children.push(_this.items[itemData.id]);
        } else {
          // 現役世代
          _this.activeGeneration.push(_this.getItem(itemData.id));
        }
      }); // 準備完了

      this.ready = true;
    }
  }, {
    key: "appear",
    value: function appear() {
      var _this2 = this;

      console.debug(this.items);
      Object.keys(this.items).forEach(function (key) {
        _this2.items[key].appear();
      });
    }
  }, {
    key: "disappear",
    value: function disappear() {
      var _this3 = this;

      Object.keys(this.items).forEach(function (key) {
        _this3.items[key].disappear();
      });
    }
  }, {
    key: "startMainMode",
    value: function startMainMode(mainItemId) {
      var _this4 = this;

      this.mainItemId = mainItemId; // メインになるアイテム以外を消す

      Object.keys(this.items).forEach(function (key) {
        if (key !== mainItemId) {
          _this4.items[key].disappear();
        } else {
          _this4.items[key].openMain();
        }
      });
    }
  }, {
    key: "endMainMode",
    value: function endMainMode() {
      var _this5 = this;

      Object.keys(this.items).forEach(function (key) {
        if (key !== _this5.mainItemId) {
          _this5.items[key].appear();
        } else {
          _this5.items[key].closeMain();
        }
      });
    }
  }, {
    key: "appearAnimation",
    value: function appearAnimation(animationTime) {
      var _this6 = this;

      var progress = animatinTime / 1000;
      Object.keys(this.items).forEach(function (key) {
        _this6.items[key].appear();
      });
    }
  }, {
    key: "open",
    value: function open() {
      var _this7 = this;

      Object.keys(this.items).forEach(function (key) {
        _this7.items[key].open();
      });
    }
  }, {
    key: "close",
    value: function close() {
      var _this8 = this;

      Object.keys(this.items).forEach(function (key) {
        _this8.items[key].close();
      });
    }
  }, {
    key: "dispose",
    value: function dispose() {
      var _this9 = this;

      //this.dom.parentNode.removeChild(this.dom);      // HTML上から削除
      this.layout = null;
      Object.keys(this.items).forEach(function (key) {
        _this9.items[key].dispose();
      });
      this.items = null;
    }
  }, {
    key: "getItem",
    value: function getItem(key) {
      return this.items[key];
    }
  }]);

  return NetworkItemManager;
}();
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!*****************************************!*\
  !*** ./resources/js/network/network.js ***!
  \*****************************************/
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var Network = /*#__PURE__*/function () {
  function Network() {
    var _this = this;

    _classCallCheck(this, Network);

    var test = '';
    this.mainContesnts = $('#main-contents');
    this.networkCanvas = document.getElementById('network-canvas');
    this.backgroundCanvas = document.getElementById('network-background-canvas');
    this.changeWindow();
    this.ctx = this.networkCanvas.getContext('2d');
    this.background = new NetworkBackground(this.backgroundCanvas);
    this.backgroundOffset = {
      left: 0,
      top: 0
    };
    $('body').mousemove(function (e) {
      _this.mainContesnts.css('background-position', event.clientX - 35 + 'px ' + (event.clientY - 20) + 'px');
    });
  }

  _createClass(Network, [{
    key: "draw",
    value: function draw(onlyImage) {
      if (!onlyImage) {
        this.background.draw();
      }

      return; // 座標を定義
      // 座標を定義

      var start = {
        x: 19,
        y: 52
      }; //始点

      var end = {
        x: 62,
        y: 118
      }; //終点

      this.ctx.save();
      this.ctx.beginPath();
      var v_color = this.ctx.createLinearGradient(start.x - 6, start.y, start.x + 6, start.y);
      v_color.addColorStop(0.0, 'rgba(0,110,0, 0)');
      v_color.addColorStop(0.5, 'rgba(0,200,0, 1)');
      v_color.addColorStop(1.0, 'rgba(0,110,0, 0)');
      this.ctx.fillStyle = v_color;
      this.ctx.rect(start.x - 6, start.y, 12, end.y - start.y + 2);
      this.ctx.fill();
      this.ctx.closePath();
      this.ctx.beginPath();
      var h_color = this.ctx.createLinearGradient(end.x, end.y - 6, end.x, end.y + 6);
      h_color.addColorStop(0.0, 'rgba(0,200,0, 0)');
      h_color.addColorStop(0.5, 'rgba(0,200,0, 1)');
      h_color.addColorStop(1.0, 'rgba(0,200,0, 0)');
      this.ctx.fillStyle = h_color;
      this.ctx.rect(start.x, end.y - 6, end.x - start.x, 12);
      this.ctx.fill();
      this.ctx.closePath();
      this.ctx.restore();
    }
  }, {
    key: "changeWindow",
    value: function changeWindow() {
      var canvas = $('#network-canvas');
      var parent = $('#main-contents');
      canvas.attr('width', parent.width());
      canvas.attr('height', parent.height());
    }
  }]);

  return Network;
}();
})();

/******/ })()
;