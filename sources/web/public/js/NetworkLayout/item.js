class NetworkItem
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
        this.center.y = top + (this.dom.offsetHeight / 2);
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

    drawRelationLine(layout)
    {
        this.relations.forEach((target) => {
            let item = layout.getItem(target);

            layout.context.beginPath();

            layout.context.moveTo(this.center.x, this.center.y);
            layout.context.lineTo(item.center.x, item.center.y);

            layout.context.closePath();
            layout.context.stroke();
        });
    }
}