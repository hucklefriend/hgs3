/**
 * 手前側のメインネットワークイメージ
 */
class NetworkImage
{
    constructor()
    {
        this.canvas = document.getElementById('network-image-canvas');
        this.context = this.canvas.getContext('2d');
    }

    changeWindowSize(left, top)
    {
        this.canvas.style.left = left;
        this.canvas.style.top = top;
    }

    scroll(mainScroll, top)
    {
        this.canvas.style.top = top - (mainScroll / 8) + 'px';
    }

    goTop(time, top)
    {
        if (time > 500) {
            this.canvas.style.top = top + 'px';
        } else {
            let now = parseInt(this.canvas.style.top);
            let distance = (now - top) * (time / 500);

            this.canvas.style.top = (now - distance) + 'px';
        }
    }

    draw(itemManager)
    {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);

        this.context.save();

        let act, chd, gchd, grad;

        // 現役ループ
        for (act = 0; act < itemManager.activeGeneration.length; act++) {
            let actItem = itemManager.activeGeneration[act];        // 現役
            let children = itemManager.activeGeneration[act].children;

            // 子ループ
            for (chd = 0; chd < children.length; chd++) {
                let chdItem = children[chd];        // 子

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
                        let gradItem = chdItem.children[gchd];
                        // 子から孫への線を引く

                        // 孫から背景への線を描く
                        this.context.strokeStyle = 'rgba(60, 90, 180, 0.5)';
                        this.context.lineWidth = 1;

                        // 孫から背景への線を描画
                        //Object.keys(items).forEach((key) => {
                        //items[key].drawChildToBackgroundBallLine(this.context);
                        //});



                        // 孫の球体を描く
                        grad = this.context.createRadialGradient(gradItem.position.x, gradItem.position.y, 2, gradItem.position.x, gradItem.position.y, 15);

                        grad.addColorStop(0,'white');
                        grad.addColorStop(1,'rgba(50, 100, 170, 0)');

                        ctx.fillStyle = grad;

                        ctx.beginPath();
                        ctx.arc(x, y, 5, 0, Math.PI * 2, true);
                        ctx.fill();
                    }
                } else {
                    // 孫いない
                    // 背景への線を描画
                }


                // 子の球体を描く
                grad = this.context.createRadialGradient(chdItem.position.x, chdItem.position.y, 5, chdItem.position.x, chdItem.position.y, 10);

                grad.addColorStop(0,'white');
                grad.addColorStop(0.5,'rgba(255, 255, 255, 0.7)');
                grad.addColorStop(0.7,'rgba(255, 255, 255, 0.1)');
                grad.addColorStop(1,'rgba(50, 100, 170, 0)');

                this.context.fillStyle = grad;

                this.context.beginPath();
                this.context.arc(chdItem.position.x, chdItem.position.y, 10, 0, Math.PI * 2, true);
                this.context.fill();
            }

            // 現役の球体を描く
            grad = this.context.createRadialGradient(actItem.position.x, actItem.position.y, 5, actItem.position.x, actItem.position.y, 10);

            grad.addColorStop(0,'white');
            grad.addColorStop(0.5,'rgba(255, 255, 255, 0.7)');
            grad.addColorStop(0.7,'rgba(255, 255, 255, 0.1)');
            grad.addColorStop(1,'rgba(50, 100, 170, 0)');

            this.context.fillStyle = grad;

            this.context.beginPath();
            this.context.arc(actItem.position.x, actItem.position.y, 10, 0, Math.PI * 2, true);
            this.context.fill();

            if (act > 0) {
                // TODO 現役同士で線をつなぐ？
            }
        }

        this.context.restore();
    }

    changeAnimation(time, oldItems, items, mainItem, oldMainItem, backgroundOffset)
    {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // 最初の0.3秒間は消えるアイテムの消去と移動
        if (time < 500) {
            // 消えるアイテム
            this.changeAnimationVanish(time, oldItems);

            // 元メインの移動
            let oldMainPos = this.changeAnimationOldMain(time, 500, oldMainItem, backgroundOffset);

            // 新メインの移動
            this.changeAnimationNewMain(time, 500, mainItem, oldMainPos, backgroundOffset);

            oldMainPos = null;
        } else {
/*

            this.context.save();

            // アイテムを描画
            Object.keys(items).forEach((key) => {
                if (!items[key].isMain) {
                    // メインから子へのラインを描画
                    this.context.strokeStyle = 'rgba(255, 255, 255, 0.4)';
                    this.context.lineWidth = 3;

                    this.context.beginPath();

                    this.context.moveTo(items[key].parent.position.x, items[key].parent.position.y);
                    this.context.lineTo(items[key].position.x, items[key].position.y);

                    this.context.closePath();
                    this.context.stroke();

                    if (items[key].childBalls.length > 0) {
                        this.context.save();

                        this.context.strokeStyle = '#444';
                        this.context.lineWidth = 2;

                        // 自分から子への線を引く
                        items[key].childBalls.forEach((childBall)=>{
                            let x = items[key].position.x + childBall.offset.x;
                            let y = items[key].position.y + childBall.offset.y;

                            this.context.beginPath();

                            this.context.moveTo(items[key].position.x, items[key].position.y);
                            this.context.lineTo(x, y);

                            this.context.closePath();
                            this.context.stroke();

                            childBall.draw(this.context, x, y);
                        });

                        this.context.restore();
                    }
                }

                // 自分のボールを描く
                let grad = this.context.createRadialGradient(items[key].position.x, items[key].position.y, 5, items[key].position.x, items[key].position.y, 10);

                grad.addColorStop(0,'white');
                grad.addColorStop(0.5,'rgba(255, 255, 255, 0.7)');
                grad.addColorStop(0.7,'rgba(255, 255, 255, 0.1)');
                grad.addColorStop(1,'rgba(50, 100, 170, 0)');

                this.context.fillStyle = grad;

                this.context.beginPath();
                this.context.arc(items[key].position.x, items[key].position.y, 10, 0, Math.PI * 2, true);
                this.context.fill();
            });

            this.context.restore();
*/
        }
    }

    changeAnimationVanish(time, oldItems)
    {
        // 消えるアイテム
        this.context.save();

        // 最初の0.2秒で消す
        let alpha = 0.5 - (0.5 * (time / 200));

        this.context.strokeStyle = 'rgba(60, 90, 180, ' + alpha + ')';
        this.context.lineWidth = 1;

        // 孫から背景への線を描画
        Object.keys(oldItems).forEach((key) => {
            if (oldItems[key].animationStatus === 'destroy') {
                oldItems[key].drawChildToBackgroundBallLine(this.context);
            }
        });

        this.context.restore();

        // たぶんウィンドウで隠れるので、ボールはもう描画しない
    }

    changeAnimationOldMain(time, animTime, oldMain, backgroundOffset)
    {
        let rate = time / animTime;
        let itemX = oldMain.animationStatus.from.x - ((oldMain.animationStatus.from.x - oldMain.position.x) * rate);
        let itemY = oldMain.animationStatus.from.y - ((oldMain.animationStatus.from.y - oldMain.position.y) * rate);

        oldMain.move(itemX, itemY);
/*
        let grad = this.context.createRadialGradient(x, y, 5, x, y, 10);

        grad.addColorStop(0,'white');
        grad.addColorStop(0.5,'rgba(255, 255, 255, 0.7)');
        grad.addColorStop(0.7,'rgba(255, 255, 255, 0.1)');
        grad.addColorStop(1,'rgba(50, 100, 170, 0)');

        this.context.fillStyle = grad;

        this.context.beginPath();
        this.context.arc(x, y, 10, 0, Math.PI * 2, true);
        this.context.fill();
*/
        if (oldMain.childBalls.length > 0) {
            this.context.save();

            this.context.strokeStyle = '#444';
            this.context.lineWidth = 2;

            // 自分から子への線を引く
            oldMain.childBalls.forEach((childBall)=>{
                // 現在地の計算
                let x = childBall.animation.from.x - ((childBall.animation.from.x - childBall.animation.to.x) * rate);
                let y = childBall.animation.from.y - ((childBall.animation.from.y - childBall.animation.to.y) * rate);

                this.context.beginPath();

                this.context.moveTo(itemX, itemY);
                this.context.lineTo(x, y);

                this.context.closePath();
                this.context.stroke();

                childBall.draw(this.context, x, y);
            });

            this.context.restore();
        }

        return {x: itemX, y: itemY};
    }

    changeAnimationNewMain(time, animTime, newMain, oldMainPos, backgroundOffset)
    {
        let rate = time / animTime;
        let itemX = newMain.animationStatus.from.x - ((newMain.animationStatus.from.x - newMain.position.x) * rate);
        let itemY = newMain.animationStatus.from.y - ((newMain.animationStatus.from.y - newMain.position.y) * rate);

        newMain.move(itemX, itemY);

        this.context.save();

        // 旧メインへのラインを引く
        this.context.strokeStyle = 'rgba(255, 255, 255, 0.4)';
        this.context.lineWidth = 3;

        this.context.beginPath();

        this.context.moveTo(itemX, itemY);
        this.context.lineTo(oldMainPos.x, oldMainPos.y);

        this.context.closePath();
        this.context.stroke();

        if (newMain.childBalls.length > 1) {

            // 自分から子への線を引く
            for (let i = 0; i < newMain.childBalls.length - 2; i++) {
                let childBall = newMain.childBalls[i];

                // 現在地の計算
                let x = childBall.animation.from.x - ((childBall.animation.from.x - childBall.animation.to.x) * rate);
                let y = childBall.animation.from.y - ((childBall.animation.from.y - childBall.animation.to.y) * rate);

                this.context.beginPath();

                this.context.moveTo(itemX, itemY);
                this.context.lineTo(x, y);

                this.context.closePath();
                this.context.stroke();

                childBall.draw(this.context, x, y);
            }
        }

        this.context.restore();
    }
}