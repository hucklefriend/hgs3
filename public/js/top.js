class NetworkMenuItem
{
    constructor(id, relations, options)
    {
        if (relations === undefined) {
            relations = [];
        }
        if (options === undefined) {
            options = {};
        }


        this.dom = document.getElementById(id);
        this.name = id;
        this.relations = relations;
        this.center = {x: 0, y: 0};

        if (options.hasOwnProperty('position')) {
            if (options.position === 'center') {
                this.setPosition = () => {this.setPosCenter()};
            }
        } else {
            this.setPosition = ()=> {this.setPosRandom()};
        }
    }

    setPosRandom()
    {
        let minLeft = this.dom.offsetWidth;
        let maxLeft = window.innerWidth - minLeft;
        let minTop = this.dom.offsetHeight;
        let maxTop = window.innerHeight - minTop;

        let left = Math.floor(Math.random()*(maxLeft - minLeft) + minLeft);
        let top = Math.floor(Math.random()*(maxTop - minTop) + minTop);

        this.dom.style.left = left + 'px';
        this.dom.style.top = top + 'px';
        this.center.x = left + (this.dom.offsetWidth / 2);
        this.center.y = top + (this.dom.offsetTop / 2);
    }

    setPosCenter()
    {
        let left = window.innerWidth / 2 - (this.dom.offsetWidth / 2);
        let top = window.innerHeight / 2 - (this.dom.offsetHeight / 2);
        this.dom.style.left = left + 'px';
        this.dom.style.top = top + 'px';
        this.center.x = window.innerWidth / 2;
        this.center.y = window.innerHeight / 2;
    }

    drawRelationLine()
    {

    }
}

class NetworkMenu
{
    constructor()
    {
        this.networkCanvas = document.querySelector('#network');
        this.context = this.networkCanvas.getContext('2d');
        this.items = [];

        this.networkCanvas.width = window.innerWidth;
        this.networkCanvas.height = window.innerHeight;

        window.onresize = ()=>{
            this.changeWindowSize();
            this.draw();
        };
    }

    addItem(id, relations, options)
    {
        this.items[id] = new NetworkMenuItem(id, relations, options)
    }

    changeWindowSize()
    {
        this.networkCanvas.width = window.innerWidth;
        this.networkCanvas.height = window.innerHeight;
    }

    draw()
    {
        // ”z’uŠm’è
        Object.keys(this.items).forEach((key) => {
            console.debug(key);
            this.items[key].setPosition();
        });

        // ŠÖŒW‚É‡‚í‚¹‚Äƒ‰ƒCƒ“‚ð•`‚­
        Object.keys(this.items).forEach((key) => {
            this.items[key].drawRelationLine();
        });
    }

    start()
    {
        this.draw();
    }
}