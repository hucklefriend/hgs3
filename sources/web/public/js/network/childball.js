class NetworkChildBall
{
    constructor(layout, parent, position)
    {
        this.parent = parent;
        this.offset = {x: 0, y: 0};

        this.offset.x = position.x + (Math.random() * 15);
        this.offset.y = position.y + (Math.random() * 15);

        this.backgroundChildren = [];

        // 1～5個、背景とつなげる
        // TODO 自分の子の数にする
        let conNum = Math.floor(Math.random() * 4) + 1;
        for (let i = 0; i < conNum; i++) {
            this.backgroundChildren.push(Math.floor(Math.random() * layout.background.balls.length));
        }
    }

    draw(ctx, x, y)
    {
        let grad = ctx.createRadialGradient(x, y, 2, x, y, 15);

        grad.addColorStop(0,'white');
        grad.addColorStop(1,'rgba(50, 100, 170, 0)');

        ctx.fillStyle = grad;

        ctx.beginPath();
        ctx.arc(x, y, 5, 0, Math.PI * 2, true);
        ctx.fill();
    }

    drawBackgroundBallLine(ctx)
    {
        let x = this.parent.position.x + this.offset.x;
        let y = this.parent.position.y + this.offset.y;

        this.backgroundChildren.forEach(()=>{
            ctx.beginPath();

            ctx.moveTo(x, y);
            ctx.lineTo(x, y);

            ctx.closePath();
            ctx.stroke();
        });
    }
}