class NetworkBackground
{
    constructor()
    {
        this.area = document.getElementById('network-layout');
        this.canvas = document.getElementById('network-background');
        this.context = this.canvas.getContext('2d');
        this.balls = [];

        this.changeWindowSize();

        // 背景用の点の生成
        this.generate();
    }

    changeWindowSize()
    {
        this.area.style.height = window.innerHeight + 'px';
        this.canvas.width = this.area.offsetWidth;
        this.canvas.height = this.area.offsetHeight;
    }

    draw()
    {

        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // 背景の描画
        let centerX = this.area.offsetWidth / 2;
        let centerY = this.area.offsetHeight / 2;

        this.context.save();

        this.context.strokeStyle = 'rgba(60, 90, 180, 0.2)';
        this.context.lineWidth = 2;

        this.balls.forEach((ball)=>{
            let x = centerX + ball.x;
            let y = centerY + ball.y;

            let grad = this.context.createRadialGradient(x, y, 2, x, y, 20);

            grad.addColorStop(0,'rgba(77, 80, 192,0.7)');
            grad.addColorStop(0.5,'rgba(60, 90, 180,0.1)');
            grad.addColorStop(1,'rgba(50, 100, 170,0)');

            this.context.fillStyle = grad;

            this.context.beginPath();
            this.context.arc(x, y, 20, 0, Math.PI * 2, true);
            this.context.fill();

            ball.relations.forEach((idx)=>{
                this.context.beginPath();

                this.context.moveTo(this.balls[idx].x + centerX, this.balls[idx].y + centerY);
                this.context.lineTo(x, y);

                this.context.closePath();
                this.context.stroke();
            });
        });

        this.context.restore();
    }


    generate()
    {
        // 中央に偏るように、全体を配置

        let no = 0;
        let maxItemNum = 50;
        let x = 0;
        let y = 0;

        // 最初の40個は中央に
        for (no; no <= maxItemNum; no++) {
            if (no < 20) {
                x = Math.random() * 300 - 150;
                y = Math.random() * 300 - 150;
            } else if (no < 40) {
                x = Math.random() * 700 - 350;
                y = Math.random() * 700 - 350;
            } else {
                x = Math.random() * 1000 - 500;
                y = Math.random() * 1200 - 600;
            }

            let relations = [];
            let num = Math.floor(Math.random() * 2) + 1;
            for (let i = 0; i < num; i++) {
                relations.push(Math.floor(Math.random() * (maxItemNum - 1)));
            }

            this.balls.push({x: x, y: y, relations: relations});
        }
    }
}