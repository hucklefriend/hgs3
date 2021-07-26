

class Network
{
    constructor()
    {
        let test = '';
        this.mainContesnts = $('#main-contents');
        this.networkCanvas = document.getElementById('network-canvas');
        this.backgroundCanvas = document.getElementById('network-background-canvas');
        this.changeWindow();

        this.ctx = this.networkCanvas.getContext('2d');

        this.background = new NetworkBackground(this.backgroundCanvas);
        this.backgroundOffset = {left: 0, top: 0};

        $('body').mousemove((e)=>{
            this.mainContesnts.css('background-position', (event.clientX - 35) + 'px ' + (event.clientY - 20) + 'px');
        });
    }

    draw(onlyImage)
    {
        if (!onlyImage) {
            this.background.draw();
        }
return;
        // 座標を定義
        // 座標を定義
        let start = { x: 19,    y: 52  };  //始点
        let end =   { x:  62,   y: 118 };  //終点

        this.ctx.save();




        this.ctx.beginPath();

        let v_color = this.ctx.createLinearGradient(start.x - 6, start.y, start.x + 6, start.y);
        v_color.addColorStop(0.0 , 'rgba(0,110,0, 0)');
        v_color.addColorStop(0.5 , 'rgba(0,200,0, 1)');
        v_color.addColorStop(1.0 , 'rgba(0,110,0, 0)');
        this.ctx.fillStyle = v_color;
        this.ctx.rect(start.x - 6, start.y, 12, end.y - start.y +2);
        this.ctx.fill();
        this.ctx.closePath();

        this.ctx.beginPath();
        let h_color = this.ctx.createLinearGradient(end.x, end.y - 6, end.x, end.y + 6);
        h_color.addColorStop(0.0 , 'rgba(0,200,0, 0)');
        h_color.addColorStop(0.5 , 'rgba(0,200,0, 1)');
        h_color.addColorStop(1.0 , 'rgba(0,200,0, 0)');
        this.ctx.fillStyle = h_color;
        this.ctx.rect(start.x, end.y - 6, end.x - start.x, 12);
        this.ctx.fill();
        this.ctx.closePath();

        this.ctx.restore();
    }

    changeWindow()
    {
        let canvas = $('#network-canvas');
        let parent = $('#main-contents');

        canvas.attr('width', parent.width());
        canvas.attr('height', parent.height());
    }
}